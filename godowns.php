<?php
session_start();
if(!(isset($_SESSION['userid']) && $_SESSION['userid']=="admin"))
echo '<meta http-equiv="Refresh" content="0;http://localhost/cart" />';
$ar=array("Godown Name"=>"name","Location"=>"location","Phone"=>"phone","Incharge Person"=>"incharge");
foreach ($ar as $val)
${$val}="";

echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://localhost/cart?logout=true">LogOut</a><br/><br/>';
if($_SESSION['userid']=="admin")
{
echo '<a href=prod.php>Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=cat.php>Categories</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=godowns.php>Godowns</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=suppliers.php>Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=buy.php>Buy from Supplier</a>';
}
echo '<br/><a href=user.php>Edit User Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=disp.php>Display and Confirm Products</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=ordersview.php>View Order History</a><br/><br/>';

mysql_connect('localhost','root','root');
mysql_select_db('osc') or die(mysql_error());
$tq="";

if(isset($_GET["gid"])) $gid=$_GET["gid"];

//Add data
if(isset($_POST["submit"]))
{
$vl=implode(",",$ar);
$i=0;
foreach($ar as $val)
{$t[$i]="'".$_POST[$val]."'";$i++;}
$v=implode(",",$t);
$query="insert into godowns (".$vl.") values (".$v.")";
$tq.=$query."<br/>";
mysql_query($query);
}

//Delete the Category
if(isset($_GET["o"]) && $_GET["o"]=="d")
{
mysql_query("delete from godowns where gid='$gid'");
}

//Update Data
if(isset($_POST["update"]))
{
$query="update godowns set ";
foreach ($ar as $val)
$query.=$val."="."'".$_POST["$val"]."'"." , ";
$query=substr($query,0,-2);
$query.=" where gid='$gid'";
$tq.=$query."<br/><br/>";
mysql_query($query);
}

//Show data to be edited
if((isset($_GET["gid"]) && isset($_GET["o"]) && $_GET["o"]=="e") || isset($_POST["update"]))
{
$query="select * from godowns where gid='$gid'"; $tq.=$query;
$res=mysql_query($query);
foreach ($ar as $val)
${$val}=mysql_result($res,0,$val);
}

?>

<br/>
godowns
<form method="post" action="<?php if(isset($_GET["gid"])) echo "?gid=".$_GET["gid"]; ?>">
<table>
<?php
foreach ($ar as $text=>$val)
if($val!="pgid")
echo "<tr><td>$text : </td><td><input type=text name=$val value=\"${$val}\" size=70></td></tr>";
else
{
echo "<tr><td>$text : </td><td><select name=$val>";
$res1=mysql_query("select gid,cname from godowns order by cname");
echo "<option "; if(0==${$val}) echo 'selected="selected"'; echo "value=0>None</option>";
for($i=0;$i<mysql_num_rows($res1);$i++)
{
echo "<option ";
if(mysql_result($res1,$i,"gid")==${$val})
echo 'selected="selected"';
echo "value=".mysql_result($res1,$i,"gid").">".mysql_result($res1,$i,"cname")."</option>";
}
echo "</select></td></tr>";

}
?>
</table>
<?php
if(isset($_GET["gid"]) && (isset($_POST["update"]) || (isset($_GET["o"]) && $_GET["o"]=="e")))
echo '<input type="submit" name="update" value="Update" />';
else
echo '<input type="submit" name="submit" value="Add" />';


?>
</form>
<br/><br/><br/><br/>
<table border=2>
<?php
//The Table showing all godowns
$res=mysql_query("select * from godowns");
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
if($val!="pgid")
echo "<td>".mysql_result($res,$i,$val)."</td>";
else
{
$pgid=mysql_result($res,$i,$val);
if($pgid!=0)
echo "<td>".mysql_result(mysql_query("select gid,cname from godowns where gid='$pgid'"),0,"cname")."</td>";
else
echo "<td></td>";
}
}
echo '<td><a href="?gid='.mysql_result($res,$i,"gid").'&o=e">Edit</a></td>';
echo '<td><a href="?gid='.mysql_result($res,$i,"gid").'&o=d">Delete</a></td>';
echo "</tr>";
}
?>
</table>
<?php
echo $tq;
?>