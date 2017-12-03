<?php

class Login_Model extends CI_Model {
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($data)
    {
        return $this->db->select('username,email,created_time')->where($data)->order_by('created_time','DESC')->get('articles_user',1)->result_array();
    }

}
