$(document).ready(function(){
 

// Ajouter une ligne pour adresse mail
	$("#add_row1").click(function(){
		if(document.getElementById('tab_logic1').rows.length>0){
			var i = document.getElementById('tab_logic1').rows.length - 1;
			$('#addrm'+i).html("<td  style=\"padding-bottom:2px;padding-top:2px;padding-left:2px;padding-right:2px;\"><input name='mail"+i+"' id='mail"+i+"' type='text' placeholder='Adresse Mail' style=\"height:30px\" class='form-control input-md'  onkeypress=\"return ((event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 64 || event.charCode == 45 || event.charCode == 46))\"/></td>");
				$('#tab_logic1').append('<tr id="addrm'+(i+1)+'"></tr>');
				i++; 
			}
		});
				
// Supprimer une ligne pour adresse mail
	$("#delete_row1").click(function(){
		var i = document.getElementById('tab_logic1').rows.length - 1;			
		if(i>1){
			$("#addrm"+(i-1)).html('');
			$("#addrm"+i).remove();
		}
	});

});

			
// Poster les informations du formulaire si les mots de passe concordent

$("#form-FirstConnection").submit(function(event){
	
	event.preventDefault();
	
	function isContact(myVar){
		myVar=myVar.split(" ").join("");
		return (((myVar.length==10) && !isNaN(parseInt(myVar)))?true:false);
	}

	function isEmail(myVar){
        var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
        return regEmail.test(myVar);
	}
	
	var i = document.getElementById("tab_logic1").rows.length - 1;
	var bool2 = true;
	
	for(j = 0; j < i; j++){	    
	    var mail = document.getElementById('mail'+j).value ;
	    bool2 = bool2 && (isEmail(mail));
	}
	
	var tel=document.forms["FirstConnection-form"].elements["tel"].value;
	var mdp=document.forms["FirstConnection-form"].elements["mdp"].value;
	var confmdp=document.forms["FirstConnection-form"].elements["confmdp"].value;
	
	if(!isContact(tel))
        mssg(lang,22,0);
    else if(!bool2)
        mssg(lang,22,1);
    else if(mdp != confmdp)
        mssg(lang,20,0);
    else if(mdp==$('.form-authentication input[name="user"]').val())
        mssg(lang,21,2);
    else if(mdp==pass)
        mssg(lang,21,1);
    else if(mdp.length<5)
        mssg(lang,21,0);
	else{
    		var donnees = $(this).serialize();
    		var table1 = document.getElementById("tab_logic1").rows.length - 1;
    		$.ajax({
    			url : 'models/First_connect_model.php',
    			type : 'POST',
    			data : donnees+'&t2='+table1,
    			dataType : 'json',
    			success : function(data){
					if(data[0]==0){
						mssg(lang,23,0);
						$('#modal-FirstConnection').modal('hide');
					}else
						mssg(lang,25,data);
    			},
				error: function(jqXHR, status, error){
					mssg(lang,24,error);
			}
    		});
    	}
    	
 
});

