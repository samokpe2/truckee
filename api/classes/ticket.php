<?php

require_once 'database.php';
require_once 'client.php';
require_once 'truckdriver.php';
require_once '../libs/fpdf181/fpdf.php';
class ticket extends FPDF
{
    public $db;
    public $client;
    public  $ticket_id;
    public  $truck_driver_id;
    public  $client_id;
    public  $container_id;
    public  $container_contents;
    public  $date_for_entry;
    public  $time_entry;
    public  $status;
    public  $date_created;
    

    public function __construct(){
        $this->db = new database();
        $this->client = new client();
        $this->truckdriver = new truckdriver();
        parent::__construct();
    }

    public function request(){
        $data = $this->db->view("SELECT * from client where email = '".$this->email."'");
        if($data){
            return $data['0']['id'];
        }else{
            return false;
        }
    }

    public function generateTicketID(){
        $generator = "1357902468";
        $result = "";
  
        for ($i = 1; $i <= 5; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
      
        // Return result
        return "TNO".$result;
    }

    public function getTime(){
        $times = ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM'];
        $random_keys = array_rand($times,3);
        return $times[$random_keys[0]];
    }



    public function requestTicket($clientEmail){
        $ticket_id = self::generateTicketID();
        $date = date("l jS \of F Y", strtotime("+1 day"));
        $time = self::getTime();
        $date_created = date("l jS \of F Y");
        $this->client->email = $clientEmail;
        $clientID = $this->client->getID();
        if(self::getTrucksPerDate($date_created) == 120){
            $ticketData = array("ticket_id"=>$ticket_id, "truck_driver_id"=>$this->truck_driver_id, "client_id"=>$clientID,
                "container_id"=>$this->container_id, "container_contents"=>$this->container_contents,"date_for_entry"=>$date,
                "time_entry"=>$time,"status"=>"Pending", "date_created"=>$date_created);

            $result = $this->db->insert("ticket_table", $ticketData);
            if(result){
                $client_name = $this->client->getName($clientEmail);
                $driver_name = $this->truckdriver->getName($this->truck_driver_id);
                self::createTicketPDF($ticket_id,$driver_name,$client_name, $this->container_id, $this->container_contents, $date, $time);
                $response = array('status' => true, 'message' => 'Request was granted');
                echo json_encode($response);
                header('Content-Type: application/json');
            }else{
                $response = array('status' => false, 'message' => 'Request was not granted');
                echo json_encode($response);
                header('Content-Type: application/json');
            }
        }else{
            $date = date("l jS \of F Y", strtotime("+2 day"));
            
            $ticketData = array("ticket_id"=>$ticket_id, "truck_driver_id"=>$this->truck_driver_id, "client_id"=>$clientID,
                "container_id"=>$this->container_id, "container_contents"=>$this->container_contents,"date_for_entry"=>$date,
                "time_entry"=>$time,"status"=>"Pending", "date_created"=>$date_created);

            $result = $this->db->insert("ticket_table", $ticketData);
            if($result){
                $client_name = $this->client->getClientDetails($clientEmail)['0']['name'];
                $client_phonenumber = $this->client->getClientDetails($clientEmail)['0']['phone_number'];
                $driver_name = $this->truckdriver->getName($this->truck_driver_id);
                self::createTicketPDF($ticket_id,$driver_name,$client_name, $client_phonenumber, $this->container_id, $this->container_contents, $date, $time);
                $response = array('status' => true, 'message' => 'Request was granted', 'url'=>"http://localhost/truckee/api/storage/".$ticket_id.".pdf");
                echo json_encode($response);
                header('Content-Type: application/json');
            }else{
                $response = array('status' => false, 'message' => 'Request was not granted');
                echo json_encode($response);
                header('Content-Type: application/json');
            }
        }
    }


    public function getTickets($email){
        $this->client->email = $email;
        $clientID = $this->client->getID();
        $data = $this->db->view("SELECT * from ticket_table where client_id = '".$clientID."' ORDER BY id DESC");
        $arr = [];
        foreach($data as $datas){
            $datas['truckdriver'] = $this->truckdriver->getName($datas['truck_driver_id']);
            $datas['url'] = "http://localhost/truckee/api/storage/".$datas['ticket_id'].".pdf";
            array_push($arr, $datas);
        }
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$arr);
        echo json_encode($response);
        header('Content-Type: application/json');
    }


