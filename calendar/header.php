<?php
$_POST = array_map('strip_tags', $_POST);
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>Jabiibe TAILOR </title>

  <link href="../css/style.default.css" rel="stylesheet"> 


 <link rel="stylesheet" href="../css/bootstrap-timepicker.min.css" />
  <link rel="stylesheet" href="../css/jquery.tagsinput.css" />
  <link rel="stylesheet" href="../css/colorpicker.css" />
  <link rel="stylesheet" href="../css/dropzone.css" />
  <script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>
<script src="../js/jquery-ui-1.10.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.sparkline.min.js"></script>
<script src="../js/toggles.min.js"></script>
<script src="../js/retina.min.js"></script>
<script src="../js/jquery.cookies.js"></script>
<!------------------------Chat JS Files ------------------------------------------------------>
<script type="text/javascript" src="../js/Chart.js"></script>
<script type="text/javascript" src="../js/Chart.min.js"></script>
 

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../js/html5shiv.js"></script>
  <script src="../js/respond.min.js"></script>
  <![endif]-->

    

 <script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

 <script>
$(function() {
$( "#datepicker1" ).datepicker();
});
</script>

 <script>
$(function() {
$( "#datepicker2" ).datepicker();
});
</script>
<style>
.page-header {
    border-bottom: 0px solid #FFF;
	color: #1D2939;

}
h1 {
  text-transform: uppercase;
}

/* ===== Jabiibe Tailor teal theme ===== */
:root{
    --brand:#0d9488;
    --brand-dark:#0f766e;
    --brand-light:#2dd4bf;
}

