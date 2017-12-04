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
            "status" => 200,
            "message" => $msg,
            "result" => $data
        ));
    }

    protected function json_fail($msg = '', $data = array())
    {
        $this->json_return(array(
            "status" => 400,
            "message" => $msg,
            "result" => $data
        ));
    }
}
