<?php
class PetModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getALl() {
        return $this->db->get("pet")->result();
    }

    public function getById($id) {
        // return $this->db->query('SELECT pet.*, e.name ownerName, e.dob ownerDob, e.salary ownerSalary, e.image ownerImage
        // from pet left join employee e on pet.ownerId = e.id where pet.id = ?',
        // [$id])->row();
        $this->db->select('pet.*, e.name ownerName, e.dob ownerDob, e.salary ownerSalary, e.image ownerImage');
        $this->db->from('pet');
        $this->db->join('employee e', 'e.id = pet.ownerId');
        $this->db->where('pet.id', $id);
        return $this->db->get()->row();
    }

    public function create($data) {
        return $this->db->insert('pet', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('pet', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('pet');
        return $this->db->affected_rows();
    }

}
?>