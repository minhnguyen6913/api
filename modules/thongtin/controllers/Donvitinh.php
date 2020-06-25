<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donvitinh extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_donvitinh');
    }
    function get_donvitinh_post(){
        $input = $this->input->post();
        $list = $this->mod_donvitinh->_get_donvitinh($input['type']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function donvitinh_info_post() {
        $input = $this->input->post();
        $list = $this->mod_donvitinh->_get_donvitinh_info($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
}
