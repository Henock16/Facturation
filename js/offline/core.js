//Initialisation des champs date
$(document).ready( function(){

  $.datetimepicker.setLocale('fr');

  $('.datepicker').datetimepicker({
    format: 'd/m/Y',
 	timepicker:false,
	dayOfWeekStart:1,
  });

  //Fermeture du loader a la fin du chargement de la page
  hideloader();
});

//Fonctions du loader
var nb=0;

function showloader(){
  if(nb==0){
         document.getElementById("loader").style.display = "block";
         document.getElementById("bgpage").style.display = "block";
	}230
   nb++;
}

function hideloader(){
  if(nb>0)
	   nb--;
  if(nb==0){
        document.getElementById("loader").style.display = "none";
        document.getElementById("bgpage").style.display = "none";
	}
}

function testnumtel(e){
	return ([2,5,8,11].includes(e.value.length)?(e.value = e.value+' '):([3,6,9,12].includes(e.value.length)?(e.value = e.value.slice(0,e.value.length-1)):null));
}


function statuscolor(id) {
	var statuscolor=['danger','warning','secondary','success','dark','danger','white','','primary',''];
return statuscolor[id];
}

function statusname(lang,id) {
	var statusname=["","En attente","Annulee","Affectee","Avortee","Rejetee"];
return statusname[id];
}

function PlageHoraire(id) {
	var plage=['','JOUR','NUIT','RELAIS'];
return plage[id];
}

function Statut(id) {
	var statut=['ACTIF','INACTIF'];
return statut[id];
}

function Ville(id){
	var ville=['','ABIDJAN','SAN PEDRO'];
return ville[id];
}

function TypePont(id){
	var type=['','Pont','Usine'];
return type[id];
}

function Connexion(id){
	var connex=['JAMAIS','DEJA','REINITIALISEE'];
return connex[id];
}

function TypeUser(id){
	var type=['','Administrateur','Opérateur','Super admin','Agent DRH'];
return type[id];
}

function TypeOperateur(id){
	var type=['','Exportateur','Pont','Usine','Transitaire'];
return type[id];
}

function JourFerie(id){
	var ferie=['E','N','R','T','M'];
return ferie[id];
}

function Facturation(id) {
	var fact=['OUI','NON'];
return fact[id];
}

function Champ(type,formulaire,champ,val1,val2,val3){

	if(type=='input'){
		$('#'+champ).css('display',(val3==1)?((val1!="")?'block':'none'):'block');
		$(formulaire+' input[name="'+champ+'"]').val(val1+((val2!="")?" ("+val2+")":""));
	}else if(type=='select' && val3!=''){
		loadselect(val2,val3,formulaire+' select[name="'+champ+'"]',val1,0);
	}else if(type=='select' && val3==''){
		$('#'+champ+val1).prop('selected',true);
		if(val2!='') $('#'+champ+val2).css('display','none');
	}else if(type=='radio'){
		$(formulaire+' input[name="'+champ+'"]').prop('checked',false);
		$('#'+champ+val1).prop('checked',true);
		$(formulaire+' input[name="'+champ+'"]').prop('disabled',(val2=='')?false:true);
		if(val2!='') $('#'+champ+val2).prop('disabled',false);
	}else if(type=='checkbox'){
		$(formulaire+' input[name="'+champ+'"]').prop('checked',(val1==1)?true:false);
		$(formulaire+' input[name="'+champ+'"]').prop('disabled',(val2=='')?false:true);
	}else if(type=='multiselect'){
		$(formulaire+' input[name="'+champ+'"]').val(val1.length);
		var html='';
        for(var i = 0; i < val1.length; i++){
			var slct=val3[i].split("-");
			html+='<label for="'+champ+i+'" style="padding-left:5px;padding-right:5px;">';
			html+='		<input type="checkbox" id="'+champ+i+'" name="'+champ+i+'" value="'+val1[i]+'" '+((slct[0]==1)?'checked':'')+'/> ';
			html+='		<input type="number" id="val'+champ+i+'" name="val'+champ+i+'" value="'+slct[1]+'" '+((slct[0]==1)?'':'disabled')+' size="10" placeholder="Impayé" /> '+val2[i];
			html+='</label>';
			html+='<script>';
			html+='$("#'+champ+i+'").on("change", function(){';
			html+='$("#val'+champ+i+'").prop("disabled",$("#'+champ+i+'").is(":checked")?false:true);';
			html+='});';
			html+='</script>';
		}
		$('#checkboxes').html(html);
	}
}

