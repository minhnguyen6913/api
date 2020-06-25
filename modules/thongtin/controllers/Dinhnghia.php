<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dinhnghia extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_dinhnghia');
    }
    function get_alldinhnghia_post() {
        $input = $this->input->post();
        $list = $this->mod_dinhnghia->_get_All_dinhnghia($input['id']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_dinhnghia_gia_kh_post() {
        $input = $this->input->post();
        $this->mod_dinhnghia->post = $input['post'];
        $this->mod_dinhnghia->status = $input['status'];
        $this->mod_dinhnghia->id_khachhang = $input['id'];
        $this->response(array(
            "list" => $this->mod_dinhnghia->_get_datatables(),
            "recordsTotal" => $this->mod_dinhnghia->_count_all(),
            "recordsFiltered" => $this->mod_dinhnghia->_count_filtered()
        ));
    }
    function get_dinhnghia_post() {
        $input = $this->input->post();
        $this->mod_dinhnghia->post_dn = $input['post'];
        $this->mod_dinhnghia->id_dinhnghia = $input['id'];
        $this->response(array(
            "list" => $this->mod_dinhnghia->_get_datatables_dinhnghia(),
            "recordsTotal" => $this->mod_dinhnghia->_count_all_dinhnghia(),
            "recordsFiltered" => $this->mod_dinhnghia->_count_filtered_dinhnghia()
        ));
    }
    function insert_gia_dinhnghia_kh_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_dinhnghia->_insert_dinhnghia_gia_kh($input['id']);
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function update_gia_dinhnghia_kh_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_dinhnghia->_update_dinhnghia_gia_kh($input);
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function update_dinhnghia_gia_status_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_dinhnghia->_update_dinhnghia_gia_status($input);
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function update_dinhnghia_gia_all_post() {
        $input = $this->input->post();
        foreach ($input['id'] as $value) {
            $data['dinhnghia'] = $value;
            $data['khachhang'] = $input['khachhang'];
            $data['status'] = $input['status'];
            $kiemtra = $this->mod_dinhnghia->_update_dinhnghia_gia_status($data);
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
    function delete_gia_dinhnghia_kh_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_dinhnghia->_delete_dinhnghia_gia_kh($input);
        if($kiemtra) {
            $this->response(array("err_code" => "200"));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_dinhnghiainfo_post(){
        $input = $this->input->post();
        $list = $this->mod_dinhnghia->_get_info_dinhnghia($input['list']);
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
    function get_dinhnghia_nhansu_post(){
        $dinhnghia = $this->input->post('list_dinhnghia');
        $donvi = $this->input->post('list_donvi');      
        $list = $this->mod_dinhnghia->_get_dinhnghia_nhansu($dinhnghia, $donvi);
         if($list) {
             $this->response(array("err_code" => "200", "list" => $list));
         } else {
             $this->response(array("err_code" => "100"));
         }
    }
    function get_dinhnghia_donvi_post() {
        $input = $this->input->post();
        $list = $this->mod_dinhnghia->_get_dinhnghia_donvi($input['donvi_id']);
        if($list) {
             $this->response(array("err_code" => "200", "list" => $list));
         } else {
             $this->response(array("err_code" => "100"));
         }
    }
    function get_dinhnghia_donvi_datatable_post() {
        $input = $this->input->post();
        $this->mod_dinhnghia->post_dn_donvi = $input['post'];
        $this->mod_dinhnghia->id_donvi = $input['id'];
        $this->response(array(
            "list" => $this->mod_dinhnghia->_get_datatables_dinhnghia_donvi(),
            "recordsTotal" => $this->mod_dinhnghia->_count_all_dinhnghia_donvi(),
            "recordsFiltered" => $this->mod_dinhnghia->_count_filtered_dinhnghia_donvi()
        ));
    }
    function get_khachhang_duyetgia_post() {
        $list1 = $this->mod_dinhnghia->get_khachhang_gia_dinhnghia();
        $list2 = $this->mod_dinhnghia->get_khachhang_gia_nhom();
        $list  = array_merge($list1,$list2);
        if ($list) {
            $this->response(array('err_code' => '200', 'list' => $list));
        } else {
            $this->response(array('err_code' => $list1, 'lisst'=> $list2));
        }    
    }

    function get_dinhnghia_result_post() {
        $list = $this->input->post('list');
        $data = $this->mod_dinhnghia->get_dinhnghia_result($list);
        if ($data) {
            $this->response(array('err_code' => '200', 'list' => $data));
        } else {
            $this->response(array('err_code' => '100'));
        }    
    }
}
