<?php
session_start();
if(isset($_GET['logout']))
unset($_SESSION['userid']);
if(isset($_SESSION['userid']))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart/user.php" />';
mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";


if(isset($_POST["submit"]))
{
$uid=$_POST["username"]; 
$password=$_POST["pass"];
$query="select * from users where uid='$uid' and password='$password'";
$tq.=$query;
if(mysql_num_rows(mysql_query($query)))
{
$_SESSION['userid']=$uid;
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart/user.php" />';
}
else
echo "Sorry the Username and Password do not Match .<br/>";
}
?>

<form method="post">
Username : <input type="text" name="username" /><br/>
Password : <input type="password" name="pass" /><br/>
<input type="submit" name="submit" value="Login" />
</form>

<?php
echo $tq;
?>