<?php
class HomeController{
    private $database;
    private $savingsModel;

    public function __construct(){
        $database=new Database();
        $this->database = $database->connect();
        require_once 'app/models/Savings.php';
        $this->savingsModel = new Savings($this->database);
    }

    public function index(){
        //Calls function Authenticated() from AuthMiddleware
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::Authenticated();
        
        $savings = $this->savingsModel->allSavings();
        $Admin = $_SESSION['user_role'] === 'admin';
        require_once 'app/models/Savings.php';
        $user_id = $_SESSION['user_id'];

        $savingsModel = new savings($this->database);
        $totalSavings = $savingsModel->getTotalSavings($_SESSION['user_id']);
        require_once 'app/views/home.php';
    }

    public function admin(){
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::Admin();
        
        require_once 'app/models/User.php';
        $userModel = new User($this->database);
        $users = $userModel->AllUsers();
        $savings = $this->savingsModel->allSavings();
        
        require_once 'app/views/admin.php';
    }
}