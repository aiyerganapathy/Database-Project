<?php include 'dbconnection_setting.php' ?>
<?php 
    session_start();
    $own_mem_id = $_SESSION['mem_id'];
    if(isset($_POST['profileText'])){
	    $con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	    $profile_string = $_POST['profileText'];
	    $query_update_profile = "UPDATE profile SET profile_string = '$profile_string' WHERE mem_id = '{$own_mem_id}' and del_flag = 'false'"; 
		$result_update_profile = pg_query($con, $query_update_profile);  
	    $row_update_profile = pg_affected_rows($result_update_profile);
	    if($result_update_profile){
            echo $profile_string;
        }
        else{
            echo "Can't update";
        }
        pg_close($con);
        }
	   ?>