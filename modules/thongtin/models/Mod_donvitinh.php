<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_donvitinh extends MY_Model implements ThongtinInterface {
    
    function _get_donvitinh($type){
        $this->db->select('*');
        $this->db->from('donvitinh');
        $this->db->where('donvitinh_status', 'Y');
        $this->db->where('donvitinh_type', $type);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_donvitinh_info($id) {
        $this->db->select('*');
        $this->db->from('donvitinh');
        $this->db->where('donvitinh_id', $id);
        $this->db->where('donvitinh_status', 'Y');
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
}
/* End of file */