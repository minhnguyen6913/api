<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['api'] = array(
    'account' => array(
        'login' => _ACCOUNT_RESTFUL.'login',
        'changepwd' => _ACCOUNT_RESTFUL.'changepwd',
        'register' => _ACCOUNT_RESTFUL.'register',
        'check' => array(
            'email' => _ACCOUNT_RESTFUL.'check/email',
            'phone' => _ACCOUNT_RESTFUL.'check/phone',
            'cmnd' => _ACCOUNT_RESTFUL.'check/cmnd'
        ),
        'resetpwd' => _ACCOUNT_RESTFUL.'resetpwd',
        'getinfo' => _ACCOUNT_RESTFUL.'gets',
        'getmenu' => _ACCOUNT_RESTFUL.'sidebar',
        'listmods' => _ACCOUNT_RESTFUL.'listmods',
        'setpermission' => _ACCOUNT_RESTFUL.'setpermission'
    ),
    'group' => array(
        'gets' => _ACCOUNT_RESTFUL.'group/gets',
        'update' => _ACCOUNT_RESTFUL.'group/update',
        'getaccs' => _ACCOUNT_RESTFUL.'group/getaccs',
        'getoutaccs' => _ACCOUNT_RESTFUL.'group/getoutaccs',
        'addaccs' => _ACCOUNT_RESTFUL.'group/addaccs',
        'removeacc' => _ACCOUNT_RESTFUL.'group/removeacc'
    ),
    'module' => array(
        'gets' => _ACCOUNT_RESTFUL.'module/gets',
        'update' => _ACCOUNT_RESTFUL.'module/update'
    )
);