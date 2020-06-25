<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('AccountInterface');
class Mod_group extends MY_Model implements AccountInterface {
    var $project = FALSE;
    function _gets($id = FALSE) {
        $this->db->select('GROUP_ID id,GROUP_NAME name, GROUP_ORDER thutu');
        $this->db->from('_group');
        $this->db->where('PROJECT_ID', $this->project);
        $this->db->order_by("GROUP_ORDER", "ASC");
        if ($id) $this->db->where('GROUP_ID', $id);
        $query = $this->db->get();
        $result = ($id) ? $query->row_array() : $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;        
    }
    function _update($id, $data) {
        $this->db->where('GROUP_ID', $id);
        $this->db->update('_group',$data);
    }
    function _getinaccs($id) {
        $this->db->select('a.ACC_ID id,a.ACC_EMAIL email,a.ACC_PHONE phone');
        $this->db->from('_account AS a');
        $this->db->join('_group_account AS g', 'a.ACC_ID = g.ACC_ID');
        $this->db->where('g.GROUP_ID', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _getoutaccs($id) {
        $sql = "
            SELECT ACC_ID id FROM _account
            WHERE _account.PROJECT_ID = {$this->project}
            AND _account.ACC_ID NOT IN (
                SELECT _account.ACC_ID
                FROM _account
                JOIN _group_account ON _account.ACC_ID = _group_account.ACC_ID
                WHERE _group_account.GROUP_ID = {$id}
            );
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $query->free_result();
		return ($result) ? $result : FALSE;
    }
    function _addaccs($value) {
        $this->db->insert_batch('_group_account', $value);
    }
    function _removeacc($aid, $gid) {
        if (!$this->db->delete('_group_account', array('ACC_ID' => $aid, 'GROUP_ID' => $gid))) {
            return FALSE;
        }
        return TRUE;
    }
}
/* End of file */