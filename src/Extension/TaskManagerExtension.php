<?php

namespace BucklesHusky\TaskManager\Extension;

use BucklesHusky\TaskManager\Model\Milestone;
use BucklesHusky\TaskManager\Model\Task;
use BucklesHusky\TaskManager\Traits\GitHub;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;

class TaskManagerExtension extends DataExtension
{
    use GitHub;
    
    private static $allowed_actions = [
        'TaskManagerForm',
        'CompleteTask'
    ];
    
    /*
     * makes the taskmanager
     */
    public function TaskManager()
    {
        //make sure the user is logged in as admin
        if (!Permission::check('ADMIN')) {
            return false;
        }
        
        //the data for the taskmanager
        $data = [
            'PageTasks' => $this->owner->Tasks()->filter([
                'Complete' => '0',
            ]),
            'PageTotalTasks' => $this->owner->Tasks()->count(),
            'PageCompletedTasks' => $this->owner->Tasks()->filter([
                'Complete' => '1',
            ])->count(),
            'AllTasks' => Task::get()->filter([
                'Complete' => '0',
            ]),
            'TotalTasks' => Task::get()->count(),
            'CompletedTasks' => Task::get()->filter([
                'Complete' => '1',
            ])->count()
        ];
        
        $page = $this->owner->customise(['TaskManager' => $data]);
        return $page->renderWith('TaskManager\\TaskManager');
    }
    
    /*
     * get if jquery needs to be included
     */
    public function getIncludeJuery()
    {
        return (boolean) Config::inst()->get('TaskManager', 'JQueryInclude');
    }
    
    /*
     * generates a form to display on the front end.
     * This form allows users to add a new task
     */
    public function TaskManagerForm()
    {
        // get the current site config
        $currentSiteConfig = SiteConfig::current_site_config();

        $form = Form::create(
            $this->owner,
            __FUNCTION__,
            FieldList::create(
                ReadonlyField::create('Ele', 'Element'),
                TextField::create('Title', 'Title')->setDescription('Use a couple of words to summarize the issue/change'),
                TextareaField::create('Description', 'Description')->setDescription('Leave a detailed description of the issue/change here'),
                HiddenField::create('Element', 'Element')
            ),
            FieldList::create(
                FormAction::create('SaveTask', 'Save')
            ),
            RequiredFields::create('Title', 'Description')
        );

        // if github integration is enabled push the checkbox
        if ($currentSiteConfig->EnableGitIssueCreating && $currentSiteConfig->GithubUser && $currentSiteConfig->GithubRepo) {
            $form->Fields()->push(CheckboxField::create('SubmitToGitHub', 'Create a GitHub issue?'));

            // add dropdown if we have milestones
            $milestones = Milestone::get()->filter('MilestonesLastUpdatedID', $currentSiteConfig->MilestonesLastUpdatedID);
            if ($milestones->count() > 0) {
                $form->Fields()->push(DropdownField::create('milestone', 'Milestone', $milestones->map('Number', 'Title'))->setEmptyString('-- select a milestone --'));
            }
        }
        
        return $form;
    }
    
    /*
     * creates a new task for the current page
     */
    public function SaveTask($data, $form)
    {
        // make sure the user is logged in
        if ($member = Security::getCurrentUser()) {
            // get the current site config
            $currentSiteConfig = SiteConfig::current_site_config();
            
            // make sure it's set to submut to github
            //@todo the description and title should be escaped
            //@todo the page link should also be included
            if (array_key_exists('SubmitToGitHub', $data)) {
                // create an issue - if it's enabled
                if ($currentSiteConfig->EnableGitIssueCreating && $currentSiteConfig->GithubUser && $currentSiteConfig->GithubRepo) {
                    // get the milestone if selected
                    $milestone = array_key_exists('milestone', $data) ? $data['milestone'] : '';

                    //@todo would be nice to save a reference to the cms, but need a way to clear it when the issue is done.
                    $createIssue = $this->createGitIssue(
                        $currentSiteConfig->GithubUser,
                        $currentSiteConfig->GithubRepo,
                        $data['Title'],
                        $data['Description'],
                        $milestone
                    );

                    // if we couldn't create the issue redirect back and show error
                    if ($createIssue === false) {
                        $form->sessionMessage('An error has occurred submitting to github. Double check your credentials.', ValidationResult::TYPE_ERROR);
                        
                        return $this->owner->redirect(
                            Controller::join_links(
                                $this->owner->Link(),
                                '#taskmanager-open'
                            )
                        );
                    }

                    // get the details
                    $createIssue = json_decode($createIssue->getBody()->getContents());
                }
            }

            //create a new task for this page
            $new = Task::create();

            $new->Title = $data['Title'];
            $new->Description = $data['Description'];
            
            if ($data['Element']) {
                $new->Element = $data['Element'];
            }
            $new->PageID = $this->owner->ID;
            //the user that create the task
            $new->MemberID = $member->ID;

            // if it's a github issue note it
            if (array_key_exists('SubmitToGitHub', $data)) {
                $new->GitHubIssue = 1;
                $new->GitHubID = $createIssue->id;
                $new->GitHubLink = $createIssue->html_url;
            }

            // write
            $new->write();

            $form->sessionMessage('Issue created successfully.', 'good');

            return $this->owner->redirect(
                Controller::join_links(
                    $this->owner->Link(),
                    '#taskmanager-open'
                )
            );
        }
    }
    
    /*
     * mark a task as completed
     */
    public function CompleteTask()
    {
        //make sure the user is logged in as admin
        if (Permission::check('ADMIN')) {
            $item = Task::get()->byID($this->owner->request->param('ID'));
            $item->Complete = 1;
            $item->write();
        }
        
        return $this->owner->redirectBack();
    }
}
