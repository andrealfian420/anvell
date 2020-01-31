<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        loginChecker();
        $this->load->model('Menu_model', 'menu');
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');
    }


    public function index()
    {
        $data['titlePage'] = 'Anvell - Menu Management';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $data['menu'] = $this->menu->getAllMenu();

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);

        // form validation rules
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/index');
            $this->load->view('templates/footer');
        } else {
            $this->menu->addMenu();
            $this->session->set_flashdata('addSuccess', 'added!');
            redirect('menu');
        }
    }

    public function subMenu()
    {
        $data['titlePage'] = 'Anvell - Submenu Management';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $data['menu'] = $this->menu->getAllMenu();
        $data['subMenu'] = $this->menu->getAllSubMenu();

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);

        // form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/submenu');
            $this->load->view('templates/footer');
        } else {
            $this->menu->addSubMenu();
            $this->session->set_flashdata('addSuccess', 'added!');
            redirect('menu/submenu');
        }
    }

    public function delete($id)
    {
        $this->menu->deleteMenu($id);
        $this->session->set_flashdata('deleteSuccess', 'deleted!');
        redirect('menu');
    }

    public function deleteSubMenu($id)
    {
        $this->menu->deleteSubMenu($id);
        $this->session->set_flashdata('deleteSuccess', 'deleted!');
        redirect('menu/submenu');
    }
}
