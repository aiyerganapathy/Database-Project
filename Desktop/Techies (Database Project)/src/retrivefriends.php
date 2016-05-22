<?php include 'dbconnection_setting.php' ?>

<?php

session_start();

$own_mem_id = $_SESSION['mem_id'];


$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
$sql = 'SELECT friend1($1)';
$res = pg_prepare($con, "my_query", $sql);
$res = pg_execute($con, "my_query", array($own_mem_id));




$rows = pg_num_rows($res);
$de_loop = array(array());

while ($row = pg_fetch_assoc($res)) {

    $jsonRow = array ('row' => $row );

    array_push($de_loop,$jsonRow);

}

$post_data = json_encode($de_loop,JSON_FORCE_OBJECT);

echo $post_data;

pg_close($con);



?>