<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function getAllRoles()
    {
        return $this->db->get('user_role')->result_array();
    }

    public function getRoleById($role_id)
    {

        return $this->db->get_where('user_role', ['id' => $role_id])->row_array();
    }

    public function getRoleAccess($data)
    {
        return $this->db->get_where('user_access_menu', $data);
    }

    public function setRoleAccess($data)
    {
        $this->db->insert('user_access_menu', $data);
    }

    public function deleteRoleAccess($data)
    {
        $this->db->delete('user_access_menu', $data);
    }
}
