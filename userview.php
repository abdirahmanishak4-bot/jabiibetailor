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

$totalusers = $pdo->query("SELECT COUNT(*) as c FROM users")->fetch(PDO::FETCH_ASSOC);
$totalusers = $totalusers['c'];

if(isset($_GET["id"])){
	$deleteid = $_GET["id"];
	if($deleteid == $uid){
		echo "<div class='alert alert-danger alert-dismissable' style='margin:20px;'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		Ma tirtiri kartid account-ka aad hadda ku soo gashay.
		</div>";
	} else if($totalusers <= 1){
		echo "<div class='alert alert-danger alert-dismissable' style='margin:20px;'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		Ma tirtiri kartid user-kan ugu dambeeya - ugu yaraan hal user waa inuu jiraa.
		</div>";
	} else {
		$pdo->exec("DELETE FROM users WHERE id='".$deleteid."'");
	}
}
?>
 	<link href="css/style.default.css" rel="stylesheet">
  	<link href="css/jquery.datatables.css" rel="stylesheet">
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <style>
    .actions-cell{display:flex;flex-wrap:wrap;gap:5px;align-items:center;}
    .actions-cell .btn{margin:0;}
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
    </style>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-header">All Users</h1>
                </div>
                <div class="col-lg-4 text-right" style="padding-top:28px;">
                    <a href="useradd.php" class="btn view-orders-btn"><i class="fa fa-user-plus"></i> Add User</a>
                </div>
            </div>
            <!-- /.row -->

			<div class="contentpanel">
                     <div class="panel panel-default">

                        <div class="panel-body">

                         <div class="clearfix mb30"></div>

                          <div class="table-responsive">
                          <table class="table table-striped" id="table2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Address</th>
                                            <th>Phone Number</th>
                                            <th>Username</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                     <tbody>
<?php

$ddaa = $pdo->query("SELECT id, username, fullname, address, phonenumber FROM users ORDER BY id");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		echo "<tr>
			<td>$data[id]</td>
			<td>$data[fullname]</td>
			<td>$data[address]</td>
			<td>$data[phonenumber]</td>
			<td>$data[username]</td>
			<td><div class='actions-cell'>";
		if($data['id'] == $uid){
			echo "<span class='label label-info'>Current User</span>";
		} else {
			echo "<a href='userview.php?id=$data[id]' onclick=\"return confirm('Continue delete?');\"><button type='button' class='btn btn-danger btn-xs'>DELETE</button></a>";
		}
		echo "</div></td></tr>";
	}
?>
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->

        </div>
      </div>



    </div><!-- contentpanel -->
    </div>
        <!-- /#page-wrapper -->

   <?php
 include ('footer.php');
 ?>
 <script src="js/jquery.datatables.min.js"></script>
<script src="js/select2.min.js"></script>

<script>
  jQuery(document).ready(function() {
    "use strict";
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers"
    });
  });
</script>

</body>
</html>
