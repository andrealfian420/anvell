<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loginChecker();
        $this->load->model('Menu_model', 'menu');
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        $data['titlePage'] = 'Anvell - Dashboard Admin';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);

        // $data['sub_menu'] = $this->menu->getSubMenu($role_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
    }

    public function role()
    {
        // load role model
        $this->load->model('Role_model', 'role');

        $data['titlePage'] = 'Anvell - Role';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);

        $data['roles'] = $this->role->getAllRoles();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/role');
        $this->load->view('templates/footer');
    }

    public function roleAccess($roleId)
    {
        // load role model
        $this->load->model('Role_model', 'role');

        $data['titlePage'] = 'Anvell - Role Access';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);

        $data['roles'] = $this->role->getRoleById($roleId);
        $data['menu'] = $this->menu->getRoleMenu();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/roleAccess');
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        // load role model
        $this->load->model('Role_model', 'role');

        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->role->getRoleAccess($data);

        if ($result->num_rows() < 1) {
            $this->role->setRoleAccess($data);
        } else {
            $this->role->deleteRoleAccess($data);
        }

        $this->session->set_flashdata('access', 'Changed!');
    }
}
