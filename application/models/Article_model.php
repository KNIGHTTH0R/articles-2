<?php

class Article_model extends CI_Model {
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function new_article($data){
        return $this->db->insert('articles_article',$data);
    }
    public function remove_article($id){
      return $this->db->update('articles_article', array(
        'is_deleted' => 1
      ), array(
        'id = ' => $id
      ));
    }
    public function update_article($id, $data){
      return $this->db->update('articles_article', $data, array(
        'id = ' => $id
      ));
    }
    public function query_article($id){
      return $this->db->select('title,content,articles_article.created_time,articles_article.id,is_public,a.username,is_public')->where(array(
        'articles_article.id = ' => $id,
        'is_deleted !=' => 1
      ))->order_by('articles_article.created_time','DESC')->join('articles_user as a', 'a.id = articles_article.author_id', 'left')->get('articles_article',1)->result_array();
    }

}
