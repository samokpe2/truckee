<?php

require_once 'database.php';
require_once 'client.php';
class truckdriver
{
    public $db;
    public  $name;
    public  $phone_number;
    public  $email;
    public  $address;
    public  $client;
    public  $transit_id;
    public  $time;
    public  $date;


    public function __construct(){
        $this->db = new database();
        $this->client = new client();
    }

    public function getID(){
        $data = $this->db->view("SELECT * from truck_driver where email = '".$this->email."'");
        if($data){
            return $data['0']['id'];
        }else{
            return false;
        }
    }

    public function isDriverExist(){
        $count = $this->db->viewandCount("SELECT * from truck_driver where email = '".$this->email."'");
        if($count==1){
            return true;
        }else{
            return false;
        }
    }


    public function add($clientEmail){
        if($this->isDriverExist()){
            $response = array('status' => false, 'message' => 'This email  has been registered');
            echo json_encode($response);
            header('Content-Type: application/json');

        }else{
            $this->client->email = $clientEmail;
            $clientID = $this->client->getID();
            $clientData = array("name"=>$this->name, "phone_number"=>$this->phone_number, "email"=>$this->email,
             "address"=>$this->address, "client_id"=>$clientID, "transit_id"=>$this->transit_id, "time"=>$this->time, "date"=>$this->date);
            $result = $this->db->insert("truck_driver", $clientData);
            if($result){
                $response = array('status' => true, 'message' => 'Registration was Sucessful');
                echo json_encode($response);
                header('Content-Type: application/json');
            }else{
                $response = array('status' => false, 'message' => 'Registration was not Succesful');
                echo json_encode($response);
                header('Content-Type: application/json');
            }
        }
    }

    public function getName($id){
        $data = $this->db->view("SELECT * from truck_driver where id = '".$id."'");
        return $data['0']['name'];
        
    }

    public function getTruckDrivers($clientEmail){
        $this->client->email = $clientEmail;
        $clientID = $this->client->getID();
        $data = $this->db->view("SELECT * from truck_driver where client_id = '".$clientID."'");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function getCountTruckDrivers($clientEmail){
        $this->client->email = $clientEmail;
        $clientID = $this->client->getID();
        $data = $this->db->viewAndCount("SELECT * from truck_driver where client_id = '".$clientID."'");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

   





}