<?php

namespace BucklesHusky\TaskManager\Extension;

use BucklesHusky\TaskManager\Model\Milestone;
use BucklesHusky\TaskManager\Model\Task;
use BucklesHusky\TaskManager\Traits\GitHub;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\SiteConfig\SiteConfig;

class SiteConfigLeftAndMainExtension extends DataExtension
{
    use GitHub;

    /**
     * get the milestones from github and save them
     * this will check to see if they exist in the system first
     *
     * @param [type] $data
     * @param [type] $form
     * @return void
     */
    public function updateMileStones($data, $form)
    {
        // get the current site config
        $currentSiteConfig = SiteConfig::current_site_config();

        // are we setup to use github?
        if ($currentSiteConfig->EnableGitIssueCreating && $currentSiteConfig->GithubUser && $currentSiteConfig->GithubRepo) {
            // request the milestones
            $milestones = $this->getMilestones($currentSiteConfig->GithubUser, $currentSiteConfig->GithubRepo);

            // something went wrong return
            if ($milestones === false) {
                $form->sessionMessage('An error has occurred. Double check your credentials.', ValidationResult::TYPE_ERROR);
                return $this->owner->getResponseNegotiator()->respond($this->owner->getRequest());
            }

            // get the content
            $milestones = json_decode($milestones->getBody()->getContents());
            
            //last updated
            $lastUpdatedID = $currentSiteConfig->MilestonesLastUpdatedID + 1;

            // loop through the milestones
            foreach ($milestones as $milestone) {
                $newOrOldMilestone = Milestone::get()->filter([
                    'Title' => $milestone->title,
                    'Number' => $milestone->number,
                ])->first();

                // if it doesn't exist create it
                if (!$newOrOldMilestone) {
                    $newOrOldMilestone = Milestone::create();
                }

                // write changes
                $newOrOldMilestone->Title = $milestone->title;
                $newOrOldMilestone->Number = $milestone->number;
                $newOrOldMilestone->MilestonesLastUpdatedID = $lastUpdatedID;
                $newOrOldMilestone->write();
            }

            //hack to prevent items that aren't in the array from showing
            $currentSiteConfig->MilestonesLastUpdatedID = $lastUpdatedID;
            $currentSiteConfig->write();

            $form->sessionMessage('Milestones updated', ValidationResult::TYPE_GOOD);
        }

        return $this->owner->getResponseNegotiator()->respond($this->owner->getRequest());
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param [type] $form
     * @return void
     */
    public function updateIssues($data, $form)
    {
        // get the current site config
        $currentSiteConfig = SiteConfig::current_site_config();

        // are we setup to use github?
        if ($currentSiteConfig->EnableGitIssueCreating && $currentSiteConfig->GithubUser && $currentSiteConfig->GithubRepo) {
            // request the issues
            $issues = $this->getClosedGitIssues($currentSiteConfig->GithubUser, $currentSiteConfig->GithubRepo);

            // something went wrong return
            if ($issues === false) {
                $form->sessionMessage('An error has occurred. Double check your credentials.', ValidationResult::TYPE_ERROR);
                return $this->owner->getResponseNegotiator()->respond($this->owner->getRequest());
            }

            // get the content
            $issues = json_decode($issues->getBody()->getContents());

            //update the issue in the system - mark complete
            foreach ($issues as $issue) {
                $task = Task::get()->filter('GitHubID', $issue->id)->first();

                if ($task) {
                    $task->Complete = 1;
                    $task->write();
                }
            }
        }

        $form->sessionMessage('Issues updated', ValidationResult::TYPE_GOOD);
        return $this->owner->getResponseNegotiator()->respond($this->owner->getRequest());
    }
}
