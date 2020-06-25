<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('TailieuInterface');
class Mod_tailieu extends MY_Model implements TailieuInterface {
    function getDeNghiByLoaiQuyTrinh($QuyTrinh, $condition, $userCondition, $trangthai = null, $option = null){
        if($trangthai == "chuaduyet")
            $trangthaiQuery = " and dn.de_nghi_id = tailieu.de_nghi_id";
        $this->db->select("dn.*, loaidn.loai_de_nghi_name,tailieu.tai_lieu_id ,tailieu.tai_lieu_name, tailieu.de_nghi_id as denghi_tai_lieu");
        $this->db->from('tl_de_nghi as dn');
        $this->db->join('tl_quy_trinh_ket_qua as qtkq', 'qtkq.quy_trinh_id = dn.quy_trinh_id and qtkq.de_nghi_ket_qua_id = dn.de_nghi_ket_qua_id', 'left');
        $this->db->group_start();
        $this->db->group_start();
        $this->db->where($condition);
        if($QuyTrinh != 1 && $QuyTrinh != 3){  
            $this->db->where("qtkq.next_step", 1);
        }
        $this->db->group_end();
        if($option){
            $this->db->or_group_start();
            $this->db->where($option);
            if($option["tailieu.loai_tai_lieu_id"] == 2){
                $this->db->where("qtkq.next_step", 1);
            }else{
                $this->db->where("qtkq.next_step", 2);// for quay lai
            }
            $this->db->group_end();
        }
        $this->db->group_end();
        $this->db->where($userCondition);
        //$this->db->where('dn.status', 1);
        $this->db->join('tl_loai_de_nghi as loaidn', 'dn.loai_de_nghi_id = loaidn.loai_de_nghi_id');
        $this->db->join('tl_tai_lieu as tailieu', 'dn.tai_lieu_id = tailieu.tai_lieu_id' . $trangthaiQuery);
        $this->db->order_by("dn.tai_lieu_id", "desc");
        //echo $this->db->get_compiled_select(); exit(1);
        $this->db->distinct();        
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }
}
/* End of file */