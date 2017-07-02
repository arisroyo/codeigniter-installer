<?php
error_reporting(E_ALL); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {
	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');
	
	$core = new Core();
	$database = new Database();

	// Validate the post data
	if($core->validate_post($_POST) == true)
	{
		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		 session_start();
		 $_SESSION['config_success'] = true;
		 $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
     	 $redir .= "://".$_SERVER['HTTP_HOST'];
      	 $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      	 $redir = str_replace('install/','',$redir); 
 		 header( 'Location: ' . $redir . 'install/confirmation.php' ) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

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
	   	<?php if(!is_writable($db_config_path)){?>
	   	<div class="row center_form">
          <div class="col-lg-12">
	      	<div class="alert alert-dismissible alert-danger">
	  	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	  		Please make the application/config/database.php file writable. <br /><br /><strong>Example</strong>:<code>chmod 777 application/config/database.php</code>
		  	</div>
		  </div>
		 </div>
	   <?php } ?>
	   <?php if(isset($message)) { ?>
	  	<div class="row center_form">
          <div class="col-lg-12">
	  		<div class="alert alert-dismissible alert-warning">
  	  			<button type="button" class="close" data-dismiss="alert">&times;</button>
      			<h4>Oops!</h4>
      			<p><?= $message ?></p>
	  		</div>
	  		</div>
	  	</div>
	   <?php } ?>
	   </div>
	  <div class="bs-docs-section center_form">
        <div class="row center_form">
          <div class="col-lg-12">
            <div class="well bs-component">
              <form id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
                <fieldset>
                  <legend>Database Settings</legend>
                  <div class="form-group">
                    <label for="inputHostName" class="col-lg-2 control-label">Hostname</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="hostname" placeholder="Hostname" name="hostname" value="localhost">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="intputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="intputDatabase" class="col-lg-2 control-label">Database</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="database" placeholder="Database" name="database">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="reset" class="btn btn-default">Cancel</button>
                      <button type="submit" value="Install" id="submit" class="btn btn-primary" >Submit</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
       </div>
 	</body>
</html>
