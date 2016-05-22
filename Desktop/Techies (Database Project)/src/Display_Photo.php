<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass")
        or die ("Could not connect to server\n");
$own_mem_id = $_SESSION['mem_id'];
// We are reading the latest image we just uploaded.
// Read bytea from table "multimedia_details".
$query_maxmultimediaid = "SELECT max(multimedia_id) FROM multimedia_details where mem_id='{$own_mem_id}'";
$res_maxmultimediaid = pg_query($con, $query_maxmultimediaid);
$res_maxmultimediaid_id = pg_fetch_result($res_maxmultimediaid,'max');
$query_latestphoto = "SELECT * FROM multimedia_details where multimedia_id={$res_maxmultimediaid_id}";
$res_latestphoto = pg_query($con, $query_latestphoto);
$data = pg_fetch_result($res_latestphoto, 'media_data');
$title = pg_fetch_result($res_latestphoto, 'title');
$privacy = pg_fetch_result($res_latestphoto, 'privacy_code');
$unes_image = pg_unescape_bytea($data);
date_default_timezone_set("America/New_York");		
$dt = new DateTime();
$file_name = $title.date_timestamp_get($dt);
$file_name = preg_replace('/\s+/', '', $file_name);	
$file_name = $file_name.".jpg";
$img = fopen($file_name, 'wb') or die("cannot open image\n");
fwrite($img, $unes_image) or die("cannot write image data\n");
fclose($img);
$query_comment_count = "SELECT count(comment_id) from comments_board where associated_type IN ('P','V') and id='{$res_maxmultimediaid_id}'";
$res_commentsboard = pg_query($con,$query_comment_count);
$count_commentsboard = pg_fetch_result($res_commentsboard,'count');
//<img id="latestphoto" src=$file_name alt="sample">
pg_close($con);
//header('Content-type: image/jpeg');
//header('Content-type: text/javascript');
//echo "<img id='file_name' name='file_name' src='",$file_name,"' width='350px' height='350px' />";
$post_data =json_encode(array('multimedia_id' => $res_maxmultimediaid_id,'title' => $title,'multimedia_fname' => $file_name,'privacy' => $privacy,'comment_count' => $count_commentsboard), JSON_FORCE_OBJECT);
echo $post_data;
}
?>
