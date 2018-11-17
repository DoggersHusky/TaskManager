<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\ORM\DataExtension;

class TaskManagerExtension extends DataExtension {
    
    /*
     * makes the taskmanager
     */
    public function TaskManager() {
        // Make sure this is a page
        //if (!$this->isAPage()) return false;
        
        //the data for the taskmanager
        $data = array(
            'PageTasks' => $this->owner->Tasks()
        );
        
        $page = $this->owner->customise(['TaskManager' => $data]);
        return $page->renderWith('TaskManager\\TaskManager');
        
    }
    
}