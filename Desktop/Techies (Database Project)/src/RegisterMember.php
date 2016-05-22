<?php include 'dbconnection_setting.php' ?>
<?php 
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass")
        or die ("Could not connect to server\n");

$f_name = $_POST['fname'];
$m_name = $_POST['mname'];
$l_name = $_POST['lname'];
$e_mail_id = $_POST['emailid'];
$password_register = $_POST['password_register'];
$l1_address = $_POST['l1Address'];
$l2_address = $_POST['l2Address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$zip = $_POST['city'];
$gender = isset($_POST["gender"]) ? $_POST["gender"] :" ";
$privacy = $_POST['privacy'];
$dob = $_POST['datepicker'];
$phone = $_POST['phonenum'];



//FIND the max mem_id in member_info
$query_maxmem_id = "SELECT max(mem_id) FROM member_info";
$res_maxmem_id = pg_query($con, $query_maxmem_id);
$res_maxmem_id_id = pg_fetch_result($res_maxmem_id,'max');
$next_mem_id = $res_maxmem_id_id + 1;
$query_insert_member_info = "INSERT INTO member_info (mem_id,f_name ,m_name,l_name,dob,email_id,phone_no,line1,line2,state,city,country,zip_code,del_flag) values
   ('{$next_mem_id}','{$f_name}' ,'{$m_name}','{$l_name}','{$dob}','{$e_mail_id}','{$phone}','{$l1_address}','{$l2_address}','{$state}','{$city}','{$country}','{$zip}','N')";
   
$result_insert_member_info = pg_query($con, $query_insert_member_info);  
$row_inserted_mi = pg_affected_rows($result_insert_member_info);
date_default_timezone_set("America/New_York");
$dt = new DateTime();
$create_time = $dt->format('Y-m-d H:i:s');
if($row_inserted_mi == 1) {
	$username = $f_name. "_" .$l_name;
    $query_insert_uad="INSERT INTO user_account_details (user_id, mem_id , log_password, creation_date,account_status,del_flag) values  ('{$username}', '{$next_mem_id}' , '{$password_register}','{$create_time}','1','N')";
	$result_insert_uad = pg_query($con, $query_insert_uad);  
	$row_inserted_uad = pg_affected_rows($result_insert_uad);
	
	if(($row_inserted_mi == 1) and ($row_inserted_uad == 1)){
		
$profile_pic_title = "profilepic". $next_mem_id;

//Profile Pic Upload 
$file_type = $_FILES["fileToUpload"]["type"];
$file_size = $_FILES["fileToUpload"]["size"];
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["fileToUpload"]["name"]);
$file_extension = end($temporary);

if ((($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/jpeg")
) && ($file_size < 100000) && in_array($file_extension, $validextensions)) {

if ($_FILES["fileToUpload"]["error"] > 0) {
echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br/><br/>";
} else {
if (file_exists("upload/" . $_FILES["fileToUpload"]["name"])) {
echo $_FILES["fileToUpload"]["name"] . " <b>already exists.</b> ";
}
else {
$file_name = $_FILES["fileToUpload"]["tmp_name"];
$img = fopen($file_name, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file_name));

$es_data = pg_escape_bytea($data);
fclose($img);
$query_maxmultimediaid = "SELECT max(multimedia_id) FROM multimedia_details";
$res_maxmultimediaid = pg_query($con, $query_maxmultimediaid);
$res_maxmultimediaid_id = pg_fetch_result($res_maxmultimediaid,'max');
$next_multimediaid = $res_maxmultimediaid_id + 1;
$query_insertmultimedia = "INSERT INTO multimedia_details(multimedia_id,mem_id,multimedia_tag,media_type,media_data,date_posted,privacy_code,del_flag,title) VALUES ('{$next_multimediaid}','{$next_mem_id}','{$next_mem_id}','P','{$es_data}','{$create_time}','2','NO','{$profile_pic_title}')";
$res_multimediaUpload = pg_query($con, $query_insertmultimedia);
$row_inserted_mid = pg_affected_rows($res_multimediaUpload);

}
}
} else {
echo "<span>***Invalid file Size or Type***<span>";
}

  //Create entry in profile table
    $keywords=$_POST['keywords'];
	$profile_string = "Hi,Please add your profile summary";
    $query_insert_profile =  "INSERT INTO profile (mem_id, profile_string, keywords, privacy_code, multimedia_id_ref, del_flag) VALUES ('{$next_mem_id}','{$profile_string}', '{$keywords}','{$privacy}','{$next_multimediaid}','NO')";
 	$result_insert_profile = pg_query($con, $query_insert_profile);  
	$row_inserted_profile = pg_affected_rows($result_insert_profile);
	
	if(($row_inserted_mi == 1) && ($row_inserted_profile == 1) && ($row_inserted_uad == 1) ) 
        //Create entry into user_login_details
		date_default_timezone_set("America/New_York");
		$dat = new DateTime();
		$login_date = $dat->format('Y-m-d');
		$login_time = $dat->format('Y-m-d H:i:s');
		$query_insert_uld = "INSERT INTO user_login_details (mem_id, log_start_time, login_date, del_flag) VALUES ('{$next_mem_id}','{$login_time}','{$login_date}', 'NO')"; 
		$result_insert_uld = pg_query($con, $query_insert_uld);  
	    $row_inserted_uld = pg_affected_rows($result_insert_uld);
		if($row_inserted_uld == 1){
		session_start();
        $_SESSION['user_name']=$username;
		$_SESSION['mem_id'] = $next_mem_id;
		$_SESSION['logon_time'] = $login_time;
        //Storing the name of user in SESSION variable.
        header("location: ProfilePage.php");
		}
		else {
			echo "<p>User logon not successful.</p>";
		}
	}
	else{
		echo "<p>User not created properly.</p>";
	}
}else{
	echo "<p>User not created</p>";
}
pg_close($con);
?>