<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nenmau extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nenmau');
    }
    function get_nenmau_post() {
        $list = $this->mod_nenmau->_get_All_nenmau();
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_infonenmau_post() {
        $input = $this->input->post();
        $list = $this->mod_nenmau->_get_nenmau_info($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_getRef_post() {
        $input = $this->input->post();
        $list = $this->mod_nenmau->_getRef($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
}
