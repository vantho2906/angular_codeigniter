<?php
class EmployeeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAll()
    {
        return $this->db->get("employee")->result();
    }

    public function getById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('employee')->row();
    }

    public function create($data)
    {
        return $this->db->insert('employee', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('employee', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('employee');
        return $this->db->affected_rows();
    }

    public function getPets($ownerId)
    {
        $this->db->where('ownerId', $ownerId);
        return $this->db->get('pet')->result();
    }

}
