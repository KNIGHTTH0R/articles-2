<?php

class User_model extends CI_Model {
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function signup($data)
    {
        if($this->db->get_where('articles_user', array('username' => $data["username"]))->result_array()){
          return 0;
        }
        return $this->db->insert('articles_user',$data);
    }

    public function login($data)
    {
        return $this->db->select('username,email,created_time,id')->where($data)->order_by('created_time','DESC')->get('articles_user',1)->result_array();
    }
    public function updateinfo($data)
    {
        return $this->db->where(array(
            'id = ' => $this->session->id
        ))->update('articles_user', $data);
    }

}
