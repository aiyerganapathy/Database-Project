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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photos</title>

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
    <script src="assets/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
	 refreshTable();
	 uploadphoto();
	 });
   function unloadTable(){
	 	$('#latestphoto').unload();

   }
   function refreshTable(){


                    $.ajax({
                type: 'GET',
				url: "Display_Photo.php",
                contentType:false,
             	cache:false,
                processData:false,
                dataType: "json",
                success: function(response){
					       	console.log(response);
							for(var key in response){
           						 response[key]= ""+response[key].trim();
        					}
                        console.log(response)
							var template = $("#latestPic").html();
							var html_temp=Mustache.to_html(template, response);
							$('#latestphoto').html(html_temp);
							}
			});




	 }
	function uploadphoto(){
		 $('#PhotoUploadForm').submit(function(event){
         $.ajax({
                type: 'POST',
                data: new FormData(this),
                contentType:false,
             	cache:false,
             	processData:false,
                url: 'Upload_Image.php',
             	success: function(data) {
                    alert(data);
					$("#message").html(data);
                    $('#message').css("display", "block");
					unloadTable();
					refreshTable();
                }
            });
	   return false;
     });
	}
	</script>
   	</head>
<body>
    <script type="text/html" id="latestPic">
  <div>
        <div class="article_head">
                <h5><b>Title:  {{title}}</b></h5>
        </div><br/>
        <div class="article_body">
				<img src='{{multimedia_fname}}' />
        </div>
        <p class="article_comments"> <a class="comments" href="Comments.php?id={{multimedia_id}}&type=P"><span>Comments ({{comment_count}})</span></a> </p>
        <div class="article_head"></div>
  </div>
</script>
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
    <div class=""><span class="spicy col-xs-6">Photo</span><span class="blog col-xs-6">Entries</span><br/></div>
    <br/><br/>
    <div class="col-md-6">
    <div class="panel panel-success" style="width=750px;height=750px">
    <div class="panel-heading">Latest Photo Uploaded</div>
    <div class="panel-body" style="padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color: white;overflow:scroll">
    <div id="Page">
    <div id="article1">
        <div class="article_head">
                <h5>Photo Title</h5>
                <h4>Posted on:date</h4>
        </div><br/>
        <div class="article_body">
           <div id="latestphoto">
           </div>

        </div>
        </div>

    </div>
    </div>
    </div></div>
    <div class="col-md-6">
    <div class="panel panel-success" style="width=750px;height=750px">
    <div class="panel-heading">Upload Photo</div>
    <div class="panel-body" style="padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color: white;overflow:scroll">
    <div id="Page">
    <div id="article1">
    <div class="text-center col-lg-12">
             <form role="form" id="PhotoUploadForm" class="text-center" method="post" enctype="multipart/form-data">
               <div >
                <div class="form-group">
                  <label for="photo_title">Photo Title</label>
                  <input type="text" class="form-control" id="photo_title" name="photo_title" placeholder="Photo_title"></input>
                  <span class="help-block" style="display: none;">Please enter the photo title.</span>
                </div>
                <br/>
                <div class="form-group"><label>Privacy:</label>
                       	<select style="width:300px" class="form-control" id="privacy" name="privacy">
                                               <option value="1">Private</option>
                                               <option value="2">Friends</option>
                                               <option value="3">Friends of Friends</option>
                                               <option value="4">Public</option>
                </select></div></br>
                <div class="form-group">
                       <label for="fileToUpload">Image Upload</label><br/>
                       <input type="file" name="fileToUpload" id="fileToUpload" class="btn-sm form-control"></input>
   					   <button type="submit" id="photoSubmit" name="photoSubmit"class="btn-sm" style="margin-top: 10px;">Upload Photo</button>
                     <br/>
                     <!--<input id="photoSubmit" name="photoSubmit" type="submit" value="photoSubmit" class="btn-sm" style="margin-top:10px;margin-left:175px"></input>-->

                </div>
                <div id="message" name="message"></div>
		        </div>
                <br/>

               </form>
    </div>
	</div>
    </div>
    </div>
    </div>
    </div>
	</nav>
 <div id="footer-sec">&copy; 2016 Techies.com| Design By :Grads at NYU </div>
</body>
</html>
