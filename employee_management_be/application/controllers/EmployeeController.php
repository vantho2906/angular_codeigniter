<?php

require APPPATH . 'libraries/REST_Controller.php';

class EmployeeController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['employeeModel']);
        $this->load->library(['form_validation']);
        $this->load->helper(['response_helper']);
    }

    public function getAll_get()
    {
        $employees = $this->employeeModel->getAll();
        if (!$employees)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employees not found'), REST_Controller::HTTP_BAD_REQUEST);

        return $this->response(
            generateResponse(REST_Controller::HTTP_OK, 'Get employees success', $employees),
            REST_Controller::HTTP_OK
        );
    }

    public function getById_get($id)
    {
        $employee = $this->employeeModel->getById($id);

        if (!$employee)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not found'), REST_Controller::HTTP_BAD_REQUEST);

        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Get employee success', $employee), REST_Controller::HTTP_OK);
    }

    public function create_post()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('dob', 'Birthday', 'trim|required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|numeric');

        if (!$this->form_validation->run()) {
            $errors = $this->form_validation->error_array();
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Validation errors', null, $errors), REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = [
            'name' => $input['name'],
            'dob' => $input['dob'],
            'salary' => $input['salary'],
            'image' => isset($input['image']) ? $input['image'] : null
        ];
        $this->employeeModel->create($data);

        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Create success'), REST_Controller::HTTP_OK);
    }

    public function update_put($id)
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('dob', 'Birthday', 'trim|required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|numeric');

        if (!$this->form_validation->run()) {
            $errors = $this->form_validation->error_array();
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Validation errors', null, $errors), REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = [
            'name' => $input['name'],
            'dob' => $input['dob'],
            'salary' => $input['salary'],
        ];

        $isUpdate = $this->employeeModel->update($id, $data) > 0;
        if (!$isUpdate)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not found'), REST_Controller::HTTP_BAD_REQUEST);
        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Update success'), REST_Controller::HTTP_OK);
    }

    public function delete_delete($id) {
        $employee = $this->employeeModel->getById($id);
        if(!$employee) 
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not found'), REST_Controller::HTTP_BAD_REQUEST);
        
        $hasPet = count($this->employeeModel->getPets($id)) > 0; 
        if($hasPet)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee having pets can not be deleted'), REST_Controller::HTTP_BAD_REQUEST);

        $isDelete = $this->employeeModel->delete($id) > 0;
        if (!$isDelete)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not found'), REST_Controller::HTTP_BAD_REQUEST);
        
        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Delete success'), REST_Controller::HTTP_OK);
    }

    public function getPets_get($id) {
        $employee = $this->employeeModel->getById($id);
        if(!$employee) 
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not found'), REST_Controller::HTTP_BAD_REQUEST);
        
        $pets = $this->employeeModel->getPets($id);
        if(!$pets)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Employee not have any pets'), REST_Controller::HTTP_BAD_REQUEST);

        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Get pets success', $pets), REST_Controller::HTTP_OK);

    }
}
