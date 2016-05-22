<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	if(isset($_GET['friend_id'])){
$friend_id = $_GET['friend_id'];
$own_mem_id = $_SESSION['mem_id'];
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass")
        or die ("Could not connect to server\n");

// We are reading the latest image we just uploaded.
// Read bytea from table "multimedia_details".
$result_profile = pg_query($con, "SELECT * from profile where mem_id='$friend_id'") or die('cannot see table records');
$profile_multimedia_id = pg_fetch_result($result_profile,'multimedia_id_ref');
$query_latestphoto = "SELECT * FROM multimedia_details where multimedia_id={$profile_multimedia_id} and mem_id={$friend_id}";
$res_latestphoto = pg_query($con, $query_latestphoto);
$data = pg_fetch_result($res_latestphoto, 'media_data');
$title = pg_fetch_result($res_latestphoto, 'title');
$unes_image = pg_unescape_bytea($data);
date_default_timezone_set("America/New_York");		
$dt = new DateTime();
$file_name = "".(string)$title."_".(string)date_timestamp_get($dt).".jpg";
$img = fopen($file_name, 'wb') or die("cannot open image\n");
fwrite($img, $unes_image) or die("cannot write image data\n");
    
fclose($img);
//<img id="latestphoto" src=$file_name alt="sample">
pg_close($con);
header('Content-type: image/jpeg');
//header('Content-type: text/javascript');
echo "<img id='file_name' class='profilePhoto' name='file_name' src='",$file_name,"' />";
//echo $file_name;
}
}
?>
