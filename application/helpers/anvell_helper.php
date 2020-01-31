<?php

// Login checker function
function loginChecker()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        $ci->session->set_flashdata('loginFirst', 'Login');
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $queryAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if ($queryAccess->num_rows() < 1) {
            redirect('auth/oops');
        }
    }
}

// Role Access Checker function
function check_access($roleId, $menuId)
{
    $ci = get_instance();

    $result = $ci->db->get_where('user_access_menu', ['role_id' => $roleId, 'menu_id' => $menuId]);

    if ($result->num_rows() > 0) {
        return "checked='checked' ";
    }
}
