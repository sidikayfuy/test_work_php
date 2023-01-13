<?php

$users = [[0, 'Max', 'asd@asd.asd'], [1, 'NotMax', 'qwe@qwe.qwe']];

function emails ($users){
    $email_list = [];
    foreach ($users as $user){
        $email_list[] = $user[2];
    }
    return $email_list;
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

date_default_timezone_set('Europe/Moscow');
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

if (strpos($email, '@') && $password == $confirm_password) {
    if (in_array($email, emails($users))){
        echo 1;
        $txt = sprintf('[%s]; Результат проверки: %s; Email: %s; Password: %s', date("Y-m-d H:i:s"), 'success', $email, $password);
    }
    else{
        echo 0;
        $txt = sprintf('[%s]; Результат проверки: %s; Email: %s; Password: %s', date("Y-m-d H:i:s"), 'failed', $email, $password);
    }

    fwrite($myfile, $txt.PHP_EOL);
}
else{
    echo -1;
}