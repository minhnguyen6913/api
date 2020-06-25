<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('NmtkqInterface');
class Mod_nhanmau extends MY_Model implements NmtkqInterface {
        var $status = array('New', 'Using');
    function _count_all_hopdong_duyet($duyet) {
        $this->db->select('hd.*');
        $this->db->from('hopdong as hd');
        $this->db->where('hd.hopdong_duyet', $duyet);
        $this->db->where_in('hd.hopdong_status', $this->status);
        return $this->db->count_all_results();
    }
    function _count_all_nhanmau_ptn($dinhnghia,$donvi) {
        $this->db->distinct();
        $this->db->select('mau.mau_id, mau.mau_code, mau.mau_name');
        $this->db->from('hopdong as hd');
        $this->db->join('mau', 'mau.hopdong_id=hd.hopdong_id');
        $this->db->join('mau_chitiet as mct', 'mct.mau_id=mau.mau_id');
        $this->db->where('hd.hopdong_duyet', 1);
        $this->db->where('hopdong_status', 'Using');
        $this->db->where_in('mct.dinhnghia_id', $dinhnghia);
        $this->db->where('mct.mau_id NOT IN (SELECT DISTINCT `mau_id` FROM `nhanmau` WHERE `donvi_id` = '.$donvi.')',NULL, FALSE);
        return $this->db->count_all_results();
    }
    function _count_all_kqnhaplai_ptn($dinhnghia,$donvi) {
        $this->db->from('nhanmau nm');
        $this->db->join('mau m','nm.mau_id = m.mau_id');
        $this->db->join('mau_chitiet mct', 'mct.mau_id=nm.mau_id AND mct.dinhnghia_id=nm.dinhnghia_id');
        $this->db->join('hopdong hd','hd.hopdong_id=m.hopdong_id');
        $this->db->join('ketqua kqn',"kqn.nhanmau_id = nm.nhanmau_id AND kqn.ketqua_status ='Y'");
        $this->db->where_in('nm.dinhnghia_id', $dinhnghia);
        $this->db->where('hd.hopdong_status', 'Using');
        $this->db->where('hd.hopdong_duyet', 1);
        $this->db->where('nm.donvi_id',$donvi);         
        $this->db->where('kqn.ketqua_duyet',2); 
        return $this->db->count_all_results();
    }
    function _count_all_kqduyet_ptn($dinhnghia) {
        $this->db->from('ketqua as kq');
        $this->db->join('nhanmau nm',' kq.nhanmau_id = nm.nhanmau_id');
        $this->db->join('mau m','nm.mau_id = m.mau_id');
        $this->db->where('kq.ketqua_duyet',0);
        $this->db->where('kq.ketqua_status','Y');
        $this->db->where_in('nm.dinhnghia_id', $dinhnghia);
        return $this->db->count_all_results();
    }
}
/* End of file */