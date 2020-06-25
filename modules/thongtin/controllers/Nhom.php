<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nhom extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nhom');
    }
    function get_nhom_post(){
        $input = $this->input->post();
        $list = $this->mod_nhom->_get_nhom_nenmau($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function dinhnghia_nhom_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_get_dinhnghia_nhom($input['id'], $input['nenmau']);
        if ($list) {
           $this->response(array("err_code" => "200", "list" => $list));
        } else {
           $this->response(array("err_code" => "100"));
        }
    }
    function nhominfo_post() {
       $input = $this->input->post();
        $list = $this->mod_nhom->_get_nhom_info($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function dinhnghiainfo_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_get_dinhnghia_info($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function getgia_nhom_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_get_gia_nhom($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function get_allnhom_kh_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_get_all_nhom_kh($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function get_gia_nhom_kh_post() {
        $input = $this->input->post();
        $this->mod_nhom->post = $input['post'];
        $this->mod_nhom->id_khachhang = $input['id'];
        $this->mod_nhom->status = $input['status'];
        $this->response(array(
            "list" => $this->mod_nhom->_get_datatables(),
            "recordsTotal" => $this->mod_nhom->_count_all(),
            "recordsFiltered" => $this->mod_nhom->_count_filtered()
        ));
    }
    function insert_gia_nhom_kh_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_insert_gia_nhom_kh($input['id']);
        if ($list) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function update_gia_nhom_kh_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_update_gia_nhom_kh($input);
        if ($list) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function update_nhom_gia_status_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_update_nhom_gia_status($input);
        if ($list) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
    function update_nhom_gia_all_post() {
        $input = $this->input->post();
        foreach ($input['id'] as $value) {
            $data['nhom'] = $value;
            $data['khachhang'] = $input['khachhang'];
            $data['status'] = $input['status'];
            $kiemtra = $this->mod_nhom->_update_nhom_gia_status($data);
            if(!$kiemtra) {
            $this->response(array("err_code" => "100"));
            }
        }
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function delete_gia_nhom_kh_post() {
        $input = $this->input->post();
        $list = $this->mod_nhom->_delete_gia_nhom_kh($input);
        if ($list) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        } 
    }
}
