<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	$own_mem_id = $_SESSION['mem_id'];

}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Messages</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
        $('#MessageSentForm').submit(function(event){
         $.ajax({
                type: 'POST',
                data: new FormData(this),
                contentType:false,
             cache:false,
             processData:false,
                url: 'setmessages.php',
             success: function(data) {
                    alert(data);
                    $("#message").html(data);
                    $('#message').css("display", "block");
                    $('#Message_Text').val('');
                    $('#to_user_id').val('');
                   
                }
            });
	   return false;	 
     });	 
	 
        $('#SearchFriendsForm').submit(function(event){
        $.ajax({
               type: 'POST',
			   data: new FormData(this),
			   contentType:false,
             	cache:false,
                processData:false,
				url: "ViewMessagesFromUser.php",
				dataType: "json",
				//url: "Check.php",
               success: function(response_data){
			      $('#searched_user_messages').empty();
                   console.log(response_data);
                   $.each(response_data, function(key,val) {
                        $(val).each(function(idx1,obj1){
                            if(Object.keys(obj1).length!==0){
                            var template = $("#message_username").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#searched_user_messages').append(html_temp);}
							}); 
                        });
                     
               }
                    	
				});
        return false;
		
    });
        
    });
    </script>
</head>

<body style="background-color:#00CA79">
<script type="text/html" id="message_username">
  <div>
        <div class="article_head">
                <h5><b>From:  {{from_mem_username}}</b></h5>
                <h5><b>To:  {{to_mem_username}}</b></h5>
                <h4>Posted on:{{sent_time}}</h4>
        </div><br/>
        <div class="article_body">
                <p> {{body}} </p>
        </div>
  </div>
</script>
<script type="text/html" id="comment_content">
  <div>
        <div class="article_head">
                <h5><b>Posted by:  {{mem_id}}</b></h5>
                <h4>Posted on: {{posted_time}}</h4>
        </div><br/>
        <div class="article_body">
                <p>{{comment_text}}</p>
        </div>
        
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
    </div>
    <nav class="navbar navbar-default navbar-cls-top "></nav><br/>
    <div style="margin-left: 300px;margin-right:200px">
    <div style="margin-top:50px"><span class="spicy col-xs-8" style="float:center">Messages</span><br/><hr style="width:1200px"></div>
    </div>
  </header>
  <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
               	    <li>
                        <a class="active-menu"   href="ViewFriends.php">View Friends</a>
                    </li>
                    <li>
                        <a class="active-menu"  href="SearchFriends.php">Search Friends</a>
                    </li>      
                    <li>
                        <a class="active-menu"   href="Messages.php">Messages</a>
                    </li> 
                </ul>

            </div>

        </nav>
<article >
  <section>   
 <div class="col-md-12" style="margin-left:300px;">   
    <div class="panel panel-success" style="width:1200px;height:750px;overflow:scroll">
    <div class="panel-heading" style="width:1250px;padding-left:600px">Compose Message</div>
    <div class="panel-body" style="padding-left: 235px;padding-right: 75px;height:550px;border-top-width: 5px;background-color: white;text-overflow:wrap">
    <div id="Page"> 
    <div id="article1">   
    <div class="text-center col-md-12" style="margin-left:200px"> 
              <div  >
              <form role="form" id="MessageSentForm" class="text-center" method="post" enctype="multipart/form-data">
               <div >
                <div class="form-group">
                  <label for="to_user_id" style="float:left">To :</label>
                  <input type="text" class="form-control" id="to_user_id" name="to_user_id" placeholder="User id of the Receiver">
                  <span class="help-block" style="display: none;">Please enter the receiver's user id.</span>
                </div>
                <br/> 
                <div class="form-group">
                  <label for="Message_Text" style="float:left">Message_Text</label>
                  <textarea rows="10" cols="100" class="form-control" id="Message_Text" name="Message_Text" placeholder="Message Text"></textarea>
                  <span class="help-block" style="display: none;">Please enter a message.</span>                  
                </div>
                <button type="submit" id="sendMessage" class="btn btn-primary btn-lg " style=" margin-top: 10px;">Send Message</button>
                <br/>
                </div> 
              </form> 
                  <br/>
                  <div id="message"></div>
               </div> 
                <br/> 
    </div>
	</div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-12" style="margin-left:300px">   
    <div class="panel panel-success" style="width:1200px;height:750px;overflow:scroll">
    <div class="panel-heading" style="width:1250px;padding-left:600px">View Messages from a User</div>
    <div class="panel-body" style="padding-left: 35px;padding-right: 75px;height:550px;border-top-width: 5px;background-color: white;text-overflow:wrap">
    <div id="Page"> 
    <div id="article1">   
    <div class="text-center" style="width:1150px"> 
         <div id="article1" align="center" >
    	 <div class="article_head" align="center" style="padding-left:300px;padding-right:100px">
          <form role="form" id="SearchFriendsForm" class="text-center" action="" method="post" enctype="multipart/form-data">
               <div >
                <div class="form-group">
                  <label for="user_id" style="float:left;margin-left:100px;margin-right:10px;margin-top: 10px;">User id</label>&nbsp;&nbsp;&nbsp;
                  <input type="text" class="form-control" style="width:320px;margin-right:10px" id="user_id" name="user_id" placeholder="Please enter the User Id of the Member">
                  <span class="help-block" style="display: none;">Please enter the user id</span>
                  <button type="submit" id="searchMessages" class="btn btn-sm" style="float:left;">Search Messages</button>
                </div>
                </div>
          </form>
          <hr>
         </div>
         <div class="article_body" style="width:1200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color:#dff0d8;overflow:scroll;">
             <div id="searched_user_messages"></div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
               
    </div>
    </div>
  </section>
    </article>
</body>
</html>