    public function getTicketsAll(){
        $data = $this->db->view("SELECT * from ticket_table ORDER BY id DESC");
        $arr = [];
        foreach($data as $datas){
            $datas['client'] = $this->client->getNameByID($datas['client_id']);
            $datas['url'] = "http://localhost/truckee/api/storage/".$datas['ticket_id'].".pdf";
            array_push($arr, $datas);
        }
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$arr);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function checkTicket($ticket_id){
        $data = $this->db->view("SELECT * from ticket_table where ticket_id = '".$ticket_id."'");
        if($data){
            $arr = [];
            foreach($data as $datas){
                $datas['truckdriver'] = $this->truckdriver->getName($datas['truck_driver_id']);
                $datas['url'] = "http://localhost/truckee/api/storage/".$datas['ticket_id'].".pdf";
                array_push($arr, $datas);
            }
            $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$arr);
            echo json_encode($response);
            header('Content-Type: application/json');
        }else{
            $response = array('status' => false, 'message' => 'Registration was Sucessful');
            echo json_encode($response);
            header('Content-Type: application/json');
        }
        
    }

    // $tomorrow = date("Y-m-d", strtotime("+1 day"));
    public function getTrucksPerDate($date){
        $data = $this->db->viewAndCount("SELECT * from ticket_table where date_for_entry =  '".$date."'");
        return $data;
    }

    public function getTicketCount($clientEmail){
        $this->client->email = $clientEmail;
        $clientID = $this->client->getID();
        $data = $this->db->viewAndCount("SELECT * from ticket_table where client_id = '".$clientID."'");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function getTicketCountAll(){
        $data = $this->db->viewAndCount("SELECT * from ticket_table");
        $response = array('status' => true, 'message' => 'Registration was Sucessful', 'data'=>$data);
        echo json_encode($response);
        header('Content-Type: application/json');
    }

    public function createTicketPDF($ticket_id,$driver_name,$client_name,$client_phonenumber, $container_id, $container_contents, $date_for_entry, $time_entry){
        // Instanciation of inherited class
        // $pdf = new FPDF();
        // Column headings
        //$header = array('det', 'details');
        // Data loading
        $data = self::LoadData($ticket_id,$driver_name,$client_name,$client_phonenumber, $container_id, $container_contents, $date_for_entry, $time_entry);
        $this->SetFont('Arial','',14);
        $this->AddPage();
        $this->FancyTable($data);
        $dirToSave = "../storage/";

        $this->Output("F", $dirToSave . $ticket_id . '.pdf');
        // return $returnFileName;
    }


    public function Header(){
        // Logo
        // $this->Image('logo.png',40,13,30);
        // Arial bold 15
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(128,0,255);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(25,20,'Port Ticket',0,0,'C');

    //overides the above settings
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(0);
        // $this->Cell(-40);
        // $this->Cell(25,35,'Name: '.$name.'');
        // $this->Cell(-25);
        // $this->Cell(25,45,'Phone No.: '.$phone.'');
        // $this->Cell(-25);
        // $this->Cell(25,55,'Date: '.$date.'');
        // Line break
        $this->Ln(10);
    }
    public function LoadData($ticket_id,$driver_name,$client_name, $client_phonenumber, $container_id, $container_contents, $date_for_entry, $time_entry){   
        $lines=array("Ticket ID ; ".$ticket_id."",
                    "Truck Driver ; ".$driver_name."",              
                    "Client Name; ".$client_name."",
                    "Client PhoneNumber; ".$client_phonenumber."",
                    "Container ID ;".$container_id."",
                    "Container Contents ; ".$container_contents."",
                    "Date For Entry ; ".$date_for_entry."",
                    "Time For Entry: ; ".$time_entry."");
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
            
        return $data;
    }
    
// Colored table
    public function FancyTable($data)
    {   $Y = 50;
        $Y_Fields_Name_position = 90;
        $Y_Table_Position = 96;
        $this->SetY($Y); 
        
    // Colors, line width and bold font
        
        $this->SetFillColor(0,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Header
        $w = array(80, 80, 10, 10);
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        foreach($data as $row)
        {   $this-> SetX(25);
            $this->Cell($w[1],20,$row[0],'LRTB',0,'L');
            $this->Cell($w[1],20,$row[1],'LRTB',0,'L');
            $this->Ln();
        }
        
    }
    public function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-13);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
    // $this->Cell(0,10,'Designed by (+254701008108)',0,0,'C'); 
    $this->SetY(-18);   
    $this->Cell(0,10,'Truckee Application',0,0,'C');
    }




   





}