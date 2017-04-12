<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
$username = ($this->session->userdata['logged_in']['username']);
$email = ($this->session->userdata['logged_in']['email']);
} else {
header("location: login");
}
?>
<head>
<title>Admin Page</title>
<link rel="stylesheet" type="text/css" href="../../css/login.css">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/table.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
    <script type='text/javascript' src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script type='text/javascript' src="<?php echo base_url();?>js/script.js"></script>
</head>
<body>
<div id="profile">
<?php
echo "Hello <b id='welcome'><i>" . $username . "</i> !</b>";
echo "<br/>";
echo "<br/>";
echo "Welcome to Admin Page";
echo "<br/>";
echo "<br/>";
echo "Your Username is " . $username;
echo "<br/>";
echo "Your Email is " . $email;
echo "<br/>";
?>

<b id="logout"><a href="logout">Logout</a></b>
</div>

<div class="col-lg-12">


<div class="col-lg-3">
	<a href="<?php echo site_url('Ctr_usuario/index') ?>"><button type="button" class="btn btn-success">Admin users</button></a>

</div>
<div class="col-lg-3">
	<a href="<?php echo site_url('Event_type/index') ?>"><button type="button" class="btn btn-success">Event type</button></a>



</div>
<div class="col-lg-3">
	<a href="<?php echo site_url('Events/index') ?>"><button type="button" class="btn btn-success">Events</button></a>

</div>
</div>


<br/>
</body>
</html>