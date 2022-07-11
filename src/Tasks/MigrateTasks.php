<?php

namespace BucklesHusky\TaskManager\Tasks;

use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

class MigrateTasks extends BuildTask
{
    protected $title = "Migrate Tasks for Taskmanager";

    protected $description = 'Migrate Tasks for Taskmanager';

    private static $segment = 'MigrateTasks';

    /**
     * @inheritDoc
     */
    public function run($request)
    {
        DB::get_conn()->withTransaction(
            function () {
                $eol = (Director::is_cli() ? PHP_EOL : '<br />');

                // drop table
                DB::query('DROP TABLE task');

                // rename table
                DB::query('RENAME TABLE buckleshusky_taskmanager_model_task TO Task;');

                print 'Migrated successfully.' . $eol;
            }
        );
    }
}
