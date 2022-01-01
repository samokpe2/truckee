<?php

require_once 'database.php';
class admin
{
    public $db;
    public  $name;
    public  $phone_number;
    public  $email;
    private  $password;
    public  $postal_address;
    public  $time;
    public  $date;


    public function __construct(){
        $this->db = new database();
    }



    public function getPassword(){
        return $this->password;
    }

    public function setPassword($code){
        $this->password = $code;
    }

    public function isClientExist(){
        $count = $this->db->viewandCount("SELECT * from admin where email = '".$this->email."'");
        if($count==1){
            return true;
        }else{
            return false;
        }
    }


    public function blackList($clientEmail, $blacklist){
        $clientData = array("blacklisted"=>$blacklist);
        $data = $this->db->update("client",$clientData, "id = '".$clientEmail."'");
        if($data){
            $response = array('status' => true, 'message' => 'This client has been blacklisted');
            echo json_encode($response);
            header('Content-Type: application/json');
        }else{
            $response = array('status' => false, 'message' => 'Sorry,  Operation was not successful try again');
            echo json_encode($response);
            header('Content-Type: application/json');
        }
    }

    public function login(){
        $data = $this->db->view("SELECT * from admin where email = '".$this->email."'");
        if(self::isClientExist()){
            if(!password_verify($this->password, $data['0']['password'])){
                $response = array('status' => false, 'message' => 'Sorry, The Password is Incorrect Pls Try again');
                echo json_encode($response);
                header('Content-Type: application/json');
            }else{
                $clientData = array("name"=>$data['0']['name'],  "email"=>$data['0']['email']);
                $response = array("status"=> true, "message" => "Login Successful", "data"=> $clientData);
                echo json_encode($response);
                header('Content-Type: application/json');
            }
        }else{
            $response = array('status' => false, 'message' => 'Sorry, The Email is not registered');
            echo json_encode($response);
            header('Content-Type: application/json');
        }
     
        
    }


    public function getCountClients(){
        $data = $this->db->viewAndCount("SELECT * from client");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function getName($email){
        $data = $this->db->view("SELECT * from admin where email = '".$email."'");
        $response = array('status' => true, 'message' => 'Sorry, The Password is Incorrect Pls Try again', 'data'=>$data['0']['name']);
        echo json_encode($response);
        header('Content-Type: application/json');
    }


   

   





}