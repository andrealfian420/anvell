<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function userRegister()
    {
        $data = [
            'name' => htmlspecialchars($this->input->post('name'), true),
            'email' => htmlspecialchars($this->input->post('email'), true),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 0,
            'date_created' => time()
        ];

        $this->db->insert('users', $data);
    }

    public function userToken($token)
    {
        $this->db->insert('user_token', $token);
    }

    public function getUser($email)
    {
        // ambil data user berdasarkan emailnya
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function getUserToken($token)
    {
        return $this->db->get_where('user_token', ['token' => $token])->row_array();
    }

    public function updateData()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');

        $this->db->set('name', $name);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function updatePicture($image)
    {
        $email = $this->input->post('email');

        $this->db->set('image', $image);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function updatePassword($password)
    {
        $this->db->set('password', $password);
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('users');
    }

    public function resetPassword($password, $email)
    {
        $this->db->set('password', $password);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function verifiedUser($email)
    {
        $this->db->set('is_active', 1);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function deleteUser($email)
    {
        $this->db->delete('users', ['email' => $email]);
    }

    public function deleteToken($email)
    {
        $this->db->delete('user_token', ['email' => $email]);
    }
}
