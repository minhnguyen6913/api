<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('AccountInterface');
class Mod_module extends MY_Model implements AccountInterface {
    var $group = FALSE;
    function _gets($id = FALSE) {
        $this->db->select('MOD_ID id, MOD_NAME name, MOD_DEFINE dinhnghia, MOD_ORDER thutu, MOD_HIDE hide');
        $this->db->from('_module');
        $this->db->where('GROUP_ID', $this->group);
        if ($id) $this->db->where('MOD_ID', $id);
        $this->db->order_by("MOD_ORDER", "ASC");
        $query = $this->db->get();
        $result = ($id) ? $query->row_array() : $query->result_array();
        $query->free_result();
	return ($result) ? $result : FALSE;        
    }
    function _update($data) {
        $this->db->trans_start();
        $this->db->where('MOD_ID', $data['id']);
        $this->db->update('_module', array('MOD_NAME' => $data['mname'], 'MOD_ORDER' => $data['morder']));
        $this->db->where('MOD_ID', $data['id']);
        $this->db->trans_complete();
    }
    function _update_new($data) {
        $this->db->trans_start();
        $this->db->where('MOD_ID', $data['id']);
        $this->db->update('_module', array('MOD_NAME' => $data['mname']));
        $this->db->where('MOD_ID', $data['id']);
        $this->db->where('GROUP_ID', $data['gid']);
        $this->db->update('_group_module', array('MOD_ORDER' => $data['morder']));
        $this->db->trans_complete();
    }
}
/* End of file */