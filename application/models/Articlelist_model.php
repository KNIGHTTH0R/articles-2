<?php

class Articlelist_model extends CI_Model {
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function search_list($limit, $keyword){
      $total = count($this->db->select('*')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->like('title', $keyword)->or_like('content', $keyword)->get('articles_article')->result_array());
      $total = ceil($total/$limit['limit']);
      $result = $this->db->select('title,articles_article.created_time,articles_article.id,a.username')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->like('title', $keyword)->or_like('content', $keyword)->order_by('articles_article.created_time','DESC')->join('articles_user as a', 'a.id = articles_article.author_id', 'left')->get('articles_article', $limit['limit'], $limit['offset'])->result_array();
      return array(
        'total' => $total,
        'data' => $result
      );
    }
    public function article_list($limit){
      $total = count($this->db->select('*')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->get('articles_article')->result_array());
      $total = ceil($total/$limit['limit']);
      $result = $this->db->select('title,content,articles_article.created_time,articles_article.id,a.username')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->order_by('articles_article.created_time','DESC')->join('articles_user as a', 'a.id = articles_article.author_id', 'left')->get('articles_article', $limit['limit'], $limit['offset'])->result_array();
      return array(
        'total' => $total,
        'data' => $result
      );
    }
    public function list_list($limit){
      $total = count($this->db->select('*')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->get('articles_article')->result_array());
      $total = ceil($total/$limit['limit']);
      $result = $this->db->select('title,articles_article.created_time,articles_article.id,a.username')->where(array(
        'is_public = ' => 1,
        'is_deleted !=' => 1
      ))->order_by('articles_article.created_time','DESC')->join('articles_user as a', 'a.id = articles_article.author_id', 'left')->get('articles_article', $limit['limit'], $limit['offset'])->result_array();
      return array(
        'total' => $total,
        'data' => $result
      );
    }
    public function user_list($limit){
      $total = count($this->db->select('*')->where(array(
        'author_id = ' => $this->session->id,
        'is_deleted !=' => 1
      ))->get('articles_article')->result_array());
      $total = ceil($total/$limit['limit']);
      $result = $this->db->select('title,articles_article.created_time,articles_article.id,a.username,is_public')->where(array(
        'author_id = ' => $this->session->id,
        'is_deleted !=' => 1
      ))->order_by('articles_article.created_time','DESC')->join('articles_user as a', 'a.id = articles_article.author_id', 'left')->get('articles_article', $limit['limit'], $limit['offset'])->result_array();
      return array(
        'total' => $total,
        'data' => $result
      );
    }

}
