      <?php include 'dbconnection_setting.php' ?>
             <?php
                 $own_id=$_SESSION['mem_id'];
                 $search=$_POST['search'];
                 $query="select mem_id from member_info where f_name ilike '%'||$search||'%' or m_name ilike '%'||$search||'%' or l_name ilike '%'||$search||'%' union select mem_id from profile where keywords ilike '%'||$search||'%' or profile_string ilike '%'||$search||'%'";
                 $db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
	//$query_max_comment = "SELECT max(comment_id) from comments_board";
	$res= pg_query($db_connection,$query);
	$res_array = pg_fetch_all($res);
                $multi_loop=array(array());
	for($i = 0, $size = count($res_array); $i < $size; ++$i) {
  				 	$row_mem_id = $res_array[$i]['mem_id'];
					$query_user_id = "SELECT user_id from user_account_details where mem_id='{$row_mem_id}'";
					$res_user_id = pg_query($db_connection,$query_user_id);
					$row_username = pg_fetch_result($res_user_id,'user_id');
                    
				  	$jsonRow = array('mem_id' => $row_mem_id,'user_id' => $row_username);
					array_push($multi_loop,$jsonRow);	
			}
$post_people = json_encode($multi_loop,JSON_FORCE_OBJECT);
            echo $post_people;        
                 ?>