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
 
$customerr = $pdo->query("SELECT COUNT(*) as sum FROM customer"); 
$orderr = $pdo->query("SELECT COUNT(*) as sum FROM `order`");
$incomee = $pdo->query("SELECT sum(amount) as sum FROM `income` WHERE date > DATE_SUB(NOW(), INTERVAL 30 DAY)");
$expensee = $pdo->query("SELECT sum(amount) as sum FROM `expense` WHERE date > DATE_SUB(NOW(), INTERVAL 30 DAY)");

$customer = $customerr->fetch(PDO::FETCH_ASSOC); 
$order = $orderr->fetch(PDO::FETCH_ASSOC);
$income = $incomee->fetch(PDO::FETCH_ASSOC);
$expense = $expensee->fetch(PDO::FETCH_ASSOC);

include ('header.php');
?>


    

        <style>
        .dash-card{
            background:#fff;
            border-radius:14px;
            box-shadow:0 4px 14px rgba(15,43,40,.08);
            overflow:hidden;
            margin-bottom:20px;
            transition:transform .2s ease, box-shadow .2s ease;
        }
        .dash-card:hover{
            transform:translateY(-4px);
            box-shadow:0 10px 24px rgba(15,43,40,.14);
        }
        .dash-card-top{
            display:flex;
            align-items:center;
            gap:16px;
            padding:22px 20px;
        }
        .dash-icon{
            width:56px;height:56px;
            border-radius:14px;
            display:flex;align-items:center;justify-content:center;
            color:#fff;font-size:22px;
            flex-shrink:0;
        }
        .dash-icon-teal{background:linear-gradient(135deg,#0f766e,#0d9488);}
        .dash-icon-cyan{background:linear-gradient(135deg,#0e7490,#0891b2);}
        .dash-icon-emerald{background:linear-gradient(135deg,#047857,#059669);}
        .dash-icon-amber{background:linear-gradient(135deg,#b45309,#d97706);}
        .dash-figure{text-align:right;flex:1;}
        .dash-number{font-size:26px;font-weight:700;color:#0f172a;line-height:1.1;}
        .dash-label{font-size:13px;color:#64748b;margin-top:2px;}
        .dash-footer{
            display:flex;align-items:center;justify-content:space-between;
            padding:12px 20px;
            border-top:1px solid #f1f5f9;
            font-size:13px;color:#0d9488;
            text-decoration:none;
        }
        .dash-footer:hover{background:#f0fdfa;color:#0f766e;text-decoration:none;}
        .chart-card{
            background:#fff;
            border-radius:14px;
            box-shadow:0 4px 14px rgba(15,43,40,.08);
            padding:20px;
            margin-bottom:20px;
        }
        .chart-card-title{
            font-size:14px;font-weight:600;color:#0f172a;
            margin-bottom:16px;
            padding-bottom:12px;
            border-bottom:1px solid #f1f5f9;
        }
        </style>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="dash-card">
                        <div class="dash-card-top">
                            <div class="dash-icon dash-icon-teal"><i class="fa fa-user"></i></div>
                            <div class="dash-figure">
                                <div class="dash-number"><?php echo $customer['sum'] ?></div>
                                <div class="dash-label">Total Customers</div>
                            </div>
                        </div>
                        <a class="dash-footer" href="customerview.php">
                            <span>View Details</span><i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dash-card">
                        <div class="dash-card-top">
                            <div class="dash-icon dash-icon-cyan"><i class="fa fa-shopping-cart"></i></div>
                            <div class="dash-figure">
                                <div class="dash-number"><?php echo $order['sum'] ?></div>
                                <div class="dash-label">Total Orders</div>
                            </div>
                        </div>
                        <a class="dash-footer" href="orderlist.php">
                            <span>View Details</span><i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dash-card">
                        <div class="dash-card-top">
                            <div class="dash-icon dash-icon-emerald"><i class="fa fa-money"></i></div>
                            <div class="dash-figure">
                                <div class="dash-number"><?php echo $currency.$income['sum'] ?></div>
                                <div class="dash-label">Last 30 Days Income</div>
                            </div>
                        </div>
                        <a class="dash-footer" href="incview.php">
                            <span>View Details</span><i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
				 <div class="col-lg-3 col-md-6">
                    <div class="dash-card">
                        <div class="dash-card-top">
                            <div class="dash-icon dash-icon-amber"><i class="fa fa-credit-card"></i></div>
                            <div class="dash-figure">
                                <div class="dash-number"><?php echo $currency.$expense['sum'] ?></div>
                                <div class="dash-label">Last 30 Days Expenses</div>
                            </div>
                        </div>
                        <a class="dash-footer" href="expview.php">
                            <span>View Details</span><i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- /.row -->
            <div class="chart-card">
                <div class="chart-card-title">Income, Expenses and Profit for past 30 days</div>
                <canvas id="myChart" height="400px" width="800"></canvas>
            </div>
        </div>
        <!-- /#page-wrapper -->
<?php
function income($today,$pdo) {
	$sites = $pdo->query("SELECT sum(amount) as sum FROM `income` WHERE date LIKE '%$today%'");
	$sites = $sites->fetch(PDO::FETCH_ASSOC);
	$sites2 = $pdo->query("SELECT sum(amount) as sum FROM `order` WHERE date_received LIKE '%$today%'");
	$sites2 = $sites2->fetch(PDO::FETCH_ASSOC);
	$site = $sites['sum'] + $sites2['sum'];
	return $site;
}
function profit($today,$pdo) {
	$sites = $pdo->query("SELECT sum(amount) as sum FROM `income` WHERE date LIKE '%$today%'");
	$sites = $sites->fetch(PDO::FETCH_ASSOC);
	$sites2 = $pdo->query("SELECT sum(amount) as sum FROM `order` WHERE date_received LIKE '%$today%'");
	$sites2 = $sites2->fetch(PDO::FETCH_ASSOC);
	$site1 = $sites['sum'] + $sites2['sum'];
	$site2 = $pdo->query("SELECT sum(amount) as sum FROM expense WHERE date LIKE '%$today%'");
	$site2 = $site2->fetch(PDO::FETCH_ASSOC);
	$site = $site1 - $site2['sum'];
	if($site<0) $site=0;
	return $site;
}
function expenses($today,$pdo) {
	$sites = $pdo->query("SELECT sum(amount) as sum FROM expense WHERE date LIKE '%$today%'");
	$sites = $sites->fetch(PDO::FETCH_ASSOC);
	$site = $sites['sum'];
	return $site;	
}

$income = '"'.income( date('Y-m-d', (strtotime(date('Y-m-d'))-((29*60*60*24)))),$pdo).'"';
$dates = '"'.date('Y-m-d', strtotime(date('Y-m-d')) - (29*60*60*24) ).'"';

for ($i = 28; $i >= 1; $i--) {
	$income .= ',"'.income( date('Y-m-d', (strtotime(date('Y-m-d'))-($i*60*60*24)) ) ,$pdo).'"';
	$dates .= ',"'.( date('Y-m-d', (strtotime(date('Y-m-d'))-($i*60*60*24)) ) ).'"';
}
$dates .= ',"'.date('Y-m-d').'"';
$income .= ',"'.income(date('Y-m-d'),$pdo).'"';

$expenses = '"'.expenses( date('Y-m-d', (strtotime(date('Y-m-d'))-((29*60*60*24)))) ,$pdo).'"';
for ($i = 28; $i >= 1; $i--) {
	$expenses .= ',"'.expenses( date('Y-m-d', (strtotime(date('Y-m-d'))-($i*60*60*24)) ) ,$pdo).'"';
}
$expenses .= ',"'.expenses(date('Y-m-d'),$pdo).'"';

$profit = '"'.profit( date('Y-m-d', (strtotime(date('Y-m-d'))-((29*60*60*24)))) ,$pdo).'"';
for ($i = 28; $i >= 1; $i--) {
	$profit .= ',"'.profit( date('Y-m-d', (strtotime(date('Y-m-d'))-($i*60*60*24)) ) ,$pdo).'"';
}
$profit .= ',"'.profit(date('Y-m-d'),$pdo).'"';
?>

<script>
//current year income / expense	
var barChartData3 = {
		labels : [<?php echo $dates; ?>],
		datasets : [
			{
				label: "Expenses",
				fillColor : "rgba(220,0,0,0.2)",
				strokeColor : "rgba(220,0,0,1)",
				pointColor : "rgba(220,0,0,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : [<?php echo $expenses; ?>]
			} ,
			{
				label: "Income",
				fillColor : "rgba(0,120,0,0.2)",
				strokeColor : "rgba(0,120,0,1)",
				pointColor : "rgba(0,320,0,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : [<?php echo $income; ?>]
			} ,
			{
				label: "Profit",
				fillColor : "rgba(13, 31, 162,0.2)",
				strokeColor : "rgba(13, 31, 162,1)",
				pointColor : "rgba(13, 31, 162,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : [<?php echo $profit; ?>]
			} 
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("myChart").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData3, {
			responsive : true
		});
	}	 

	
</script>
<?php
 include ('footer.php');
 ?>