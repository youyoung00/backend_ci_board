<?php
class Board_model extends CI_Model {

    public function __construct()
    {
        $this->load->database(); 
    }

    public function list_total($search)
    {
        $data = $this->db->query("
        select 
            count(*) as cnt 
        from 
            ci_board 
        where 
            status = 0
            AND title LIKE '%".$search."%'
        ");
        return $data->row();
    }

    public function list_select($now_page,$search)
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
            (select email from ci_member where _id = ci_board.member_id ) as name
        from 
            ci_board as ci_board
        where  
            _id = ".$id."
        ");

        return $data->row();

    }


    public function board_insert($title,$content){

        $this->db->query("
            INSERT INTO ci_board(title,content)
            values ('".$title."','".$content."');
        ");

    }

    public function board_update($id, $title, $content)
    {
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

    public function board_delete($id){

        $this->db->query("
                UPDATE 
                        ci_board
                SET 
                        status = 1
                WHERE 
                        _id = ".$id."
                ");

    }

    public function comment_list($board_id) {

        // board_id값을 입력받아 해당 게시물에 해당하는 댓글의 리스트를 불러오는 쿼리
        $data = $this->db->query("
        SELECT
            _id,
            content,
            (select email from ci_member where _id = ci_comment.member_id) as name
        FROM
            ci_comment as ci_comment
        WHERE
            status = 0
        AND
            board_id = ".$board_id."
        ;
        ");
    
        return $data->result_array();
    
    }

    public function comment_insert($board_id, $content) {

        // 게시물 id, content 값을 받아 댓글을 새로 삽입하는 쿼리 수행
        $this->db->query("
        INSERT INTO ci_comment
            (board_id, content)
        VALUES
            (".$board_id.", '".$content."')
        ;
        ");
    
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
}