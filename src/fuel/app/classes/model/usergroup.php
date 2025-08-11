<?php

class Model_UserGroup extends \Orm\Model
{
    protected static $_table_name = 'users_groups';

    protected static $_properties = [
        'id',
        'name',
        'user_id',
        'created_at',
        'updated_at',
    ];
}