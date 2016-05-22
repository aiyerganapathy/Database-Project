<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration_Login</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
   <!-- <link href="assets/css/custom.css" rel="stylesheet" />-->
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- CALENDAR FONTS -->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script>
   $(document).ready(function() {
	$("#register").click(function(){
					var input=$("#fname");
					var is_fname=input.val();
					if(!is_fname || String(is_fname).length>25){
                        alert("Invalid First name");
                    }
                    var input=$("#mname");
					var is_mname=input.val();
					if(!is_mname || String(is_mname).length>25){
                        alert("Invalid middle name");
                    }
                    var input=$("#lname");
					var is_lname=input.val();
					if(!is_lname || String(is_lname).length>25){
                        alert("Invalid last name");
                    }
					var input=$('#emailid');
					var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
					var is_email=re.test(input.val());
					if(!is_email){alert("Invalid email");}
					
					var input = $('#fileToUpload');
					var is_file = input.val();				
					if(is_file == ''){alert("file not selected");}
                    
					var input=$('#password_register');
                    var is_pwd=input.val();
					if(!is_pwd){alert("Invalid pwd");}
                    
                    var input=$('#repassword');
                    var is_repwd=input.val();
					if(!is_repwd||is_repwd!==is_pwd){alert("Invalid pwd");}
                    var input=$("#l1Address");
					var is_address1=input.val();
					if(!is_address1 || String(is_address1).length>50){
                        alert("Invalid address");
                    }
                    var input=$("#l2Address");
					var is_address2=input.val();
					if(String(is_address2).length>50){
                        alert("Invalid address");
                    }
                    var input=$("#state");
					var is_state=input.val();
					if(!is_state || String(is_state).length>25){
                        alert("Invalid state");
                    }
                    var input=$("#city");
					var is_city=input.val();
					if(!is_city || String(is_city).length>25){
                        alert("Invalid city");
                    }
                    var input=$("#country");
					var is_country=input.val();
					if(!is_country || String(is_country).length>50){
                        alert("Invalid country");
                    }
                    var input=$("#zip");
					var is_zip=input.val();
					if(!is_zip || String(is_zip).length>8||!is_zip.match(/^\d+$/)){
                        alert("Invalid zip");
                    }
                    var input=$("#datepicker");
                    var is_date=input.val();
					if(!is_date){
                        alert("Invalid date");
                    }
                    var input=$("#keywords");
                    var is_keyword=input.val();
					if(!is_keyword ||String(is_keyword).length>50){
                        alert("Invalid keywords");
                    }
				});
				
   
       $('#LoginForm').submit(function(event){
         $.ajax({
                type: 'POST',
                data: new FormData(this),
                contentType:false,
             cache:false,
             processData:false,
                url: 'Login_authentication.php',
             success: function(data) {
                 var title=($(data).filter('title').text());
                 if(title==="ProfilePage"){
                 window.location.replace('ProfilePage.php');}
                 else{
                     alert("Wrong username or password");
                     window.location.replace('Reg_Login.php');
                     
                 }
            }});
	   return false;	 
     });
	});
	</script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top ">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><em>Techies.com</em></a>
            </div>
          <form id="LoginForm" name="LoginForm" method="post">
            <div class="form-inline header-right"><label>Username </label>&nbsp;
          	<input class="form-control" id="user_name" name="user_name" type="text"></input>
         	 <label>Password </label>&nbsp;
          	<input class="form-control" id="password" name="password" type="password"></input>
          	<button type="submit" id="Login" name="Login" class="btn btn-danger">Login</button>
         	 </div>
          </form>

		</nav>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                      <h1 class="page-head-line"> SIGN UP</h1>
                    </div>
                </div>
            	<div class="row">
           		 <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="panel panel-info">
                      <div class="panel-body">
                            <form role="form" id="RegistrationForm" name="RegistrationForm" method="post" action="RegisterMember.php" enctype="multipart/form-data">
                               <div class="form-inline">
                                   <div class="form-group">
                                     <input class="form-control" type="text" id="fname" name ="fname" style="width:300px" placeholder="First name"/>
                                   </div>
                                   <div class="form-group">
                                     <input class="form-control" type="text" id="mname" name="mname" style="width:300px" placeholder="Middlename"/>
                                   </div>
                                   <div class="form-group">
                                     <input class="form-control" type="text" id="lname" name="lname" style="width:300px" placeholder="Last name"/>
                                   </div>
                                </div><div id="error_name" style="display: none;"></div><hr>
                                <div class="form-group">
                                     <input class="form-control" type="text" id="emailid" name="emailid" style="width:300px" placeholder="Email id"/>
                                </div><hr>  
                                <div class="form-group">
                                     <input class="form-control" type="password" id="password_register" name="password_register" style="width:300px" placeholder="Password"/>
                                </div><hr>      
                                <div class="form-group">
                                <input class="form-control" type="password" id="repassword" name="repassword" style="width:300px" placeholder="Re type Password"/>                                </div> <hr> 
                                <div class="form-group">
                                <input class="form-control" type="number" id="phonenum" name="phonenum" style="width:300px" placeholder="Phone Number" min="1000000000" max="9999999999"/> 
                                </div> <hr> 
                                <div class="form-group">
                                    <input class="form-control" type="text" id="l1Address" name="l1Address" style="width:300px" placeholder="Line 1 Address">
                                    <input class="form-control" type="text" id="l2Address" name="l2Address" style="width:300px" placeholder="Line 2 Address">
                                    <input class="form-control" type="text" id="city" name="city" style="width:300px" placeholder="City">
                                    <input class="form-control" type="text" id="state" name="state" style="width:300px" placeholder="State">
                                    <input class="form-control" type="text" id="country" name="country" style="width:300px" placeholder="Country">                                	<input class="form-control" type="text" id="zip" name="zip" style="width:300px" placeholder="ZipCode"><div id="email_error" visible="false"></div>                  
                                 </div><hr>
                                 <div class="form-group">
                        		 <label>Gender:</label>
                        		 <select style="width:300px" class="form-control" id="gender" name="gender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                         		</select>
                               </div><hr>
        <div class="form-group">
                        		 <label>Privacy:</label>
                        		 <select style="width:300px" class="form-control" id="privacy" name="privacy">
                                                <option value="1">Private</option>
                                                <option value="2">Friends</option>
                                                <option value="3">Friends of Friends</option>
                                                <option value="4">Public</option>
                         		</select>
                               </div><hr>                        
        <div><label for="dob">Date of birth:</label>
            <input type="date" id="datepicker" name="datepicker" style="width:300px" class="form-control" />
        </div>
        <hr>
        
         <div class="form-group">
           <label for="photo_title">Profile Photo</label>
          </div>
         <div class="form-group">
             <label for="fileToUpload">Image Upload</label><br/>
             <input type="file" name="fileToUpload" id="fileToUpload" class="btn-sm form-control"></input>
   			  <label for="keywords">Key Words:</label>
            <input type="text" id="keywords" name="keywords" style="width:300px" class="form-control" />
        </div> 
    
      <hr>
     <br>    
     <input id="register" name="register" type="submit" value="Register Now" class="btn btn-danger"> </input>              			
</form>
 </div>
 </div>                              
<div id="footer-sec">
        &copy; 2016 Techies.com| Design By :Grads at NYU </div>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
   
     
</body>
</html>
