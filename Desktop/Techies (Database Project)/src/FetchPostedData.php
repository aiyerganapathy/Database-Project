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
	$own_id = $_GET['element_id'];
	$own_associated_type = $_GET['type'];
	
	//querying database for the multimedia_type
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	if($own_associated_type == 'D'){
		$query_getDE = "SELECT * FROM diary_entry WHERE diary_id='{$own_id}'";
   		$res_DE = pg_query($db_connection,$query_getDE);
		$row_DE = pg_num_rows($res_DE);
		if($row_DE == 1) {
			$own_DE_title = pg_fetch_result($res_DE,'diary_title');
			$own_DE_dp = pg_fetch_result($res_DE,'date_posted');
			$own_DE_privacy = pg_fetch_result($res_DE,'privacy_code');
			$own_DE_text = pg_fetch_result($res_DE,'text');
			$own_DE_mid = pg_fetch_result($res_DE,'multimedia_id_ref');
			
			$query_own_DE_pic = "SELECT * FROM multimedia_details where multimedia_id={$own_DE_mid}";
			$res_own_DE_pic = pg_query($db_connection, $query_own_DE_pic);
			$res_own_DE = pg_fetch_result($res_own_DE_pic, 'media_data');
			$unes_image = pg_unescape_bytea($res_own_DE);
			date_default_timezone_set("America/New_York");		
			$dt = new DateTime();
			$own_DE_pic_fname = $own_DE_title.date_timestamp_get($dt);
			$own_DE_pic_fname = preg_replace('/\s+/', '', $own_DE_pic_fname);	
			$own_DE_pic_fname = $own_DE_pic_fname.".jpg";
			$img = fopen($own_DE_pic_fname, 'wb') or die("cannot open image\n");
			fwrite($img, $unes_image) or die("cannot write image data\n");
			fclose($img);
			$post_data =json_encode(array('DE_diary_id' => $own_id,'DE_title' => $own_DE_title,'DE_dateposted' => $own_DE_dp,'DE_privacy' => $own_DE_privacy,'DE_text' => $own_DE_text,'DE_multimedia_id' => $own_DE_mid,'DE_pic_fname' => $own_DE_pic_fname), JSON_FORCE_OBJECT);
    
			echo $post_data;
	}
	}
	elseif($own_associated_type == 'P' or 'V')
	{
		$query_getMD = "SELECT * FROM multimedia_details where multimedia_id='{$own_id}'";
   		$res_MD = pg_query($db_connection,$query_getMD);
		$row_MD = pg_num_rows($res_MD);
		if($row_MD == 1) {
			$own_MD_id = pg_fetch_result($res_MD,'multimedia_id');
			$own_MD_mem_id = pg_fetch_result($res_MD,'mem_id');
			$own_MD_multimedia_tag = pg_fetch_result($res_MD,'multimedia_tag');
			$own_MD_media_type = pg_fetch_result($res_MD,'media_type');
			$own_MD_dateposted = pg_fetch_result($res_MD,'date_posted');
			$own_MD_title = pg_fetch_result($res_MD,'title');
			$own_MD_mediadata = pg_fetch_result($res_MD, 'media_data');
			$own_MD_privacy = pg_fetch_result($res_MD,'privacy_code');
			$unes_image = pg_unescape_bytea($own_MD_mediadata);
			date_default_timezone_set("America/New_York");		
			$dt = new DateTime();
			$own_MD_fname = $own_MD_title.date_timestamp_get($dt);
			$own_MD_fname = preg_replace('/\s+/', '', $own_MD_fname);	
			$own_MD_fname = $own_MD_fname.".jpg";
			$img = fopen($own_MD_fname, 'wb') or die("cannot open image\n");
			fwrite($img, $unes_image) or die("cannot write image data\n");
			fclose($img);
			$post_data =json_encode(array('MD_id' => $own_MD_id,'MD_mem_id' => $own_MD_mem_id,'MD_multimedia_tag' => $own_MD_multimedia_tag,'MD_privacy' => $own_MD_privacy,'MD_fname' => $own_MD_fname,'MD_title' => $own_MD_title,'MD_dateposted' => $own_MD_dateposted), JSON_FORCE_OBJECT);
    
			echo $post_data;
	}
		
	}
		
}
?>