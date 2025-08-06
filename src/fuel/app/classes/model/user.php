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
    
    public function get_role_name()
    {
        switch($this->group_id) {
            case 1: return 'Normal';
            case 2: return 'Author';
            case 3: return 'Admin';
        }
    }
    
    public function is_admin()
    {
        return $this->group == 3;
    }
    
    public function is_author()
    {
        return $this->group >= 2;
    }
    
    public function can_manage_users()
    {
        return $this->is_admin();
    }
    
    public function can_manage_posts()
    {
        return $this->is_author();
    }
} 