<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Check extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("mod_account");
    }
    function email_get() {
        $arrayUser = $this->get();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_EMAIL', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'email', 'message' => 'Email Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => $arrayUser['val'], 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
    function email_post() {
        $arrayUser = $this->post();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_EMAIL', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'email', 'message' => 'Email Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => 'email', 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
    function phone_get() {
        $arrayUser = $this->get();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_PHONE', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'phone', 'message' => 'Điện thoại Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => 'phone', 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
    function phone_post() {
        $arrayUser = $this->post();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_PHONE', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'phone', 'message' => 'Điện thoại Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => 'phone', 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
    function cmnd_get() {
        $arrayUser = $this->get();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_CMND', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'phone', 'message' => 'Chứng minh này Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => 'phone', 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
    function cmnd_post() {
        $arrayUser = $this->post();
        $this->mod_account->project = $arrayUser['project'];
        if ($this->mod_account->_isExists('ACC_CMND', $arrayUser['val'], $arrayUser['id']))
            $data = array('err_code' => '101', 'response' => 'phone', 'message' => 'Chứng minh này Đã sử dụng');
        else
            $data = array('err_code' => '200', 'response' => 'phone', 'message' => 'Có thể sử dụng');
        $this->response($data);
    }
}
