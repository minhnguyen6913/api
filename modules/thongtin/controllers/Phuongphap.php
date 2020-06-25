<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Phuongphap extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_phuongphap');
    }
    function add_phuongphap_post(){
        $input = $this->input->post();
        if ($input['code_old'] == '') {
            $data = array(
                'code' => $input['code'],
                'name' => $input['name'],
                'shortname' => $input['shortname'],
                'name_eng' => $input['name_eng'],
                'loai' => $input['loai']
            );
            $kiemtra = $this->mod_phuongphap->_create($data);
            ($kiemtra == true) ? $err = "200" : $err = "101";
            $this->response(array("err_code" => $err));
        } else {
            $get_phuongphap_id = $this->mod_phuongphap->_get_phuongphap_id($input['code_old']);
            $values = array(
                'id' => $get_phuongphap_id['phuongphap_id'],
                'code' => $input['code']
            );
            $kiemtra = $this->mod_phuongphap->_update_phuongphap($values);
            ($kiemtra == true) ? $err = "200" : $err = "101";
            $this->response(array("err_code" => $err));
        }
    }
    function deactive_phuongphap_post(){
        $input = $this->input->post();
        $kiemtra = $this->mod_phuongphap->phuongphap_update($input);
        ($kiemtra == true) ? $err = "200" : $err = "101";
        $this->response(array("err_code" => $err));
    }
}
