<?php 
if($_SERVER['REQUEST_METHOD']=='POST' && $this->action=='login'){
	print "<script>alert('".$this->data."');</script>";
}
?>
<html>
<head>
</head>
<body>
<h3>로그인</h3>
<form action="/web1/member/index.php?action=login" method="post">
<table>
<tr><th>
id:</th><td><input type="text" name="id">
</td>
<td rowspan="2"><input type="submit" value="Login" style="height:60px"></td></tr>
<tr><th>
pwd:</th><td><input type="text" name="pwd"></td></tr>
<tr>
<th colspan="2">
<a href="/web1/member/index.php?action=joinform">회원가입</a></th>
</tr>
</form>
</table>
</body>
</html>