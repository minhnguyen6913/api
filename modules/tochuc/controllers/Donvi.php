<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donvi extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_donvi');
    }
    function getPTN_post() {
        $array = $this->post();
        $list = $this->mod_donvi->getPTN($array['type']);
        if($list){
            $this->response(array('code' => '100', 'list' => $list));
        }else{
            $this->response(array('code' => '200'));
        }
    }
    function getdsnhansu_donvi_post(){
        $array = $this->post();
        $list = $this->mod_donvi->getDSNS_Donvi($array['donvi_id']);
        if($list){
            $this->response(array('code' => '100', 'list' => $list));
        }else{
            $this->response(array('code' => '200'));
        }
    }
    function getnhansuchinh_donvi_post(){
        $input = $this->input->post();
        $list = $this->mod_donvi->getDSNSChinh_Donvi($input['donvi_id']);
        if($list){
            $this->response(array('code' => '100', 'list' => $list));
        }else{
            $this->response(array('code' => '200'));
        }
    }
    function getdonvi_post(){
        $array = $this->post();
        $list = $this->mod_donvi->getDV($array['id']);
        if($list){
            $this->response(array('code' => '100', 'list' => $list));
        }else{
            $this->response(array('code' => '200'));
        }
    }
    function get_alldonvi_post(){
        $list = $this->mod_donvi->_getAllDonVi();
        if($list){
            $this->response(array('code' => '100', 'list' => $list));
        }else{
            $this->response(array('code' => '200'));
        }
    }
    function getphongban_list_post(){
        $input = $this->input->post();
        $list = $this->mod_donvi->_get_phongban_by_list($input);
        $this->response(array('list' => $list));
    }
}
