<?php
session_start();
if(!isset($_SESSION['userid']))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart" />';
$uid=$_SESSION["userid"];

mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://localhost/cart?logout=true">LogOut</a><br/><br/>';
if($_SESSION['userid']=="admin")
{
echo '<a href=prod.php>Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=cat.php>Categories</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=godowns.php>Godowns</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=suppliers.php>Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=buy.php>Buy from Supplier</a>';
}
echo '<br/><a href=user.php>Edit User Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=disp.php>Display and Confirm Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=ordersview.php>View Order History</a><br/><br/>';
$ar=array("First Name"=>"fname","Last Name"=>"lname","Email"=>"email","Phone"=>"phone","Billing Address"=>"billadd","Delivery Address"=>"deladd");

if(isset($_POST["submit"]))
{
$query="update users set ";
foreach ($ar as $val)
$query.=$val."="."'".$_POST["$val"]."'"." , ";
$query=substr($query,0,-2);
$query.=" where uid='$uid'";
$tq.=$query."<br/><br/>";
mysql_query($query);
}


$query="select * from users where uid='$uid'"; $tq.=$query;
$res=mysql_query($query);
foreach ($ar as $val)
${$val}=mysql_result($res,0,$val);
?>
<br/>
Profile
<form method="post">
<?php
foreach ($ar as $text=>$val)
echo "$text : <input type=text name=$val value=\"${$val}\" size=70><br/>";
?>
<input type="submit" name="submit" value="Update" />
</form>

<?php
echo $tq;
?>