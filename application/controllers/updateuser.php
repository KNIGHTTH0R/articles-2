<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Common.php");

class Updateuser extends Common {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->json_return("updateuser Controller~");
        exit();
    }
    public function email()
    {
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }

      $this->form_validation->set_rules('email','电子邮件','required|valid_email');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }

      $data = array(
          'email' => $this->input->post('email',true),
      );
      $result = $this->User_model->updateinfo($data);
      if($result){
        $this->json_success("修改成功！");
      } else {
        $this->json_fail("修改失败！");
      }
    }
    public function password()
    {
      if(!$this->session->username)
      {
          $this->json_fail('未登陆,请先登陆');
          return 0;
      }

      $this->form_validation->set_rules('newmd5pass','新密码','required|valid_base64|exact_length[32]');
      $this->form_validation->set_rules('md5pass','密码','required|valid_base64|exact_length[32]');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }
      $data = array(
          'username = ' => $this->session->username,
          'md5pass =' => md5($this->input->post('md5pass',true))
      );
      $result = $this->User_model->login($data);
      if(!$result)
      {
          $this->json_fail('原密码有误！');
      }
      $data = array(
          'md5pass' => md5($this->input->post('newmd5pass',true))
      );
      $result = $this->User_model->updateinfo($data);
      if($result){
        $this->json_success("修改成功！");
      } else {
        $this->json_fail("修改失败！可能原因：原密码输入错误！");
      }
    }
}
