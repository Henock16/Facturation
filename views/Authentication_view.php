<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Facturation des Prestations SOLAS</title>
  <link rel="shortcut icon" href="images/cci.png" />

  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style1.css">
   <link rel="stylesheet" href="css/loader.css"> 
  <link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.min.css"> 
  <!-- endinject -->
 
</head>

<body style="background-color: #f2f2f2;">
	<div id="loader"></div>
	<div id="bgpage"></div>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow"> 
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="images/cci.jpg" alt="logo" style="width: 100%;">
              </div>
              <form class="pt-3 form-authentication">
                <div class="form-group text-center" >
				    <p style="color: black; font-size: 18px;"><span style="color:#D70036;">F</span>acturation des <span style="color:#D70036;">P</span>restations <span style="color:#D70036;">S</span>OLAS</p>
                 </div>
                <div class="form-group"> 
                  <label for="exampleInputEmail">Login</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text border-right-0"  style="background-color: white">
                        <i class="mdi mdi-account-outline text-secondary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" name="user" placeholder="Nom d'utilisateur" style="background-color: white" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Mot de Passe</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text  border-right-0" style="background-color: white">
                        <i class="mdi mdi-lock-outline text-secondary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" name="pass" placeholder="Mot de Passe" style="background-color: white" required>
                  </div>
                </div>
                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-secondary btn-lg font-weight-medium auth-form-btn">Connexion</button>
                </div>
               

                <div class="my-3">
<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;padding-left:10px;margin-top:5px;background-color:#770055;color:white" align="left">
<b>RECLAMATION</b>
</div>
    <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;padding-bottom:10px;background-color:white;font-size:13px;border:solid;border-color:#770055" align="center">
    Avez-vous été satisfaits de nos services ? Votre avis nous intéresse ! Merci de nous accorder quelques minutes pour nous faire part de toute Réclamation/Insatisfaction en cas de dysfonctionnement constaté.
<br/>
<a href="https://reclamations.pesagecci.com" class="btn btn-danger" target="_blank" title="Soumettre une réclamation à la Chambre de Commerce" style="border-radius:3px; height:23px;width:80px;font-size:14px;text-align:center; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); outline-style:none;padding:2px">
Soumettre</a>
    </div>

                </div>

              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <style>
              .col-lg-6{
                
                   background-size: cover;
              }
            </style>
            <p class="text-black font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021 <a href="https://www.cci.ci" target="_blank">CCI-CI</a> Tous droits r&eacute;serv&eacute;s.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
<?php
include_once('views/modal/Message_modal.php') ;
include_once('views/modal/First_connection_modal.php') ;
include_once('views/modal/New_password_modal.php') ;
?> 
  <script src="js/jquery/jquery-3.1.1.min.js"></script>
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <script src="js/template.js"></script>
  <script src="js/datetimepicker/jquery.datetimepicker.full.min.js"></script>
  <script src="js/offline/core.js"></script>
  <script src="js/offline/message.js"></script>
  <script src="js/offline/authentication.js"></script>
  <script src="js/offline/new-password.js"></script>
  <script src="js/offline/first-connect.js"></script>
  
 
  
<?php
include_once('./config/Connexion.php');

echo "<script type='text/javascript' >
         var session=".round($deconnect/60).";
         var lang=".$lang.";
         var pass=".$pass.";
		</script>";

?>  
</body>
</html>