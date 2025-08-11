<?php

namespace Fuel\Migrations;

class Add_Columns_To_Users
{
    public function up()
    {
        // Add group_id column
        try {
            \DB::query('ALTER TABLE `users` ADD COLUMN `group_id` INT(11) DEFAULT 1')->execute();
        } catch (Exception $e) {
        }
        
        // Add profile_fields
        try {
            \DB::query('ALTER TABLE `users` ADD COLUMN `profile_fields` TEXT NULL')->execute();
        } catch (Exception $e) {
        }
        
        // Add created_at and updated_at
        try {
            \DB::query('ALTER TABLE `users` ADD COLUMN `created_at` INT(11) NULL')->execute();
        } catch (Exception $e) {
        }
        
        try {
            \DB::query('ALTER TABLE `users` ADD COLUMN `updated_at` INT(11) NULL')->execute();
        } catch (Exception $e) {
        }
    }

    public function down()
    {
        // Remove added columns
        try {
            \DB::query('ALTER TABLE `users` DROP COLUMN `group_id`')->execute();
        } catch (Exception $e) {
        }
        
        try {
            \DB::query('ALTER TABLE `users` DROP COLUMN `profile_fields`')->execute();
        } catch (Exception $e) {
        }
        
        try {
            \DB::query('ALTER TABLE `users` DROP COLUMN `created_at`')->execute();
        } catch (Exception $e) {
        }
        
        try {
            \DB::query('ALTER TABLE `users` DROP COLUMN `updated_at`')->execute();
        } catch (Exception $e) {
        }
    }
} 