<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
$profilestring= "";
$own_fname = "";
$own_fname = "";
$own_mname = "";
$own_lname = "";
$own_email_id = "";
$own_dob = "";
$own_phone = "";
$own_l1address = "";
$own_l2address = "";
$own_state = "";
$own_country = "";
$own_city = "";
$own_zipcode = "";
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	$own_mem_id = $_SESSION['mem_id'];
	$db_connection = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass") or die('cannot connect to db') ;
    
	if(isset($_GET['friend_id'])){
	$friend_id = $_GET['friend_id'];
	$result_mem_info = pg_query($db_connection, "SELECT * from member_info where mem_id='{$friend_id}'") or die('cannot see table records');
	$row_mem_info = pg_num_rows($result_mem_info);
	if($row_mem_info == 1) {
		$own_fname = pg_fetch_result($result_mem_info,'f_name');
		$own_mname = pg_fetch_result($result_mem_info,'m_name');
		$own_lname = pg_fetch_result($result_mem_info,'l_name');
		$own_email_id = pg_fetch_result($result_mem_info,'email_id');
   		$own_dob =  pg_fetch_result($result_mem_info,'dob');
		$own_phone = pg_fetch_result($result_mem_info,'phone_no');
		$own_l1address = pg_fetch_result($result_mem_info,'line1');
		$own_l2address = pg_fetch_result($result_mem_info,'line2');
		$own_state = pg_fetch_result($result_mem_info,'state');
		$own_country = pg_fetch_result($result_mem_info,'country');
		$own_city = pg_fetch_result($result_mem_info,'city');
		$own_zipcode = pg_fetch_result($result_mem_info,'zip_code');
		
   
    $result_profile = pg_query($db_connection, "SELECT * from profile where mem_id='$friend_id'") or die('cannot see table records');
	$row_profile = pg_num_rows($result_profile);
    $profilestring = pg_fetch_result($result_profile,'profile_string');
	$privacy = pg_fetch_result($result_profile,'privacy_code');
	$profile_multimedia_id = pg_fetch_result($result_profile,'multimedia_id_ref');
	
	}
	pg_close($db_connection);
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ProfilePage</title>
<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- COLUMN FONTS -->
    <link href="assets/css/default.css" rel="stylesheet" />
    <link href="assets/css/multiColumnTemplate.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<link href="AboutPageAssets/styles/aboutPageStyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(document).ready(function(){
        loadprofilepic();
          });
    
    function loadprofilepic(){
        $.ajax({
                //var a=data; // This line shows error.
                        type: "GET",
                         contentType:false,
             cache:false,async:false,
             processData:false,
                        url: "Display_FriendProfilepic.php?friend_id="+<?php echo $friend_id ?>,
                        success: function(img){
                            
                            
                            $('#profilepic').html(img);
                            
                        }});

    }

    </script>
    </head>

<body>
<!-- Header content -->
<header>
   <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top ">
            <div class="navbar-header">
              <a class="navbar-brand">Techies.com</a>
            </div>
            <form method="post" action="logout.php">
            <div class="form-inline header-right">
            	<label>Username :</label>&nbsp;
		  		<?php
				$user=$_SESSION['user_name'];
				$name=explode("_",$user);
               
                echo ucfirst($name[0])." ".ucfirst($name[1]);
                ?>
                
          		<button class="btn btn-danger" id="logout" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a></button>
                
            </div></form>
	</nav>

     	<nav class="secondary_header" id="menu">
      		<ul>
        	<li><a href="ProfilePage.php">ABOUT</a></li>
<li><a href="ViewFriends.php">FRIENDS</a></li>
<li><a href="Photos.php">PHOTOS</a></li>
<li><a href="DiaryEntry.php">DAIRY ENTRY</a></li>
<!-- <li>NOTIFICATIONS</li> -->
<li><a href="Messages.php">MESSAGES</a></li>
      		</ul>
    	</nav>
    </div>
    <nav class="navbar navbar-default navbar-cls-top "><br/>
    <div style="margin-left: 200px;margin-right:200px">
    <div style="margin-top:50px"><span class="spicy col-xs-6" style="float:center">Profile</span><span class="blog col-xs-6">Page</span><br/></div>
  <!-- Profile details -->
  <section class="profileHeader">    
    <h1><label id="name" style="padding-left:270px"><?php echo $own_fname," ",$own_mname," ",$own_lname; ?></label></h1>
    <div id="profilepic" > 
    <!-- Profile photo --> 
    </div>
    <hr>
    <form role="form" id="ProfileTextUploadForm" class="text-center" method="post" enctype="multipart/form-data">
    <div style="margin-left:300px;width:1100px;height:80px;">
   <textarea style="width:500px;float:left;height:80px;word-wrap:normal;" type="text" id="profileText" name="profileText" placeholder="Profile Text : Please enter the Profile Text here"  readonly="true"><?php echo $profilestring;?></textarea>
    </div>
   
    </form>
  </section>
  <hr>
  <!-- content -->
<section class="mainContent"> 
  <!-- Contact details -->
  <section class="section1">
    <h2 class="sectionTitle">About</h2>
    <hr class="sectionTitleRule2">
    <form role="form" id="ProfileDetailsUpdateForm" class="text-center" method="post" enctype="multipart/form-data">
    <div class="section1Content">
      <p><label style="float:left;margin-right:15px;width: 60px;" for="email" id="l_email" title="Email :">Email :</label>
      <input id="email" value="<?php echo $own_email_id; ?>"  readonly="true" type="email" style="background: #00CA79;border:none;"/></br></p>
      <p><label style="float:left;margin-right:15px;width: 60px;" for="dob" id="l_dob" title="Dob :">Dob :</label>
      <input id="dob" value="<?php echo $own_dob; ?>" readonly type="date" style="background:#00CA79;border:none;width:160px;"/></br></p>
      <p><label style="float:left;margin-right:15px;width: 60px;" for="phone_num" id="l_phone" title="Phone :">Phone :</label>
      <input type="text" id="phone_num" name="phone_num"  readonly="true" value="<?php echo $own_phone; ?>" /></br></p>
      <p><label style="float:left;margin-right:15px;width: 70px;" for="address" id="l_address" title="Address :" >Address :</label></br></p>
      <address id="address">
      <p><input type="text" id="line1Add" name="line1Add"  readonly="true" value="<?php echo $own_l1address; ?>" placeholder="Line 2 Address" /></p>
      <p><input type="text" id="line2Add" name="line2Add"  readonly="true" value="<?php echo $own_l2address; ?>" placeholder="Line 2 Address" /><br/></p>
      <p><input type="text" id="city" name="city"  readonly="true" value="<?php echo $own_city; ?>" placeholder = "City" /></p>
      <p><input type="text" id="state" name="state"  readonly="true" value="<?php echo $own_state; ?>" placeholder="State" /><br/></p>
      <input type="text" id="country" name="country"  readonly="true" value="<?php echo $own_country; ?>" placeholder="Country" /> 
      <input type="text" id="zipcode" name="zipcode"  readonly="true" value="<?php echo $own_zipcode; ?>" placeholder="ZipCode" /> 
      </address>
      <br>
      
    </div>
    </form>
  </section>
 
 </section>
</div>
</nav>
</header>
<footer>
  <div id="footer-sec">2016 Techies.com| Design By :Grads at NYU </div>
</footer>
</body>
</html>
