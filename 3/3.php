<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'test';

function generateRandomString($length = 25) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class DB{
    private $host;
    private $user;
    private $password;
    private $db;
    private $connect;

    public function __construct($host, $user, $password, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
        $this->connect = $this->connect();
    }

    private function connect()
    {
        $connect = mysqli_connect($this->host, $this->user, $this->password, $this->db);

        if (!$connect){
            return mysqli_connect_error();
        }
        else{
            return $connect;
        }
    }

    private function fill()
    {
        $results = ['normal', 'illegal', 'failed', 'success'];
        $random_result = $results[array_rand($results,1)];
        $random_script_name = generateRandomString();
        $random_start_time = rand(0,5);
        $random_end_time = rand(5,10);
        $sql = sprintf("INSERT INTO tests (id, script_name, start_time, end_time, result) VALUES (null, '%s', %d, %d, '%s');", $random_script_name, $random_start_time, $random_end_time, $random_result);
        $result = mysqli_query($this->connect, $sql);
        if (!$result) {
            print("Произошла ошибка при выполнении запроса");
        }
        else{
            return 'success';
        }
    }

    public function get()
    {
        for ($i=0;$i<10;$i++)
        {
            $this->fill();
        }

        $sql = "SELECT * FROM tests WHERE result='normal' or result='success'";
        $result = mysqli_query($this->connect, $sql);
        if (!$result) {
            print("Произошла ошибка при выполнении запроса");
        }
        else{
            while ($row = mysqli_fetch_array($result)) {
                print("Script name: " . $row['script_name'] . "; Result: " . $row['result'] . "\r\n");
            }
            return 'success';
        }
    }
}


$dbcon = new DB($host,$user,$password,$db);
$res = $dbcon->get();
echo $res;