
<?php echo $msg;?>
<form method="post" action="/index.php/member/modify">
    이메일 : <input type="text" name="email" value="<?php echo $email?>"> <br />
    비밀번호 : <input type="password" name="password" value=""> <br />
    새 비밀번호 : <input type="password" name="new_password" value=""> <br />
    <input type="submit" value="회원정보 수정">
</form>