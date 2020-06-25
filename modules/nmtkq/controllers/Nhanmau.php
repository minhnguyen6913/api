<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nhanmau extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_nhanmau');
    }
    function notification_hopdong_duyet_post(){
        $total['duyet'] = $this->mod_nhanmau->_count_all_hopdong_duyet(4);
        $total['sua'] = $this->mod_nhanmau->_count_all_hopdong_duyet(3);
        $this->response(array("err_code" => "200", "total" => $total));
    }
    function notification_nhanmau_post(){
        $input = $this->input->post();
        $total['duyet'] = $this->mod_nhanmau->_count_all_hopdong_duyet(4);
        $total['sua'] = $this->mod_nhanmau->_count_all_hopdong_duyet(3);
        $this->response(array("err_code" => "200", "total" => $total));
    }

}
