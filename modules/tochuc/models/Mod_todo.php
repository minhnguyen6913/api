<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('TochucInterface');
class Mod_todo extends MY_Model implements TochucInterface {
    
    var $column = array('todo_name'); // thiết lập cột 
    var $order = array('td.todo_id' => 'DESC'); // sắp xếp
    var $id_dinhnghia;
    var $post;
    var $status = 'Y';
    private function _get_datatables_query() {
        @$post = $this->post;
        $this->db->from('todo as td');
        $this->db->where('td.todo_status', $this->status);
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
        $this->db->from('todo as td');
        $this->db->where('td.todo_status', $this->status);
        return $this->db->count_all_results();
    }
}
/* End of file */