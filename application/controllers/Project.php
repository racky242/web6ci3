<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Project_model', 'project');
    }

    /*
      Display all records in page
   */
    public function index()
    {
        $data['projects'] = $this->project->get_all();
        $data['title'] = "CodeIgniter Project Manager";
        $this->load->view('layout/header');
        $this->load->view('project/index', $data);
        $this->load->view('layout/footer');
    }

    /*
 
    Display a record
  */
    public function show($id)
    {
        $data['project'] = $this->project->get($id);
        $data['title'] = "Show Project";
        $this->load->view('layout/header');
        $this->load->view('project/show', $data);
        $this->load->view('layout/footer');
    }

    /*
    Create a record page
  */
    public function create()
    {
        $data['title'] = "Create Project";
        $this->load->view('layout/header');
        $this->load->view('project/create', $data);
        $this->load->view('layout/footer');
    }

    /*
    Save the submitted record
  */
    public function store()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('project/create'));
        } else {
            $this->project->store();
            $this->session->set_flashdata('success', "Saved Successfully!");
            redirect(base_url('project'));
        }
    }

    /*
    Edit a record page
  */
    public function edit($id)
    {
        $data['project'] = $this->project->get($id);
        $data['title'] = "Edit Project";
        $this->load->view('layout/header');
        $this->load->view('project/edit', $data);
        $this->load->view('layout/footer');
    }

    /*
    Update the submitted record
  */
    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('project/edit/' . $id));
        } else {
            $this->project->update($id);
            $this->session->set_flashdata('success', "Updated Successfully!");
            redirect(base_url('project'));
        }
    }

    /*
    Delete a record
  */
    public function delete($id)
    {
        $item = $this->project->delete($id);
        $this->session->set_flashdata('success', "Deleted Successfully!");
        redirect(base_url('project'));
    }
}
