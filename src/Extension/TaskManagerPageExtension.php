<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\ORM\DataExtension;

class TaskManagerPageExtension extends DataExtension {
    
    /*
     * makes the taskmanager
     */
    public function TaskManager() {
        // Make sure this is a page
        if (!$this->isAPage()) return false;
    }
    
}