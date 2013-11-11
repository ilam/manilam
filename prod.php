<?php
session_start();
if(!(isset($_SESSION['userid']) && $_SESSION['userid']=="admin"))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart" />';
$ar=array("Product Name"=>"pname","Description"=>"description","Price"=>"price","Price Type (kg/piece)"=>"typeprice","Company"=>"company","Category"=>"cid");
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://localhost/cart?logout=true">LogOut</a><br/><br/>';
if($_SESSION['userid']=="admin")
{
echo '<a href=prod.php>Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=cat.php>Categories</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=godowns.php>Godowns</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=suppliers.php>Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=buy.php>Buy from Supplier</a>';
}
echo '<br/><a href=user.php>Edit User Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=disp.php>Display and Confirm Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=ordersview.php>View Order History</a><br/><br/>';

mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";

foreach ($ar as $val)
${$val}="";

if(isset($_GET["pid"])) $pid=$_GET["pid"];

//Add data
if(isset($_POST["submit"]))
{
$vl=implode(",",$ar);
$i=0;
foreach($ar as $val)
{$t[$i]="'".$_POST[$val]."'";$i++;}
$v=implode(",",$t);
$query="insert into prod (".$vl.") values (".$v.")";
$tq.=$query."<br/>";
mysql_query($query);
}

//Delete the Product
if(isset($_GET["o"]) && $_GET["o"]=="d")
{ 
mysql_query($qu="delete from prod where pid='$pid'"); $tq.=$qu."<br/";
}

//Update Data
if(isset($_POST["update"]))
{
$query="update prod set ";
foreach ($ar as $val)
$query.=$val."="."'".$_POST["$val"]."'"." , ";
$query=substr($query,0,-2);
$query.=" where pid='$pid'";
$tq.=$query."<br/><br/>";
mysql_query($query);
}

//Show data to be edited
if((isset($_GET["pid"]) && isset($_GET["o"]) && $_GET["o"]=="e") || isset($_POST["update"]))
{
$query="select * from prod where pid='$pid'"; $tq.=$query;
$res=mysql_query($query);
foreach ($ar as $val)
${$val}=mysql_result($res,0,$val);
}

?>

<br/>
Product
<form method="post" action="<?php if(isset($_GET["pid"])) echo "?pid=".$_GET["pid"]; ?>">
<table>
<?php
foreach ($ar as $text=>$val)
if($val!="cid")
echo "<tr><td>$text : </td><td><input type=text name=$val value=\"${$val}\" size=70></td></tr>";
else
{
echo "<tr><td>$text : </td><td><select name=$val>";
$res1=mysql_query("select cid,cname from categories order by cname");
for($i=0;$i<mysql_num_rows($res1);$i++)
{
echo "<option ";
if(mysql_result($res1,$i,"cid")==${$val})
echo 'selected="selected"';
echo "value=".mysql_result($res1,$i,"cid").">".mysql_result($res1,$i,"cname")."</option>";
}
echo "</select></td></tr>";

}
?>
</table>
<?php
if(isset($_GET["pid"]) && (isset($_POST["update"]) || (isset($_GET["o"]) && $_GET["o"]=="e")))
echo '<input type="submit" name="update" value="Update" />';
else
echo '<input type="submit" name="submit" value="Add" />';


?>
</form>
<br/><br/><br/><br/>
<table border=2>
<?php
//The Table showing all Products
$res=mysql_query("select * from prod");
echo "<tr>";
foreach ($ar as $text=>$val)
echo "<th>".$text."</th>";
echo "<th>Edit</th>";
echo "<th>Delete</th>";

echo "</tr>";

for($i=0;$i<mysql_num_rows($res);$i++)
{
echo "<tr>";
foreach ($ar as $val)
{
if($val!="cid")
echo "<td>".mysql_result($res,$i,$val)."</td>";
else
{
$cid=mysql_result($res,$i,$val);
echo "<td>".mysql_result(mysql_query("select cid,cname from categories where cid='$cid'"),0,"cname")."</td>";
}
}
echo '<td><a href="?pid='.mysql_result($res,$i,"pid").'&o=e">Edit</a></td>';
echo '<td><a href="?pid='.mysql_result($res,$i,"pid").'&o=d">Delete</a></td>';
echo "</tr>";
}
?>
</table>
<?php
echo $tq;
?>