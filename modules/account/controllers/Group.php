<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_group');
    }
    function gets_post() {
        $arrayPost = $this->post();
        $this->mod_group->project = $arrayPost['project'];
        $group = ($arrayPost['gid']) ? $this->mod_group->_gets($arrayPost['gid']) : $this->mod_group->_gets();
        $this->response($group);
    }
    function getaccs_post() {
        $arrayPost = $this->post();
        $accounts = $this->mod_group->_getinaccs($arrayPost['gid']);
        $this->response($accounts);
    }
    function getoutaccs_post() {
        $arrayPost = $this->post();
        $this->mod_group->project = $arrayPost['project'];
        $accounts = $this->mod_group->_getoutaccs($arrayPost['gid']);
        $this->response($accounts);
    }
    function update_post() {
        $arrayPost = $this->post();
        $this->mod_group->_update($arrayPost['id'], array('GROUP_NAME' => $arrayPost['name'], 'GROUP_ORDER' => $arrayPost['gorder']));
        $this->response(array('mess'=>'ok'));
    }
    function addaccs_post() {
        $arrayPost = $this->post();
        $value = array();
        foreach ($arrayPost['accounts'] as $acc) {
            $value[] = array(
                'ACC_ID' => $acc,
                'GROUP_ID' => $arrayPost['gid']
            );
        }
        $this->mod_group->_addaccs($value);
        $this->response(array('ketqua'=>'OK'));
    }
    function removeacc_post() {
        $arrayPost = $this->post();
        $this->mod_group->_removeacc($arrayPost['aid'], $arrayPost['gid']);
        $this->response(array('ketqua'=>'OK'));
    }
}
