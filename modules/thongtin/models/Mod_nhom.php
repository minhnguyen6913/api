<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('ThongtinInterface');
class Mod_nhom extends MY_Model implements ThongtinInterface {
    var $status = array('Y' , 'N', 'D' );
    function _get_nhom_nenmau($id){
        $list = explode('-', $this->_getRef($id)['ref']);
        $list[] = $id;
        $this->db->select('*');
        $this->db->from('nhom');
        $this->db->where_in('nenmau_id', $list);
        $this->db->where('nhom_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_dinhnghia_nhom($id, $nenmau) {
        $this->db->select('*');
        if ($id != 0) {
            $this->db->from('nhom_dinhnghia as ndn');
            $this->db->join('dinhnghia as dn', 'dn.dinhnghia_id=ndn.dinhnghia_id');
            $this->db->where('ndn.nhom_id', $id);
        } else {
            $this->db->from('dinhnghia as dn');
            $this->db->where_in('dn.nenmau_id', $nenmau);
            $this->db->where('dn.dinhnghia_id NOT IN(SELECT dinhnghia_id from nhom_dinhnghia)', NULL, FALSE);
        }
        $this->db->where('dn.dinhnghia_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_nhom_info($id) {
        $this->db->select('*');
        $this->db->from('nhom');
        $this->db->where('nhom_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_dinhnghia_info($id) {
        $this->db->select('*');
        $this->db->from('dinhnghia');
        $this->db->where('dinhnghia_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
     function _get_gia_nhom($ids){
        $this->db->select('nhom_id id, nhom_gia gia');
        $this->db->from('nhom');
        $this->db->where('nhom_status', 'Y');
        $this->db->where_in('nhom_id', $ids);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_all_nhom_kh($id) {
        $this->db->select('*');
        $this->db->from('nhom');
        $this->db->where('nhom_status', 'Y');
        $this->db->where('nhom_id NOT IN (SELECT nhom_id FROM nhom_khachhang_gia WHERE khachhang_id = '.(int)$id.')',NULL, FALSE);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _insert_gia_nhom_kh($data) {
        $values = array();
        foreach ($data as $dt) {
            $values[] = array(
                'nhom_id' => $dt['nhom'],
                'khachhang_id' => $dt['khachhang'],
                'gia' => $dt['gia']
            );
        }
        $this->db->trans_start();
        $this->db->insert_batch('nhom_khachhang_gia', $values);
        if (!$this->db->trans_complete()) return FALSE;
        return TRUE;
    }
    function _update_gia_nhom_kh($data) {
        $value = array('gia' => $data['gia'], 'gia_status'=>'N') ;
        $dieukien = array('nhom_id' => $data['nhom'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->update('nhom_khachhang_gia', $value)) return FALSE;
        return TRUE;
    }
    function _update_nhom_gia_status($data) {
        $value = array('gia_status' => $data['status']);
        $dieukien = array('nhom_id' => $data['nhom'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->update('nhom_khachhang_gia', $value)) return FALSE;
        return TRUE;
    }
    function _delete_gia_nhom_kh($data) {
        $dieukien = array('nhom_id' => $data['nhom'], 'khachhang_id' => $data['khachhang']);
        $this->db->where($dieukien);
        if (!$this->db->delete('nhom_khachhang_gia')) return FALSE;
        return TRUE;
    }
    private function _getRef($id) {
        $this->db->select('nenmau_ref ref');
        $this->db->from('nenmau');
        $this->db->where('nenmau_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }

    var $column = array('nhom.nhom_name_vni', 'ng.gia'); // thiết lập cột 
    var $order = array('nhom.nhom_id' => 'DESC'); // sắp xếp
    var $id_khachhang;
    var $post;
    
    private function _get_datatables_query() {
        @$post = $this->post;
        $this->db->from('nhom');
        $this->db->join('nhom_khachhang_gia as ng', 'ng.nhom_id=nhom.nhom_id');
        $this->db->where('nhom.nhom_status', 'Y');
        $this->db->where('ng.khachhang_id', $this->id_khachhang);
        $this->db->where_in('ng.gia_status', $this->status);
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
        $this->db->from('nhom');
        $this->db->join('nhom_khachhang_gia as ng', 'ng.nhom_id=nhom.nhom_id');
        $this->db->where('nhom.nhom_status', 'Y');
        $this->db->where('ng.khachhang_id', $this->id_khachhang);
        $this->db->where_in('ng.gia_status', $this->status);
        return $this->db->count_all_results();
    }
}
/* End of file */