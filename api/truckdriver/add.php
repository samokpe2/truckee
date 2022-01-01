<?php
include '../config.php';
include '../http/header.php';
include '../http/request.php';
include '../autoload.php';

$data = json_decode(file_get_contents('php://input'));
$truckdriver = new truckdriver();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'POST':
        // Insert User
        if(empty($data->email)){
            $response = array('status' => false, 'message' => 'Sorry Please, Something went wrong, Try again.');
            echo json_encode($response);
            header('Content-Type: application/json');
        }else{
            $truckdriver->name = $data->name;
            $truckdriver->phone_number = $data->phone_number;
            $truckdriver->email = $data->email;
            $truckdriver->address = $data->address;
            $truckdriver->transit_id = $data->transit_id;
            $clientEmail = $data->client_email;
            $truckdriver->time = date('h:i A');
            $truckdriver->date = date("l jS \of F Y");
            $truckdriver->add($clientEmail);

        }

        break;

    case 'GET':
        
        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}