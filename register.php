<?php
mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";
if(isset($_POST["submit"]))
{
mysql_query("insert into users (uid,password,fname,lname,deladd) values('$_POST[username]','$_POST[password]','$_POST[username]','$_POST[username]','$_POST[username]')");
echo "Thank You !! You have been registered NOW !! <a href=index.php>Login Now </a><br/><br/>";
}
?>
<form method=post>
Username : <input type=text name=username /><br/>
Password : <input type=text name=password /><br/>
<input type=submit name=submit value=Register />
</form>