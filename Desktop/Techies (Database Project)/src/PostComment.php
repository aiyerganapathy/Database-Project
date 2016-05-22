<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	$own_mem_id = $_SESSION['mem_id'];
	//multimedia_id/diary_id received from the hyperlink clicked
	$own_id = $_POST['id'];
	$own_associated_type = $_POST['type'];
	
	$comment_text = $_POST['comment_text'];
	$privacy_code = $_POST['privacy'];
	
	//echo $own_id;
	date_default_timezone_set("America/New_York");		
	$dt = new DateTime();
	$date_posted = $dt->format('Y-m-d H:i:s');
	//querying database for the multimedia_type
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	$query_max_comment = "SELECT max(comment_id) from comments_board";
	$res_max_comment = pg_query($db_connection,$query_max_comment);
	$res_max_comment_id = pg_fetch_result($res_max_comment,'max');
	$next_comment_id = $res_max_comment_id + 1;
	if($own_associated_type == 'D'){
	 $query_insert_comment = "INSERT INTO comments_board(comment_id,mem_id,id,associated_type,comment_text,posted_time,privacy_code,del_flag) VALUES 
   ('{$next_comment_id}','{$own_mem_id}','{$own_id}','{$own_associated_type}','{$comment_text}','{$date_posted}','{$privacy_code}','N')";   
    $res_insert_comment = pg_query($db_connection,$query_insert_comment);
	$row_insert_comment = pg_affected_rows($res_insert_comment);
	if($row_insert_comment == 1){
		echo "<p>Comment posted</p>";	
		}
		
	}
	elseif($own_associated_type == 'P' or 'V')
	{
	$query_insert_comment_P = "INSERT INTO comments_board(comment_id,mem_id,id,associated_type,comment_text,posted_time,privacy_code,del_flag) VALUES 
   ('{$next_comment_id}','{$own_mem_id}','{$own_id}','{$own_associated_type}','{$comment_text}','{$date_posted}','{$privacy_code}','N')";   
    $res_insert_comment_P = pg_query($db_connection,$query_insert_comment_P);
	$row_insert_comment_P = pg_affected_rows($res_insert_comment_P);
	if($row_insert_comment_P == 1){
		echo "<p>Comment posted</p>";	
		}
	
	}
}