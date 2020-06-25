<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_nenmau extends MY_Model implements ThongtinInterface {
    
    function _get_All_nenmau(){
        $this->db->select('*');
        $this->db->from('nenmau');
        $this->db->where('nenmau_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_nenmau_info($id) {
        $this->db->select('*');
        $this->db->from('nenmau');
        $this->db->where('nenmau_id', $id);
        $this->db->where('nenmau_status', 'Y');
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _getRef($id) {
        $this->db->select('nenmau_ref ref');
        $this->db->from('nenmau');
        $this->db->where('nenmau_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }

}
/* End of file */