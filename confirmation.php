<?php 
session_start();
if (!isset($_SESSION['config_success'])) {
	exit('No direct script access allowed');
}
unset($_SESSION['config_success']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CodeIgniter | Installer</title>
		<link href="./assets/bootstrap.min.css" rel="stylesheet">
		<style>
		.center_form{
    		margin: 0 auto;
    		width:80%;
		}
		</style>	
		
	</head>
	<?php 
		 $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
     	 $redir .= "://".$_SERVER['HTTP_HOST'];
      	 $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      	 $redir = str_replace('install/','',$redir);
      	 $redir .= 'index.php';
     ?>
	<body>
       <div class="row">
	   <span>&nbsp;</span>
	   </div>
	   <div class="row center_form">
	    <div class="row center_form">
          <div class="col-lg-12">
	    	<h2>CodeIgniter Installer</h2>
	    	<p class="lead">A starting point for building an installer on CodeIgniter, useful for self-hosted web apps that need to have a GUI installer</p>
	   		</div>
	   	</div>
	   	<div class="row center_form">
          <div class="col-lg-12">
	      	<div class="alert alert-dismissible alert-success">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>Sucess!</strong><br/>You successfully configure Application Database Go to <a href="<?=$redir?>" class="alert-link">HomePage</a>...
				</div>
				<div class="well">
  					<code>Please make sure to <strong>DELETE</strong> the install folder</code>
				</div>
		 </div>
	   </div>
	</body>
</html>
