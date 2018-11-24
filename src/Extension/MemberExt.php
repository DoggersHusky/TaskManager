<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\ORM\DataExtension;
use BucklesHusky\TaskManager\Model\Task;

class MemberExt extends DataExtension {
    
    private static $has_many = [
        'Tasks' => Task::class
    ];
    
}