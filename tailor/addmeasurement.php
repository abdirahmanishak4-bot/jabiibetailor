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
    .measure-card{
        background:#fff;
        border-radius:14px;
        border:none;
        border-top:4px solid var(--brand,#0d9488);
        box-shadow:0 2px 10px rgba(15,43,40,.08);
        margin-bottom:24px;
        overflow:hidden;
    }
    .measure-card .panel-heading{
        background:linear-gradient(135deg,#0f766e,#0d9488);
        color:#fff;
        font-size:16px;
        font-weight:600;
        letter-spacing:.4px;
        text-transform:uppercase;
        padding:14px 20px;
    }
    .measure-card .panel-heading .fa{margin-right:8px;}
    .measure-card .panel-body{padding:18px 20px;}
    .measure-grid{
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
        gap:14px;
    }
    .measure-row{
        display:flex;
        align-items:center;
        gap:12px;
        padding:12px;
        border:1px solid #eef2f6;
        border-radius:10px;
        background:#f8fafc;
    }
    .measure-thumb{
        width:44px;height:44px;
        flex:0 0 44px;
        border-radius:8px;
        overflow:hidden;
        background:#fff;
        border:1px solid #eef2f6;
        display:flex;align-items:center;justify-content:center;
    }
    .measure-thumb img{width:100%;height:100%;object-fit:cover;}
    .measure-label{
        flex:1 1 auto;
        font-size:13.5px;
        font-weight:400;
        color:#475569;
    }
    .measure-input-wrap{flex:0 0 110px;}
    .measure-input-wrap input{
        width:100%;
        height:38px;
        border:1.5px solid #e2e8f0;
        border-radius:8px;
        padding:0 10px;
        font-size:14px;
        font-weight:400;
        background:#fff;
        outline:none;
        transition:border-color .2s,background .2s,box-shadow .2s;
    }
    .measure-input-wrap input:focus{
        border-color:var(--brand,#0d9488);
        background:#fff;
        box-shadow:0 0 0 4px rgba(13,148,136,.14);
    }
    .measure-customer-banner{
        background:linear-gradient(135deg,#0f766e,#0d9488);
        color:#fff;
        border-radius:14px;
        padding:20px 24px;
        margin-bottom:24px;
        display:flex;
        align-items:center;
        gap:16px;
        box-shadow:0 4px 14px rgba(15,43,40,.15);
    }
    .measure-customer-banner .avatar{
        width:52px;height:52px;
        border-radius:50%;
        background:rgba(255,255,255,.18);
        border:1px solid rgba(255,255,255,.35);
        display:flex;align-items:center;justify-content:center;
        font-size:22px;
        flex:0 0 52px;
    }
    .measure-customer-banner h3{
        margin:0;
        font-size:19px;
        font-weight:700;
    }
    .measure-customer-banner span{
        font-size:13px;
        color:rgba(255,255,255,.85);
    }
    .measure-submit-btn{
        background:linear-gradient(135deg,var(--brand-dark,#0f766e),var(--brand,#0d9488)) !important;
        border:none !important;
        border-radius:8px !important;
        font-weight:700;
        letter-spacing:.5px;
        padding:12px !important;
        box-shadow:0 3px 10px rgba(13,148,136,.3);
    }
    .measure-submit-btn:hover{
        background:linear-gradient(135deg,#0d9488,#14b8a6) !important;
    }
    @media (max-width:600px){
        .measure-row{flex-wrap:wrap;}
        .measure-input-wrap{flex:1 1 100%;}
    }
    </style>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-header">Add Measurement</h1>
                </div>
                <div class="col-lg-4 text-right" style="padding-top:28px;">
                    <a href="customerview.php" class="btn view-orders-btn"><i class="fa fa-list"></i> View / Edit Customer</a>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">



		<?php

if($_POST)
{
	$id = $_GET["id"];
	foreach ($_POST as $key => $value)
	{
 		$res = $pdo->exec("INSERT INTO `measurement`(`customer_id`, `part_id`, `measurement`) VALUES ('$id' ,'$key','$value')");

	}
echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>

Measurements Added Successfully!

</div>
<meta http-equiv='refresh' content='2; url=orderadd.php?id=$id' /> ";



}
	?>



	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

<?php
$id = $_GET["id"];
$ddaa = $pdo->query("SELECT fullname,sex FROM customer where id = '$id'");
$dda = $ddaa->fetch(PDO::FETCH_ASSOC);
?>

                <div class="measure-customer-banner">
                    <div class="avatar"><i class="fa fa-user"></i></div>
                    <div>
                        <h3><?php echo($dda["fullname"]); ?></h3>
                        <span><?php echo($dda["sex"] == 0 ? 'Male' : 'Female'); ?> &middot; Taking new measurements</span>
                    </div>
                </div>

                <form action="addmeasurement.php?id=<?php echo ($_GET['id']);?>" method="post">

        <?php
$type = $pdo->query("SELECT id, title FROM type where sex= '$dda[sex]'");

while ($typee = $type->fetch(PDO::FETCH_ASSOC))
{
	echo('<div class="panel measure-card"><div class="panel-heading"><i class="fa fa-scissors"></i>'.$typee["title"].'</div><div class="panel-body"><div class="measure-grid">');
	$ddaa = $pdo->query("SELECT id, title, image FROM part where type='$typee[id]'");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		$img = 'img/part/'.$data["image"];
		echo "<div class='measure-row'>";
		echo "<div class='measure-thumb'><img src='$img' alt='' /></div>";
		echo "<div class='measure-label'>$data[title]</div>";
		echo "<div class='measure-input-wrap'><input type='text' name='$data[id]' required /></div>";
		echo "</div>";
	}
	echo('</div></div></div>');
}
?>

						<input type="submit" class="btn btn-lg btn-success btn-block measure-submit-btn" value="ADD">
				    	</form>
                </div>

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
