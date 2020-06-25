<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nmtkq extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nmtkq');
    }
    function check_donvitinh_post() {
        $input = $this->input->post();
        $list = $this->mod_nmtkq->_check_donvitinh_mau($input['id']);
        if($list) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function check_thitruong_post() {
        $input = $this->input->post();
        $check_mau = $this->mod_nmtkq->_check_thitruong_mau($input['id']);
        $check_chitiet = $this->mod_nmtkq->_check_thitruong_chitiet($input['id']);
        if(!$check_mau && !$check_chitiet) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function deaction_hopdong_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_nmtkq->_deaction_hopdong($input['id']);
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
}