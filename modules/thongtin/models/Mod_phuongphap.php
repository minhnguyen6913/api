<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_phuongphap extends MY_Model implements ThongtinInterface {
    function _create($values) {
        $dieukien = array(
            'phuongphap_code' => trim($values['code']),
            'phuongphap_name_vni' => $values['name'],
            'phuongphap_name_eng' => $values['name_eng'],
            'phuongphap_status' => 'Y'
        );
        $kiemtra = $this->db->select("*")->from('phuongphap')->where($dieukien)->get()->num_rows();
        if ($kiemtra == 0) {
            $insert = array(
                'phuongphap_code' => trim($values['code']),
                'phuongphap_name_vni' => $values['name'],
                'phuongphap_name_eng' => $values['name_eng'],
                'phuongphap_shortname' => $values['shortname'],
                'phuongphap_type' => $values['loai']
            );
            return $this->db->insert('phuongphap', $insert);
        } else {
            return false;
        }
    }
    function phuongphap_update($input){
        $data = array(
            'phuongphap_status' => 'N',
        );
        $this->db->where_in('phuongphap_code', $input['phuongphap_code']);
        $this->db->update('phuongphap', $data);
        return TRUE;
    }
    function _get_phuongphap_id($phuongphap_code) {
        $this->db->select('phuongphap_id');
        $this->db->from('phuongphap');
        $this->db->where('phuongphap_code', $phuongphap_code);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _update_phuongphap($data) {
        $value = array('phuongphap_code', $data['code']);
        $this->db->where('phuongphap_id', $data['id']);
        $this->db->update('phuongphap', $value);
        return TRUE;
    }
}
/* End of file */