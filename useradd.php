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
    .order-form-group{
        margin-bottom:20px;
    }
    .order-form-group label{
        color:#0f766e;
        font-weight:600;
    }
    .order-input{
        border:1.5px solid #cbeee7;
        background:#f6fffd;
    }
    .order-input:focus{
        border-color:#0d9488;
        box-shadow:0 0 0 3px rgba(13,148,136,.15);
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
                    <h1 class="page-header">Add User</h1>
                </div>
                <div class="col-lg-4 text-right" style="padding-top:28px;">
                    <a href="userview.php" class="btn view-orders-btn"><i class="fa fa-list"></i> View / Edit Users</a>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">

                <div class="panel order-card">
                <div class="panel-heading"><i class="fa fa-user-plus"></i>Add User</div>
                <div class="panel-body">

		<?php

if($_POST)
{

$username = trim($_POST["username"]);
$password = $_POST["password"];
$fullname = trim($_POST["fullname"]);
$address = trim($_POST["address"]);
$phonenumber = trim($_POST["phonenumber"]);

if($username == '' || $password == '' || $fullname == '' || $address == '' || $phonenumber == ''){

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Fadlan buuxi dhammaan xaqiiqda loo baahan yahay (Full Name, Address, Phone Number, Username, Password).

</div>";

} else if(strlen($password) < 4) {

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Password waa inuu ka koobnaadaa ugu yaraan 4 xaraf.

</div>";

} else if(username_exists($username)) {

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Username-kan horeyba waa la isticmaalayaa. Fadlan mid kale dooro.

</div>";

} else {

$passmd = MD5($password);
$res = $pdo->exec("INSERT INTO users SET username='".$username."', fullname='".$fullname."', address='".$address."', phonenumber='".$phonenumber."', password='".$passmd."'");
if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

User Added Successfully!

</div>";

} else {

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Some Problem Occurs, Please Try Again.

</div>";

}

}

}
	?>



				    <form action="useradd.php" method="post">

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-user"></i>Full Name</label>
                            <input type="text" name="fullname" class="form-control order-input" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" required />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-map-marker"></i>Address</label>
                            <input type="text" name="address" class="form-control order-input" required />
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
                            <label><i class="fa fa-key"></i>Username</label>
                            <input type="text" name="username" class="form-control order-input" oninput="this.value=this.value.replace(/[^a-zA-Z0-9._-]/g,'')" required />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-lock"></i>Password</label>
                            <input type="password" name="password" class="form-control order-input" minlength="4" required />
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

<?php
 include ('footer.php');
 ?>
