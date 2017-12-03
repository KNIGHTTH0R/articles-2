<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: * ");

class Common extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    protected function auth_check($auth = 0)
    {
        if(!$this->session->username)
        {
            $this->json_fail('无登陆信息，请先登录');
            return 0;
        }
    }

    protected function json_return($data)
    {
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data))
        ->_display();
        exit();
    }

    protected function json_success($msg = '', $data = array())
    {
        $this->json_return(array(
            "status" => 'success',
            "message" => $msg,
            "result" => $data
        ));
    }

    protected function json_fail($msg = '', $data = array())
    {
        $this->json_return(array(
            "status" => 'fail',
            "message" => $msg,
            "result" => $data
        ));
    }
}
