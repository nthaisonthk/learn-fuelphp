<?php

/**
 * @group model
 */
class Test_Model_User extends TestCase
{
    public function test_create_user()
    {
        $user = Model_User::forge([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('testuser', $user->username);
        $this->assertEquals('test@example.com', $user->email);
    }
}