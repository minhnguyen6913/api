<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_dinhnghia extends MY_Model implements ThongtinInterface {
    var $status = array('Y' , 'N' , 'D' );
    
    function _get_All_dinhnghia($id){
        $this->db->select('dinhnghia_id,dinhnghia_name_vni');
        $this->db->from('dinhnghia');
        $this->db->where('dinhnghia_status', 'Y');
        $this->db->where('dinhnghia_id NOT IN (SELECT dinhnghia_id FROM dinhnghia_khachhang_gia WHERE khachhang_id = '. (int)$id.')', NULL, FALSE);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _insert_dinhnghia_gia_kh($data) {
        $values = array();
        foreach ($data as $dt) {
            $values[] = array(
                'dinhnghia_id' => $dt['dinhnghia'],
                'khachhang_id' => $dt['khachhang'],
                'gia' => $dt['gia']
            );
        }
        $this->db->trans_start();
        $this->db->insert_batch('dinhnghia_khachhang_gia', $values);
        if(!$this->db->trans_complete()) return FALSE;
        return TRUE;
    }
    function _delete_dinhnghia_gia_kh($data) {
        $dieukien = array('dinhnghia_id' => $data['dinhnghia'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->delete('dinhnghia_khachhang_gia')) return FALSE;
        return TRUE;
    }
    function _update_dinhnghia_gia_kh($data) {
        $value = array('gia' => $data['gia'], 'gia_status' => 'N');
        $dieukien = array('dinhnghia_id' => $data['dinhnghia'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->update('dinhnghia_khachhang_gia', $value)) return FALSE;
        return TRUE;
    }
    function _update_dinhnghia_gia_status($data) {
        $value = array('gia_status' => $data['status']);
        $dieukien = array('dinhnghia_id' => $data['dinhnghia'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->update('dinhnghia_khachhang_gia', $value)) return FALSE;
        return TRUE;
    }
    
    var $column = array('dn.dinhnghia_id', 'dn.dinhnghia_name_vni', 'dnkh.gia', 'dnkh.gia_status'); // thiết lập cột 
    var $order = array('dn.dinhnghia_id' => 'DESC'); // sắp xếp
    var $id_khachhang;
    var $post;
    
    private function _get_datatables_query() {
        @$post = $this->post;
        $this->db->from('dinhnghia_khachhang_gia as dnkh');
        $this->db->join('dinhnghia as dn', 'dn.dinhnghia_id=dnkh.dinhnghia_id');
        $this->db->where('dnkh.khachhang_id', $this->id_khachhang);
        $this->db->where_in('dnkh.gia_status', $this->status);
        $this->db->where('dn.dinhnghia_status', 'Y');
        $i = 0;
        foreach ($this->column as $item) {//loop column
            if (@$post['search']['value']) {//if datatable send POST for search
                if ($i === 0) {//first loop
                    $this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, @$post['search']['value']);
                } else {
                    $this->db->or_like($item, @$post['search']['value']);
                }
                //last loop
                if (count($this->column) - 1 == $i)
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; //set column array variable to order processing
            $i++;
        }
        if (isset($post['order'])) {//here order processing
            $this->db->order_by($column[@$post['order']['0']['column']], @$post['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    } 
    function _get_datatables() {
        @$post = $this->post;
        $this->_get_datatables_query();
        if (@$post['length'] != -1) 
          $this->db->limit(@$post['length'], @$post['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function _count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function _count_all() {
        $this->db->from('dinhnghia_khachhang_gia as dnkh');
        $this->db->join('dinhnghia as dn', 'dn.dinhnghia_id=dnkh.dinhnghia_id');
        $this->db->where('dnkh.khachhang_id', $this->id_khachhang);
        $this->db->where_in('dnkh.gia_status', $this->status);
        $this->db->where('dn.dinhnghia_status', 'Y');
        return $this->db->count_all_results();
    }
    function _get_info_dinhnghia($list){
        if ($list) {
        $this->db->select('*');
        $this->db->from('dinhnghia dn');
        $this->db->join('phuongphap pp',"(dn.phuongphap_id = pp.phuongphap_id) AND (pp.phuongphap_status = 'Y')");
        $this->db->join('kythuat kt',"(dn.kythuat_id = kt.kythuat_id) AND (kythuat_status = 'Y')");
        $this->db->join('chitieu ct',"(dn.chitieu_id = ct.chitieu_id) AND (chitieu_status = 'Y')");
        $this->db->join('nenmau nm',"(dn.nenmau_id = nm.nenmau_id) AND (nm.nenmau_status = 'Y')");
        $this->db->join('donvitinh dvt',"(dn.donvitinh_id = dvt.donvitinh_id) AND (dvt.donvitinh_status = 'Y')");
        $this->db->where_in('dinhnghia_id',$list);
        $this->db->where('dinhnghia_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
        }
        else {
            return FALSE;
        }
        
    }
    function _get_dinhnghia_nhansu($list_dinhnghia,$list_donvi){
        $this->db->select('dn.dinhnghia_id,dn.dinhnghia_name_vni,nm.nenmau_name_vni');
        $this->db->from('dinhnghia dn');
        $this->db->join('nenmau nm',"(dn.nenmau_id = nm.nenmau_id) AND (nm.nenmau_status = 'Y')");
        $this->db->join('phuongphap pp',"(dn.phuongphap_id = pp.phuongphap_id) AND (pp.phuongphap_status = 'Y')");
        $this->db->join('kythuat kt',"(dn.kythuat_id = kt.kythuat_id) AND (kythuat_status = 'Y')");
        $this->db->join('chitieu ct',"(dn.chitieu_id = ct.chitieu_id) AND (chitieu_status = 'Y')");
        $this->db->where_not_in('dinhnghia_id',$list_dinhnghia);
        $this->db->where_in('dn.donvi_id',$list_donvi);
        $this->db->where('dinhnghia_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return  $result;       
    }
    var $column_dn = array('dinhnghia_name_vni'); // thiết lập cột 
    var $order_dn = array('dinhnghia_id' => 'DESC'); // sắp xếp
    var $id_dinhnghia;
    var $post_dn;
    private function _get_datatables_query_dinhnghia() {
        @$post = $this->post_dn;
        $this->db->from('dinhnghia');
        $this->db->where_in('dinhnghia_id', $this->id_dinhnghia);
        $this->db->where('dinhnghia_status', 'Y');
        $i = 0;
        foreach ($this->column_dn as $item) {//loop column
            if (@$post['search']['value']) {//if datatable send POST for search
                if ($i === 0) {//first loop
                    $this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, @$post['search']['value']);
                } else {
                    $this->db->or_like($item, @$post['search']['value']);
                }
                //last loop
                if (count($this->column_dn) - 1 == $i)
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; //set column array variable to order processing
            $i++;
        }
        if (isset($post['order'])) {//here order processing
            $this->db->order_by($column[@$post['order']['0']['column']], @$post['order']['0']['dir']);
        } elseif (isset($this->order_dn)) {
            $order = $this->order_dn;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    } 
    function _get_datatables_dinhnghia() {
        @$post = $this->post_dn;
        $this->_get_datatables_query_dinhnghia();
        if (@$post['length'] != -1) 
          $this->db->limit(@$post['length'], @$post['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function _count_filtered_dinhnghia() {
        $this->_get_datatables_query_dinhnghia();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function _count_all_dinhnghia() {
        $this->db->from('dinhnghia');
        $this->db->where_in('dinhnghia_id', $this->id_dinhnghia);
        $this->db->where('dinhnghia_status', 'Y');
        return $this->db->count_all_results();
    }
    function _get_dinhnghia_donvi($donvi_id) {
        $this->db->select('dinhnghia_id');
        $this->db->from('dinhnghia');
        $this->db->where('dinhnghia_status', 'Y');
        $this->db->where('donvi_id', $donvi_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    var $column_dn_donvi = array('dinhnghia_name_vni', 'nenmau_name_vni', 'chitieu_name_vni', 'phuongphap_code', 'kythuat_name_vni'); // thiết lập cột 
    var $order_dn_donvi = array('dinhnghia_id' => 'DESC'); // sắp xếp
    var $id_donvi;
    var $post_dn_donvi;
    private function _get_datatables_query_dinhnghia_donvi() {
        @$post = $this->post_dn_donvi;
        $this->db->from('dinhnghia dn');
        $this->db->join('nenmau nm',"(dn.nenmau_id = nm.nenmau_id) AND (nm.nenmau_status = 'Y')");
        $this->db->join('phuongphap pp',"(dn.phuongphap_id = pp.phuongphap_id) AND (pp.phuongphap_status = 'Y')");
        $this->db->join('kythuat kt',"(dn.kythuat_id = kt.kythuat_id) AND (kythuat_status = 'Y')");
        $this->db->join('chitieu ct',"(dn.chitieu_id = ct.chitieu_id) AND (chitieu_status = 'Y')");
        $this->db->where('dn.donvi_id', $this->id_donvi);
        $this->db->where_in('dn.dinhnghia_status', array('Y','D'));
        $i = 0;
        foreach ($this->column_dn_donvi as $item) {//loop column
            if (@$post['search']['value']) {//if datatable send POST for search
                if ($i === 0) {//first loop
                    $this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, @$post['search']['value']);
                } else {
                    $this->db->or_like($item, @$post['search']['value']);
                }
                //last loop
                if (count($this->column_dn_donvi) - 1 == $i)
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; //set column array variable to order processing
            $i++;
        }
        if (isset($post['order'])) {//here order processing
            $this->db->order_by($column[@$post['order']['0']['column']], @$post['order']['0']['dir']);
        } elseif (isset($this->order_dn_donvi)) {
            $order = $this->order_dn_donvi;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    } 
    function _get_datatables_dinhnghia_donvi() {
        @$post = $this->post_dn_donvi;
        $this->_get_datatables_query_dinhnghia_donvi();
        if (@$post['length'] != -1) 
          $this->db->limit(@$post['length'], @$post['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function _count_filtered_dinhnghia_donvi() {
        $this->_get_datatables_query_dinhnghia_donvi();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function _count_all_dinhnghia_donvi() {
        $this->db->from('dinhnghia dn');
        $this->db->join('nenmau nm',"(dn.nenmau_id = nm.nenmau_id) AND (nm.nenmau_status = 'Y')");
        $this->db->join('phuongphap pp',"(dn.phuongphap_id = pp.phuongphap_id) AND (pp.phuongphap_status = 'Y')");
        $this->db->join('kythuat kt',"(dn.kythuat_id = kt.kythuat_id) AND (kythuat_status = 'Y')");
        $this->db->join('chitieu ct',"(dn.chitieu_id = ct.chitieu_id) AND (chitieu_status = 'Y')");
        $this->db->where('dn.donvi_id', $this->id_donvi);
        $this->db->where_in('dn.dinhnghia_status', array('Y','D'));
        return $this->db->count_all_results();
    }
    function get_khachhang_gia_dinhnghia() {
        $this->db->distinct();
        $this->db->select('khachhang_id');
        $this->db->from('dinhnghia_khachhang_gia');
        $this->db->where('gia_status', 'N');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }
    function get_khachhang_gia_nhom() {
        $this->db->distinct();
        $this->db->select('khachhang_id');
        $this->db->from('nhom_khachhang_gia');
        $this->db->where('gia_status', 'N');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }
    function get_dinhnghia_result($list) {
        $this->db->select('*');
        $this->db->from('dinhnghia_result dnr');
        $this->db->join('capacity_result cr','dnr.result_id = cr.result_id');
        $this->db->where_in('dnr.dinhnghia_id',$list);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }
}
/* End of file */