body{
    background: linear-gradient(180deg,#0f2b28 0%,#134e4a 100%) !important;
}

.headerbar{
    background:#fff !important;
    border-left:none;
    box-shadow:0 2px 6px rgba(15,43,40,.12);
    position:relative;
    z-index:20;
}

.leftpanel .logopanel{
    background:linear-gradient(135deg,var(--brand-dark),var(--brand)) !important;
    border-right:none !important;
    box-sizing:border-box;
    display:flex;
    align-items:center;
    padding:16px 18px !important;
}

.logopanel h1{
    color:#fff !important;
    display:flex;
    align-items:center;
    gap:9px;
    font-size:18px;
    font-weight:700;
    letter-spacing:.4px;
    line-height:normal;
    text-shadow:0 1px 2px rgba(0,0,0,.15);
    white-space:nowrap;
}

.logopanel h1 .fa{
    margin-right:0;
    font-size:18px;
}

.logopanel h1 span{
    color:#99f6e4 !important;
    font-weight:400;
    opacity:.95;
}

.menutoggle{
    color:#64748b;
}
.menutoggle:hover{
    color:var(--brand-dark);
    background-color:#f0fdfa;
}

.headermenu .dropdown-toggle{
    background:#fff;
    border-color:#fff;
    color:#334155;
}
.headermenu .dropdown-toggle:hover,
.headermenu .dropdown-toggle:focus,
.headermenu .dropdown-toggle:active{
    background:#f0fdfa;
    color:var(--brand-dark);
}
.headermenu > li{
    border-left:1px solid #f1f5f9;
}

.dropdown-menu-usermenu > li > a:hover{
    background:var(--brand) !important;
    color:#fff !important;
}

/* Sidebar */
.sidebartitle{
    color:#5eead4;
    opacity:.7;
}

.nav-bracket > li > a{
    color:#a7d8d3;
}
.nav-bracket > li > a:hover,
.nav-bracket > li > a:active,
.nav-bracket > li > a:focus{
    background-color:rgba(255,255,255,.08);
    color:#fff;
    box-shadow:none;
}
.nav-bracket > li.nav-parent > a:hover,
.nav-bracket > li.nav-parent > a:active{
    background-color:rgba(255,255,255,.08);
    color:#fff;
}
.nav-bracket > li.active > a,
.nav-bracket > li.active > a:hover,
.nav-bracket > li.active > a:focus{
    background-color:var(--brand) !important;
    color:#fff !important;
    box-shadow:none;
}
.nav-bracket .children > li > a{
    color:#8fc9c2;
}
.nav-bracket .children > li > a:hover,
.nav-bracket .children > li > a:active,
.nav-bracket .children > li > a:focus,
.nav-bracket .children > li.active > a{
    color:#5eead4;
}
.nav-bracket li .fa{
    color:#5eead4;
    opacity:.85;
}

/* Main content area */
.mainpanel{
    background-image:none !important;
    background-color:#f1f5f9;
}
</style>

 
</head>

<body>



<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
<?php   $dd = $pdo->query("SELECT currency, sitename FROM general_setting WHERE id='1'");
		$currency = $dd->fetch(PDO::FETCH_ASSOC);
		$currency = $currency['currency'];
 ?>
<section>

  <div class="leftpanel">

    <div class="logopanel">
        <h1><i class="fa fa-scissors"></i>Jabiibe <span>Tailor</span></h1>
    </div><!-- logopanel -->

    <div class="leftpanelinner">

        <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">

            <h5 class="sidebartitle actitle">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
              <li><a href="../changepass.php"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
              <li><a href="../signout.php"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>

      <h5 class="sidebartitle">Navigation</h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
	  
	  
	   
	  
        <li><a href="../home.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        <li><a href="../calendar/"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
		
    	<li><a href="../orderlist.php"><i class="fa fa-shopping-cart"></i><span>Orders</span></a></li>

        <li><a href="../customerview.php"><i class="fa fa-user"></i><span>Customers</span></a></li>
        <li><a href="../userview.php"><i class="fa fa-users"></i><span>Users</span></a></li>
         <!--<li><a href="../smslist.php"><i class="fa fa-envelope-o"></i><span>SENT MESSAGES</span></a></li>
	 	<li><a href="../emaillist.php"><i class="fa fa-envelope"></i><span>SENT EMAILS</span></a></li> -->
        
        <li class="nav-parent"><a href="../#"><i class="fa fa-th-list"></i> <span>Staff Management</span></a>
          <ul class="children">
            <li><a href="../staffadd.php"><i class="fa fa-caret-right"></i>Add Staff</a></li>
            <li><a href="../staffview.php"><i class="fa fa-caret-right"></i>View/Edit Staff</a></li>
            <li><a href="../paysalary.php"><i class="fa fa-caret-right"></i> Pay Salary</a></li>
            <li><a href="../staffcatadd.php"><i class="fa fa-caret-right"></i>Add Designation</a></li>
            <li><a href="../staffcatview.php"><i class="fa fa-caret-right"></i>View/Edit Designations</a></li>
          </ul>
        </li>
        <li><a href="../expview.php"><i class="fa fa-money"></i><span>Expenses</span></a></li>
        <li><a href="../incview.php"><i class="fa fa-money"></i><span>Income</span></a></li>
        
        <li class="nav-parent"><a href="../#"><i class="fa fa-th-list"></i> <span>Measurement Settings</span></a>
          <ul class="children">
            <li><a href="../typeadd.php"><i class="fa fa-caret-right"></i>Add Cloth Type</a></li>
            <li><a href="../typeview.php"><i class="fa fa-caret-right"></i>View/Edit Cloth Type</a></li>
            <li><a href="../partadd.php"><i class="fa fa-caret-right"></i>Set Mesurement Parts</a></li>
            <li><a href="../partview.php"><i class="fa fa-caret-right"></i>View/Edit Mesurement Parts</a></li>
          </ul>
        </li>
        
        <li class="nav-parent"><a href="../#"><i class="fa fa-cog"></i> <span> General Setting</span></a>
          <ul class="children">
            <li><a href="../setgeneral.php"><i class="fa fa-caret-right"></i> Setting</a></li>
            <li><a href="../setlogo.php"><i class="fa fa-caret-right"></i> LOGO</a></li>
            <li><a href="../document.php"><i class="fa fa-caret-right"></i> Office Documents</a></li>
			<li><a href="../templateadd.php"><i class="fa fa-caret-right"></i>Add SMS/Email Template</a></li>
            <li><a href="../templateview.php"><i class="fa fa-caret-right"></i>View SMS/Email Template</a></li>

          </ul>
        </li>




      </ul>

      

    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->

  <div class="mainpanel">

    <div class="headerbar">

      <a class="menutoggle"><i class="fa fa-bars"></i></a>

        
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

<?php
echo "<img src='../images/user.png' alt='' />";
echo " $user";
?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
              <li><a href="../changepass.php"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
              <li><a href="../signout.php"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
              </ul>
            </div>
          </li>

        </ul>
      </div><!-- header-right -->

    </div><!-- headerbar -->


    <div class="contentpanel">