
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
$search = $_POST['search'];
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
$sql = 'SELECT deep_search_people_with_text($1,$2)';
$sql_prepare = pg_prepare($con, "search_people", $sql);
$res = pg_execute($con, "search_people", array($search,$own_mem_id));
$noofrows = pg_num_rows($res);
$de_loop = array(array());
$records = pg_fetch_all($res);
for($i=0;$i<$noofrows;$i++) {
	$str = $records[$i]['deep_search_people_with_text'];
	$str=explode(',',$str);
	$noofsplit = count($str);
	$mem_id = $str[0];
	$mem_id = substr($mem_id,1);
	$f_name = $str[1];
	$l_name = $str[2];
	$associated_type = $str[3];
	$temp = array();
	if( $noofsplit > 4){
		$counter=0;
		for( $j=4;$j<=$noofsplit;$j++){
			$temp[$counter] = $str[$j];
			$counter++;
			}
		$tempnew = implode(":",$temp);
	}
	else
	{
		$tempnew = $str[4];
	}
		
	$matches = $tempnew;
	
	$len_at=strlen($matches);
	$matches = substr($matches,0,($len_at-2));
	$jsonRow = array ('mem_id' => $mem_id,'f_name' => $f_name,'l_name' => $l_name,'matches' => $matches,'associated_type' => $associated_type );

    array_push($de_loop,$jsonRow);
}

$post_data = json_encode($de_loop,JSON_FORCE_OBJECT);

echo $post_data;
pg_close($con);

}
?>