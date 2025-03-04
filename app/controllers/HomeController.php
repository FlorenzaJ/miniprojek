<?php
class HomeController{
    private $database;
    private $savingsModel;

    public function _construct(){
        $database=new Database();
        $this->database = $database->connect();
        require_once 'app/models/Donation.php';
        $this->savingsModel = new Savings($this->database);
    }

    public function index(){
        //Calls function Authenticated() from AuthMiddleware
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::Authenticated();
        
        $donations = $this->savingsModel->allSavings();
        $isAdmin = $_SESSION['user_role'] === 'admin';
        require_once 'app/views/home.php';
    }

    public function admin(){
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::Admin();
        
        require_once 'app/models/User.php';
        $userModel = new User($this->db);
        $users = $userModel->AllUsers();
        $Savings = $this->savingsModel->allSavings();
        require_once 'app/views/admin.php';
    }
}