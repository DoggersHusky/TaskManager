<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use BucklesHusky\TaskManager\Model\Task;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Security\Security;
use SilverStripe\Core\Config\Config;

class TaskManagerExtension extends DataExtension {
    
    private static $allowed_actions = [
        'TaskManagerForm',
        'CompleteTask'
    ];
    
    /*
     * makes the taskmanager
     */
    public function TaskManager() {
        
        //make sure the user is logged in as admin
        if (!Permission::check('ADMIN')) {
            return false;
        }
        
        //the data for the taskmanager
        $data = array(
            'PageTasks' => $this->owner->Tasks()->filter(array(
                'Complete'=>'0'
            )),
            'PageTotalTasks' => $this->owner->Tasks()->count(),
            'PageCompletedTasks' => $this->owner->Tasks()->filter(array(
                'Complete'=>'1'
            ))->count(),
            
            
            'AllTasks' => Task::get()->filter(array(
                'Complete'=>'0'
            )),
            'TotalTasks' => Task::get()->count(),
            'CompletedTasks'=> Task::get()->filter(array(
                'Complete'=>'1'
            ))->count()
        );
        
        $page = $this->owner->customise(['TaskManager' => $data]);
        return $page->renderWith('TaskManager\\TaskManager');
        
    }
    
    public function getIncludeJuery(){
        var_dump(Config::inst()->get('TaskManager', 'JQueryInclude'));
        return (boolean)Config::inst()->get('TaskManager', 'JQueryInclude');
    }
    
    /*
     * generates a form to display on the front end. 
     * This form allows users to add a new task
     */
    public function TaskManagerForm() {
        
        $form = Form::create(
                    $this->owner,
                    __FUNCTION__,
                    FieldList::create(
                        ReadonlyField::create('Ele','Element'),
                        TextField::create('Title', 'Title')->setDescription('Use a couple of words to summarize the issue/change'),
                        TextareaField::create('Description','Description')->setDescription('Leave a detailed description of the issue/change here'),
                        HiddenField::create('Element','Element')
                    ),
                    FieldList::create(
                        FormAction::create('SaveTask', 'Save')
                    ),
                    RequiredFields::create('Title','Description')
                );
        
        return $form;
        
    }
    
    /*
     * creates a new task for the current page
     */
    public function SaveTask($data, $form) {
        
        if ($member = Security::getCurrentUser()) {
        
            //create a new task for this page
            $new = Task::create();
            $new->Title = $data['Title'];
            $new->Description = $data['Description'];
            if ($data['Element']) {
                $new->Element = $data['Element'];
            }
            $new->PageID = $this->owner->ID;
            //the user that create the task
            $new->MemberID = $member->ID;
            $new->write();

            $form->sessionMessage('Good job on submitting this form fella', 'good');

            return $this->owner->redirectBack();
        }
    }
    
    /*
     * mark a task as completed
     */
    public function CompleteTask() {
        
        //make sure the user is logged in as admin
        if (Permission::check('ADMIN')) {
            $item = Task::get()->byID($this->owner->request->param('ID'));
            $item->Complete = 1;
            $item->write();
        }
        
        return $this->owner->redirectBack();
    }
    
    
}