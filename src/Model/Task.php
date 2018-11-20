<?php

namespace BucklesHusky\TaskManager\Model;

use SilverStripe\ORM\DataObject;
use Page;

class Task extends DataObject {
    
    private static $db = [
        'Title' => 'Text',
        'Description' => 'Text',
        'Complete' => 'Boolean',
        'Element' => 'HTMLText'
    ];
    
    private static $has_one = [
        'Page' => Page::class
    ];
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        return $fields;
    }
}
