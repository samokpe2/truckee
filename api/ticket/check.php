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
            $ticket_id = $data->ticket_id;
            $ticket->checkTicket($ticket_id);

        

        break;

    case 'GET':
        
        break;
    default:
        // Invalid Request Method
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}