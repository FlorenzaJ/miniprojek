<?php
class User{
    private $connection;
    private $table = 'users';

    public function _construct($db){
        $this->connection = $db;
    }
}
?>