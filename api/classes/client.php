<?php

require_once 'database.php';
class client
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

    public function getID(){
        $data = $this->db->view("SELECT * from client where email = '".$this->email."'");
        if($data){
            return $data['0']['id'];
        }else{
            return false;
        }
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($code){
        $this->password = $code;
    }

    public function isClientExist(){
        $count = $this->db->viewandCount("SELECT * from client where email = '".$this->email."'");
        if($count==1){
            return true;
        }else{
            return false;
        }
    }

    public function register(){
        if($this->isClientExist()){
            $response = array('status' => false, 'message' => 'This email  has been registered');
            echo json_encode($response);
            header('Content-Type: application/json');

        }else{
            $clientData = array("name"=>$this->name, "phone_number"=>$this->phone_number, "email"=>$this->email,
            "password"=>$this->password, "postal_address"=>$this->postal_address, "time"=>$this->time, "date"=>$this->date,
            "blacklisted"=>0);
            $result = $this->db->insert("client", $clientData);
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

    public function isBlackListed(){
        $data = $this->db->view("SELECT * from client where email = '".$this->email."'");
        if($data['0']['blacklisted'] == "1"){
            return true;
        }else{
            return false;
        }
    }

    public function login(){
        $data = $this->db->view("SELECT * from client where email = '".$this->email."'");
        if(self::isBlackListed()){
            $response = array('status' => false, 'message' => 'Sorry,  You have been blacklisted by the admin');
            echo json_encode($response);
            header('Content-Type: application/json');
        }else{
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
        
    }

    public function getName($email){
        $data = $this->db->view("SELECT * from client where email = '".$email."'");
        $response = array('status' => true, 'message' => 'Sorry, The Password is Incorrect Pls Try again', 'data'=>$data['0']['name']);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function getNameByID($client_id){
        $data = $this->db->view("SELECT * from client where id = '".$client_id."'");
        return $data['0']['name'];
    }

    public function getClientDetails($email){
        $data = $this->db->view("SELECT * from client where email = '".$email."'");
        return $data;
    }

    public function getClientsCountAll(){
        $data = $this->db->viewAndCount("SELECT * from client");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function getAll(){
        $data = $this->db->view("SELECT * from client ");
        $arr = [];
        foreach($data as $datas){
            if($datas['blacklisted'] == "0"){
                $datas['blacklist'] = "http://localhost/truckee/api/admin/blacklist.php?blacklist=1&client_id=".$datas['id'];
                $datas['word'] = "BlackList Client";
            }else{
                $datas['blacklist'] = "http://localhost/truckee/api/admin/blacklist.php?blacklist=0&client_id=".$datas['id'];
                $datas['word'] = "WhiteList Client";
            }
            array_push($arr,$datas);
        }
        $response = array('status' => true, 'message' => 'Sorry, The Password is Incorrect Pls Try again', 'data'=>$arr);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

   





}