<?php
class SavingController{
    private $database;
    private $savingsModel;

    public function __construct() {
        $database = new Database();
        $this->database = $database->connect();
        require_once 'app/models/Savings.php';
        $this->savingsModel = new Savings($this->database);
    }

    public function index() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $message = $_POST['message'];
            $user_id = $_SESSION['user_id'];

            if($this->savingsModel->addSavings($user_id, $amount, $message)) {
                header('Location: home');
                exit();
            }
        }

        require_once 'app/views/save.php';
    }
}