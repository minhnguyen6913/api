<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('TochucInterface');
class Mod_donvi extends MY_Model implements TochucInterface {
    function getPTN($type) {
        $this->db->select('*');
        $this->db->from('donvi');
    	$this->db->where_in('donvi_type', $type);
        $this->db->where('donvi_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function getDSNS_Donvi($id_donvi){
        $this->db->select('ns.*');
        $this->db->from('nhansu AS ns');
        $this->db->join('hopdong AS hd', 'hd.hopdong_id =ns.hopdong_id');
        $this->db->where('hd.donvi_id',$id_donvi);
        $this->db->where('hd.hopdong_status', 'Y');
        $this->db->where('ns.nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function getDV($id_donvi){
        $this->db->select('*');
        $this->db->from('donvi');
        $this->db->where('donvi_id',$id_donvi);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _getAllDonVi(){
        $this->db->select('donvi_id id, donvi_idparent parent, donvi_ten name');
        $this->db->from('donvi');
        $this->db->where('donvi_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array(); 
        $query->free_result();
	return ($result) ? $result : FALSE;
    }
    function getDSNSChinh_Donvi($id_donvi) {
        $this->db->select('ns.*');
        $this->db->from('nhansu AS ns');
        $this->db->join('hopdong AS hd', 'hd.hopdong_id=ns.hopdong_id');
        $this->db->where('hd.donvi_id',$id_donvi);
        $this->db->where('hd.hopdong_status', 'Y');
        $this->db->where('ns.nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_phongban_by_list($input){
        if($input){
        $this->db->select('dv.*');
        $this->db->from('donvi as dv');
        $this->db->where_in('dv.donvi_id', $input['list']);
        $this->db->where('donvi_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result(); 
        }                
        return ($result) ? $result : FALSE;
    } 
}
/* End of file */