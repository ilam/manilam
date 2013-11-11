<?php
session_start();
if(!isset($_SESSION['userid']))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart" />';
$uid=$_SESSION["userid"];

mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";
$uid=$_SESSION['userid'];
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://localhost/cart?logout=true">LogOut</a><br/><br/>';
if($_SESSION['userid']=="admin")
{
echo '<a href=prod.php>Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=cat.php>Categories</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=godowns.php>Godowns</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=suppliers.php>Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=buy.php>Buy from Supplier</a>';
}
echo '<br/><a href=user.php>Edit User Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=disp.php>Display and Confirm Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=ordersview.php>View Order History</a><br/><br/>';


if(isset($_POST["update"]))
{
$s=mysql_query($qu="select p.pid,p.pname,c.quantity from cart c join prod p on c.pid=p.pid where c.uid='$uid'"); $tq.=$qu."<br/>";
if(mysql_num_rows($s))
{
for($i=0;$i<mysql_num_rows($s);$i++)
{
$ppq=$_POST["p".mysql_result($s,$i,"pid")];
if($ppq>0)
mysql_query($qu="update cart set quantity='$ppq' where pid='".mysql_result($s,$i,"pid")."' and uid='$uid'"); $tq.=$qu."<br/>";
}
}
}


$s=mysql_query($qu="select p.price,p.pid,p.pname,c.quantity from cart c join prod p on c.pid=p.pid where c.uid='$uid'");$tq.=$qu."<br/>";
if(mysql_num_rows($s))
{
echo "<table><tr><th>Product Name</th><th>Quantity</th><th>Price/Unit</th><th>Total Price</th></tr><form method=post>";
for($i=0;$i<mysql_num_rows($s);$i++)
{
echo '<tr><td><a href=disp.php?pid='.mysql_result($s,$i,"pid").'>'.mysql_result($s,$i,"pname")."</a></td><td>";
echo "<input type=text name=p".mysql_result($s,$i,"pid")." size=3 value=".mysql_result($s,$i,"quantity")." /></td>";
echo "<td>".mysql_result($s,$i,"price")."</td>";
echo "<td>".mysql_result($s,$i,"price")*mysql_result($s,$i,"quantity")."</td>";
}
echo "</table>";
$qm=mysql_query($qu="select sum(c.quantity*p.price) as total from cart c join prod p on p.pid=c.pid where c.uid='$uid' "); $tq.=$qu."<br/";
echo "Total Amount to be paid -> Rs.".mysql_result($qm,0,"total")." <br/><input type=submit name=update value=Update /></form><form action=confirmcart.php method=post><input type=submit name=confirm value=ConfirmCheckOut  /></form><br/><a href=disp.php>No, I would like to shop some more products ......</a>";
}
else
{
echo "Oops !! You haven't bought any products yet !!.<a href=disp.php>Take me back to Products page </a><br/>";
}
echo "<br/><br/>$tq";
?>
