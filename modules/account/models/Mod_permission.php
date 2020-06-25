<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('AccountInterface');
class Mod_permission extends MY_Model implements AccountInterface {
    function _loadMenu($acc) {
        $sql = "
            SELECT
                `_group`.`GROUP_ID` `gid`,
                `_group`.`GROUP_NAME` `gname`,
                `_group`.`GROUP_LINK` `glink`,
                `_group`.`GROUP_ICON` `gicon`,
                `_module`.`MOD_ID` `mid`,
                `_module`.`MOD_NAME` `mname`,
                `_module`.`MOD_DEFINE` `mdefine`,
                `_module`.`MOD_LINK` `mlink`,
                `_module`.`MOD_HIDE` `mhide`
            FROM
                `_group`
            INNER JOIN `_group_account` ON `_group`.`GROUP_ID` = `_group_account`.`GROUP_ID`
            LEFT JOIN `_module` ON `_module`.`GROUP_ID` = `_group`.`GROUP_ID`
            WHERE `_group_account`.`ACC_ID` = {$acc}
            ORDER BY `_group`.`GROUP_ORDER`,`_module`.`MOD_ORDER` ASC
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _setPermission($value = array()) {
        $mods = array();
        $data = array();
        foreach($value['value'] as $key => $val) {
            $mods[] = $val['idMod'];
            $data[] = array(
                'ACC_ID' => $value['aid'],
                'MOD_ID' => $val['idMod'],
                'VALUE' => $val['priv']
            );
        }
        $this->db->trans_start();
        $this->db->where('ACC_ID', $value['aid']);
        $this->db->where_in('MOD_ID', $mods);
        $this->db->delete('_permission');
        $this->db->insert_batch('_permission', $data);
        $this->db->trans_complete();
    }
}
/* End of file */