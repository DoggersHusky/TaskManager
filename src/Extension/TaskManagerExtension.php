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
            'AllTasks' => Task::get()->filter(array(
                'Complete'=>'0'
            ))
        );
        
        $page = $this->owner->customise(['TaskManager' => $data]);
        return $page->renderWith('TaskManager\\TaskManager');
        
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
                        LiteralField::create('Ele','Element: <span class="display-element"></span>'),
                        TextField::create('Title', 'Title'),
                        TextareaField::create('Description','Description'),
                        HiddenField::create('Element','Element')
                    ),
                    FieldList::create(
                        FormAction::create('SaveTask', 'Save')
                    )
                );
        
        return $form;
        
    }
    
    /*
     * creates a new task for the current page
     */
    public function SaveTask($data, $form) {
        
        //create a new task for this page
        $new = Task::create();
        $new->Title = $data['Title'];
        $new->Description = $data['Description'];
        if ($data['Element']) {
            $new->Element = $data['Element'];
        }
        $new->PageID = $this->owner->ID;
        $new->write();
        
        return $this->owner->redirectBack();
    }
    
    public function CompleteTask() {
        
        $item = Task::get()->byID($this->owner->request->param('ID'));
        $item->Complete = 1;
        $item->write();
        
        return $this->owner->redirectBack();
        
    }
    
    
}