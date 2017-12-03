<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Common.php");

class Login extends Common {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->json_return("public Controller~");
        exit();
    }

    public function login()
    {
        //todo 返回个人信息
        //验证是否已经登陆
        if($this->session->username)
        {
            $this->json_success('已登陆', array(
                'username' => $this->session->username,
                'email' => $this->session->email
            ));
            return 0;
        }

        $this->load->library('form_validation');
        $this->load->model('Login_Model');

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
        $result = $this->Login_Model->login($data);
        if(!$result)
        {
            $this->json_fail('用户名密码有误！');
        }

        $this->session->set_userdata('username', $result[0]['username']);
        $this->session->set_userdata('email', $result[0]['email']);
        $this->session->set_userdata('created_time', $result[0]['created_time']);

        $this->json_success('登陆成功', array(
            'username' => $this->session->username,
        ));

    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->json_success('退出成功');
    }
}
