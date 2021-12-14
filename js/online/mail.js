
function AfficheMails(){
 
	$.ajax({
        url: "models/Process_email_model.php",
        type: "POST",
        data: "&action=afficher",
		dataType:'json',
        success: function(data, textStatus, jqXHR) {
    		$("#head-tag").html(data[0]);
    		$("#body-tag").html(data[1]);
			document.forms["form_ajout"].elements["mail"].value='';
        },
        error: function(jqXHR, status, error) {
        	alert(" Erreur de connexion Internet: \n\n" + error);
        }
    });
}	


$('#email').on('click', function(){

	AfficheMails();
	$('#modal-mail').modal('show');

});


function isEmail(myVar){
    // La 1ère étape consiste à définir l'expression régulière d'une adresse email
     var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

     return regEmail.test(myVar);
}
        
$("#ajout_mail").on("click", function() {
		   
    var addr = document.forms["form_ajout"].elements["mail"].value ;
		    
    if((addr=="")||(isEmail(addr) == false))
		 alert("Veuillez saisir une adresse electronique valide !"); 
    else{
		 $("#ajout_form").submit();  
	}		 
});



$("#ajout_form").on("submit", function(e) {
            
		    e.preventDefault();
					    
				var postData = $(this).serializeArray();
				$.ajax({
					url: "models/Process_email_model.php",
					type: "POST",
					data: postData,
					dataType:'json',
					success: function(data, textStatus, jqXHR) {
					    
					if(data.split(";")[0]=="ko")
					    alert("L'adresse électronique existe deja dans la liste !");
					else if(data.split(";")[0]=="ok"){
						AfficheMails();
					}else
 				        alert("Erreur détectée lors de l'ajout du mail: \n"+data);
 				},
				error: function(jqXHR, status, error) {
					alert("Erreur de connexion Internet: \n\n" + error);
				}
			});
});
			

function delmail(id){

          							$.ajax({
        							    url: "models/Process_email_model.php",
        							    type: "POST",
        							    data: "idmail="+id+"&action=desactiver",
        							    success: function(data, textStatus, jqXHR) {
        							    if(data=="ok")
										   AfficheMails();
										else
    								        alert("Erreur de désactivation du mail: \n"+data);
        							    },
        							    error: function(jqXHR, status, error) {
        								alert(" Erreur de connexion Internet: \n\n" + error);
        							    }
        							});
}
