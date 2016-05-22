<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Notifications</title>
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
  
	<link href="AboutPageAssets/styles/aboutPageStyle.css" rel="stylesheet" type="text/css">

</head>

<body style="background-color:#00CA79">
<!-- Header content -->
<header>
  <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top ">
            <div class="navbar-header">
              <a class="navbar-brand">Techies.com</a>
            </div>
            <div class="form-inline header-right">
            	<label>Username :</label>&nbsp;
		  		<?php
		    	$name = 'Ashmita Gopal';
				echo $name;
				?>
          		<a href="Reg_Login.php" class="btn btn-danger" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>
            </div>
	    </nav>

     	<nav class="secondary_header" id="menu">
      		<ul>
        	<li>ABOUT</li>
        	<li>FRIENDS</li>
        	<li>PHOTOS</li>
        	<li>VIDEOS</li>
        	<li>NOTIFICATIONS</li>
        	<li>SETTINGS</li>
      		</ul>
    	</nav>
    </div>
    <nav class="navbar navbar-default navbar-cls-top "></nav><br/>
    <div style="margin-left: 200px;margin-right:200px">
    <div style="margin-top:50px"><span class="spicy col-xs-6" style="float:center">Notifications</span><br/><hr></div>
    </div>
  </header>
 <article >
 <section>   
    <div class="col-md-12" style="margin-left:200px">   
    <div class="panel panel-success" style="width:1500px;height:750px;overflow:scroll">
    <div class="panel-heading" style="width:1500px;padding-left:550px">View Notifications</div>
    <div class="panel-body" style="padding-left: 35px;padding-right: 75px;height:550px;border-top-width: 5px;background-color: white;text-overflow:wrap">
    <div id="Page"> 
    <div id="article1">
    <p>/*scroll of all the entries in activity tracker folder in a friendly text format
    
    
    something like this :
    
    $sql = "SELECT id, activity_desc, type,associated_id FROM Activity_Tracker";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
   		 // output data of each row
   		 while($row = $result->fetch_assoc()) {
			 if($row["type"] = "Friend"){
				 echo "id: " . $row["id"]. "is now friends with " . $row["associated_id"]."<br>";
			 }
			 else if ($row["type"] = "Photo"){
				 echo "id: " . $row["id"]. "uploaded a new photo " . $row["associated_id"]."<br>";
		     }
			 else if ($row["type"] = "Video"){
				 echo "id: " . $row["id"]. "uploaded a new video " . $row["associated_id"]."<br>";
		     }
		  }
		} 
        else {
   			 echo "0 results";
		}
    */</p>
    </div>
    </div>
	</div>
	</div>
	</div>               
 </section>
 </article>
</body>
</html>