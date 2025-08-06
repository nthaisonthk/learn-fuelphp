<?php

class Model_User extends \Orm\Model
{
    protected static $_table_name = 'users';
    
    protected static $_properties = array(
        'id',
        'username',
        'email',
        'password',
        'salt',
        'group_id',
        'profile_fields',
        'last_login',
        'login_hash',
        'created_at',
        'updated_at',
    );
    
    protected static $_has_many = array(
        'posts' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Post',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'comments' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Comment',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
} 