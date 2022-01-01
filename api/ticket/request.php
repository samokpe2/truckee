<?php
include '../config.php';
include '../http/header.php';
include '../http/request.php';
include '../autoload.php';

$data = json_decode(file_get_contents('php://input'));
$ticket = new ticket();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'POST':
        // Insert User
        
            $ticket->truck_driver_id = $data->truck_driver_id;
            $ticket->container_id = $data->container_id;
            $ticket->container_contents = $data->container_contents;
            $clientEmail = $data->client_email;
            $ticket->requestTicket($clientEmail);

        

        break;

    case 'GET':
        
        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}