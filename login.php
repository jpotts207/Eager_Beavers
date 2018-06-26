<?php
/**
 * Created by PhpStorm.
 * User: Tapra
 * Date: 26/6/18
 * Time: 16:09
 */

spl_autoload_extensions('.php');
spl_autoload_register();

$error='';
$result = '';

class login {

    private $dsn;
    private $user;
    private $pass;

    public function __construct()
    {
        $this->dsn = "sqlsrv:server = tcp:eagerbeavers.database.windows.net,1433; Database = SQLEagerBeavers";
        $this->user = "nicebeaver";
        $this->pass = "bits2018!";
    }

    public function login(){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = stripcslashes($username);
        $password = stripcslashes($password);

        $username = mysqli_real_escape_string($username);
        $password = mysqli_real_escape_string($password);

        try{
            $connection =  new PDO($this->dsn, $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = mysqli_query($connection, "SELECT * FROM Users where email='$username' and password ='$password'");
            $query->setFetchMode(PDO::FETCH_CLASS, 'User');
            $query->execute();

            $rows = mysqli_num_rows($query);
            if ($rows == 1){
                $error = 'login success';
            } else {
                $error = 'login fail';
            }
            return($error);
            mysqli_close($connection);
        }
        catch (PDOException $e){
            die(print_r($e));
        }
    }
}
