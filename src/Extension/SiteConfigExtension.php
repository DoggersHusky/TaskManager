<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;

class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'EnableGitIssueCreating' => 'Boolean',
        'GithubUser' => 'Varchar(255)',
        'GithubRepo' => 'Varchar(255)',
        'AssignUserToIssue' => 'Boolean',
        'MilestonesLastUpdatedID' => 'Int',
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab(
            'Root.Github',
            CheckboxField::create(
                'EnableGitIssueCreating',
                'Enable GitHub features?'
            )
            ->setDescription('With this enabled, admins can create issues in this project\'s repo without needing to login to guthub.<br/><strong>Note:</strong> You must have a token set in the ENV file.')
        );

        $fields->addFieldToTab(
            'Root.Github',
            TextField::create('GithubUser', 'GitHub user')
            ->setDescription('This can be found in the repos url. example: https://github.com/<strong>USER</strong>/REPO/')
        );

        $fields->addFieldToTab(
            'Root.Github',
            CheckboxField::create(
                'AssignUserToIssue',
                'Should the user to the issue?'
            )
        );
        
        $fields->addFieldToTab(
            'Root.Github',
            TextField::create('GithubRepo', 'GitHub repo')
            ->setDescription('This can be found in the repos url. example: https://github.com/USER/<strong>REPO</strong>/')
        );

        return $fields;
    }

    /**
     * update cms actions
     */
    public function updateCMSActions($actions)
    {
        // get the current site config
        $currentSiteConfig = SiteConfig::current_site_config();

        if ($currentSiteConfig->EnableGitIssueCreating && $currentSiteConfig->GithubUser && $currentSiteConfig->GithubRepo) {

            // add button to update milestones
            $actions->push(
                    FormAction::create(
                    'updateMileStones',
                    'Update milestones'
                )
            );
        }
    }
}
