<?php
include '../config.php';
include '../http/header.php';
include '../http/request.php';
include '../autoload.php';




$data = json_decode(file_get_contents('php://input'));
$admin = new admin();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'POST':
        // Insert User
        $admin->email = $data->email;
        $admin->setPassword($data->password);
        $admin->login();
        break;

    case 'GET':

        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}