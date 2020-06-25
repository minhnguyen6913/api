<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Phongthinghiem extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nhanmau');
    }
    function notification_nhanmau_post(){
        $input = $this->input->post();
        $total = $this->mod_nhanmau->_count_all_nhanmau_ptn($input['dinhnghia'],$input['donvi']);
        $this->response(array("err_code" => "200", "total" => $total));
    }
    function notification_kqnhaplai_post(){
        $input = $this->input->post();
        $total = $this->mod_nhanmau->_count_all_kqnhaplai_ptn($input['dinhnghia'],$input['donvi']);
        $this->response(array("err_code" => "200", "total" => $total));
    }
    function notification_kqduyet_post(){
        $input = $this->input->post();
        $total = $this->mod_nhanmau->_count_all_kqduyet_ptn($input['dinhnghia']);
        $this->response(array("err_code" => "200", "total" => $total));
    }

}
