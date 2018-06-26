<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 16/06/2018
 * Time: 9:39 PM
 */
class DatabaseContext
{
    private $dsn;
    private $username;
    private $password;

    public function __construct()
    {
        $this->dsn = "sqlsrv:server = tcp:eagerbeavers.database.windows.net,1433; Database = SQLEagerBeavers";
        $this->username = "nicebeaver";
        $this->password = "bits2018!";
    }

    public function getUsers(){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Users");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
            $statement->execute();

            $results = $statement->fetchAll();
            return $results;
        }
        catch (PDOException $e) {
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function getUser($id){
        try{
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Users WHERE Id = ?");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
            $statement->execute([$id]);

            $result = $statement->fetch();
            return $result;
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function addUser($user){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement =  $connection->prepare("INSERT INTO Users (first_name, second_name, email, password, friends, groups) 
                      VALUES (:fname, :sname, :mail, :pass, '','')");
            $statement->execute(array(
                "fname" => $user->getFirstName(),
                "sname" => $user->getSecondName(),
                "mail" => $user->getEmail(),
                "pass" => md5($user->getPassword()) //md5 to hash the password to db
            ));
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }

    }

    public function getGroups(){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Groups");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Group');
            $statement->execute();

            $results = $statement->fetchAll();
            return $results;
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }
    public function getGroup($id){
        try{
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Groups WHERE Id = ?");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Group');
            $statement->execute([$id]);

            $result = $statement->fetch();
            return $result;
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    /* To Do list
     *
     * AddGroup
     * AddEvent
     * UpdateUser
     * UpdateEvent
     * UpdateGroup
     *
     * ** Possibly class methods **
     * AddUserToEvent
     * AddUserToGroup
     * RemoveUserFromEvent
     * RemoveUserFromGroup
     *

     */
}