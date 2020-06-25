<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_account');
        $this->load->model('mod_project');
    }
    function login_post() {
        $arrayUser = $this->post();
        $this->mod_account->project = $arrayUser['project'];
        $salt = $this->mod_account->_getSalt($arrayUser['username']);
        if ($salt) {
            $user = $this->mod_account->_login(array(
                'id' => $salt['id'],
                'password' => $arrayUser['password'],
                'salt' => $salt['salt']
            ));
            if ($user) $this->response(array('err_code' => '100', 'status' => 'success', 'user' => $user));
            else $this->response(array('err_code' => '102', 'status' => 'Lỗi dữ liệu, vui lòng thử lại'));
        }
        else $this->response(array('err_code' => '101', 'status' => 'Sai tên đăng nhập hoặc mật khẩu', 'test' => $arrayUser['username']));
    }
    function sidebar_post() {
        $this->load->model('mod_permission');
        $this->load->library('permission');
        //Load menu
        $arrInfo = $this->post();
        $menu = $this->mod_permission->_loadMenu($arrInfo['aid']);
        $this->response(array('menu' => $menu));
    }    
    function register_post() {
        $arrayUser = $this->post();
        $this->mod_account->project = $arrayUser['project'];
        //Kiem tra project co ton tai ko
        if (!$this->mod_project->_isExists($arrayUser['project'])) {
            $this->response(array('err_code' => '101', 'msg' => 'Project ko ton tai', 'project' => $arrayUser['project']));
            exit();
        }
        //Kiem tra email
        if ($this->mod_account->_isExists('ACC_EMAIL', $arrayUser['email'])) {
            $this->response(array('err_code' => '102'));
            exit();
        }
        //Kiem tra phone
        if ($this->mod_account->_isExists('ACC_PHONE', $arrayUser['phone'])) {
            $this->response(array('err_code' => '103'));
            exit();
        }
        //Kiem tra cmnd
        if ($this->mod_account->_isExists('ACC_CMND', $arrayUser['cmnd'])) {
            $this->response(array('err_code' => '104'));
            exit();
        }
        $arrayUser['salt'] = getRandom(15);
        $arrayUser['pwd'] = '123';
        $regID = $this->mod_account->_create($arrayUser);
        if ($regID) {
            $this->response(array('err_code' => '200', 'id' => $regID, 'pwd' => $arrayUser['pwd']));
        }
        else $this->response(array('err_code' => '101'));
    }
    function changepwd_post() {
        $arrInfo = $this->post();
        $this->mod_account->project = $arrInfo['project'];
        $account = $this->mod_account->_gets($arrInfo['aid']);
        if (md5(md5($arrInfo['password_old']).$account['salt']) == $account['pwd']) {
            $values['password_new'] = md5(md5($arrInfo['password_new']).$account['salt']);
            $values['password_live'] = $arrInfo['password_new'];
            $values['aid'] = $account['id'];
            if ($this->mod_account->_changePwd($values)) {
                $this->response(array('err_code' => '100', 'status' => 'success'));
            }
            else $this->response(array('err_code' => '101', 'status' => 'Lỗi hệ thống, vui lòng thử lại'));
        }
        else $this->response(array('err_code' => '102', 'status' => 'Sai mật khẩu cũ'));
    }
    function resetpwd_post() {
        $arrInfo = $this->post();
        $this->mod_account->project = $arrInfo['project'];
        $account = $this->mod_account->_gets($arrInfo['aid']);
        if ($account) {
            $values['password_new'] = md5(md5($arrInfo['password_new']).$account['salt']);
            $values['password_live'] = $arrInfo['password_new'];
            $values['aid'] = $account['id'];
            if ($this->mod_account->_changePwd($values)) {
                $this->response(array('err_code' => '100', 'status' => 'success'));
            }
            else $this->response(array('err_code' => '101', 'status' => 'Lỗi hệ thống, vui lòng thử lại'));
        }
        else $this->response(array('err_code' => '102', 'status' => 'Sai mật khẩu cũ'));
    }
    function listmods_post() {
        $this->load->library('permission');
        $arrInfo = $this->post();
        $modules = $this->mod_account->_getmods($arrInfo['uid'], $arrInfo['gid']);
        $items = array();
        $stt = 0;
        foreach ($modules as $module) {
            $permarr = $this->permission->getPermissions($module['val']);
            $read = ($permarr['master'] OR $permarr['read']) ? ' checked' : '';
            $write = ($permarr['master'] OR $permarr['write']) ? ' checked' : '';
            $delete = ($permarr['master'] OR $permarr['delete']) ? ' checked' : '';
            $update = ($permarr['master'] OR $permarr['update']) ? ' checked' : '';
            $master = ($permarr['master']) ? ' checked' : '';

            $items[$module['id']] = array(
                'read' => $read,
                'write' => $write,
                'delete' => $delete,
                'update' => $update,
                'master' => $master,
                'group' => $module['groupname'],
                'groupid' => $module['groupid'],
                'module' => $module['name'],
                'dinhnghia' => $module['dinhnghia'],
                'hide' => $module['hide'],
                'value' => $module['val'],
                'stt' => $stt
            );
            $stt++;
        }
        $this->response(array('listmods' => $items));
    }
    function setpermission_post() {
        $arrayPost = $this->post();
        $this->load->model('mod_permission');
        $this->mod_permission->_setPermission($arrayPost['value']);
        $this->response(array('ketqua'=>'OK'));
    }
    function gets_post() {
        $arrayPost = $this->post();
        $this->mod_account->project = $arrayPost['project'];
        $account = ($arrayPost['uid']) ? $this->mod_account->_gets($arrayPost['uid']) : $this->mod_account->_gets();
        $this->response($account);
    }
    function get_acclaymau_post() {
        $list = $this->mod_account->_getModID_laymau();
        $acc = $this->mod_account->_get_acclaymau($list['MOD_ID']);
        if ($acc) {
            $this->response(array('err_code' => '100', 'list' => $acc));
        } else {
            $this->response(array('err_code' => '200'));
        }
    }
}
