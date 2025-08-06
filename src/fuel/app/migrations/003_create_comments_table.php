<?php

namespace Fuel\Migrations;

class Create_Comments_Table
{
    public function up()
    {
        \DBUtil::create_table('comments', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'content' => array('type' => 'text', 'null' => false),
            'status' => array('type' => 'enum', 'constraint' => "'pending','approved','spam'", 'default' => 'pending'),
            'post_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'user_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'parent_id' => array('type' => 'int', 'constraint' => 11, 'null' => true), // For nested comments
            'created_at' => array('type' => 'int', 'constraint' => 11, 'null' => true),
            'updated_at' => array('type' => 'int', 'constraint' => 11, 'null' => true),
        ), array('id'), true, 'InnoDB', 'utf8_unicode_ci');
        
        // Add foreign keys
        \DB::query('ALTER TABLE `comments` ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE')->execute();
        \DB::query('ALTER TABLE `comments` ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE')->execute();
        \DB::query('ALTER TABLE `comments` ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE')->execute();
    }

    public function down()
    {
        \DBUtil::drop_table('comments');
    }
}