<?php
class Board_model extends CI_Model {

    public function __construct()
    {
        $this->load->database(); 
    }

    public function list_total($search,$board_type)
    {
        $data = $this->db->query("
        select 
            count(*) as cnt 
        from 
            ci_board 
        where 
            status = 0
            AND board_type = '".$board_type."'
            AND title LIKE '%".$search."%'
        ");
        return $data->row();
    }

    public function list_select($now_page,$search,$board_type)
    {
        if($now_page == '')
            $now_page = 0;

        $data = $this->db->query('
        select 
            _id,
            title,
            (select email from ci_member where _id = ci_board.member_id) as name 
        from 
            ci_board as ci_board
        where 
            status = 0 
            AND board_type = "'.$board_type.'"
            AND title LIKE "%'.$search.'%"
        order by _id desc
        limit '.$now_page.',10
        ');
        
        $result = $data->result_array();
        return $result;
    }

    public function view_select($id){

        $data = $this->db->query("
        select 
            _id,
            title,
            content,
            member_id,
            (select email from ci_member where _id = ci_board.member_id ) as name
        from 
            ci_board as ci_board
        where  
            _id = ".$id."
        ");

        return $data->row();

    }
 
    public function board_delete($board_id){

        $this->db->query("
            UPDATE 
                ci_board
            SET
                status = 1
            WHERE
                _id = ".$board_id."
        ");

    }

    public function board_insert($title,$content,$member_id,$board_type){

        $this->db->query("
            INSERT INTO ci_board(title,content,member_id,board_type)
            values ('".$title."','".$content."',".$member_id.",'".$board_type."');
        ");

    }
    public function board_update($title,$content,$id){

        $this->db->query("
            UPDATE 
                ci_board
            SET
                title = '".$title."',
                content = '".$content."'
            WHERE
                _id = ".$id."
        ");

    }

    public function comment_list($board_id)
    {
        $data = $this->db->query("
            select
                _id,
                content,
                member_id,
                (select email from ci_member where _id = ci_comment.member_id) as name
            from
                ci_comment as ci_comment
            where
                status = 0 AND
                board_id = ".$board_id."
        ");

        return  $data->result_array();
    }

    public function comment_delete($comment_id){

        $this->db->query("
            UPDATE 
                ci_comment
            SET
                status = 1
            WHERE
                _id = ".$comment_id."
        ");

    } 

    public function comment_insert($content,$board_id,$member_id){

        $this->db->query("
            INSERT INTO ci_comment(board_id,content,member_id)
            values(".$board_id.",'".$content."',".$member_id.")
        ");

    }  

    public function member_select_email($email)
    {
        $data = $this->db->query("
        select 
            _id 
        from 
            ci_member
        where  
            email = '".$email."'
        ");

        return $data->row();
    }


    public function member_insert($email,$password){

        $result = $this->member_select_email($email);

        if(!isset($result->_id))
        {
            $this->db->query("
                INSERT INTO ci_member(email,passwd)
                values('".$email."','".$password."')
            ");
            return true;

        }
        else{
            return false;
        }

    }  

    public function login_select($email,$password)
    {
        $data = $this->db->query("
        select 
            _id 
        from 
            ci_member
        where  
            email = '".$email."' and
            passwd = '".$password."'
        ");

        return $data->row();
    } 

    public function member_update($_id,$new_email,$new_password){

        $this->db->query("
            UPDATE 
                ci_member
            SET
                email = '".$new_email."',
                passwd = '".$new_password."'
            WHERE
                _id = ".$_id."
        ");

    } 
    

 
}