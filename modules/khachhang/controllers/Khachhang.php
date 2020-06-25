<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Khachhang extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_khachhang');
    }
    function get_allkh_post() {
        $list = $this->mod_khachhang->_get_khachhangall();
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_infokh_post(){
        $input = $this->input->post();
        $list = $this->mod_khachhang->_get_infokh($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_contactkh_post(){
        $input = $this->input->post();
        $list = $this->mod_khachhang->_get_contact_kh($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_allcontact_post() {
        $list = $this->mod_khachhang->_get_contact_all();
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_list_contact_byKH_post() {
        $input = $this->input->post();
        $this->response(array(
            "list" => $this->mod_khachhang->_get_contact_by_listKH($input['id']),
        ));
    }
    function get_infocontact_post(){
        $input = $this->input->post();
        $list = $this->mod_khachhang->_get_contactinfo($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_khcontact_post(){
        $input = $this->input->post();
        $list = $this->mod_khachhang->_get_kh_contact($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_khachhang_nhansu_post() {
        $input = $this->input->post();
        $this->mod_khachhang->post = $input['post'];
        $this->mod_khachhang->id_khachhang = $input['id'];
        $this->response(array(
            "list" => $this->mod_khachhang->_get_datatables(),
            "recordsTotal" => $this->mod_khachhang->_count_all(),
            "recordsFiltered" => $this->mod_khachhang->_count_filtered()
        ));
    }

}
