<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tailieu extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Mod_tailieu');
    }
    function get_notification_post(){
        $trangthai = NULL;
        $input = $this->input->post();
        $current_user = $input['id'];
        for ($i = 1; $i <= 6; $i++) {
            switch ($i) {
                case 2:
                    $condition = array(
                        "dn.quy_trinh_id" => $i, // get danh sach da duyet buoc 2
                        "tailieu.loai_tai_lieu_id" => 1 // tai lieu noi bo
                    );
                    $option = array(
                        "dn.quy_trinh_id" => 4, // for soan thao lai
                        "dn.de_nghi_ket_qua_id" => 5
                    );
                    break;
                case 3:
                    $condition = array(
                        "dn.quy_trinh_id" => 3, // get danh sach da soan thao buoc 3
                        "tailieu.loai_tai_lieu_id" => 1 // tai lieu noi bo
                    );
                    $option = array(
                        "dn.quy_trinh_id" => 5, // for soan thao lai tai phe duyet
                        "dn.de_nghi_ket_qua_id" => 5
                    );
                    break;
                case 4:
                    $condition = array(
                        "dn.quy_trinh_id" => 4, // get danh sach da xem xet soan thao buoc 4
                        "tailieu.loai_tai_lieu_id" => 1 // tai lieu noi bo
                    );
                    $option = array(
                        "dn.quy_trinh_id" => 2, // get danh sach da duyet buoc 2
                        "tailieu.loai_tai_lieu_id" => 2 // tai lieu ben ngoai
                    );
                    break;
                default:
                    $condition = array(
                        "dn.quy_trinh_id" => $i,
                    );
                    $option = NULL;
                    break;
            }
            $userCondition = array(
                'de_nghi_user_receive' => trim($current_user)
            );
            $list_de_nghi = $this->Mod_tailieu->getDeNghiByLoaiQuyTrinh($i, $condition, $userCondition, $trangthai, $option);
            $count_trangthai = 0;
            foreach ($list_de_nghi as $dn) {
                if ($dn['denghi_tai_lieu'] == $dn['de_nghi_id']) {
                    $count_trangthai = $count_trangthai + 1;
                }
            }
            $total[$i] = $count_trangthai;
        }
        $this->response(array("err_code" => "200", "total" => $total));
    }
}
