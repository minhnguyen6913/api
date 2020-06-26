<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Todo extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_todo');
    }
    
    function todo_list_post() {
        $input = $this->input->post();
        $this->mod_todo->post = $input['post'];
        $this->response(array(
            "list" => $this->mod_todo->_get_datatables(),
            "recordsTotal" => $this->mod_todo->_count_all(),
            "recordsFiltered" => $this->mod_todo->_count_filtered()
        ));
    }
}
