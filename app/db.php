<?php
class Database {
    const DB_HOSTNAME = 'db';
    const DB_USERNAME = 'user';
    const DB_PASSWORD = 'test';
    const DB_NAME = 'todo';
    protected $_db_connect;
    protected $_sqlCreateUser;
    protected $_sqlCreateTask;
    protected $_sqlUpdateTask;
    protected $_sqlDeleteTask;
    protected $_sqlSelectOneUser;
    protected $_sqlSelectAllTask;
    protected $_result;
    protected $_row;
    public $nameTable = ['users', 'tasks'];

    function db_connect(){
        $this->_db_connect = mysqli_connect(self::DB_HOSTNAME,self::DB_USERNAME,self::DB_PASSWORD, self::DB_NAME) or die(mysqli_error($this->_db_connect));
    }

    function select_db(){
        mysqli_select_db($this->_db_connect, self::DB_NAME) or die(mysqli_error($this->_db_connect));
    }

    function sqlCreateUser($login, $email, $password){
        $this->_sqlCreateUser = 'INSERT INTO users (login, email, password) VALUES ('$login', '$email', '$password')';
    }
    function sqlCreateTask($task){
        $this->_sqlCreateTask = 'INSERT INTO tasks (task) VALUES ('$task')';
    }
    function sqlUpdateTask($id){
        $this->_sqlUpdateTask = 'UPDATE tasks SET task WHERE id='.$id;
    }
    function sqlDeleteTask($id){
        $this->_sqlDeleteTask = 'DELETE FROM tasks WHERE id='.$id;
    }
    function sqlSelectOneUser($db,$_POST['login']){
        $this->_sqlSelectOneUser = 'SELECT login, password FROM users WHERE login='".mysqli_real_escape_string($db,$_POST['login'])."' LIMIT 1';
    }
    function sqlSelectAllTask(){
        $this->_sqlSelectAllTask = 'SELECT * FROM tasks';
    }

    function Create(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }
    function Update(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }
    function Delete(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }
    function Insert(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }
    function SelectOne(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }
    function SelectAll(){
        $this->_result = mysqli_query($this->_db_connect, $this->_sql);
    }

//    function fetch_array(){
//        while($this->_row = mysqli_fetch_array($this->_result)){
//            $username = $this->_row['user_USERNAME'];
//
//            echo "<ul>";
//            echo "<li>".$username."</li>";
//            echo "</ul>";
//        }
//    }

    function db_close(){
        mysqli_close($this->_db_connect);
    }
}

$database = new Database();
var_dump($database->db_connect());
var_dump($database->select_db());
var_dump($database->sql());
var_dump($database->query());
//var_dump($database->fetch_array());
//var_dump($database->db_close());

