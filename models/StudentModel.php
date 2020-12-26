<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentModel extends CI_Model {
    public function addStudent($data)
    {
       return $this->db->insert("tblstudent",$data);
    }
    public function getStudent()
    {
        return $this->db->get("tblstudent")->result();
    }
    public function updateStudent($id,$data)
    {
        $this->db->where("sid",$id);
        return $this->db->update("tblstudent",$data);
    }
    public function deleteStudent($id)
    {
        $this->db->where("sid",$id);
        return $this->db->delete("tblstudent");
    }
}
?>