<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Common.php");

class Login extends Common {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->json_return("login Controller~");
        exit();
    }
    public function signup()
    {
      if($this->session->username)
      {
          $this->json_fail('已登陆,请先登出再进行注册操作');
          return 0;
      }

      $this->form_validation->set_rules('username','用户名','required|alpha_numeric|min_length[5]|max_length[12]');
      $this->form_validation->set_rules('md5pass','密码','required|valid_base64|exact_length[32]');
      $this->form_validation->set_rules('email','电子邮件','required|valid_email');

      if($this->form_validation->run() == FALSE)
      {
          $this->json_fail('数据格式有误');
      }

      $data = array(
          'username' => $this->input->post('username',true),
          'md5pass' => md5($this->input->post('md5pass',true)),
          'email' => $this->input->post('email',true),
          'created_time' => time(),
      );
      echo time();
      $result = $this->User_model->signup($data);
      if($result){
        $this->json_success("注册成功！");
      } else {
        $this->json_fail("注册失败！可能原因：用户名已经被注册");
      }

    }
    public function login()
    {
        //todo 返回个人信息
        //验证是否已经登陆
        if($this->session->username)
        {
            $this->json_success('已登陆', array(
                'username' => $this->session->username,
                'email' => $this->session->email,
                'created_time' => $this->session->created_time,
            ));
            return 0;
        }

        $this->form_validation->set_rules('username','用户名','required|alpha_numeric|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('md5pass','密码','required|valid_base64|exact_length[32]');

        if($this->form_validation->run() == FALSE)
        {
            $this->json_fail('用户名或密码未填写，或者格式有误');
        }

        $data = array(
            'username = ' => $this->input->post('username',true),
            'md5pass =' => md5($this->input->post('md5pass',true))
        );
        $result = $this->User_model->login($data);
        if(!$result)
        {
            $this->json_fail('用户名密码有误！');
        }

        $this->session->set_userdata('username', $result[0]['username']);
        $this->session->set_userdata('email', $result[0]['email']);
        $this->session->set_userdata('created_time', $result[0]['created_time']);
        $this->session->set_userdata('id', $result[0]['id']);

        $this->json_success('登陆成功', array(
            'username' => $this->session->username,
            'email' => $this->session->email,
            'created_time' => $this->session->created_time,
        ));

    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->json_success('退出成功');
    }
}
