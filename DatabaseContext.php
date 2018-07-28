<?php

/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 16/06/2018
 * Time: 9:39 PM
 */
spl_autoload_extensions(".php");
spl_autoload_register();

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
    public function findUser($email){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Users WHERE email = ?");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
            $statement->execute([$email]);

            $results = $statement->fetch();
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

    public function authenticateUser($username, $password){
        $username = stripcslashes($username);
        $password = stripcslashes($password);

        try{
            $connection =  new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $connection->prepare("SELECT * FROM Users WHERE email = ? AND password = ?");
            $query->setFetchMode(PDO::FETCH_CLASS, 'User');
            $query->execute(array($username, $password));
            $result = $query->fetch();

            //$result will be false if incorrect or doesn't exist
            return($result);
        }
        catch (PDOException $e){
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
    public function addGroup($group){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement =  $connection->prepare("INSERT INTO Groups (name)
                      VALUES (:gname )");
                $statement->execute(array(
                    "gname" => $group->getName()
                    )
            );

            return $connection->lastInsertId();
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function addEvent($event, $id){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement =  $connection->prepare("INSERT INTO Events (title, location, attendees) 
                      VALUES (:ename, :loc, :creator )");
            $statement->execute(array(
                    "ename" => $event->getTitle(),
                    "loc" => $event->getLocation(),
                    "creator"> $id)
            );
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }
    public function getEvent($id){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("SELECT * FROM Events WHERE Id = ?");
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Event');
            $statement->execute([$id]);

            $result = $statement->fetch();
            return $result;
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }


    public function updateUser($user){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("UPDATE Users SET first_name = ?, second_name = ?, friends = ?, 
                email = ?, password=?, groups=?, events=? WHERE Id = ?");

            $statement->execute(array(
                $user->getFirstName(),
                $user->getSecondName(),
                $user->getFriends(User::AS_PROPERTY),
                $user->getEmail(),
                $user->getPassword(),
                $user->getGroups(Group::AS_PROPERTY),
                $user->getEvents(Event::AS_PROPERTY),
                $user->getId()
                )
            );
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function updateEvent($event){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("UPDATE Events SET title = ?, location = ?, attendees = ? 
                                                  WHERE Id = ?");
            $statement->execute(array(
                $event->getTitle(),
                $event->getLocation(),
                $event->getAttendees(Event::AS_PROPERTY),
                $event->getId()
                )
            );
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function updateGroup($group){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("UPDATE Groups SET name = ?, members = ? WHERE Id = ?");
            $statement->execute(array(
                $group->getName(),
                $group->getMembers(Group::AS_PROPERTY),
                $group->getID()
            ));
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }

    public function deleteGroup($id){
        try {
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $connection->prepare("DELETE FROM Groups WHERE Id = ?");
            $statement->execute([$id]);
        }
        catch(PDOException $e){
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }
    }
}