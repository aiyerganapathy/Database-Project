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
    <title>Diary Entry</title>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script>
	$(document).ready(function(){
	 loadlatestDiaryEntry();
    $("#DiaryEntryViewForm").submit(function(){
        $.ajax({
               type: 'POST',
			   data: new FormData(this),
			   contentType:false,
             	cache:false,
                processData:false,
				url: "DE_Search.php",
				dataType: "json",
				//url: "Check.php",
               success: function(response_data){
			      $('#articlestable').empty();
                   console.log(response_data);
                   $.each(response_data, function(key,val) {
                        $(val).each(function(idx1,obj1){
                            if(Object.keys(obj1).length!==0){
                            var template = $("#listdiary_entry").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#articlestable').append(html_temp);}
							}); 
                        });
                     
               }
                    	
				});
        return false;
		
    });
	 $('#DiaryEntryUploadForm').submit(function(event){
         $.ajax({
                type: 'POST',
                data: new FormData(this),
                contentType:false,
             cache:false,
             processData:false,
                url: 'UploadDiaryEntry.php',
             success: function(data) {
                    $("#message").html(data);
                    $('#message').css("display", "block");
					unloadTable();
					loadlatestDiaryEntry()
                    $('#diary_title').val('');
                    $('#diary_text').val('');
                   $('#fileToUpload').val('');
                }
            });
	   return false;	 
     });
	 });
		function loadlatestDiaryEntry() {
    	 $.ajax({
                type: "GET",
				url: "Display_LatestDiaryEntry.php",
                dataType: "json",
                success: function(response){
					       	console.log(response);
							for(var key in response){
           						 response[key]= ""+response[key].trim();
        					}
							var template = $("#latestDE").html();
							var html_temp=Mustache.to_html(template, response);
							$('#latestentry').html(html_temp);
							}
			});	
		}
		 function unloadTable(){
	   		$('#latestentry').unload();  
	   		}
    </script>

	
	
  	</head>
<body>
  <script type="text/html" id="latestDE">
  <div>
        <div class="article_head">
                <h5><b>Title:  {{DE_title}}</b></h5>
                <h4>Posted on:{{DE_dateposted}}</h4>
        </div><br/>
        <div class="article_body">
                <p>{{DE_text}}</p><br/>
				<img src='{{DE_pic_fname}}' />
        </div>
        <p class="article_comments"> <a class="comments" href="Comments.php?id={{DE_diary_id}}&type=D"><span>Comments ({{DE_comment_count}})</span></a> </p>
  </div>
</script>
    <script type="text/html" id="listdiary_entry">
  <div>
        <div class="article_head">
                <h5>{{diary_title}}</h5>
                <h4>Posted on:{{date_posted}}</h4>
        </div><br/>
        <div class="article_body">
                <p>{{diary_text}}</p>
				<br/>
				<img src='{{multimedia_fname}}' />
        </div>
        <p class="article_comments"> <a class="comments" href="Comments.php?id={{diary_id}}&type=D"><span>Comments ({{comment}})</span></a> </p>
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
    <div class=""><span class="spicy col-xs-6">Diary</span><span class="blog col-xs-6">Entries</span><br/></div>
    <br/><br/>
    <div class="col-md-6">
    <div class="panel panel-success" style="width=750px;height=750px">
    <div class="panel-heading">Latest Diary Entry</div>
    <div class="panel-body" style="padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color: white;overflow:scroll">
    <div id="Page" name="Latest_Diary_Entry">
    <div id="latestentry" name="article1" >
     
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6">
    <div class="panel panel-success" style="width=750px;height=750px">
    <div class="panel-heading">Create Diary Entry</div>
    <div class="panel-body" style="padding-left: 200px;padding-right: 200px;height:550px;border-top-width: 5px;background-color: white;overflow:scroll">
    <div id="Page"> 
    <div id="article1">   
    <div class="text-center col-lg-12"> 
             <form role="form" id="DiaryEntryUploadForm" class="text-center" action="Upload_Image.php" method="post" enctype="multipart/form-data">
               <div >
                <div class="form-group">
                  <label for="diary_title">Diary Title</label>
                  <input type="text" class="form-control" id="diary_title" name="diary_title" placeholder="Diary_title">
                  <span class="help-block" style="display: none;">Please enter the diary title.</span>
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
   					  
                </div>
		        <div class="form-group">
                  <label for="diary_text">Diary Text</label>
                  <textarea rows="10" cols="100" class="form-control" id="diary_text" name="diary_text" placeholder="Diary Text"></textarea>
                  <span class="help-block" style="display: none;">Please enter a message.</span>
                  
                </div>
                <button type="submit" id="diarySubmit" class="btn btn-primary btn-lg " style=" margin-top: 10px;">Diary Upload</button>
                <br/>
                </div> 
                 
              </form>
            <br/>
        <div id="message"></div>
    </div>
	</div>
    </div>
    </div>
    </div>
    </div> 
    <div class="col-md-12">
    <div class="panel panel-success">
    <div class="panel-heading">Time Period for Diary Entry</div>
    <div class="panel-body" style="overflow:scroll" >
    <div>
    <div id="article11">
        <div class="article_head" align="center" style="padding-left:500px;padding-right:500px">
           <form role="form" id="DiaryEntryViewForm" class="text-center" method="post" enctype="multipart/form-data">
             <div align="center" style="padding-left:200px;padding-right:130px">
              <label style="text-indent: 5em;float:left"  for="fromdatepicker">From:</label>&nbsp;&nbsp;
              <input type="date" id="fromdatepicker" name="fromdatepicker"/>                 
              <label style="text-indent: 2em;float:left" for="todatepicker">To:</label>
              <input type="date" id="todatepicker" name="todatepicker"/>
              </div>
              <br/>
              <div align="center" style="margin-left:230px;margin-right:230px;margin-bottom:10px;">
              <button style="float:center" type="submit" id="searchDiaryEntry" name="searchDiaryEntry" class="btn btn-sm btn-default ">SearchDiaryEntry</button>
              </div>
              </form>
        </div> 
        <div id="articlestable">                   
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
