<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_camquang extends MY_Model implements ThongtinInterface {
    
    function _get_all_camquang() {
        $this->db->select('*');
        $this->db->from('camquang');
        $this->db->where('camquang_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
}
/* End of file */