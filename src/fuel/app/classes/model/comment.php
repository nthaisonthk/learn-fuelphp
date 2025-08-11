<?php

class Model_Comment extends \Orm\Model
{
    protected static $_table_name = 'comments';
    
    protected static $_properties = array(
        'id',
        'content',
        'status',
        'post_id',
        'user_id',
        'parent_id',
        'created_at',
        'updated_at',
    );
    
    protected static $_belongs_to = array(
        'post' => array(
            'key_from' => 'post_id',
            'model_to' => 'Model_Post',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'user' => array(
            'key_from' => 'user_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'parent' => array(
            'key_from' => 'parent_id',
            'model_to' => 'Model_Comment',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    
    protected static $_has_many = array(
        'replies' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Comment',
            'key_to' => 'parent_id',
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
    
    public function is_approved()
    {
        return $this->status == 'approved';
    }
    
    public function is_pending()
    {
        return $this->status == 'pending';
    }
    
    public function is_spam()
    {
        return $this->status == 'spam';
    }
    
    public function get_replies()
    {
        return Model_Comment::query()
            ->where('parent_id', $this->id)
            ->where('status', 'approved')
            ->order_by('created_at', 'ASC')
            ->get();
    }
} 