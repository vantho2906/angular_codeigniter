<?php

require APPPATH . 'libraries/REST_Controller.php';

class PetController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['petModel', 'employeeModel']);
        $this->load->library(['form_validation']);
        $this->load->helper(['response_helper']);
    }

    public function getAll_get()
    {
        $pets = $this->petModel->getAll();

        if (!$pets)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'pets not found'), REST_Controller::HTTP_BAD_REQUEST);

        return $this->response(
            generateResponse(REST_Controller::HTTP_OK, 'Get pets success', $pets),
            REST_Controller::HTTP_OK
        );
    }

    public function getById_get($id)
    {
        $pet = $this->petModel->getById($id);

        if (!$pet)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'pet not found'), REST_Controller::HTTP_BAD_REQUEST);

        $petFormat = [
            'id' => $pet->id,
            'type' => $pet->type,
            'name' => $pet->name,
            'dob' => $pet->dob,
            'image' => $pet->image,
            'owner' => [
                'id' => $pet->ownerId,
                'name' => $pet->ownerName,
                'dob' => $pet->ownerDob,
                'salary' => $pet->ownerSalary,
                'image' => $pet->ownerImage,
            ]
        ];

        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Get pet success', $petFormat), REST_Controller::HTTP_OK);
    }

    public function create_post()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('dob', 'Birthday', 'trim|required');
        $this->form_validation->set_rules('ownerId', 'Owner ID', 'trim|required');

        if (!$this->form_validation->run()) {
            $errors = $this->form_validation->error_array();
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Validation errors', null, $errors), REST_Controller::HTTP_BAD_REQUEST);
        }

        $owner = $this->employeeModel->getById($input['ownerId']);
        if (!$owner)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'Owner not found'), REST_Controller::HTTP_BAD_REQUEST);

        $data = [
            'name' => $input['name'],
            'type' => $input['type'],
            'dob' => $input['dob'],
            'image' => isset($input['image']) ? $input['image'] : null,
            'ownerId' => $input['ownerId'],
        ];
        $this->petModel->create($data);

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

        $isUpdate = $this->petModel->update($id, $data) > 0;
        if (!$isUpdate)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'pet not found'), REST_Controller::HTTP_BAD_REQUEST);
        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Update success'), REST_Controller::HTTP_OK);
    }

    public function delete_delete($id)
    {
        $isDelete = $this->petModel->delete($id) > 0;

        if (!$isDelete)
            return $this->response(generateResponse(REST_Controller::HTTP_BAD_REQUEST, 'pet not found'), REST_Controller::HTTP_BAD_REQUEST);
        return $this->response(generateResponse(REST_Controller::HTTP_OK, 'Delete success'), REST_Controller::HTTP_OK);
    }
}
