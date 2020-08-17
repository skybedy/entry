<!DOCTYPE html>
<html lang="cs" dir="ltr">
  <head>
    <title>Přihlášky
    </title>
    <meta charset="UTF-8" />
    <meta name="Description" content="" lang="cs" />
    <link rel="stylesheet" href="<?php echo URL ?>public/css/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" href="<?php echo URL ?>public/css/main.css" media="screen" />
    <link rel="shortcut icon" href="<?php echo URL ?>/images/favicon.ico" />
<script type="text/javascript" src="<?php echo URL ?>public/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo URL ?>public/js/bootstrap.min.js"></script>    
<?php
	if(isset($this->js)){
	    foreach($this->js as $js){
		echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>',"\n";
    } echo "\n"; } ?>
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-placeholder/2.0.8/jquery.placeholder.min.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header"> 
            <a href="/" class="navbar-brand">
              <img src="/public/images/logo_new.png" alt="TimeChip" width="146" height="34" /></a>
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar-main"> 
              <span class="icon-bar">
              </span> 
              <span class="icon-bar">
              </span> 
              <span class="icon-bar">
              </span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav navbar-right menu">			
<?php  	
              if (Session::get('race_id') == TRUE): ?>
              <li>
              <a href="<?php echo URL ?>prihlaska">Přihlásit se k závodu</a>
              </li> 
              <?php if($_SESSION['race_id'] != 18000): ?>
              <li>
              <a href="<?php echo URL ?>prihlaska/vypis-prihlasek">Výpis přihlášek</a>
              </li> 
              <?php endif; ?>
              <li>
              <a href="<?php echo URL ?>administrace">Administrace přihlášek</a>
              </li>
              <?php  else: ?> 
              <li>
              <span>Přihlásit se k závodu
              </span>
              </li> 
              <li>
              <span>Výpis přihlášek
              </span>
              </li> 
              <li>
              <span>Administrace přihlášek
              </span>
              </li>
              <?php  endif; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="underbar">
        <div class="container">
          <div class="row">
            <div class="col-lg-12"><h1>
                <?php if(isset($this->h1)) echo $this->h1 ?></h1>
              <form class="form-inline text-right">
                <?php if(isset($_GET['url'])): ?>
                <?php if($_GET['url'] == 'administrace'):?> 
                <span id="hlaska">
                </span> 
                <a href="./administrace/export-excel-jednotlivci" target="_blank" class="btn btn-default">Export Excel jednotlivci</a> 
                <a href="./administrace/export-excel-tymy" target="_blank" class="btn btn-default">Export Excel Týmy</a>
                <?php endif; ?>
                <?php endif; ?>
                <div class="form-group">				
<?php   
				    require 'select_race_option.php';
				    $select_race_option = New Select_Race_Option();
				    echo $select_race_option->race_listing();
                  				?>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>