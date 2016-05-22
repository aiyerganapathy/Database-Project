<?php include 'dbconnection_setting.php' ?>
<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
$from_mem_id = $_SESSION['mem_id'];
$to_mem_id=$_GET['id'];

$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;


$query_insert= " UPDATE friendship_status SET rel_code=2 WHERE mem_id_1='{$from_mem_id}' AND mem_id_2='{$to_mem_id}'";
 
$result=pg_query($con,$query_insert);


pg_close($con);

echo "Friend Request Accepted";}
?>