<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
if (isset($_POST['photoSubmit'])) {
	$mem_id =$_SESSION['mem_id'];
	$privacy = $_POST['privacy'];
//echo $_FILES["fileToUpload"]["type"];
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["fileToUpload"]["name"]);
$file_extension = end($temporary);

if ((($_FILES["fileToUpload"]["type"] == "image/png") || ($_FILES["fileToUpload"]["type"] == "image/jpg") || ($_FILES["fileToUpload"]["type"] == "image/jpeg")
) && ($_FILES["fileToUpload"]["size"] < 100000) && in_array($file_extension, $validextensions)) {

if ($_FILES["fileToUpload"]["error"] > 0) {
echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br/><br/>";
} else {
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass")
        or die ("Could not connect to server\n");

$file_name = $_FILES["fileToUpload"]["tmp_name"];
$title = $_POST['photo_title'].$mem_id;

$img = fopen($file_name, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file_name));

$es_data = pg_escape_bytea($data);
fclose($img);
$query_maxmultimediaid = "SELECT max(multimedia_id) FROM multimedia_details";
$res_maxmultimediaid = pg_query($con, $query_maxmultimediaid);
$res_maxmultimediaid_id = pg_fetch_result($res_maxmultimediaid,'max');
$next_multimediaid = $res_maxmultimediaid_id + 1;
$query = "INSERT INTO multimedia_details(multimedia_id,mem_id,multimedia_tag,media_type,media_data,date_posted,privacy_code,del_flag,title) VALUES ('{$next_multimediaid}','{$mem_id}','{$mem_id}','P','{$es_data}',NOW(),'{$privacy}','NO','{$title}')";
echo $next_multimediaid;

pg_query($con, $query);
pg_close($con);
echo "<span>Image Uploaded Succesfully!!</span><br/>";
echo "<br/><b>File Name:</b> " . $_FILES["fileToUpload"]["name"] . "<br>";
echo "<b>Type:</b> " . $_FILES["fileToUpload"]["type"] . "<br>";
echo "<b>Size:</b> " . ($_FILES["fileToUpload"]["size"] / 1024) . " kB<br>";
echo "<b>Temp file:</b> " . $_FILES["fileToUpload"]["tmp_name"] . "<br>";

}

}
} else {
echo "<span>***Invalid file Size or Type***<span>";
}
}

?>

