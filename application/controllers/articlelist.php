<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Common.php");

class Articlelist extends Common {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Articlelist_model');
    }

    public function index()
    {
        $this->json_return("article list Controller~");
        exit();
    }
    public function query_article(){
      if(!$this->uri->segment(3, 0) || !$this->uri->segment(4, 0)){
        $this->json_fail("查询失败！可能原因：参数不完整");
        exit;
      }
      $limit = array(
        'offset' => $this->uri->segment(3, 0) * $this->uri->segment(4, 0),
        'limit' => $this->uri->segment(4, 0),
      );
      $result = $this->Articlelist_model->article_list($limit);
      if($result){
        $this->json_success("查询成功",$result);
      } else $this->json_fail("查询失败！可能原因：文章不存在");
    }
    public function query_list(){
      if(!$this->uri->segment(3, 0) && !$this->uri->segment(4, 0)){
        $this->json_fail("查询失败！可能原因：参数不完整");
        exit;
      }
      $limit = array(
        'offset' => $this->uri->segment(3, 0) * $this->uri->segment(4, 0),
        'limit' => $this->uri->segment(4, 0),
      );
      $result = $this->Articlelist_model->list_list($limit);
      if($result){
        $this->json_success("查询成功",$result);
      } else $this->json_fail("查询失败！可能原因：文章不存在");
    }
    public function query_user(){
      if(!$this->uri->segment(3, 0) && !$this->uri->segment(4, 0)){
        $this->json_fail("查询失败！可能原因：参数不完整");
        exit;
      }
      if(!$this->session->username){
        $this->json_fail("查询失败！可能原因：未登陆！");
        exit;
      }
      $limit = array(
        'offset' => $this->uri->segment(3, 0) * $this->uri->segment(4, 0),
        'limit' => $this->uri->segment(4, 0),
      );
      $result = $this->Articlelist_model->user_list($limit);
      if($result){
        $this->json_success("查询成功",$result);
      } else $this->json_fail("查询失败！可能原因：文章不存在");
    }
    public function query_search(){
      $this->form_validation->set_rules('keyword','关键词','required');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }
      if(!$this->uri->segment(3, 0) && !$this->uri->segment(4, 0)){
        $this->json_fail("查询失败！可能原因：参数不完整");
        exit;
      }
      $keyword = $this->input->post('keyword',true);
      $limit = array(
        'offset' => $this->uri->segment(3, 0) * $this->uri->segment(4, 0),
        'limit' => $this->uri->segment(4, 0),
      );
      $result = $this->Articlelist_model->search_list($limit, $keyword);
      if($result){
        $this->json_success("查询成功",$result);
      } else $this->json_fail("查询失败！可能原因：文章不存在");
    }
}
