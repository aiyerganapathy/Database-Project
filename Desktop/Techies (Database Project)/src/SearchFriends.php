<?php include 'dbconnection_setting.php' ?>

<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	
	
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Search Friends</title>
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
    
            <style type="text/css">

                #tfnewsearch{
                    float:left;
                    padding:20px;
                }
                .textinput{
                    margin: 0;
                    padding: 5px 15px;
                    font-family: Arial, Helvetica, sans-serif;
                    font-size:14px;
                   }
                .tbutton {
                    margin: 0;
                    padding: 5px 15px;
                    font-family: Arial, Helvetica, sans-serif; 
                    font-size:12px;
                    outline: none;
                    cursor: pointer;
                    text-align: center;
                    text-decoration: none;
                    color: #ffffff;
                    border: solid 1px #0076a3; border-right:0px;
                    background: #0095cd;
                    background-color: #4CAF50;
                    border-top-right-radius: 5px 5px;
                    border-bottom-right-radius: 5px 5px;
                }

             </style>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    <script>
        $(document).ready(function() {
    $('#tfnewsearch').submit(function(event){
         $.ajax({
                type: 'POST',
                data: new FormData(this),
                contentType:false,
             cache:false,
             processData:false,
             dataType:'json',
                url: 'RetrieveSearchPeople.php',
             success: function(response_data) {
                   $('#message').empty();
                   $.each(response_data, function(key,val) {
                        $(val).each(function(idx1,obj1){
                            if(Object.keys(obj1).length!==0){
                                if(+obj1['associated_type']===1){
                            var template = $("#request_received").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#message').append(html_temp);}
                            else if(+obj1['associated_type']===2){
                            var template = $("#request_sent").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#message').append(html_temp);}
                            else if(+obj1['associated_type']===3){
                            var template = $("#Send_Friend_Request").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#message').append(html_temp);}
                            else if(+obj1['associated_type']===4){
                            var template = $("#Send_Friend_Request_FOF").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#message').append(html_temp);}
                            
                            else if(+obj1['associated_type']===5){
                            var template = $("#Friend").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#message').append(html_temp);}
                            }
							}); 
                        });

                }
            });
	   return false;	 
     });
        
        
       
        });</script>
</head>

<body style="background-color:#00CA79">
<!-- Header content -->
    <script type="text/html" id="request_received">
    <div class="article_head"></div>
        <div class="article_head">
                <h3><b>{{f_name}} {{l_name}}</b></h3>
                <button name="a" type="button" value="Accept Friend Request" onclick="acceptrequest({{mem_id}})">Accept Friend Request</button>
        </div><br/>
         <div class="article_head"></div>
  </div>
</script>
    <script type="text/html" id="request_sent">
    <div class="article_head"></div>
        <div class="article_head">
                <h3><b>{{f_name}} {{l_name}}</b></h3>
                <button name="b" type="button" value="Request Pending for approval" disabled>Request Pending for approval</button>
        </div><br/>
         <div class="article_head"></div>
  </div>
</script>
    <script type="text/html" id="Send_Friend_Request">
    <div class="article_head"></div>
        <div class="article_head">
                <h3><b>{{f_name}} {{l_name}}</b></h3>
                <button type="button" name="c" value="Add Friend" onclick="sendrequest({{mem_id}})">Add Friend</button>
        </div><br/>
         <div class="article_head"></div>
  </div>
</script>
    <script type="text/html" id="Send_Friend_Request_FOF">
    <div class="article_head"></div>
        <div class="article_head">
                <h3><b>{{f_name}} {{l_name}}</b></h3>
                <p>{{matches}}</p>
                <p> You have mutual friends</p>
                <button type="button" name="d" value="Add Friend" onclick="sendrequest({{mem_id}})">Add Friend</button>
        </div><br/>
         <div class="article_head"></div>
  </div>
</script>
    <script type="text/html" id="Friend">
    <div class="article_head"></div>
        <div class="article_head">
                <h3><b>{{f_name}} {{l_name}}</b></h3>
                <p>{{matches}}</p>
                <button type="button" name="e" value="Friend" onclick="viewfriend({{mem_id}})" > View Friend Profile</button>
        </div><br/>
         <div class="article_head"></div>
  </div>
</script>
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
    
    <nav class="navbar navbar-default navbar-cls-top "><br/>
    <div style="margin-left: 200px;margin-right:200px">
    <div style="margin-top:50px">
    <span class="spicy col-xs-6" style="float:center">Search</span>
    </div>
    </div>
 
    </nav>
   <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="active-menu" href="ViewFriends.php">View Friends</a>
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


       


        <div id="tfheader" class="col-md-6">
            <form id="tfnewsearch" method="post">
                <input type="text" class="textinput" name="search" size="50" maxlength="300">
                <input type="submit"  value="SEARCH " class="tbutton">

            </form>

        </div>
        <div class="article_body" style="padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color:#dff0d8;overflow:scroll;">
             <div id="message">
           
             
             </div>
        </div>
    </div>
    </div>
    </div>
    </div>
	</div>
    </section>
    </div>
    </header>
    <script>
        function acceptrequest(mem_id){
            $.ajax({
                type: 'GET',
            data: 'id='+ mem_id,
             cache:false,
             processData:false,
                url: 'acceptfriend.php',
             success: function(data) {
                    alert(data);
                 
                }
            });
        
            
        }
        function sendrequest(mem_id){
            $.ajax({
                type: 'GET',
            data: 'id='+ mem_id,
             cache:false,
             processData:false,
                url: 'friendrequest.php',
             success: function(data) {
                    alert(data);
                 
                }
            });
        
            
        }
        function viewfriend(mem_id){
             window.location.href = "ViewFriendsProfilePage.php?friend_id="+mem_id;
        
        }
       
    </script>
</body>
</html>