<?php

class Model_Post extends \Orm\Model
{
    protected static $_table_name = 'posts';

    // các field
    protected static $_properties = array(
        'id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'user_id',
        'created_at',
        'updated_at',
    );
    
    protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'user_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    
    protected static $_has_many = array(
        'comments' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Comment',
            'key_to' => 'post_id',
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
    
    public function get_approved_comments()
    {
        return Model_Comment::query()
            ->where('post_id', $this->id)
            ->where('status', 'approved')
            ->order_by('created_at', 'ASC')
            ->get();
    }
    
    public function get_excerpt($length = 150)
    {
        if (!empty($this->excerpt)) {
            return $this->excerpt;
        }
        
        $content = strip_tags($this->content);
        if (strlen($content) <= $length) {
            return $content;
        }
        
        return substr($content, 0, $length) . '...';
    }
    
    public function is_published()
    {
        return $this->status == 'published';
    }
} 