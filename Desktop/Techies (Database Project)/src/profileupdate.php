<?php include 'dbconnection_setting.php' ?>
<?php 
    session_start();
    $own_mem_id = $_SESSION['mem_id'];
    if(isset($_POST['phone_num'])){
		 $con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	    $new_phone_num = $_POST['phone_num'];
		$new_l1address = $_POST['line1Add'];
		$new_l2address = $_POST['line2Add'];
		$new_city = $_POST['city'];
		$new_state = $_POST['state'];
		$new_country = $_POST['country'];
		$new_zipcode = $_POST['zipcode'];
	    $query_update_meminfo = "UPDATE member_info SET phone_no = '$new_phone_num',line1 = '$new_l1address',line2 = '$new_l2address',city = '$new_city',state = '$new_state',country = '$new_country',zip_code = '$new_zipcode' WHERE mem_id = '{$own_mem_id}' and del_flag = 'false'"; 
		$result_update_meminfo = pg_query($con, $query_update_meminfo);
        if($result_update_meminfo){
            //create json and send
            
            $post_data = json_encode(array(
  
    'phone_no' => $new_phone_num,
    'l1address' => $new_l1address,
    'l2address' => $new_l2address,
    'city' => $new_city,
    'state' => $new_state,
   'country' => $new_country,
    'zipcode' => $new_zipcode
  
), JSON_FORCE_OBJECT);
            echo $post_data;
        }
        else{
            echo "Can't update";
        }
	    $row_update_meminfo = pg_affected_rows($result_update_meminfo); 
		pg_close($con);}
	   ?>