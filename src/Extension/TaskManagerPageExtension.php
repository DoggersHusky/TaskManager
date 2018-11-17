<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\ORM\DataExtension;
use BucklesHusky\TaskManager\Model\Task;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class TaskManagerPageExtension extends DataExtension {
    
    private static $has_many = [
        'Tasks' => Task::class
    ];
    
    public function updateCMSFields(FieldList $fields) {
        
        //add fields to the Tasks tab
        $fields->addFieldsToTab('Root.Tasks', array(
            GridField::create('Tasks','Tasks',$this->owner->Tasks(), GridFieldConfig_RecordEditor::create())
        ));
    }
    
}