<table border=1>
    <tr>
        <td>번호</td>
        <td>제목</td>
        <td>작성자</td>
    </tr>
<?php
foreach($list as $row)
{ 
?>
    <tr>
        <td><?php echo $row['_id']?></td>
        <td><a href='/index.php/board/view?id=<?php echo $row['_id']?>'><?php echo $row['title']?></a></td>
        <td><?php echo $row['name']?></td>
    </tr>
<?php }?>
</table>
<br />
1 2 3 4 5 6 7 8 9 10
<br />


<a href='/index.php/board/input/'>글쓰기</a>