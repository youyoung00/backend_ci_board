<?php
class Board_model extends CI_Model {

    public function __construct()
    {
        $this->load->database(); 
    }

    public function list_select()
    {
        $data = $this->db->query('
        select 
            _id,
            title,
            (select email from ci_member where _id = ci_board.member_id) as name 
        from 
            ci_board as ci_board
        ');
        $result = $data->result_array();
        return $result;
    }
 
}