<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Module extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_module');
    }
    function gets_post() {
        $arrayPost = $this->post();
        $this->mod_module->group = $arrayPost['group'];
        $module = ($arrayPost['mid']) ? $this->mod_module->_gets($arrayPost['mid']) : $this->mod_module->_gets();
        $this->response($module);
    }
    function update_post() {
        $arrayPost = $this->post();
        $this->mod_module->_update($arrayPost);
        $this->response(array('mess' => 'ok'));
    }
}
