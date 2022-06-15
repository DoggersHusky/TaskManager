<?php

namespace BucklesHusky\TaskManager\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use Page;

class Task extends DataObject
{
    private static $db = [
        'Title' => 'Text',
        'Description' => 'Text',
        'Complete' => 'Boolean',
        'Element' => 'Text',
        'GitHubIssue' => 'Boolean',
        'GitHubID' => 'Int',
        'GitHubLink' => 'Varchar(2083)',
    ];
    
    //@todo this should have one milestone
    private static $has_one = [
        'Page' => Page::class,
        'Member' => Member::class
    ];
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        return $fields;
    }
}