function loadselect(table,model,list,selected,critere){

	showloader() ;

	$.ajax({

		url: './models/'+model+'.php',
		type: 'POST',
		data: 'critere='+critere,
		dataType: 'json',
		success : function(response){

			hideloader();

			if(response[0]!=0)
				mssg(lang,15,response[0]);
			else{
				var j = 3;
				var options = "<option value=\"\" selected=\"selected\">"+table+"</option>";
				for(var i = 0; i < response[1]; i++){
					options += "<option value=\""+response[j]+"\" "+((response[j]==selected)?"selected=\"selected\"":"")+">"+response[j+1]+"</option>";							
					j += response[2];
				}
				if(model=='Get_structures_model')
					options += "<option value=\"0\" style=\"font-weight:bold;\">AJOUTER UNE NOUVELLE STRUCTURE</option>";
				
				$(list).html(options);
			}
		},//SUCCESS
		error: function(jqXHR, status, error){
			hideloader();
			mssg(lang,14,error);
		}//ERROR
	});//AJAX
	
}
 
 

 function loadform(id,action,statut,table,nom,response){
	
 	var voyelle=((table=='reservation' || table=='structure')?'e la ':((nom.charAt(0)=='i' || nom.charAt(0)=='u')?'e l\'':'u '));
 	if(action==1){
 		$('#modal-'+table+'-title').html('<i class="mdi mdi-magnify-plus"></i>&nbsp;Détails d'+voyelle+nom+'');
 		$('#modal-'+table+'-header').css("background-color",'lightblue');
 	}else if(action==0){
 		$('#modal-'+table+'-title').html('<i class="mdi mdi-plus-box"></i>&nbsp; Ajout d\'un'+((table=='structure')?'e':'')+' '+nom+'');
 		$('#modal-'+table+'-header').css("background-color",'lightgreen');
 	}else if(action==2){
 		$('#modal-'+table+'-title').html('<i class="mdi mdi-lead-pencil"></i>&nbsp; Modification d'+voyelle+nom+'');
 		$('#modal-'+table+'-header').css("background-color",'orange');
 	}

 	$('.form-'+table+' input[name="action-id"]').val(action);
 	$('.form-'+table+' input[name="'+table+'-id"]').val((action==2)?id:'');

 	$('.'+table+'-details').prop('disabled',(action==1)?true:false);

	if(table=='user'){
 			Champ('radio','.form-'+table,'statut',response[1],(action==0)?'0':'',0);
 			Champ('input','.form-'+table,'structure',response[2],'',0);
 			Champ('input','.form-'+table,'login',(action==0)?'':response[3],'',0);
 			$('.form-'+table+' input[name="login"]').prop('readonly',true);
 			Champ('input','.form-'+table,'numcc',response[4],'',0);
 			Champ('input','.form-'+table,'bp',response[5],'',0);
 			Champ('input','.form-'+table,'tel',response[6],'',0);
 			Champ('input','.form-'+table,'adresse',response[7],'',0);
 			Champ('input','.form-'+table,'acompte',response[8],'',0);
			Champ('multiselect','.form-'+table,'pont',response[9],response[10],response[11]);
			ChangeExpension(true);

 			$('.'+table+'-info').prop('disabled',true);
 			$('.'+table+'-chmp').css('display',(action==1)?'block':'none');
/*
 			if(action!=1){	
 				showloader() ;
 				$.ajax({
 					url: './models/Process_user_model.php',
 					type: 'POST',
 					data: 'action-id=1',
 					dataType: 'json',
 					success : function(response){
 						hideloader();
 						if(response[0]==0)
 							$('.form-'+table+' input[name="numero"]').val(response[1]);
 						else
 							mssg(lang,11,response[0]); 
 					},SUCCESS
 					error: function(jqXHR, status, error) {
 						hideloader();
 						mssg(lang,10,error);
 					}ERROR
 				});AJAX
 			}
			
*/
	}
	
 	$('#submit-'+table+'').css('display',(action==1)?'none':'block');
 	$('#submit-'+table+'').text((action==2)?"Modifier":"Ajouter");

 	$('#modal-'+table+'').modal('show');
}

function Confirmation(id,action,statut,model,table,txt){
	
    $('#modal-confirmation-title').html("Confirmattion !");
	$('#modal-confirmation-header').css("background-color",'orange');
    $('#confirmation-image').prop('src','images/caution.png');

    $('.form-confirmation input[name="confirmation-id"]').val(id);
    $('.form-confirmation input[name="action-id"]').val(action);
    $('.form-confirmation input[name="statut"]').val(statut);
    $('.form-confirmation input[name="model"]').val(model);
    $('.form-confirmation input[name="table"]').val(table);
    $('#confirmation-message').html(txt,"");

    $('#modal-confirmation').modal("show","");
	
}

///*
$('.form-confirmation').on('submit', function(e){

	e.preventDefault();


	if($('.form-confirmation input[name="model"]').val()==1){
		$('#modal-confirmation').modal('hide');
		triggeraction(1,$('.form-confirmation input[name="table"]').val(),0);
	}else{
		
		showloader() ;

		var postdata = $(this).serialize();

		$.ajax({

			url: './models/'+$('.form-confirmation input[name="model"]').val()+'.php',
			type: 'POST',
			data: postdata,
			dataType: 'json',
			success : function(response){

				hideloader();
				
				$('#modal-confirmation').modal('hide');

				triggeraction(0,$('.form-confirmation input[name="table"]').val(),response);

			},//SUCCESS
			error: function(jqXHR, status, error) {
				hideloader();
				mssg(lang,10,error);
			}//ERROR
		});//AJAX
	}		
});
//*/

function triggeraction(type,action,response){
					
	if(type==1){	//ouverture du PDF du Recapitulatif
		window.open(action);	
	}else if(action=="recapitulatif"){//generation du PDF du Recapitulatif
		if(response[0]==0)
			Confirmation(0,0,0,1,response[3],"Le PDF du récapitulatif des affectations a été généré et envoyé par mail. \nVoulez-vous l'ouvrir?");		
		else if(response[0]==1)
			mssg(lang,13,"Il n'y a aucune réservation d'inspecteur."); 
		else if(response[0]==2)
			mssg(lang,16,"Il n'y a aucune affectation d'inspecteur."); 
		else if(response[0]==3)
			mssg(lang,16,"Il y a "+(response[2]-response[1])+" réservation"+(((response[2]-response[1])>1)?"s":"")+" sans inspecteur affecté."); 
	}else if(response[0]==0){ 
		if(action=="table-users")//liste des utilisateurs
			LoadUtilisateurs();
	}else 
		mssg(lang,11,response); 
			
}

