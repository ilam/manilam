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

//have to display Categories if no GET parameters 
//Display Product and Categories associated is GET parameter is Category
//Display Product Details if the associated GET parameter is Product


if(isset($_POST["apid"]) && isset($_POST["addc"]))
{
$apid=$_POST["apid"];
$quant=$_POST["quant"];
mysql_query($qu="insert into cart (uid,pid,quantity) values ('$uid','$apid','$quant')"); $tq.=$qu."<br/>";
}
if(isset($_POST["apid"]) && isset($_POST["delc"]))
{
$apid=$_POST["apid"];
mysql_query($qu="delete from cart where uid='$uid' and pid='$apid'"); $tq.=$qu."<br/";
}



//Display the shopping cart
$s=mysql_query($qu="select p.price,p.pid,p.pname,c.quantity from cart c join prod p on c.pid=p.pid where c.uid='$uid'"); $tq.=$qu."<br/";
if(mysql_num_rows($s))
{
echo "<table border=1><tr><th>Product Name</th><th>Quantity</th><th>Price/Unit</th><th>Total Price</th></tr>";
for($i=0;$i<mysql_num_rows($s);$i++)
{
echo '<tr><td><a href=?pid='.mysql_result($s,$i,"pid").'>'.mysql_result($s,$i,"pname")."</a></td><td>".mysql_result($s,$i,"quantity")."</td>";
echo "<td>".mysql_result($s,$i,"price")."</td>";
echo "<td>".mysql_result($s,$i,"price")*mysql_result($s,$i,"quantity")."</td>";
}
echo "</table>";
echo "<br/><form action=cart.php method=post><input type=submit name=checkout value=CheckOut /></form>";
}
else
echo " Oh no !! Shopping Cart is Empty !! Add some products to your Cart !! <br/>";





if(isset($_GET["cid"]))
{
$cid=$_GET["cid"];
//Categories
$res=mysql_query("select * from categories where cid='$cid'");
$res1=mysql_query("select * from categories where pcid='$cid'");

$ccid=$cid;
$st="";
while($ccid!=0)
{
$res3=mysql_query("select * from categories where cid='$ccid'");
$st='<a href="?cid='.mysql_result($res3,0,"cid").'">'.mysql_result($res3,0,"cname")."</a> >> ".$st;
$ccid=mysql_result($res3,0,"pcid");
}
$st='<a href="disp.php">Home</a> >> '.$st;
echo $st."<br/>";
for($i=0;$i<mysql_num_rows($res1);$i++)
{
echo '<a href="?cid='.mysql_result($res1,$i,"cid").'">'.mysql_result($res1,$i,"cname")."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
echo "<br/><br/>You are in the Category - ".mysql_result($res,0,"cname")."<br/>";
echo "!! ".mysql_result($res,0,"description")." !!<br/><br/>";
//Products
$res2=mysql_query("select * from prod where cid='$cid'");
if(mysql_num_rows($res2))
{
echo "<h4>Products in this Category</h4>";
echo "<table border=1><tr><th>Product Name</th><th>Price</th>";
for($i=0;$i<mysql_num_rows($res2);$i++)
{
echo '<tr><td><a href="?pid='.mysql_result($res2,$i,"pid").'">'.mysql_result($res2,$i,"pname")."</a></td><td>".mysql_result($res2,$i,"price")."</td></tr>";
}
echo "</table>";
}
}
else if(isset($_GET["pid"]))
{
$pid=$_GET["pid"];
$res=mysql_query("select * from prod where pid='$pid'");
$ccid=mysql_result($res,0,"cid");
$st="";
while($ccid!=0)
{
$res3=mysql_query("select * from categories where cid='$ccid'");
$st='<a href="?cid='.mysql_result($res3,0,"cid").'">'.mysql_result($res3,0,"cname")."</a> >> ".$st;
$ccid=mysql_result($res3,0,"pcid");
}
$st='<a href="disp.php">Home</a> >> '.$st;
echo $st."<br/>";

echo "<br/>The product details are as follows - <br/>";
echo "Product Name -> ".mysql_result($res,0,"pname")."<br/>Price -> Rs.".mysql_result($res,0,"price")." per ".mysql_result($res,0,"typeprice")."<br/>Company -> ".mysql_result($res,0,"company")."<br/> About the Product -> ".mysql_result($res,0,"description")."<br/><br/>";
$r=mysql_query($qu="select * from cart where uid='$uid' and pid='$pid'"); $tq.=$qu."<br/>";
if(mysql_num_rows($r))
{
echo "<br/>Already in Cart";
echo '<form method=post><input type=hidden name=apid value="'.$pid.'" /><input type=submit name=delc value="Delete from Cart" /></form>';
}
else
echo '<form method=post>Quantity : <input type=text name=quant value=1 size=3 />&nbsp;<input type=hidden name=apid value="'.$pid.'" /><input type=submit name=addc value="Add to Cart" /></form>';

}
else
{
$res=mysql_query("select * from categories where pcid=0");
for($i=0;$i<mysql_num_rows($res);$i++)
{
echo '<a href="?cid='.mysql_result($res,$i,"cid").'">'.mysql_result($res,$i,"cname")."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
}

?>
