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
    $own_id = $_GET['element_id'];
	$own_associated_type = $_GET['type'];
	//echo $own_id.$own_associated_type;
    
	//querying database for the multimedia_type
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	if($own_associated_type == 'D'){
			$query_comments_list = "SELECT * from comments_board where associated_type='D' and id={$own_id}";
			$res_commentsboard = pg_query($db_connection,$query_comments_list);
			$row_cb = pg_num_rows($res_commentsboard);
			$arr_cb = pg_fetch_all($res_commentsboard);
		   	$dc_loop = array(array());
			for($i = 0, $size = count($arr_cb); $i < $size; $i++) {
  				 	$row_comment_id = $arr_cb[$i]['comment_id'];
					$row_mem_id = $arr_cb[$i]['mem_id'];
					$query_user_id = "SELECT user_id from user_account_details where mem_id='{$row_mem_id}'";
					$res_user_id = pg_query($db_connection,$query_user_id);
					$row_username = pg_fetch_result($res_user_id,'user_id');
                    $row_id = $arr_cb[$i]['id'];
					$row_associated_type = $arr_cb[$i]['associated_type'];
					$row_comment_text = $arr_cb[$i]['comment_text'];
					$row_posted_time = $arr_cb[$i]['posted_time'];
					$row_privacy_code = $arr_cb[$i]['privacy_code'];
				  	$jsonRow = array('comment_id' => $row_comment_id,'mem_id' => $row_mem_id,'user_id' => $row_username,'id' => $row_id, 'associated_type' => $row_associated_type, 'comment_text' =>$row_comment_text, 'posted_time'=> $row_posted_time,'privacy_code' => $row_privacy_code);
					array_push($dc_loop,$jsonRow);	
			}
$post_data = json_encode($dc_loop,JSON_FORCE_OBJECT);
echo $post_data;

     }
	elseif($own_associated_type == 'P' or 'V')
	{
			$query_comments_list = "SELECT * FROM comments_board WHERE associated_type IN ('P','V') and id='{$own_id}'";
			$res_commentsboard = pg_query($db_connection,$query_comments_list);
			$row_cb = pg_num_rows($res_commentsboard);
			$arr_cb = pg_fetch_all($res_commentsboard);
		   	$multi_loop = array(array());
			for($i = 0, $size = count($arr_cb); $i < $size; ++$i) {
  				 	$row_comment_id = $arr_cb[$i]['comment_id'];
					$row_mem_id = $arr_cb[$i]['mem_id'];
					$query_user_id = "SELECT user_id from user_account_details where mem_id='{$row_mem_id}'";
					$res_user_id = pg_query($db_connection,$query_user_id);
					$row_username = pg_fetch_result($res_user_id,'user_id');
                    $row_id = $arr_cb[$i]['id'];
					$row_associated_type = $arr_cb[$i]['associated_type'];
					$row_comment_text = $arr_cb[$i]['comment_text'];
					$row_posted_time = $arr_cb[$i]['posted_time'];
					$row_privacy_code = $arr_cb[$i]['privacy_code'];
				  	$jsonRow = array('comment_id' => $row_comment_id,'mem_id' => $row_mem_id,'user_id' => $row_username,'id' => $row_id, 'associated_type' => $row_associated_type, 'comment_text' =>$row_comment_text, 'posted_time'=> $row_posted_time,'privacy_code' => $row_privacy_code);
					array_push($multi_loop,$jsonRow);	
			}
$post_comments = json_encode($multi_loop,JSON_FORCE_OBJECT);
echo $post_comments;
	}
	pg_close($db_connection);
}
?>