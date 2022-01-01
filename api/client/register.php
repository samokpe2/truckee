<?php
include '../config.php';
include '../http/header.php';
include '../http/request.php';
include '../autoload.php';

$data = json_decode(file_get_contents('php://input'));
$client = new client();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'POST':
        // Insert User
        if(empty($data->email) || empty($data->password)){
            $response = array('status' => false, 'message' => 'Sorry Please, Something went wrong, Try again.');
            echo json_encode($response);
            header('Content-Type: application/json');
        }else{
            $client->name = $data->name;
            $client->phone_number = $data->phone_number;
            $client->setPassword(password_hash($data->password, PASSWORD_DEFAULT));
            $client->email = $data->email;
            $client->postal_address = $data->postal_address;
            $client->time = date('h:i A');
            $client->date = date("l jS \of F Y");
            $client->register();

        }

        break;

    case 'GET':
        
        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}