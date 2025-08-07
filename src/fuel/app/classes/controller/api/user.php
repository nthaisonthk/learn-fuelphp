<?php

class Controller_Api_User extends \Fuel\Core\Controller_Rest
{
    /**
     * GET /api/user
     * Lấy danh sách tất cả users
     */
    public function get_index()
    {
        try {
            // Kiểm tra quyền truy cập (chỉ admin mới được xem)
            if (!Auth::check()) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ), 401);
            }
            
            $user = Auth::get_user();
            if ($user->group_id != ROLE_ADMIN) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'Access denied. Admin only.'
                ), 403);
            }
            
            // Lấy danh sách users
            $users = Model_User::query()
                ->select('id', 'username', 'email', 'group_id', 'created_at', 'updated_at')
                ->order_by('created_at', 'DESC')
                ->get();
            
            // Format dữ liệu trả về
            $user_list = array();
            foreach ($users as $user) {
                $user_list[] = array(
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'group_id' => $user->group_id,
                    'role' => $this->get_role_name($user->group_id),
                    'created_at' => date('Y-m-d H:i:s', $user->created_at),
                    'updated_at' => date('Y-m-d H:i:s', $user->updated_at)
                );
            }
            
            return $this->response(array(
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => array(
                    'total' => count($user_list),
                    'users' => $user_list
                )
            ), 200);
            
        } catch (Exception $e) {
            return $this->response(array(
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ), 500);
        }
    }
    
    /**
     * GET /api/user/{id}
     * Lấy thông tin chi tiết của một user
     */
    public function get_view($id = null)
    {
        try {
            if (!$id) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'User ID is required'
                ), 400);
            }
            
            // Kiểm tra quyền truy cập
            if (!Auth::check()) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ), 401);
            }
            
            $current_user = Auth::get_user();
            if ($current_user->group_id != ROLE_ADMIN && $current_user->id != $id) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'Access denied'
                ), 403);
            }
            
            // Lấy thông tin user
            $user = Model_User::query()
                ->select('id', 'username', 'email', 'group_id', 'created_at', 'updated_at')
                ->where('id', $id)
                ->get_one();
            
            if (!$user) {
                return $this->response(array(
                    'status' => 'error',
                    'message' => 'User not found'
                ), 404);
            }
            
            $user_data = array(
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'group_id' => $user->group_id,
                'role' => $this->get_role_name($user->group_id),
                'created_at' => date('Y-m-d H:i:s', $user->created_at),
                'updated_at' => date('Y-m-d H:i:s', $user->updated_at)
            );
            
            return $this->response(array(
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $user_data
            ), 200);
            
        } catch (Exception $e) {
            return $this->response(array(
                'status' => 'error',
                'message' => 'Internal server error: ' . $e->getMessage()
            ), 500);
        }
    }
    
    /**
     * Helper function để lấy tên role
     */
    private function get_role_name($group_id)
    {
        switch ($group_id) {
            case ROLE_ADMIN:
                return 'Admin';
            case ROLE_AUTHOR:
                return 'Author';
            case ROLE_USER:
            default:
                return 'Normal User';
        }
    }
}
