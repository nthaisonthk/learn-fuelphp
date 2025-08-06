<?php

namespace Fuel\Migrations;

class Create_Posts_Table
{
    public function up()
    {
        \DBUtil::create_table('posts', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
            'slug' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
            'content' => array('type' => 'text', 'null' => false),
            'excerpt' => array('type' => 'text', 'null' => true),
            'featured_image' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
            'status' => array('type' => 'enum', 'constraint' => "'draft','published'", 'default' => 'draft'),
            'user_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'created_at' => array('type' => 'int', 'constraint' => 11, 'null' => true),
            'updated_at' => array('type' => 'int', 'constraint' => 11, 'null' => true),
        ), array('id'), true, 'InnoDB', 'utf8_unicode_ci');
        
        // Add foreign key
        \DB::query('ALTER TABLE `posts` ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE')->execute();
        
        // Add unique constraint for slug
        \DB::query('ALTER TABLE `posts` ADD UNIQUE KEY `slug` (`slug`)')->execute();
    }

    public function down()
    {
        \DBUtil::drop_table('posts');
    }
}