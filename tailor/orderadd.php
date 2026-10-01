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
    .order-input:focus{
        border-color:#0d9488 !important;
        box-shadow:0 0 0 3px rgba(13,148,136,.15) !important;
        background:#fff;
    }
    .order-addon{
        border:2px solid #ccfbf1;
        border-right:none;
        background:#0d9488;
        color:#fff;
        font-weight:600;
        border-radius:8px 0 0 8px;
    }
    .order-addon + .order-input{
        border-radius:0 8px 8px 0 !important;
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
                    <h1 class="page-header">Add Order</h1>
                </div>
                <div class="col-lg-4 text-right" style="padding-top:28px;">
                    <a href="orderlist.php" class="btn view-orders-btn"><i class="fa fa-list"></i> View / Edit Orders</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">

                <div class="panel order-card">
                <div class="panel-heading"><i class="fa fa-plus-circle"></i>Add Order</div>
                <div class="panel-body">

		<?php

if($_POST)
{

$customer = $_POST["customer"];
$desc = trim($_POST["desc"]);
$date_received = $_POST["date_received"];
$completed = $_POST["completed"];
$date_collected = $_POST["date_collected"];
$amount = $_POST["amount"];
$paid = $_POST["paid"];
$received_by = $_POST["received_by"];

if($customer == '' || $customer == '0' || $desc == '' || $date_received == '' || $date_collected == '' || $amount === '' || $paid === '' || $received_by == ''){

echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Fadlan buuxi dhammaan xaqiiqda loo baahan yahay (Customer, Description, Dates, Amount, Paid, Received By).

</div>";

} else {

$name = $pdo->query("SELECT fullname FROM customer WHERE id='".$customer."'");
$name = $name->fetch(PDO::FETCH_ASSOC);
if (!$name) {
	$name = array('fullname' => 'Deleted Customer');
}
$name = $name['fullname'].": ". substr($desc,0,100);

	if($completed == 'No'){
		$color = '#a00000';
	}
	else{
		$color = '#00a014';
	}



$res = $pdo->exec("INSERT INTO `order`(`customer`, `description`, `amount`, `paid`, `received_by`, `date_received`, `completed`, `date_collected`) VALUES ('$customer','$desc','$amount','$paid','$received_by','$date_received','$completed','$date_collected')");
$cid = $pdo->lastInsertId();
$res2 = $pdo->exec("INSERT INTO `calendar`(`title`, `description`, `start`, `end`, `allDay`, `color`, `url`, `category`, `user_id`) VALUES ('$name','$desc','$date_received','$date_collected','true','$color','../orderedit.php?id=$cid','Orders','$uid')");
if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Order Added Successfully!

</div>";


}

}



} 
	?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
				
				
				
				
				    <form action="orderadd.php" method="post">

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-user"></i>Select Customer</label>
                            <select name="customer" class="form-control order-input" required>
                            <option value="" disabled selected>Please Select a Customer</option>
                            <?php

$ddaa = $pdo->query("SELECT id, fullname FROM customer ORDER BY id");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		if(isset($_GET['id']) && $data['id'] == $_GET['id'])
		{
			echo "<option value='$data[id]' selected='selected'>$data[fullname]</option>";
		}
		else
		{
 			echo "<option value='$data[id]'>$data[fullname]</option>";
		}
	}
?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-align-left"></i>Description</label>
                            <input type="text" name="desc" class="form-control order-input" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-calendar"></i>Date Received</label>
                            <input type="date" name="date_received" class="form-control order-input" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-user-circle"></i>Received By</label>
                            <select name="received_by" class="form-control order-input" required>
                            <option value="" disabled selected>Please Select Staff</option>
                            <?php

					$ddaa = $pdo->query("SELECT id, fullname FROM staff ORDER BY id");
					$staffcount = 0;

						while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
						{
						 $staffcount++;
					 echo "<option value='$data[id]'>$data[fullname]</option>";
						}
					?>
                            </select>
                            <?php if($staffcount == 0): ?>
                            <p class="text-danger" style="margin-top:6px;font-size:12.5px;">
                                <i class="fa fa-exclamation-circle"></i>
                                Weli ma jirto shaqaale. <a href="staffadd.php">Riix halkan si aad shaqaale ugu darto</a>.
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-money"></i>Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon order-addon"><?php echo($currency);?></span>
                                <input type="number" step="0.01" min="0" name="amount" class="form-control order-input" required />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-money"></i>Paid</label>
                            <div class="input-group">
                                <span class="input-group-addon order-addon"><?php echo($currency);?></span>
                                <input type="number" step="0.01" min="0" name="paid" class="form-control order-input" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-check-circle"></i>Completed?</label>
                            <select name="completed" class="form-control order-input">
                            <option value='No'>No</option>
                            <option value='Yes'>Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="order-form-group">
                            <label><i class="fa fa-calendar-check-o"></i>Date to Collect</label>
                            <input type="date" name="date_collected" class="form-control order-input" required />
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