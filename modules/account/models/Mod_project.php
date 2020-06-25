<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('AccountInterface');
class Mod_project extends MY_Model implements AccountInterface {
    function _isExists($id) {
        $this->db->select('PROJECT_NAME');
    	$this->db->where('PROJECT_ID', $id);
        $query = $this->db->get('_projects');
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }
}
/* End of file */