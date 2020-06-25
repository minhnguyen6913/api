<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('AccountInterface');
class Mod_account extends MY_Model implements AccountInterface {
    var $project = FALSE;
    function _getSalt($id) {
        $this->db->select('ACC_ID id, ACC_SALT salt');
        $this->db->from('_account');
        $this->db->where('PROJECT_ID',$this->project)->where("(ACC_EMAIL='{$id}' OR ACC_PHONE='{$id}' OR ACC_CMND='{$id}')");
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return $result;
    }
    function _login($login) {
        $this->db->select('ACC_ID id,ACC_EMAIL email,ACC_PHONE phone,ACC_CMND cmnd,ACC_DATE date_create');
        $this->db->from('_account');
        $this->db->where('PROJECT_ID', $this->project);
        $this->db->where('ACC_ID', $login['id']);
        $this->db->where('ACC_PWD', md5(md5($login['password']).$login['salt']));
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return $result;
    }
    function _gets($id = FALSE) {
        $this->db->select('ACC_ID id,ACC_EMAIL email,ACC_PHONE phone,ACC_DATE date_create,ACC_SALT salt, ACC_PWD pwd');
        $this->db->from('_account');
        $this->db->where('PROJECT_ID', $this->project);
        if ($id) $this->db->where('ACC_ID', $id);
        $query = $this->db->get();
        $result = ($id) ? $query->row_array() : $query->result_array();
        $query->free_result();
	return ($result) ? $result : FALSE;        
    }
    function _getmods($acc, $group = FALSE) {
        $where = $group ? "`_group_account`.`ACC_ID` = {$acc} AND `_group`.`GROUP_ID` = {$group}" : "`_group_account`.`ACC_ID` = {$acc}";
        //$where = $group ? "`_group_account`.`ACC_ID` = {$acc} AND `_group`.`GROUP_ID` = {$group} AND `_module`.`MOD_HIDE` = 'N'" : "`_group_account`.`ACC_ID` = {$acc}";
        $sql = "
            SELECT
                `_module`.`MOD_ID` `id`,
                `_module`.`MOD_NAME` `name`,
                `_module`.`MOD_DEFINE` `dinhnghia`,
                `_module`.`MOD_HIDE` `hide`,
                `_group`.`GROUP_ID` `groupid`,
                `_group`.`GROUP_NAME` `groupname`,
                `_permission`.`VALUE` `val`
            FROM
                `_module`
            INNER JOIN `_group` ON `_module`.`GROUP_ID` = `_group`.`GROUP_ID`
            INNER JOIN `_group_account` ON `_group`.`GROUP_ID` = `_group_account`.`GROUP_ID`
            LEFT JOIN `_permission` ON `_group_account`.`ACC_ID` = `_permission`.`ACC_ID` AND `_module`.`MOD_ID` = `_permission`.`MOD_ID`
            WHERE {$where}
            ORDER BY `_group`.`GROUP_ORDER`,`_module`.`MOD_ORDER` ASC
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $query->free_result();
	return ($result) ? $result : FALSE;
    }
    function _changePwd($values) {
        $data = array(
            'ACC_PWD' => $values['password_new'],
            'ACC_PWD_LIVE' => $values['password_live']
        );
        $this->db->where('ACC_ID', $values['aid']);
        $this->db->where('PROJECT_ID', $this->project);
        $this->db->update('_account', $data);
        return ($this->db->affected_rows()) ? TRUE : FALSE;
    }
    function _create($values) {
        if (!$this->db->insert('_account', array(
            'ACC_EMAIL' => $values['email'],
            'ACC_PWD' => md5(md5($values['pwd']).$values['salt']),
            'ACC_PWD_LIVE' => $values['pwd'],
            'ACC_SALT' => $values['salt'],
            'ACC_PHONE' => $values['phone'],
            'ACC_CMND' => $values['cmnd'],
            'PROJECT_ID' => $this->project
        ))) return FALSE;
        return $this->db->insert_id();
    }
    function _isExists($field, $value, $uid = FALSE) {
        $this->db->select('ACC_ID');
    	$this->db->where('PROJECT_ID', $this->project);
    	$this->db->where($field, $value);
        if ($id) $this->db->where('ACC_ID <>', $id);
        $query = $this->db->get('_account');
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }
    function _getModID_laymau() {
        $this->db->select('MOD_ID');
        $this->db->from('_module');
        $this->db->where('MOD_DEFINE', '_LAYMAU');
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_acclaymau($mod_id){
        $this->db->select('ACC_ID');
        $this->db->from('_permission');
        $this->db->where('MOD_ID', $mod_id);
        $this->db->where('VALUE >', 0);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
}
/* End of file */