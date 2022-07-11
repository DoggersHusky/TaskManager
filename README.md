Task Manager
=================
Keep track of issues with the site. This allows the user to highlight broken stuff on a page and create a task. It also allows you to mark the Task as completed.

## Maintainer Contact
* Buckles

## Requirements
* SilverStripe CMS 4.x 


## Installation
* Run composer require buckleshusky/taskmanager dev-master in the project folder
* Run dev/build?flush=all to regenerate the manifest

## Upgrading from 0.1.*
After you have updated to the latested version, run `dev/tasks/MigrateTasks` to fix the table and your task should start showing.

## Example Usage
add the below to your template file
```php
$TaskManager
```

With github enabled, you can:
* update Milestones here: `admin/settings/`
    * this will pull in all open Milestones for the project
* update Issues here: `admin/settings/`
    * this will pull in the 50 most recent closed issues and mark complete in task manager

#### Configuration Options
How to setup Github issue submitting:
* generate a new personal token [here](https://github.com/settings/tokens)
    * make sure yoy have the following permissions set: `repo` 
* in your .env set the following variable with your token `GITHUB_TOKEN='YOUR_TOKEN'`
* flush your site `flush=1`
* visit your site settings `admin/settings/` and navigate to the Github tab
* check `Enable GitHub features?`
* set the user that will be used for accessing `GitHub user`
* enable if the created issue should be assigned to the `GitHub user`
* and finally set the repo `GitHub repo`