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

if(isset($_POST["osubmit"]))
{
$ocode=$_POST["ocode"];
$res=mysql_query($qu="select * from offers where ocode='$ocode' and used=0"); $tq.=$qu."<br/>";
if(mysql_num_rows($res))
{
$tid=$_POST["tid"];
mysql_query("update offers set used=1 where ocode='$ocode'");
mysql_query("update orders set oid='$ocode' where tid='$tid'");
echo "!! Offer is Offered !!";
} 
else
echo "<br/>Sorry !! The offer code is WRONG / USED UP !!<br/>";
}

if(isset($_POST["confirm"]))
{
$res=mysql_query($qu1="select * from cart where uid='$uid'");
mysql_query($qu2="insert into orders (uid,orderdate,oid) values ('$uid',now(),NULL)");
$tid=mysql_result(mysql_query($qu3="select max(tid) as mtid from orders"),0,"mtid");
$tq.=$qu1."<br/>".$qu2."<br/>".$qu3."<br/>";
for($i=0;$i<mysql_num_rows($res);$i++)
{
mysql_query($qu="insert into orders_details (tid,pid,quantity) values ($tid,".mysql_result($res,$i,"pid").",".mysql_result($res,$i,"quantity").")");
}
mysql_query("delete from cart where uid='$uid'");
$r=mysql_query("select * from users where uid='$uid'");
echo "Thank You for Shopping with Us !!";
echo "Your Products will be delivered to your Address : ".mysql_result($r,0,"deladd")."<br/>The Bill was billed to ".mysql_result($r,0,"billadd")."<br/><br/>";
echo "Would you like to get a percentage off on your products ? <br/>Please enter the Offer Code given to you !! (One-Time Offer)<br/>
<form method=post><input type=text name=ocode /><input type=hidden name=tid value=$tid />
<input type=submit name=osubmit value=\"Get my Offer\" /></form>";
}

echo $tq;
?>
