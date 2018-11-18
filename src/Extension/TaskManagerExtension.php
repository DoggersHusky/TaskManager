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

class TaskManagerExtension extends DataExtension {
    
    private static $allowed_actions = [
        'TaskManagerForm'
    ];
    
    /*
     * makes the taskmanager
     */
    public function TaskManager() {
        
        //the data for the taskmanager
        $data = array(
            'PageTasks' => $this->owner->Tasks()->filter(array(
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
        $new->Element = $data['Element'];
        $new->PageID = $this->owner->ID;
        $new->write();
        
        return $this->owner->redirectBack();
        
    }
    
    
}