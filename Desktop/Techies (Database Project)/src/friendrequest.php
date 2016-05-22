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

if($from_mem_id>$to_mem_id){

    $temp=$from_mem_id;
    $from_mem_id=$to_mem_id;
    $to_mem_id=$temp;

}

$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;

$query_insert ="INSERT INTO friendship_status VALUES ('{$from_mem_id}','{$to_mem_id}','{$from_mem_id}','1','FRIEND','false');";

$result=pg_query($con,$query_insert);




pg_close($con);
echo "Friend Request Sent";
}
?>