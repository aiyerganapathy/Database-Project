<?php include 'dbconnection_setting.php' ?>
<?php 
    session_start();
    $own_mem_id = $_SESSION['mem_id'];
	   $con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	   //user_login_details 
	    date_default_timezone_set("America/New_York");
	    $log_out_time = new DateTime();
$log_out_time = $log_out_time->format('Y-m-d H:i:s');
		$login_time = $_SESSION['logon_time'];
    $login_date=explode(" ",$login_time)[0];
	   $query_update_uld = "UPDATE user_login_details SET log_end_time = '$log_out_time' WHERE mem_id = '{$own_mem_id}' and log_start_time = '$login_time' and login_date = '{$login_date}' and del_flag = 'false'"; 
		$result_update_uld = pg_query($con, $query_update_uld);  
	    $row_update_uld = pg_affected_rows($result_update_uld);
	    if($row_update_uld == 1){
			session_unset();
			header("location: Reg_Login.php");
			session_destroy();
		}
        echo $query_update_uld;
		pg_close($con);  
?>