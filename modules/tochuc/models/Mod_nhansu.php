<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
get_instance()->load->iface('TochucInterface');
class Mod_nhansu extends MY_Model implements TochucInterface {
    function UserInfo($id) {
        $this->db->select('ns.*,dv.donvi_id,dv.donvi_ten,cv.chucvu_id, cv.chucvu_ten');
        $this->db->from('nhansu as ns');
        $this->db->join('hopdong as hd', 'hd.hopdong_id=ns.hopdong_id','left');
        $this->db->join('donvi AS dv', "dv.donvi_id=hd.donvi_id AND dv.donvi_status ='Y'", 'left');
        $this->db->join('chucvu AS cv', 'cv.chucvu_id=hd.chucvu_id', 'left');
    	$this->db->where('ns.nhansu_id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function GetPhongBan($id_nhansu){
        $this->db->select('hd.hopdong_id,nhansu_id,dv.donvi_id,dv.donvi_ten,cv.chucvu_id, cv.chucvu_ten');
        $this->db->from('hopdong AS hd');
        $this->db->join('donvi AS dv', 'dv.donvi_id=hd.donvi_id', 'left');
        $this->db->join('chucvu AS cv', 'cv.chucvu_id=hd.chucvu_id', 'left');
        $this->db->where('hd.nhansu_id', $id_nhansu);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function capbac_hientai($nhansu_id) {
        $this->db->select('*');
        $this->db->from('hopdong AS hd');
        $this->db->join('nhansu AS ns', 'hd.hopdong_id=ns.hopdong_id','left');
        $this->db->where('ns.nhansu_id', $nhansu_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function get_chucvu($chucvu_id) {
        $this->db->select("*");
        $this->db->from("chucvu");
        $this->db->where("chucvu_id", $chucvu_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function danhsach_theochucvu($chucvu_id, $donvi_id) {
        $this->db->select('*');
        $this->db->from('nhansu as ns');
        $this->db->join('hopdong as hd', 'hd.hopdong_id=ns.hopdong_id','left');
        $this->db->where('chucvu_id', $chucvu_id);
        $this->db->where('donvi_id', $donvi_id);
        $this->db->where('nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_allns() {
        $this->db->select('ns.*,dv.donvi_id,dv.donvi_ten,cv.chucvu_id, cv.chucvu_ten');
        $this->db->from('nhansu as ns');
        $this->db->join('hopdong as hd', 'hd.hopdong_id = ns.hopdong_id');
        $this->db->join('donvi AS dv', "dv.donvi_id=hd.donvi_id AND dv.donvi_status = 'Y'");
        $this->db->join('chucvu AS cv', 'cv.chucvu_id=hd.chucvu_id', 'left');
        $this->db->where('nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _getNhansu($arr_id){
        $this->db->select('ns.*,dv.donvi_id,dv.donvi_ten,cv.chucvu_id, cv.chucvu_ten');
        $this->db->from('nhansu as ns');
        $this->db->join('hopdong as hd', 'hd.hopdong_id=ns.hopdong_id');
        $this->db->join('donvi AS dv', "dv.donvi_id=hd.donvi_id AND dv.donvi_status = 'Y'", 'left');
        $this->db->join('chucvu AS cv', 'cv.chucvu_id=hd.chucvu_id', 'left');
        $this->db->where_in('ns.nhansu_id', $arr_id);
        $this->db->where('nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    
    function _getNhansu_ngoaiphongban($arr_id){
        $this->db->select('ns.*,dv.donvi_id,dv.donvi_ten,cv.chucvu_id, cv.chucvu_ten');
        $this->db->from('nhansu as ns');
        $this->db->join('hopdong as hd', 'hd.hopdong_id=ns.hopdong_id');
        $this->db->join('donvi AS dv',  "dv.donvi_id=hd.donvi_id AND dv.donvi_status = 'Y'", 'left');
        $this->db->join('chucvu AS cv', 'cv.chucvu_id=hd.chucvu_id', 'left');
        $this->db->where('ns.hopdong_id NOT IN(select hopdong_id from hopdong where donvi_id IN ('.$arr_id.'))',NULL, FALSE);
        $this->db->where('nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_nhansu_dinhnghia_donvi($id_donvi, $id_dinhnghia) {
        $this->db->select('ns.*');
        $this->db->from('nhansu AS ns');
        $this->db->join('hopdong AS hd', 'hd.nhansu_id =ns.nhansu_id');
        $this->db->where('hd.donvi_id',$id_donvi);
        $this->db->where('hd.hopdong_status', 'Y');
        $this->db->where('ns.nhansu_status', 'Y');
        $this->db->where('ns.nhansu_id NOT IN(SELECT nhansu_id FROM nhansu_dinhnghia WHERE dinhnghia_id='.(int)$id_dinhnghia.')',NULL, FALSE);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _insert_nhansu_dinhnghia($data) {
        $values = array();
        foreach ($data['nhansu'] as $dt) {
            $values[] = array(
                'dinhnghia_id' => $data['dinhnghia'],
                'nhansu_id' => $dt
            );
        }
        $this->db->trans_start();
        $this->db->insert_batch('nhansu_dinhnghia', $values);
        $this->db->trans_complete();
    }
    function _delete_nhansu_dinhnghia($id_dinhnghia, $id_nhansu) {
        $dieukien = array(
            'dinhnghia_id' => $id_dinhnghia,
            'nhansu_id' => $id_nhansu
        );
        $this->db->where($dieukien);
        $this->db->delete('nhansu_dinhnghia');
    }
    function _detele_dinhnghia($id_dinhnghia) {
        $this->db->where('dinhnghia_id', $id_dinhnghia);
        $this->db->delete('nhansu_dinhnghia');
    }
    function _get_nhansu_dinhnghia($id_dinhnghia) {
        $this->db->select('*');
        $this->db->from('nhansu_dinhnghia as nsdn');
        $this->db->join('nhansu as ns','ns.nhansu_id=nsdn.nhansu_id');
        $this->db->where('nsdn.dinhnghia_id', $id_dinhnghia);
        $this->db->where('ns.nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    var $column = array('ns.nhansu_lastname','ns.nhansu_firstname'); // thiết lập cột 
    var $order = array('ns.nhansu_id' => 'DESC'); // sắp xếp
    var $id_dinhnghia;
    var $post;
    private function _get_datatables_query() {
        @$post = $this->post;
        $this->db->from('nhansu_dinhnghia as nsdn');
        $this->db->join('nhansu as ns','ns.nhansu_id=nsdn.nhansu_id');
        $this->db->where('nsdn.dinhnghia_id', $this->id_dinhnghia);
        $this->db->where('ns.nhansu_status', 'Y');
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
        $this->db->from('nhansu_dinhnghia as nsdn');
        $this->db->join('nhansu as ns','ns.nhansu_id=nsdn.nhansu_id');
        $this->db->where('nsdn.dinhnghia_id', $this->id_dinhnghia);
        $this->db->where('ns.nhansu_status', 'Y');
        return $this->db->count_all_results();
    }
    function _get_nhansu_by_list($input){
        if($input){
           $this->db->select('ns.*');
        $this->db->from('nhansu as ns');
        $this->db->where_in('ns.nhansu_id', $input['list']);
        $this->db->where('nhansu_status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result(); 
        }                
        return ($result) ? $result : FALSE;
    }
    function get_dinhnghia_by_nhansu($id_nhansu){
        $this->db->select('dinhnghia_id');
        $this->db->from('nhansu_dinhnghia');
        $this->db->where('nhansu_id',$id_nhansu);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    } 
    function get_dinhnghia_assign(){
        $date_today = date('Y-m-d H:i:s');
        $this->db->select('detail.dinhnghia_id, assign.assign_nhansu');
        $this->db->from('nhansu_assigned_detail detail');
        $this->db->join('nhansu_assigned assign','detail.assign_id = assign.assign_id');
        $this->db->where('assign.assign_from <=',$date_today);
        $this->db->where('assign.assign_to >=',$date_today);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }    
    function _get_all_dinhnghia_assign($id_nhansu) {
        $this->db->select('detail.dinhnghia_id');
        $this->db->from('nhansu_assigned_detail detail');
        $this->db->join('nhansu_assigned assign','detail.assign_id = assign.assign_id');
        $this->db->where('assign.assign_nhansu',$id_nhansu);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _get_khachhang_nhansu($nhansu_id) {
        $this->db->select('*');
        $this->db->from('nhansu_khachhang');
        $this->db->where('nhansu_id', $nhansu_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $query->free_result();
        return ($result) ? $result : FALSE;
    }
    function _insert_khachhang_nhansu($data) {
        $value = array(
            'nhansu_id' => $data['nhansu'],
            'khachhang_id' => $data['khachhang']
        );
        if (!$this->db->insert('nhansu_khachhang', $value)) return FALSE;
        return TRUE;
    }
    function _delete_khachhang_nhansu($data) {
        $dieukien = array(
            'nhansu_id' => $data['nhansu'],
            'khachhang_id' => $data['khachhang']
        );
        $this->db->where($dieukien);
        $this->db->delete('nhansu_khachhang');
        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }
}
/* End of file */