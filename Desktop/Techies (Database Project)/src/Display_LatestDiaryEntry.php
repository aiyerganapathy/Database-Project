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
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	$query_maxdiaryid = "SELECT max(diary_id) FROM diary_entry where mem_id={$own_mem_id}";
	$res_maxdiaryid = pg_query($db_connection, $query_maxdiaryid);
	$res_maxdiaryid_id = pg_fetch_result($res_maxdiaryid,'max');
	$query_getLatestDE = "SELECT * FROM diary_entry WHERE diary_id='{$res_maxdiaryid_id}'";
	$res_DE = pg_query($db_connection,$query_getLatestDE);
	$row_DE = pg_num_rows($res_DE);
	if($row_DE == 1) {
		$own_latestDE_title = pg_fetch_result($res_DE,'diary_title');
		$own_latestDE_dp = pg_fetch_result($res_DE,'date_posted');
		$own_latestDE_privacy = pg_fetch_result($res_DE,'privacy_code');
		$own_latestDE_text = pg_fetch_result($res_DE,'text');
		$own_latestDE_mid = pg_fetch_result($res_DE,'multimedia_id_ref');
		$query_own_latestDE_pic = "SELECT * FROM multimedia_details where multimedia_id={$own_latestDE_mid}";
		$res_own_latestDE_pic = pg_query($db_connection, $query_own_latestDE_pic);
		$res_own_latestDE = pg_fetch_result($res_own_latestDE_pic, 'media_data');
		$unes_image = pg_unescape_bytea($res_own_latestDE);
		date_default_timezone_set("America/New_York");		
		$dt = new DateTime();
		$file_name = $own_latestDE_title.date_timestamp_get($dt);
		$file_name=preg_replace('/\s+/', '', $file_name);
		$file_name = $file_name.".jpg";
		$own_latestDE_pic_fname = $file_name;
		$img = fopen($file_name, 'wb') or die("cannot open image\n");
		fwrite($img, $unes_image) or die("cannot write image data\n");
		fclose($img);
		$query_comment_count = "SELECT count(comment_id) from comments_board where associated_type='D' and id='{$res_maxdiaryid_id}'";
		$res_commentsboard = pg_query($db_connection,$query_comment_count);
		$count_commentsboard = pg_fetch_result($res_commentsboard,'count');
		pg_close($db_connection);
		$post_data =json_encode(array('DE_diary_id' => $res_maxdiaryid_id,'DE_title' => $own_latestDE_title,'DE_dateposted' => $own_latestDE_dp,'DE_privacy' => $own_latestDE_privacy,'DE_text' => $own_latestDE_text,'DE_multimedia_id' => $own_latestDE_mid,'DE_pic_fname' => $own_latestDE_pic_fname,'DE_comment_count' => $count_commentsboard), JSON_FORCE_OBJECT);
    
	echo $post_data;
	}
}

?>