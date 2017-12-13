<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Common.php");

class Article extends Common {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Article_model');
    }

    public function index()
    {
        $this->json_return("article Controller~");
        exit();
    }
    public function create(){
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }
      $this->form_validation->set_rules('title','标题','required|max_length[30]');
      $this->form_validation->set_rules('content','内容','required|max_length[5000]');
      $this->form_validation->set_rules('isPublic','是否公开','required|max_length[1]|numeric');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }
      $data = array(
          'title' => $this->input->post('title',true),
          'content' => $this->input->post('content',true),
          'is_public' => $this->input->post('isPublic',true),
          'created_time' => time(),
          'author_id' => $this->session->id,
          'is_deleted' => 0,
      );
      $result = $this->Article_model->new_article($data);
      if($result){
        $this->json_success("文章创建成功！");
      } else {
        $this->json_fail("新建失败！");
      }
    }
    public function update(){
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }
      $this->form_validation->set_rules('articleid','文章id','required|numeric');
      $this->form_validation->set_rules('title','标题','required|max_length[30]');
      $this->form_validation->set_rules('content','内容','required|max_length[5000]');
      $this->form_validation->set_rules('isPublic','是否公开','required|max_length[1]|numeric');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }
      $data = array(
          'title' => $this->input->post('title',true),
          'content' => $this->input->post('content',true),
          'is_public' => $this->input->post('isPublic',true),
          'created_time' => time(),
          'author_id' => $this->session->id,
          'is_deleted' => 0,
      );
      $articleid = $this->input->post('articleid',true);
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }
      if($articleid){
        $result = $this->Article_model->query_article($articleid);
        if($result){
          if($result[0]['username'] == $this->session->username){
            $result = $this->Article_model->update_article($articleid,$data);
            $this->json_success("修改成功");
          }else{
            $this->json_fail("修改失败！可能原因：这不是你的文章");
          }
        } else {
          $this->json_fail("修改失败！可能原因：文章不存在");
        }
      }
    }
    public function query(){
      $articleid = $this->uri->segment(3, 0);
      if($articleid){
        $result = $this->Article_model->query_article($articleid);
        if($result){
          if($result[0]['username'] != $this->session->username && $result[0]['is_public'] == 0){
            $this->json_fail("查询失败！可能原因：这是别人的私密文章！");
          } else $this->json_success("查询成功",$result);
        } else $this->json_fail("查询失败！可能原因：文章不存在");
      } else $this->json_fail("查询失败！请输入文章id。");
    }
    public function remove(){
      $articleid = $this->uri->segment(3, 0);
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }
      if($articleid){
        $result = $this->Article_model->query_article($articleid);
        if($result){
          if($result[0]['username'] == $this->session->username){
            $result = $this->Article_model->remove_article($articleid);
            $this->json_success("删除成功");
          }else{
            $this->json_fail("删除失败！可能原因：这不是你的文章");
          }
        } else {
          $this->json_fail("删除失败！可能原因：文章不存在");
        }
    }
  }
}
