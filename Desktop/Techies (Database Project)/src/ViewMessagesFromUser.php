<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
$from_user_name = $_POST['user_id'];
$own_mem_id =$_SESSION['mem_id'];
$query_from_user_id="(select mem_id from user_account_details where user_id='{$from_user_name}')";
$res_memid = pg_query($con,$query_from_user_id);
$from_user_id = pg_fetch_result($res_memid,'mem_id');
$query_messages_list = "(select * from (select * from message_details where from_id='{$own_mem_id}' and to_id='{$from_user_id}' union select * from message_details where from_id='{$from_user_id}' and to_id='{$own_mem_id}' ) as t order by sent_time);";
$res_messages = pg_query($con,$query_messages_list);
$row_messages = pg_num_rows($res_messages);
$arr_messages = pg_fetch_all($res_messages);
$dc_loop = array(array());
for($i = 0, $size = count($arr_messages); $i < $size; $i++) {
  					$row_message_id = $arr_messages[$i]['message_id'];
					$row_from_mem_id = $arr_messages[$i]['from_id'];
					$query_from_user_id = "SELECT user_id from user_account_details where mem_id='{$row_from_mem_id}'";
					
                    $res_from_user_id = pg_query($con,$query_from_user_id);
					$row_from_username = pg_fetch_result($res_from_user_id,'user_id');
					
                    $row_to_mem_id = $arr_messages[$i]['to_id'];
					$query_to_user_id = "SELECT user_id from user_account_details where mem_id='{$row_to_mem_id}'";
					
                    $res_to_user_id = pg_query($con,$query_to_user_id);
					$row_to_username = pg_fetch_result($res_to_user_id,'user_id');
                   
                    $row_body = $arr_messages[$i]['body'];
					$row_sent_time = $arr_messages[$i]['sent_time'];
					$jsonRow = array('message_id' => $row_message_id,'from_mem_username' => $row_from_username,'to_mem_username' => $row_to_username,'body' => $row_body, 'sent_time' => $row_sent_time);
					array_push($dc_loop,$jsonRow);			
}
    $json_data=json_encode($dc_loop, JSON_FORCE_OBJECT);
    echo $json_data;
}
?>