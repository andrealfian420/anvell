<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load modules
        $this->load->library('form_validation');
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        // if user already logged in
        if ($this->session->userdata('email')) {
            redirect('user');
        }


        $data['titlePage'] = 'Anvell - Login';

        // form validation rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // cek data user
        $user = $this->user->getUser($email);

        // user exist
        if ($user) {
            // user is active
            if ($user['is_active'] == 1) {
                // password check
                if (password_verify($password, $user['password'])) {
                    // all checked
                    $data = $user;
                    $this->session->set_userdata($data);

                    // check user role
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else if ($user['role_id'] == 2) {
                        redirect('user');
                    }
                } else {
                    // password salah
                    $this->session->set_flashdata('wrongPassword', 'Oops!');
                    redirect('auth');
                }
            } else {
                // email belum aktivasi
                $this->session->set_flashdata('isNotActive', 'Activate');
                redirect('auth');
            }
        } else {
            // email/user tidak ada
            $this->session->set_flashdata('failedLogin', 'Oops!');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('password');

        $this->session->set_flashdata('logout', 'logged out!');
        redirect('auth');
    }

    public function registration()
    {
        // if user already logged in
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data['titlePage'] = 'Anvell - Member Register';

        // validation form
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'The Email has already been registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'required' => 'Password is empty!',
            'min_length' => 'Password is too short!',
            'matches' => "Password doesn't match!"
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {

            // prepare token for user activation
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $this->input->post('email'),
                'token' => $token,
                'date_created' => time()
            ];

            // insert user data to db
            $this->user->userRegister();
            $this->user->userToken($user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('successRegister', 'Congratulations!');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        // set up config for email
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'your_email@mail.com',
            'smtp_pass' => 'your_password',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        // load email library
        $this->load->library('email', $config);
        $this->email->initialize($config);

        // set up email
        $this->email->from('youremail@mail.com', 'Example');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('<h1>Hey ' . $this->input->post('name') . '</h1>
                                <h2>Thank you for joining us!</h2>
                                <p>Now click this link below to verify your account!</p>                        
                                <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate!</a>
                                <br><br>
                                <p>This activation will expire in 1 hour. So please activate your account <strong>immediately!</strong></p>');
        } else if ($type == 'forgot') {
            $this->email->subject('Password Recovery');
            $this->email->message('
                                <h2>Click this link below to recover your password!</h2>                        
                                <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>
                                <br><br>
                                <p>This link will expire in 1 hour. So please recover your password <strong>immediately!</strong></p>');
        }

        // sending email
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        // get email and token from url
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->user->getUser($email);

        // verify email
        if ($user) {
            // verify token
            $user_token = $this->user->getUserToken($token);
            if ($user_token) {

                // token expiration check
                if (time() - $user_token['date_created'] > 3600) {

                    // token expired
                    $this->user->deleteUser($email);
                    $this->user->deleteToken($email);
                    $this->session->set_flashdata('failedActivate', 'Token expired!');
                    redirect('auth');
                } else {

                    // user all ok
                    $this->user->verifiedUser($email);
                    $this->user->deleteToken($email);
                    $this->session->set_flashdata('successActivate', $email);
                    redirect('auth');
                }
            } else {
                // token invalid
                $this->session->set_flashdata('failedActivate', 'Invalid token!');
                redirect('auth');
            }
        } else {
            // email invalid
            $this->session->set_flashdata('failedActivate', 'Invalid email!');
            redirect('auth');
        }
    }

    public function forgotPassword()
    {
        // if user already logged in
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data['titlePage'] = 'Anvell - Forgot Password';

        // validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgotpassword');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->user->getUser($email);

            if ($user) {

                if (!$user['is_active'] == 1) {
                    $this->session->set_flashdata('isNotActive', 'been activated!');
                    redirect('auth/forgotpassword');
                } else {
                    $token = base64_encode(random_bytes(32));
                    $user_token = [
                        'email' => $email,
                        'token' => $token,
                        'date_created' => time()
                    ];

                    $this->user->userToken($user_token);
                    $this->_sendEmail($token, 'forgot');

                    $this->session->set_flashdata('successRecover', 'Please check your email to recover your password!');
                    redirect('auth/forgotpassword');
                }
            } else {
                $this->session->set_flashdata('unknownEmail', 'is not registered');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        // get email and token from url
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->user->getUser($email);

        if ($user) {
            $user_token = $this->user->getUserToken($token);

            if ($user_token) {
                if (time() - $user_token['date_created'] > 3600) {

                    // token expired
                    $this->user->deleteToken($email);
                    $this->session->set_flashdata('recoveryFailed', 'Token expired!');
                    redirect('auth');
                } else {
                    // all ok
                    $this->user->deleteToken($email);
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                }
            } else {
                $this->session->set_flashdata('recoveryFailed', 'The token is wrong!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('recoveryFailed', 'The email is not registered in our server!');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email') || $this->session->userdata('email')) {
            redirect('auth/oops');
        }

        $data['titlePage'] = 'Password Recovery';

        // validation rules 
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirmation Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/changepassword');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->user->resetPassword($password, $email);

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('successRecovery', 'The password has been changed! Now you can login!');
            redirect('auth');
        }
    }

    public function oops()
    {
        $data['titlePage'] = 'Oops!';

        $this->load->view('templates/header', $data);
        $this->load->view('auth/oops');
    }
}
