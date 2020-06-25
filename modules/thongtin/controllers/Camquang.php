<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Camquang extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_camquang');
    }
    function get_allcamquang_post() {
        $list = $this->mod_camquang->_get_all_camquang();
        if($list) {
            $this->response(array("err_code" => "200", "list" => $list));
        } else {
            $this->response(array("err_code" => "100"));
        }
    }
}