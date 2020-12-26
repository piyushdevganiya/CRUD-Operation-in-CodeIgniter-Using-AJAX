<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('StudentModel','sm');
    }
    public function index()
    {
        $this->load->view('student');
    }
    public function addStudent()
    {
        $data=array(
            "name"=>$this->input->post('name'),
            "dob"=>$this->input->post('dob'),
            "address"=>$this->input->post('address'),
            "mobileno"=>$this->input->post('mobileno'),
            "email"=>$this->input->post('email'),            
        );
        $addStud=$this->sm->addStudent($data);
        if($addStud){
            $response=array("status"=>200);
        }else{
            $response=array("status"=>500);
        }
        echo json_encode($response);
        
    }
    public function getStudent()
    {
        $stud=$this->sm->getStudent();
        echo json_encode($stud);
    }
    public function updateStudent()
    {
        $data=array(
            "name"=>$this->input->post('name'),
            "dob"=>$this->input->post('dob'),
            "address"=>$this->input->post('address'),
            "mobileno"=>$this->input->post('mobileno'),
            "email"=>$this->input->post('email'),            
        );
        $updateStud=$this->sm->updateStudent($this->input->post('sid'),$data);
        if($updateStud){
            $response=array("status"=>200);
        }else{
            $response=array("status"=>500);
        }
        echo json_encode($response);
    }
    public function deleteStudent($id)
    {
        $deleteStud=$this->sm->deleteStudent($id);
        if($deleteStud){
            $response=array("status"=>200);
        }else{
            $response=array("status"=>500);
        }
        echo json_encode($response);
    }
}

?>