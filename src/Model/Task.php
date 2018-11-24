<?php

namespace BucklesHusky\TaskManager\Model;

use SilverStripe\ORM\DataObject;
use Page;
use SilverStripe\Security\Member;

class Task extends DataObject {
    
    private static $db = [
        'Title' => 'Text',
        'Description' => 'Text',
        'Complete' => 'Boolean',
        'Element' => 'Text'
    ];
    
    private static $has_one = [
        'Page' => Page::class,
        'Member' => Member::class
    ];
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        return $fields;
    }
}
