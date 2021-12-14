		<footer class="footer">
          <div class="footer-wrap text-center">
              <div class="w-100 clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2021 <a href="https://www.cci.ci" target="_blank">CCI-CI</a> Tous droits r&eacute;serv&eacute;s.</span>
              </div>
          </div>
        </footer>

	<!-- partial:partials/_footer.html -->
			</div>
			<!-- main-panel ends -->


    <!-- base:js -->
	<script src="js/jquery/jquery-3.1.1.min.js"></script>
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->

    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->

    <!-- inject:js -->
    <script src="js/template.js"></script>
    <!-- endinject -->

    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->

    <!-- Custom js for this page-->
	<script src="js/datetimepicker/jquery.datetimepicker.full.min.js"></script>

	<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendors/datatables/js/dataTables.buttons.min.js"></script>
	<script src="vendors/datatables/js/jszip.min.js"></script>
	<script src="vendors/datatables/js/pdfmake.min.js"></script>
	<script src="vendors/datatables/js/vfs_fonts.js"></script>
	<script src="vendors/datatables/js/buttons.html5.min.js"></script>
	<script src="vendors/datatables/js/buttons.print.min.js"></script>


	<script src="js/offline/core.js"></script>
	<script src="js/offline/message.js"></script>
	<script src="js/offline/deconnection.js"></script>
	<script src="js/offline/new-password.js"></script>

	<script src="js/online/facturation.js"></script>
	<script src="js/online/users.js"></script>
	<script src="js/online/param.js"></script>
	<script src="js/online/mail.js"></script>

    <!-- End custom js for this page-->
<?php

include_once('./config/Connexion.php');

echo "<script type='text/javascript' >

            var session=".round($deconnect/60).";
            var mpdf=".$mpdf.";
            var lang=".$lang.";
            var cafe=".$cafe.";
            var cajou=".$cajou.";
            var autres=".$autres.";
            var nbpnt=".$nbpnt.";
            var nbchg=".$nbchg.";
            var nbuser=".$nbuser.";
            var pass=".$pass.";
            var uploadrep=\"".$uploadrep."\";
            var idutil=".$_SESSION['ID'].";
            var typuser=".$_SESSION['TYPE'].";
            var ponts='".$_SESSION['PONTS']."';
                     	
    		function actualiser(){
    			var x = 1;
   			
    			
    			var body = document.getElementsByTagName('body');
    			
    			var timerID = setTimeout(function() { // On crée notre compte à rebours
                    
		            var x = 1;

		            $.ajax({
						url: './models/Deconnection_model.php',
						type: 'POST',
						data: '&x='+x,
						dataType: 'json',
						success : function(data){
							if(data[0] == 0){

								$('body').fadeOut(1500);
								setTimeout( function(){
									window.location.replace('index.php');
								}, 1500);
							}
						}
					});
		
		        }, ".$deconnect."000);


		        body[0].addEventListener('click', function() {

		            clearTimeout(timerID); // Le compte à rebours est annulé

		        });
    			
        	}
        		
    		$(document).ready(function(){
    			actualiser();
    		});
										
		</script>";





?>

  </body>
</html>