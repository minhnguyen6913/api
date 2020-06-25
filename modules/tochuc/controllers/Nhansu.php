<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nhansu extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nhansu');
    }
    function getinfouser_post() {
        $id = $this->post();
        $array = array();
        $array['nhansu'] = $this->mod_nhansu->UserInfo($id['id']);
        $array['dsphongban'] = $this->mod_nhansu->GetPhongBan($id['id']);
        $this->response(array('list' => $array));
    }
    function getallns_post() {
        $list = $this->mod_nhansu->_get_allns();
        $this->response(array('list' => $list));
    }
    function getnhansu_post(){
        $array = $this->input->post();
        $list = $this->mod_nhansu->_getNhansu($array['id']);
        $this->response(array('list' => $list));
    }
    function getnhansungoaiphong_post(){
        $array = $this->input->post();
        $list = $this->mod_nhansu->_getNhansu_ngoaiphongban($array['id']);
        $this->response(array('list' => $list));
    }
    function captren_post() {
        $danhsach_nhansu_captren = array();
        $input = $this->input->post();
        if (isset($input['nhansu_id'])) {
            $hientai = $this->mod_nhansu->capbac_hientai($input['nhansu_id']);
            //chức vụ cấp cao hơn
            $chucvu = $this->mod_nhansu->get_chucvu($hientai['chucvu_id']);
            $chucvucaohon = explode("-", $chucvu['chucvu_ref']);
            $ketthuc = 0;
            if (count($chucvucaohon) != 0) {
                for ($i = 1; $i < count($chucvucaohon); $i++) {
                    if (trim($chucvucaohon[$i]) != "") {
                        $get_danhsach_theochucvu = $this->mod_nhansu->danhsach_theochucvu(trim($chucvucaohon[$i]), $hientai['donvi_id']);
                        if ($ketthuc == 0) {
                            if (!in_array($get_danhsach_theochucvu['nhansu_id'], $danhsach_nhansu_captren)) {
                                $danhsach_nhansu_captren[$get_danhsach_theochucvu['nhansu_id']] = $get_danhsach_theochucvu['nhansu_lastname'] . " " . $get_danhsach_theochucvu['nhansu_firstname'];
                                $ketthuc = 1;
                            }
                        }
                    }
                }
                //kết thúc chức vụ cấp cao hơn
                if (count($danhsach_nhansu_captren) > 0) {
                    $this->response(array('err_code' => '200', 'danhsach' => $danhsach_nhansu_captren));
                } else {
                    $this->response(array('err_code' => '101'));
                }
            }
        } else {
            $this->response(array('err_code' => '101'));
        }
    }
    function insert_ns_dinhnghia_post() {
        $input = $this->input->post();
        $this->mod_nhansu->_insert_nhansu_dinhnghia($input);
        $this->response(array('mess' => 'ok'));
    }
    function get_nhansu_dinhnghia_post() {
        $input = $this->input->post();
        $list = $this->mod_nhansu->_get_nhansu_dinhnghia($input['id']);
        if ($list) {
            $this->response(array('err_code' => '100', 'list' => $list));
        } else {
            $this->response(array('err_code' => '200'));
        }
    }
    function nhansu_dinhnghia_post() {
        $input = $this->input->post();
        $this->mod_nhansu->post = $input['post'];
        $this->mod_nhansu->id_dinhnghia = $input['id'];
        $this->response(array(
            "list" => $this->mod_nhansu->_get_datatables(),
            "recordsTotal" => $this->mod_nhansu->_count_all(),
            "recordsFiltered" => $this->mod_nhansu->_count_filtered()
        ));
    }
    function nhansu_dinhnghia_donvi_post() {
        $input = $this->input->post();
        $list = $this->mod_nhansu->_get_nhansu_dinhnghia_donvi($input['id_donvi'], $input['id_dinhnghia']);
        if ($list) {
            $this->response(array('err_code' => '100', 'list' => $list));
        } else {
            $this->response(array('err_code' => '200'));
        }
    }
    function delete_nhansu_dinhnghia_post() {
        $input = $this->input->post();
        $this->mod_nhansu->_delete_nhansu_dinhnghia($input['id_dinhnghia'], $input['id_nhansu']);
        $this->response(array('mess' => 'ok'));
    }
    function delete_dinhnghia_post() {
        $input = $this->input->post();
        $this->mod_nhansu->_detele_dinhnghia($input['id']);
        $this->response(array('mess' => 'ok'));
    }
    function getnhansu_list_post(){
        $input = $this->input->post();
        $list = $this->mod_nhansu->_get_nhansu_by_list($input);
        $this->response(array('list' => $list));
    }
    function get_dinhnghia_by_nhansu_post(){
        $input = $this->input->post();
        $get_list_assign = $this->mod_nhansu->get_dinhnghia_assign();
        $list_assign = array();
        foreach ($get_list_assign as $dn) {
            $list_assign[$dn['dinhnghia_id']][] = $dn['assign_nhansu'];
        }
        $list = $this->mod_nhansu->get_dinhnghia_by_nhansu($input['nhansu_id']);
        $list_all_dnassign = $this->mod_nhansu->_get_all_dinhnghia_assign($input['nhansu_id']);
        if ($list || $list_assign) {
            $this->response(array('err_code' => '200', 'list' => $list, 'list_assign'=> $list_assign, 'list_alldn_assign' => $list_all_dnassign));
        } else {
            $this->response(array('err_code' => '100'));
        }       
    }
    function get_khachhang_nhansu_post() {
        $input = $this->input->post();
        $list = $this->mod_nhansu->_get_khachhang_nhansu($input['id']);
        if ($list) {
            $this->response(array('err_code' => '200', 'list' => $list));
        } else {
            $this->response(array('err_code' => '100'));
        }    
    }
    function insert_khachhang_nhansu_post() {
        $input = $this->input->post();
        $this->mod_nhansu->_insert_khachhang_nhansu($input);
        $this->response(array('mess' => 'ok'));
    }
    function delete_khachhang_nhansu_post() {
        $input = $this->input->post();
        $kiemtra = $this->mod_nhansu->_delete_khachhang_nhansu($input);
        if ($kiemtra) {
            $this->response(array('err_code' => '200'));
        } else {
            $this->response(array('err_code' => '100'));
        }    
    }
}
