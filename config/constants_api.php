<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['_projectID'] = 1;
define('_PROJECT_ID', $config['_projectID']);

define('_MYSQL', json_encode(array(
    'account' => array('username' => 'root', 'password' => 'root', 'database' => 'api_account'),
    'tochuc' => array('username' => 'root', 'password' => 'root', 'database' => 'api_tochuc'),
    )));

// define('_MYSQL', json_encode(array(
//     'account' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_account'),
//     'tochuc' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_tochuc'),
//     'thongtin' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_thongtin'),
//     'tailieu' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_tailieu'),
//     'hoachat' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_hoachat'),
//     'khachhang' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_khachhang'),
//     'nmtkq' => array('username' => 'root', 'password' => 'root', 'database' => 'brem_nmtkq')
// )));

// define('_MYSQL', json_encode(array(
//     'account' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_account'),
//     'tochuc' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_tochuc'),
//     'thongtin' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_thongtin'),
//     'tailieu' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_tailieu'),
//     'hoachat' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_hoachat'),
//     'khachhang' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_khachhang'),
//     'nmtkq' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_nmtkq'),
//     'ketqua' => array('username' => 'root', 'password' => 'root', 'database' => 'wrt_ketqua'),
// )));