<?php include 'dbconnection_setting.php' ?>

<?php
session_start();




?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Friends</title>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {


            $.ajax({
                //var a=data; // This line shows error.

                type: "GET",
                contentType:false,
                cache:false,

                processData:false,
                url: "retrivefriends.php",
                dataType: "json",

                success: function(data){
                    //alert(data);
                    //console.log(data);

                    $('#friends_view').empty();
                   //console.log(data);
                   $.each(data, function(key,val) {
                        $(val).each(function(idx1,obj1){
                            if(Object.keys(obj1).length!==0){
                                var row_data=obj1['row'];
                                $.each(row_data, function(key1,value) {
                                    var friend=String(value).split(",");
                                    friend[0]=friend[0].substring(1);
                                    friend[1]=friend[1].substring(1,friend[1].length-1);
                                    friend[2]=friend[2].substring(0,friend[2].length-1);
                                    var friend_details={id:friend[0],full_name:friend[1],first_name:friend[2]};
                                    console.log(friend_details['id']);
                                    console.log(friend_details['full_name']);
                                    console.log(friend_details['first_name']);
                                    var template = $("#friendsview").html();
							         var html_temp=Mustache.to_html(template, friend_details);
							         $('#friends_view').append(html_temp);
                                });
                                }
							}); 
                        });
                    

                }});



        });
    </script>

</head>

<body style="background-color:#00CA79">
<script type="text/html" id="friendsview">
  <div>
        <div class="article_body">
                <p style="float: left;"><h3><b>{{full_name}}</b></h3></p>
        </div>
  </div>
</script>

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
                
          		<button class="btn btn-danger" id="logout" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>
                
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
    <div style="margin-top:50px"><span class="spicy col-xs-6" style="float:center">View</span><span class="blog col-xs-6">Friends</span><br/></div>
    </div>
  </header>
  <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="active-menu" href="SearchFriends.php">Search Friends</a>
                    </li>
                  
                    <li>
                        <a class="active-menu" href="Messages.php">Messages</a>
                    </li>
                </ul>
            </div>
   </nav>
    <section style="margin-left:100px" >
	<div style="margin-left: 200px;margin-right:200px">    
    <div class="col-md-12">
    <div class="panel panel-success">
    <div class="panel-heading"></div>
    <div class="panel-body" style="overflow:scroll" >
    <div>
    <div id="article1">
         <div class="article_body" padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color:#dff0d8;>
               <form role="form" id="ViewFriendsForm" class="text-center" action="" method="post" enctype="multipart/form-data">
                  <div id="friends_view"></div>
               </form>
         </div>
    </div>
    </div>
    </div>
    </div>
	</div></div>
    </section>
</body>
</html>
