<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loginChecker();
        // load model
        $this->load->model('Menu_model', 'menu');
        // load model
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        $data['titlePage'] = 'Anvell - My Profile';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        // load library
        $this->load->library('form_validation');


        $data['titlePage'] = 'Anvell - Edit Profile';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);


        // validation rules
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('user/edit');
            $this->load->view('templates/footer');
        } else {

            // if user upload new profile image
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path']   = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    // delete old picture
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    // upload new picture
                    $new_image = $this->upload->data('file_name');
                    $this->user->updatePicture($new_image);
                } else {
                    // upload failed
                    $this->session->set_flashdata('failedUpload', $this->upload->display_errors());
                    redirect('user');
                    die;
                }
            }

            $this->user->updateData();
            $this->session->set_flashdata('successUpdate', 'updated!');
            redirect('user');
        }
    }

    public function changepassword()
    {
        // load library
        $this->load->library('form_validation');

        $data['titlePage'] = 'Anvell - Change Password';

        $email = $this->session->userdata('email');
        $data['user'] = $this->user->getUser($email);

        $role_id = $this->session->userdata('role_id');
        $data['sidemenu'] = $this->menu->getMenu($role_id);


        // validation rules
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newPassword1', 'New Password', 'required|trim|min_length[6]|matches[newPassword2]');
        $this->form_validation->set_rules('newPassword2', 'Confirm New Password', 'required|trim|min_length[6]|matches[newPassword1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('user/changepassword');
            $this->load->view('templates/footer');
        } else {
            $currentPassword = $this->input->post('currentPassword');
            $newPassword = $this->input->post('newPassword1');

            if (!password_verify($currentPassword, $data['user']['password'])) {
                $this->session->set_flashdata('wrongPassword', 'incorrect!');
                redirect('user/changepassword');
                die;
            } else {
                if ($currentPassword == $newPassword) {
                    $this->session->set_flashdata('sameOldPassword', 'same!');
                    redirect('user/changepassword');
                    die;
                } else {
                    // password ok
                    $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $this->user->updatePassword($password_hash);

                    $this->session->set_flashdata('passwordChanged', 'changed!');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
