<?php
include '../config.php';
include '../http/header.php';
include '../http/request.php';
include '../autoload.php';

$data = json_decode(file_get_contents('php://input'));
$admin = new admin();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'GET':
        // Insert User
        $email = $_GET['client_id'];
        $blacklist = $_GET['blacklist'];
            $admin->blacklist($email, $blacklist);

            header("Location: http://localhost/truckee/admin/viewclient.html");

        

        break;

    case 'POST':
        
        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}