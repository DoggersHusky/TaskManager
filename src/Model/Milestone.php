<?php

namespace BucklesHusky\TaskManager\Model;

use SilverStripe\ORM\DataObject;

class Milestone extends DataObject
{
    private static $table_name = 'Milestone';

    //@todo should have a model admin to manage these
    private static $db = [
        'Title' => 'Varchar(255)',
        'Number' => 'Int',
        'MilestonesLastUpdatedID' => 'Varchar(255)',
    ];
}
