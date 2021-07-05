<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Facturation</title>
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
                <div class="form-group">
				    <p style="color: black; font-size: 18px; align:center">Facturation</p>
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
               
<!--
                <div class="my-3">
                  <a id="new-suggestion" href="#modal-suggestion" data-toggle="modal" data-target="#modal-suggestion" style="font-size: 12px;">Emettre une suggestion</a>
                </div>
                <div class="my-3">
                  <a id="forgotten-password" href="#modal-ForgottenPassword" data-toggle="modal" data-target="#modal-ForgottenPassword" style="font-size: 12px;">Mot de passe oublié</a>
                </div>
-->
              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <style>
              .col-lg-6{
                background: url("../images/auth/facture.jpg");
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

  <script src="js/jquery/jquery-3.1.1.min.js"></script>
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <script src="js/template.js"></script>
  <script src="js/datetimepicker/jquery.datetimepicker.full.min.js"></script>
  <script src="js/offline/core.js"></script>
  <script src="js/offline/message.js"></script>

  <script src="js/authentication.js"></script>
  
 
  
<?php
include_once('views/Users_modal_message_partial.php') ;
include_once('./config/Connexion.php');

echo "<script type='text/javascript' >
         var session=".round($deconnect/60).";
         var lang=".$lang.";
		</script>";

?>  
</body>
</html>