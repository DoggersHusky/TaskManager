<?php

namespace BucklesHusky\TaskManager\Extension;

use SilverStripe\Core\Environment;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
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
        $gitToken = Environment::getEnv('GITHUB_TOKEN');

        if ($gitToken) {
            $fields->addFieldToTab(
                'Root.Github',
                CheckboxField::create(
                    'EnableGitIssueCreating',
                    'Enable GitHub features?'
                )
                ->setDescription('With this enabled, admins can create issues in this project\'s repo without needing to login to guthub.')
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
        } else {
            $fields->addFieldToTab('Root.Github', LiteralField::create('NoGitHub', '<p>You do not have <strong>`GITHUB_TOKEN`</strong> set in your .env</p>'));
        }

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

            $actions->push(
                FormAction::create(
                    'updateIssues',
                    'Update issues'
                )
            );
        }
    }
}
