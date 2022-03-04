<table border=1> 
<?php
    foreach($result as $row)
    {
    ?>
    <tr>
        <td>작성자: <?php echo $row['name']?></td>
        <td>댓글내용 : <?php echo $row['content']?></td>
        <td><a href="javascript:comment_delete('<?php echo $row['_id']?>');">X</a></td>
    </tr>
<?php }?>     
</table>
<form>
    <input type="text" >
    <input type="submit" value="댓글작성">
</form>

<script>
    function comment_delete(str)
    {  
        if(confirm('진짜지우실?'))
        {
            alert(str);
            location.href="/index.php/form/comment_delete?id=<?php echo $row['_id']?>&id2="+str;
        }

    }
</script>