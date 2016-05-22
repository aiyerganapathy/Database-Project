<?php include 'dbconnection_setting.php' ?>
<?php
session_start();
$own_mem_id = $_SESSION['mem_id']; 
if(isset($_POST['Message_Text'])&&isset($_POST['to_user_id'])){
    $con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
    $userid=$_POST['to_user_id'];
    $body=$_POST['Message_Text'];
    date_default_timezone_set("America/New_York");
    $dt = new DateTime();
    $date_sent = $dt->format('Y-m-d H:i:s');
    $sql = 'SELECT postmessage($1,$2,$3,$4)';
    $res = pg_prepare($con, "my_query", $sql);
    $res = pg_execute($con, "my_query", array($own_mem_id,$userid,$body,$date_sent));
  
   echo "<p style='font-weight: bold; text-align: center'> Message Sent </p>";
}

?>