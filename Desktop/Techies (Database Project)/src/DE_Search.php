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
	$to_date = $_POST['todatepicker'];
	$from_date = $_POST['fromdatepicker'];
	$date_to_date = date_create($to_date);
	date_modify($date_to_date, '+1 day');
	$to_date_new = date_format($date_to_date, 'Y-m-d');
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	$query_getLatestDE = "SELECT * FROM diary_entry WHERE mem_id='{$own_mem_id}' and date_posted >= '{$from_date}' and date_posted <= '{$to_date_new}' order by date_posted desc";
    $res_DE = pg_query($db_connection,$query_getLatestDE);
	$row_DE = pg_num_rows($res_DE);
	$arr_DE = pg_fetch_all($res_DE);
	$de_loop = array(array());
	while ($row = pg_fetch_assoc($res_DE))
	{
 
  		$currentmid = $row['multimedia_id_ref'];
		$currentdiary_id = $row['diary_id'];
		$current_title = $row['diary_title'];
		date_default_timezone_set("America/New_York");
		$dt = new DateTime();	
		$current_pic_fname = $current_title.date_timestamp_get($dt).rand(1,100);
		$current_pic_fname = preg_replace('/\s+/', '', $current_pic_fname);	
		$current_pic_fname = $current_pic_fname.".jpg";
		$query_current_pic = "SELECT * FROM multimedia_details where multimedia_id={$currentmid}";
		$res_current_pic = pg_query($db_connection, $query_current_pic);
		$res_currentDE = pg_fetch_result($res_current_pic, 'media_data');
		$unes_image = pg_unescape_bytea($res_currentDE);
		$current_img = fopen($current_pic_fname, 'wb') or die("cannot open image\n");
		fwrite($current_img, $unes_image) or die("cannot write image data\n");
		fclose($current_img); 
		$query_comment_count = "SELECT count(comment_id) from comments_board where associated_type='D' and id='{$currentdiary_id}'";
		$res_commentsboard = pg_query($db_connection,$query_comment_count);
		$curr_count_commentsboard = pg_fetch_result($res_commentsboard,'count');
		$jsonRow = array('diary_id' => $row['diary_id'],'mem_id' => $row['mem_id'],'diary_title' => $row['diary_title'], 'date_posted' => $row['date_posted'], 'privacy_code' => $row['privacy_code'], 'diary_text'=> $row['text'],'multimedia_id_ref' => $row['multimedia_id_ref'],'multimedia_fname' => $current_pic_fname,'comment' => $curr_count_commentsboard);
		//$jsonRow = array('diary_id' => $row['diary_id'],'mem_id' => $row['mem_id'],'diary_title' => $row['diary_title'], 'date_posted' => $row['date_posted'], 'privacy_code' => $row['privacy_code'], 'diary_text'=> $row['text'],'multimedia_id_ref' => $row['multimedia_id_ref'],'comment' => $curr_count_commentsboard);
		array_push($de_loop,$jsonRow);	
}
$post_data = json_encode($de_loop,JSON_FORCE_OBJECT);
echo $post_data;
pg_close($db_connection);
}

?>