<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Thitruong extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_thitruong');
    }
    function thitruong_info_post() {
        $input = $this->input->post();
        $list = $this->mod_thitruong->_get_thitruong_info($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_allthitruong_post() {
        $list = $this->mod_thitruong->_get_all_thitruong();
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
}
