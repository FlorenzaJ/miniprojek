<?php
class AuthMiddleware{
    public static function Authenticated(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        }
    }

    public static function Admin() {
        self::Authenticated();
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: admin');
            exit();
        }
    }

    public static function Guest() {
        if (isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
    }

    function isLoggedIn() {
        if(isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get current user ID
    function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    // Check if user has permission to access a resource
    function checkPermission($resourceOwnerId) {
        if(!isLoggedIn()) {
            return false;
        }
        
        // Admin can access all resources
        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            return true;
        }
        
        // Regular users can only access their own resources
        return $_SESSION['user_id'] == $resourceOwnerId;
    }
}