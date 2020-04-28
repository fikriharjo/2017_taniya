<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];
        $accessMenu = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);
        if ($accessMenu->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function dd($array)
{
    return "<pre>" . print_r($array, true) . "</pre>";
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0) {
        return "checked = 'checked'";
    }
}
function checkEmail($email)
{
    $ci = get_instance();
    $ci->db->where('id_user', $email);
    $result = $ci->db->get('user')->row_array();
    if ($result['is_active'] == 1) {
        return "checked = 'checked'";
    }
}
function formatRp($params)
{
    $separator = "Rp.";
    return $separator . number_format($params, 0, ',', '.');
}
function checkError($params)
{
    if ($params) {
        return 'in-valid';
    } else {
        return 'valid';
    }
}

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
function get_monthname($number)
{
    if ($number == 1 or $number ==  "01") {
        return "Januari";
    } else if ($number == 2 or $number == "02") {
        return "Februari";
    } else if ($number == 3 or $number ==  "03") {
        return "Maret";
    } else if ($number == 4 or  $number == "04") {
        return "April";
    } else if ($number == 5 or  $number == "05") {
        return "Mei";
    } else if ($number == 6 or  $number == "06") {
        return "Juni";
    } else if ($number == 7 or  $number == "07") {
        return "Juli";
    } else if ($number == 8 or  $number == "08") {
        return "Agustus";
    } else if ($number == 9 or $number == "09") {
        return "September";
    } else if ($number == "10") {
        return "Oktober";
    } else if ($number == "11") {
        return "November";
    } else if ($number == "12") {
        return "Desember";
    }
}
