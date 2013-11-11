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
echo "Order History Details<br/><br/>";

echo "Filter by the following <br/>";
//Filter Options are Orders having given Products only, Direct Categorys Only, Total Cost in Range of , Having _ or more items in 
for($i=0;$i<5;$i++)
{
if($_POST["type"]==$i)
${"v".$i}='selected="selected"';
}
echo '<form method=post><select name=type><option value=0 '.$v0.'>None</option><option value=1 '.$v1.'>Product Only</option><option value=2 '.$v2.'>Direct Category Only</option><option value=3 '.$v3.' >Total Cost More than ...</option><option value=4 '.$v4.'>Orders having items more than ....</option></select>';
echo '<br/>Products Only : <select name=1v>';
$r=mysql_query($qu="select * from prod order by pname");
for($i=0;$i<mysql_num_rows($r);$i++)
echo '<option value='.mysql_result($r,$i,"pid").'>'.mysql_result($r,$i,"pname")."</option>";

echo '</select><br/>Direct Category Only : <select name=2v>';
$r=mysql_query($qu="select * from categories order by cname");
for($i=0;$i<mysql_num_rows($r);$i++)
echo '<option value='.mysql_result($r,$i,"cid").'>'.mysql_result($r,$i,"cname")."</option>";
if(isset($_POST["3v"])) $v33=$_POST["3v"]; else $v33=0;
if(isset($_POST["4v"])) $v44=$_POST["4v"]; else $v44=0;
echo '</select><br/>Total Cost more than ... : <input type=text name=3v value='.$v33.'  size=10 />';
echo '</select><br/>Order having items more than or = ... : <input type=text name=4v value='.$v44.'  size=10 />
<br/><input type=submit name=submit value=Filter /><br/></form>';

if(isset($_POST["submit"]))
{
$type=$_POST["type"];
$val=$_POST[$type."v"];
if($type==1)
{
$res=mysql_query($qu="select * from orders o where o.uid='$uid' and exists(select * from orders_details d where d.tid=o.tid and d.pid=$val) order by o.orderdate desc"); $tq.=$qu."<br/>";
}
else if($type==2)
{
$res=mysql_query($qu="select * from orders o where o.uid='$uid' and exists(select * from orders_details d  join prod p on p.pid=d.pid where p.cid=$val and d.tid=o.tid) order by o.orderdate desc"); $tq.=$qu."<br/>";
}
else if($type==3)
{
$res=mysql_query($qu="select * from orders o join orders_details d on o.tid=d.tid join prod p on p.pid=d.pid where o.uid='$uid' group by d.tid having sum(p.price*d.quantity)>$val order by o.orderdate desc"); $tq.=$qu."<br/>";
}
else if($type==4)
{
$res=mysql_query($qu="select * from orders o join orders_details d on o.tid=d.tid where o.uid='$uid' group by d.tid having count(*)>=$val order by o.orderdate desc");
}
else
{
$res=mysql_query($qu="select * from orders where uid='$uid' order by orderdate desc"); $tq.=$qu."<br/>";
}
}
else
$res=mysql_query($qu="select * from orders where uid='$uid' order by orderdate desc"); $tq.=$qu."<br/>";
echo "<table border=1>";
echo "<tr><th>Order ID and Date of Ordering</th><th>Details of Ordering</th><th>Total Cost of Ordering</th></tr>";
for($i=0;$i<mysql_num_rows($res);$i++)
{
if(mysql_result($res,$i,"oid")!="")
$ans=" Offer Code Used - ".mysql_result($res,$i,"oid")."<br/>";
echo "<td>".mysql_result($res,$i,"tid")." -> Ordered on ".mysql_result($res,$i,"orderdate")."<br/>$ans</td>";
$ans="";
$tid=mysql_result($res,$i,"tid");
$res1=mysql_query("select * from orders_details o join prod p on o.pid=p.pid where tid='$tid' ");
echo "<td>";
for($j=0;$j<mysql_num_rows($res1);$j++)
{
echo "<a href=disp.php?pid=".mysql_result($res1,$j,"pid").">".mysql_result($res1,$j,"pname")."</a>"." - ".mysql_result($res1,$j,"quantity")." ".mysql_result($res1,$j,"typeprice")." - Rs.".mysql_result($res1,$j,"price")." per ".mysql_result($res1,$j,"typeprice")."<br/>";
}
$rs=mysql_query($qu="select sum(o.quantity*p.price) as total from orders_details o join prod p on o.pid=p.pid where tid='$tid'"); $tq.=$qu."<br/>";
echo "</td><td>".mysql_result($rs,0,"total")."</td></tr>";
}
echo "</table>";
echo "<br/>$tq";
?>
