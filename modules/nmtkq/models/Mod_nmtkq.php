<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('NmtkqInterface');
class Mod_nmtkq extends MY_Model implements NmtkqInterface {
    function _check_donvitinh_mau($donvitinh_id) {
        $this->db->select('*');
        $this->db->from('mau');
        $this->db->join('hopdong hd', 'hd.hopdong_id = mau.hopdong_id');
        $this->db->where('hopdong_status <>', 'Deactive');
        $this->db->where('donvitinh_id', $donvitinh_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return (count($result) > 0) ? FALSE : TRUE;
    }
    function _check_thitruong_hopdong($thitruong_id) {
        $this->db->select('*');
        $this->db->from('hopdong_thitruong tthd');
        $this->db->join('hopdong hd', 'hd.hopdong_id = tthd.hopdong_id');
        $this->db->where('thitruong_id', $thitruong_id);
        $this->db->where('hopdong_status <>', 'Deactive');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _check_thitruong_mau($thitruong_id) {
        $this->db->select('*');
        $this->db->from('mau_thitruong');
        $this->db->where('thitruong_id', $thitruong_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _check_thitruong_chitiet($thitruong_id) {
        $this->db->select('*');
        $this->db->from('mau_chitiet_thitruong');
        $this->db->where('thitruong_id', $thitruong_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _deaction_hopdong($khachhang_id) {
        $this->db->where('khachhang_id', $khachhang_id);
        $this->db->update('hopdong', array('hopdong_status' => 'Deactive'));
        if ($this->db->affected_rows() > 0) return TRUE;
        return FALSE;
    }
}
/* End of file */