<?php
function backView($url, $data)
{
    $ci = get_instance();
    $ci->load->view('template/header', $data);
    $ci->load->view('template/sidebar', $data);
    $ci->load->view('template/topbar', $data);
    $ci->load->view($url);
    $ci->load->view('template/footer', $data);
}
