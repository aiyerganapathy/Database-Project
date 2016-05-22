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
	$query_maxdiaryid = "SELECT max(diary_id) FROM diary_entry";
	$res_maxdiaryid = pg_query($db_connection, $query_maxdiaryid);
	$res_maxdiaryid_id = pg_fetch_result($res_maxdiaryid,'max');
	$next_diaryid = $res_maxdiaryid_id + 1;
	$diary_title = $_POST['diary_title'];
	$diary_text = $_POST['diary_text'];
	$next_multimediaid = "";
	$privacy = $_POST['privacy'];
	date_default_timezone_set("America/New_York");
	$dt = new DateTime();
	$create_time = $dt->format('Y-m-d H:i:s');
			
	//Upload image related to diary entry
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["fileToUpload"]["name"]);
		$file_extension = end($temporary);
		$file_type =$_FILES["fileToUpload"]["type"];
		$filesize =$_FILES["fileToUpload"]["size"];

		if ((( $file_type== "image/png") || ($file_type == "image/jpg") || ($file_type == "image/jpeg")) && ($filesize < 100000) && in_array($file_extension, $validextensions)) {

			if ($_FILES["fileToUpload"]["error"] > 0) {
				echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br/><br/>";
			} else {

			if (file_exists("upload/" . $_FILES["fileToUpload"]["name"])) {
				echo $_FILES["fileToUpload"]["name"] . " <b>already exists.</b> ";
			}
			else {

			$file_name = $_FILES["fileToUpload"]["tmp_name"];
			$title = $diary_title;
			$img = fopen($file_name, 'r') or die("cannot read image\n");
			$data = fread($img, filesize($file_name));
			$es_data = pg_escape_bytea($data);
			fclose($img);
			$query_maxmultimediaid = "SELECT max(multimedia_id) FROM multimedia_details";
			$res_maxmultimediaid = pg_query($db_connection, $query_maxmultimediaid);
			$res_maxmultimediaid_id = pg_fetch_result($res_maxmultimediaid,'max');
			$next_multimediaid = $res_maxmultimediaid_id + 1;
			
			$query_insertmultimedia = "INSERT INTO multimedia_details(multimedia_id,mem_id,multimedia_tag,media_type,media_data,date_posted,privacy_code,del_flag,title) VALUES ('{$next_multimediaid}','{$own_mem_id}','{$own_mem_id}','P','{$es_data}','{$create_time}','{$privacy}','NO','{$title}')";
			$res_multimediaUpload = pg_query($db_connection, $query_insertmultimedia);
			$row_inserted_mid = pg_affected_rows($res_multimediaUpload);
			
		$query_insert_diaryentry = "INSERT into diary_entry(diary_id, mem_id , diary_title , text , date_posted, privacy_code , multimedia_id_ref , del_flag) Values ({$next_diaryid}, {$own_mem_id} , '{$diary_title}', '{$diary_text}' , '{$create_time}', {$privacy} , {$next_multimediaid} ,'N')";
		 echo $query_insert_diaryentry ;
		$result_insert_de = pg_query($db_connection, $query_insert_diaryentry);  
	    $row_insert_de = pg_affected_rows($result_insert_de);
	    if($row_insert_de == 1){
		echo "Diary entry posted ";	
		}
		}
	} 
		}
	else {
		echo "<span>***Invalid file Size or Type***<span>";
	}
}

pg_close($db_connection);
?>