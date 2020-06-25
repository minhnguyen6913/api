<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('KhachhangInterface');
class Mod_khachhang extends MY_Model implements KhachhangInterface {
    var $id_khachhang;
    function _get_khachhangall(){
        $this->db->select('khachhang_id, khachhang_name');
        $this->db->from('khachhang');
        $this->db->where_in('khachhang_status', array('Y','P'));
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_infokh($id) {
        $this->db->select('*');
        $this->db->from('khachhang');
        $this->db->join('tinhthanh', 'tinhthanh.tinhthanh_id=khachhang.tinhthanh_id', 'left');
        $this->db->join('quanhuyen', 'quanhuyen.quanhuyen_id=khachhang.quanhuyen_id', 'left');
        $this->db->where('khachhang_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_contact_kh($id_kh) {
        $this->db->select('*');
        $this->db->from('khachhang_contact AS khct');
        $this->db->join('contact', 'contact.contact_id=khct.contact_id');
        $this->db->where('khct.khachhang_id', $id_kh);
        $this->db->where('contact.contact_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_contact_by_listKH($id_khachhang) {
        $this->db->select('*');
        $this->db->from('khachhang_contact AS khct');
        $this->db->join('contact', 'contact.contact_id=khct.contact_id');
        $this->db->where_in('khct.khachhang_id', $id_khachhang);
        $this->db->where('contact.contact_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_contact_all() {
        $this->db->select('contact_id, 	contact_lastname, contact_firstname') ;
        $this->db->from('contact');
        $this->db->where('contact_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_contactinfo($id) {
        $this->db->select('*');
        $this->db->from('contact');
        $this->db->where('contact_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_kh_contact($id) {
        $this->db->select('*');
        $this->db->from('khachhang_contact AS khct');
        $this->db->join('khachhang AS kh', 'kh.khachhang_id=khct.khachhang_id');
        $this->db->where('khct.contact_id', $id);
        $this->db->where('kh.khachhang_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    var $column = array('khachhang_name'); // thiết lập cột 
    var $order = array('khachhang_id' => 'DESC'); // sắp xếp
    var $post;
    private function _get_datatables_query() {
        @$post = $this->post;
        $this->db->from('khachhang AS kh');
        $this->db->join('tinhthanh AS tt', 'tt.tinhthanh_id=kh.tinhthanh_id', 'left');
        $this->db->join('quanhuyen AS qh', 'qh.quanhuyen_id=kh.quanhuyen_id', 'left');
        $this->db->where_in('khachhang_status', array('Y','P'));
        $this->db->where_in('khachhang_id', $this->id_khachhang);
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
        $this->db->from('khachhang AS kh');
        $this->db->join('tinhthanh AS tt', 'tt.tinhthanh_id=kh.tinhthanh_id', 'left');
        $this->db->join('quanhuyen AS qh', 'qh.quanhuyen_id=kh.quanhuyen_id', 'left');
        $this->db->where_in('khachhang_status', array('Y','P'));
        $this->db->where_in('khachhang_id', $this->id_khachhang);
        return $this->db->count_all_results();
    }
}
/* End of file */