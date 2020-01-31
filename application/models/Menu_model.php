<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getMenu($role_id)
    {
        $query = "SELECT `user_menu`.`id`, `menu`
                    FROM `user_menu` JOIN `user_access_menu` 
                        ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                    WHERE `user_access_menu`.`role_id` = $role_id 
                ORDER BY `user_access_menu`.`menu_id` ASC";

        return $sidemenu = $this->db->query($query)->result_array();
    }


    public function getAllMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    public function getAllSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu` 
                ON `user_sub_menu`.`menu_id` = `user_menu`.`id`";

        return $this->db->query($query)->result_array();
    }

    public function addMenu()
    {
        $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
    }

    public function addSubMenu()
    {
        $data = [
            'title' => htmlspecialchars($this->input->post('title'), true),
            'menu_id' => $this->input->post('menu_id'),
            'url' => htmlspecialchars($this->input->post('url'), true),
            'icon' => htmlspecialchars($this->input->post('icon'), true),
            'is_active' => $this->input->post('is_active')
        ];

        $this->db->insert('user_sub_menu', $data);
    }

    public function deleteMenu($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
    }

    public function deleteSubMenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
    }

    public function getRoleMenu()
    {
        $this->db->where('id !=', 1);
        return $this->db->get('user_menu')->result_array();
    }
}
