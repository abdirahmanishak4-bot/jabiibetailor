<?php
require_once('function.php');
dbconnect();
session_start();

if (!is_user()) {
	redirect('index.php');
}

?>

		

<?php
 $user = $_SESSION['username'];
$usid = $pdo->query("SELECT id FROM users WHERE username='".$user."'");
$usid = $usid->fetch(PDO::FETCH_ASSOC);
 $uid = $usid['id'];
 include ('header.php');
 ?>

    <style>
    .order-card{
        background:#fff;
        border-radius:10px;
        border:none;
        border-top:4px solid var(--brand,#0d9488);
        box-shadow:0 2px 10px rgba(15,43,40,.08);
        margin-bottom:24px;
    }
    .order-card .panel-heading{
        background:linear-gradient(135deg,#0f766e,#0d9488);
        color:#fff;
        border-radius:10px 10px 0 0;
        font-size:16px;
        font-weight:600;
        padding:14px 18px;
    }
    .order-card .panel-heading .fa{
        margin-right:8px;
    }
    .order-card .panel-body{
        padding:22px;
    }
    .view-orders-btn{
        background:linear-gradient(135deg,#0f766e,#0d9488);
        color:#fff !important;
        border:none;
        border-radius:6px;
        padding:8px 18px;
        font-weight:600;
        box-shadow:0 2px 6px rgba(15,43,40,.18);
    }
    .view-orders-btn:hover{
        background:linear-gradient(135deg,#0d9488,#14b8a6);
        color:#fff !important;
    }
    .order-form-group{
        margin-bottom:20px;
    }
    .order-form-group label{
        color:#0f766e;
        font-weight:600;
        margin-bottom:6px;
    }
    .order-form-group label .fa{
        width:16px;
        text-align:center;
        margin-right:4px;
    }
    .order-input{
        width:100% !important;
        height:42px !important;
        border:2px solid #ccfbf1 !important;
        border-radius:8px !important;
        background:#f8fffe;
        box-shadow:none !important;
        transition:border-color .15s ease, box-shadow .15s ease;
    }
    textarea.order-input{
        height:auto !important;
    }
    .order-input:focus{
        border-color:#0d9488 !important;
        box-shadow:0 0 0 3px rgba(13,148,136,.15) !important;
        background:#fff;
    }
    .order-submit-btn{
        background:linear-gradient(135deg,#0f766e,#0d9488) !important;
        border:none !important;
        border-radius:8px !important;
        font-weight:700;
        letter-spacing:.5px;
        padding:12px !important;
        box-shadow:0 3px 10px rgba(13,148,136,.3);
    }
    .order-submit-btn:hover{
        background:linear-gradient(135deg,#0d9488,#14b8a6) !important;
    }
    </style>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-header">Add Customer</h1>
                </div>
                <div class="col-lg-4 text-right" style="padding-top:28px;">
                    <a href="customerview.php" class="btn view-orders-btn"><i class="fa fa-list"></i> View / Edit Customer</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">

                <div class="panel order-card">
                <div class="panel-heading"><i class="fa fa-plus-circle"></i>Add Customer</div>
                <div class="panel-body">

		<?php

if($_POST)
{

$fullname = trim($_POST["fullname"]);
$address = trim($_POST["address"]);
$phonenumber = trim($_POST["phonenumber"]);
$sex = $_POST["sex"];
$email = trim($_POST["email"]);
$city = trim($_POST["city"]);
$comment = $_POST["comment"];

if($fullname == '' || $address == '' || $phonenumber == '' || $email == '' || $city == ''){

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Fadlan buuxi dhammaan xaqiiqda loo baahan yahay (Full Name, Address, Phone Number, City, Email).

</div>";

} else {

$res = $pdo->exec("INSERT INTO customer SET fullname='".$fullname."', address='".$address."', phonenumber='".$phonenumber."', sex='".$sex."',`email`='".$email."',`city`='".$city."',`comment`='".$comment."'");
$cid = $pdo->lastInsertId();
if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Customer Added Successfully!

</div>
<meta http-equiv='refresh' content='2; url=addmeasurement.php?id=$cid' />
";


}

}



} 
	?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
				
				
				
				
				    <form action="customeradd.php" method="post">

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-user"></i>Full Name</label>
                            <input type="text" name="fullname" class="form-control order-input" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-map-marker"></i>Address</label>
                            <input type="text" name="address" class="form-control order-input" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-phone"></i>Phone Number</label>
                            <input type="text" name="phonenumber" class="form-control order-input" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required minlength="7" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-building"></i>City</label>
                            <input type="text" name="city" class="form-control order-input" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-envelope"></i>Email</label>
                            <input type="email" name="email" class="form-control order-input" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-venus-mars"></i>Sex</label>
                            <select name="sex" class="form-control order-input">
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="order-form-group">
                            <label><i class="fa fa-comment"></i>Comment</label>
                            <textarea rows="4" name="comment" class="form-control order-input"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-lg btn-success btn-block order-submit-btn" value="ADD">
                    </div>
                </div>

			    	</form>

                </div><!-- /.panel-body -->
                </div><!-- /.order-card -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
	    



<script src="js/bootstrap-timepicker.min.js"></script>


<script>
jQuery(document).ready(function(){
    
  
  jQuery("#ssn").mask("999-99-9999");
  
  // Time Picker
  jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

  
});
</script>







<?php
 include ('footer.php');
 ?>