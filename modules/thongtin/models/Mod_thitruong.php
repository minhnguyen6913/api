<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_thitruong extends MY_Model implements ThongtinInterface {
    
    function _get_thitruong_info($id_thitruong){
        $this->db->select('*');
        $this->db->from('thitruong');
        $this->db->where('thitruong_status', 'Y');
        $this->db->where_in('thitruong_id', $id_thitruong);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_all_thitruong() {
        $this->db->select('*');
        $this->db->from('thitruong');
        $this->db->where('thitruong_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
}
/* End of file */