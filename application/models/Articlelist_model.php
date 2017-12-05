<?php

class Articlelist_model extends CI_Model {
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function search_list($keyword){}
    public function article_list($limit){}
    public function list_list($limit){}
    public function user_list($limit){}

}
