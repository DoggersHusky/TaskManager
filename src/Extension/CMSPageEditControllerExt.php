<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\CMS\Controllers\CMSPageEditController;

class CMSPageEditControllerExt extends Extension
{
    public function doMarkComplete($data, Form $form)
    {
        //get current page Tasks
        $tasks = $this->owner->currentPage()->Tasks();
        //how many task were marked as completed.
        $count = 0;
        
        foreach ($tasks as $task) {
            if ($task->Complete == 0) {
                $task->Complete = 1;
                $task->write();
                $count++;
            }
        }
        
        //which message should be displayed
        if ($count == 0) {
            $form->sessionMessage('There are no tasks that need to be marked completed.', 'warning');
        } else {
            $form->sessionMessage($count . ' task(s) have been marked as completed.', 'good');
        }
        
        return $this->owner->getResponseNegotiator()->respond($this->owner->getRequest());
    }
}
