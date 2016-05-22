<?php
session_start();
if(!isset($_SESSION['mem_id']))
    {
		header("location: Reg_Login.php");
		session_destroy();
            
    }
else{
	$own_mem_id = $_SESSION['mem_id'];
    $mult_id=$_GET['id'];
    $mult_type=$_GET['type'];
}?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Comments</title>
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
	$(document).ready(function(){
        var data_send = {};
		var id = <?php echo $mult_id; ?>;
		var type = '<?php echo $mult_type; ?>';
		
		refreshcomments();
       // alert (id);
       // alert(type);
        //console.log(data_send);
        $.ajax({
                type: 'GET',
            data: 'element_id='+ id+'&type='+ type,  
            dataType: "json",
             cache:false,
             processData:false,
                url: 'FetchPostedData.php',
             success: function(data) {
                  //  alert(data);
                 console.log(data);
                   for(var key in data){
           						 data[key]= ""+data[key].trim();
                                //alert(data[key]);
        					}
                                if(type==='D'){
                               // alert("here");    
                            var template = $("#content").html();
							var html_temp=Mustache.to_html(template, data);
							$('#element').append(html_temp);        
                                }
								else{
                    var template = $("#picture_content").html();
					var html_temp=Mustache.to_html(template, data);
					$('#element').append(html_temp);        
                               }
                }
            });
        
		
        $("#CommentSentForm").submit(function(){
			var id_val = <?php echo $mult_id; ?>;
			var type_val = '<?php echo $mult_type; ?>';
			$('#id').val(id_val);
			$('#type').val(type_val);
			var comment_text = $('#Comment_Text').val();
   			var privacy = $('#privacy').val();
			
			
			$.post("PostComment.php",{id: id,type: type_val, comment_text: comment_text,privacy: privacy},function(data) {
                    alert(data);
                    $("#done").html(data);
                    $('#done').css("display", "block")});
			
	     });
    });
	
	function refreshcomments(){
		var id = <?php echo $mult_id; ?>;
		var type = '<?php echo $mult_type; ?>';
		
		$.ajax({
                type: 'GET',
            data: 'element_id='+ id+'&type='+ type,  
            dataType: "json",
             cache:false,
             processData:false,
                url: 'Comments_For_ID.php',
             success: function(data) {
                   // alert(data);
                 console.log(data);
                   $('#comments_all').empty();
                    $.each(data, function(key,val) {
                        var count=0;
                        $(val).each(function(idx1,obj1){
                            if(Object.keys(obj1).length!==0){
                            
                            var template = $("#comment_content").html();
							var html_temp=Mustache.to_html(template, obj1);
							$('#comments_all').append(html_temp);
                            }
							}); 
                        });
                }
            });
	}
	function unloadTable(){
	   		$('#comments_all').unload();  
	   		}
    </script>
</head>

<body style="background-color:#00CA79">
<script type="text/html" id="content">
  <div>
        <div class="article_head">
                <h5><b>Title:  {{DE_title}}</b></h5>
                <h4>Posted on:{{DE_dateposted}}</h4>
        </div><br/>
        <div class="article_body">
                <p>{{DE_text}}</p>
                <img src='{{DE_pic_fname}}' />
        </div>
  </div>
</script>
    
    <script type="text/html" id="picture_content">
  <div>
        <div class="article_head">
                <h5><b>Title:  {{MD_title}}</b></h5>
                <h4>Posted on:{{MD_dateposted}}</h4>
        </div><br/>
        <div class="article_body">
                <img src='{{MD_fname}}' />
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
    <div style="margin-left: 200px;margin-right:200px">
    <div style="margin-top:50px"><span class="spicy col-xs-6" style="float:center">Comments</span><br/><hr></div>
    </div>
  </header>
 <article >
 <section>   
    <div class="col-xs-12" style="margin-left:200px">   
    <div class="panel panel-success" style="width:1500px;height:750px;overflow:scroll">
    <div class="panel-heading" style="width:1500px;padding-left:600px">View Messages from a User</div>
    <div class="panel-body" style="padding-left: 35px;padding-right: 75px;height:550px;border-top-width: 5px;background-color: white;text-overflow:wrap;float:left">
    <div id="Page"> 
    <div id="article1">
        <div class="article_head" style="width:1350px;">
            
        </div><br/>
        <div class="article_body" id="element" style="width:1350px;height:400px">
               
        </div>
       </div>
    <div id="article2">   
    <div class="text-center" style="width:1450px"> 
         <div id="article3" align="center" >
    	 <div class="article_head" align="center" style="padding-right:100px"></div>
          <hr>
          <div id="comments_all" class="article_body" style="width:1400px;padding-right: 200px;height:550px;border-top-width: 5px;background-color:#dff0d8;overflow:scroll;">
             
        </div>
         <div >
              <form role="form" id="CommentSentForm" class="text-center" method="post" enctype="multipart/form-data">
               <div >
               
                <br/> 
                <div class="form-group">
                  <label for="Message_Text" style="float:left">Comment Text</label>
                  <textarea rows="10" cols="100" class="form-control" id="Comment_Text" name="Comment_Text" placeholder="Write a Comment"></textarea>
                  <span class="help-block" style="display: none;">Please enter your comment.</span>    
                  <label style="float:left">Privacy:</label>
                       	<select style="width:300px" class="form-control" id="privacy" name="privacy">
                                               <option value="1">Private</option>
                                               <option value="2">Friends</option>
                                               <option value="3">Friends of Friends</option>
                                               <option value="4">Public</option>
                  </select></br>              
                </div>
                <button type="submit" id="postComment" class="btn btn-primary btn-lg " style=" margin-top: 10px;">Post Comment</button>
                <br/>
                 <input type="hidden" name="id" id="id" />
                 <input type="hidden" name="type" id="type" />
                   <div id="done"></div>
                </div> 
                <br/> 
              </form>  
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
