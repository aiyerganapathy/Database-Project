<?php include 'dbconnection_setting.php' ?>
<?php
if(isset($_POST['Login'])){
if(isset($_POST['user_name']))
{   $user_name=$_POST['user_name'];
    $password=$_POST['password'];
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;

	$result2 = pg_query($db_connection, "SELECT * from user_account_details where user_id='$user_name' and log_password='$password'") or die('cannot see table records');
	$rows = pg_affected_rows($result2);	
    if($rows == 1) {
		
		$mem_id = pg_fetch_result($result2,'mem_id');
		 //Create entry into user_login_details
		 date_default_timezone_set("America/New_York");
		
		$dt = new DateTime();
		$login_date = $dt->format('Y-m-d');
		$login_time = $dt->format('Y-m-d H:i:s');
	$query_insert_uld = "INSERT INTO user_login_details (mem_id, log_start_time,login_date, del_flag) VALUES ('{$mem_id}','{$login_time}','{$login_date}', 'false')"; 
		$result_insert_uld = pg_query($db_connection, $query_insert_uld);  
	    $row_inserted_uld = pg_affected_rows($result_insert_uld);
		session_start();
		
        $_SESSION['user_name']=$_POST['user_name'];
		$_SESSION['mem_id'] = $mem_id;
		$_SESSION['logon_time'] = $login_time;
		pg_close($db_connection);
		
        //Storing the name of user in SESSION variable.
        header("location: ProfilePage.php");	
	}
    else{	
    
        header("location: Reg_Login.php");
    }
}
}
?>