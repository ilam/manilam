<?php
session_start();
if(!(isset($_SESSION['userid']) && $_SESSION['userid']=="admin"))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart" />';
$tq="<br/>";
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://localhost/cart?logout=true">LogOut</a><br/><br/>';
if($_SESSION['userid']=="admin")
{
echo '<a href=prod.php>Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=cat.php>Categories</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=godowns.php>Godowns</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=suppliers.php>Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=buy.php>Buy from Supplier</a>';
}
echo '<br/><a href=user.php>Edit User Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=disp.php>Display and Confirm Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=ordersview.php>View Order History</a><br/><br/>';
mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());

if(isset($_POST["submit"]))
{
mysql_query($qu="insert into buy (sid,gid,pid,quantity) values ($_POST[sid],$_POST[gid],$_POST[pid],$_POST[quantity])");
$tq.=$qu."<br/>";
echo "Your buy has been done !<br/>";
}
?>

Buy Order Form <br/>
<form method=post>
<table>
<tr><th>Supplier</th><th>Godown</th><th>Product</th><th>Quantity</th><th></th></tr>
<tr>
<td><select name=sid>
<?php
$res=mysql_query($qu="select sid,name from suppliers"); $tq.=$qu."<br/>";
for($i=0;$i<mysql_num_rows($res);$i++)
echo '<option value='.mysql_result($res,$i,"sid").'>'.mysql_result($res,$i,"sid")." - ".mysql_result($res,$i,"name").'</option>';
?>
</select></td>

<td><select name=gid>
<?php
$res=mysql_query($qu="select gid,name from godowns"); $tq.=$qu."<br/>";
for($i=0;$i<mysql_num_rows($res);$i++)
echo '<option value='.mysql_result($res,$i,"gid").'>'.mysql_result($res,$i,"gid")." - ".mysql_result($res,$i,"name").'</option>';
?>
</select></td>

<td><select name=pid>
<?php
$res=mysql_query($qu="select pid,pname from prod"); $tq.=$qu."<br/>";
for($i=0;$i<mysql_num_rows($res);$i++)
echo '<option value='.mysql_result($res,$i,"pid").'>'.mysql_result($res,$i,"pid")." - ".mysql_result($res,$i,"pname").'</option>';
?>
</select></td>
<td>
<input type=text name=quantity value=1 size=3/>
</td>
<td>
<input type=submit name=submit value=Buy />
</td>
</form>
<?php
$res=mysql_query($qu="select s.sid,p.pid,g.gid,s.name as sname,p.pname,g.name as gname,b.quantity,b.dateofbuy from buy b join suppliers s on b.sid=s.sid join godowns g on b.gid=g.gid join prod p on p.pid=b.pid order by dateofbuy desc");
if(mysql_num_rows($res))
{
echo '<table border=1>';
echo '<tr><td>Supplier</td><td>Godown</td><td>Product</td><td>Quantity</td><td>Date Of Buying</td></tr>';
for($i=0;$i<mysql_num_rows($res);$i++)
{
echo '<tr><td>'.mysql_result($res,$i,"sname").'</td><td>'.mysql_result($res,$i,"gname").'</td><td>'.mysql_result($res,$i,"pname").'</td><td>'.mysql_result($res,$i,"quantity").'</td><td>'.mysql_result($res,$i,"dateofbuy").'</td></tr>';
}
}
$tq.=$qu."<br/>";
echo $tq;
?>