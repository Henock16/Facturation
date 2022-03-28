///
$(document).ready(function(){

    $(".table-ponts").DataTable({
        autoWidth: true,
        ordering:  true,
        order: [[ 1, 'asc' ]],
        language: {'url': 'vendors/datatables/French.json'},
        pageLength: nbpnt,
		columnDefs: [
            { "visible": false, "targets": 0 },
			{ "visible": true, "targets": 1 },
			{ "visible": false, "targets": 6},
			//  { "visible": false, "targets": 1 },
			// { "visible": false, "targets": 8 },	
			{ "visible": false, "targets": 9 },	
        ],
		createdRow: function( row, data, dataIndex){
               if( data[6] ==  0  ){
                    $(row).css({"background-color":"#eeeeee"});
                }
		},
        dom: 'Bfrtip',
		buttons: [{extend:'copyHtml5',text:'Copier',titleAttr: 'Copier le contenu du tableau'},
				  {extend:'csv',text:'CSV',titleAttr: 'Télécharger le tableau au format CSV'},
				  {extend:'excel',text:'Excel',titleAttr: 'Télécharger le tableau au format Excel'},
				  {extend:'pdf',text:'PDF',titleAttr: 'Télécharger le tableau au format PDF'},
				  {extend:'print',text:'Imprimer',titleAttr: 'Imprimer le tableau'}],
    });

    $(".table-chargeurs").DataTable({
        autoWidth: true,
        ordering:  false,
        language: {'url': 'vendors/datatables/French.json'},
        pageLength: nbchg,
		columnDefs: [
            { "visible": false, "targets": 0 },
       ],
		createdRow: function( row, data, dataIndex){
               if( data[1] ==  'JOUR'  ){
                    $(row).css({"background-color":"#dddd33"});
                }
		},
        
    });
	loadselect('PROPIETAIRE','Get_structure_model','.form-ponts select[name="strc"]',0);	

	// loadselect('ANNEE','Get_annee_model','.form-ponts select[name="annee"]',0,0);
	
	Champ('checkbox','.form-ponts','cafe',cafe,'',0);

	// Champ('checkbox','.form-ponts','cajou',cajou,'',0);
	Champ('checkbox','.form-ponts','autres',autres,'',0);
	
});

// $('.form-ponts select[name="annee"]').on('change', function(e){
	
// 	loadselect('MOIS','Get_mois_model','.form-ponts select[name="mois"]',0,$('.form-ponts select[name="annee"]').val());
// });	

	
	
//*/

$('.form-ponts').on('submit', function(e){
	
	e.preventDefault();

	trigerponts();
});	
//*/

function trigerponts(){
	
	var datedebut=$('.form-ponts input[name="dateD"]').val();
	var datefin=$('.form-ponts input[name="dateF"]').val();
	// var mois=$('.form-ponts select[name="mois"]').val();
	// var annee=$('.form-ponts select[name="annee"]').val();
	var strc=$('.form-ponts select[name="strc"]').val();
	var pont=ponts;
	var userid= userid;
	var cafe=($('.form-ponts input[name="cafe"]').is(":checked")?1:0);
	//var cajou=($('.form-ponts input[name="cajou"]').is(":checked")?1:0);
	var autres=($('.form-ponts input[name="autres"]').is(":checked")?1:0);
	loadponts(datedebut,datefin,userid,cafe,/*cajou,*/autres,strc);
}


// liste des chargeurs 
function loadponts(/*mois*/datedebut,datefin/*annee*/,userid,cafe,/*cajou,*/autres,strc)
{
	// var debut='01/'+mois+'/'+annee;
	// var fin='31/'+mois+'/'+annee;
	var debut=datedebut;
	var fin=datefin;
	var date=new Date(fin);
	var mois=["janvier","fevrier","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","decembre"]; 
	
	showloader() ;

	$.ajax({
		   
        url: './models/Get_user_fac_model.php',
        type: 'POST',
		data: '&debut='+debut+'&fin='+fin+'&pont='+pont+'&cafe='+cafe+'&user_id='+userid+/*'&cajou='+cajou+*/'&autres='+autres+'&strc='+strc,
		dataType: 'json',
        success : function(response){
			
			hideloader();
			

            $('.table-ponts').DataTable().clear().draw(false);
			
            if(response[0]==1)
				mssg(lang,29,response);
            else if(response[0]==0){

				var resume;
				var tickets=parseInt(response[3].replaceAll(" "),10);
				resume= "Pour la période du&nbsp;<b>"+debut+"&nbsp;au&nbsp;"+fin+"</b>,&nbsp;";
				resume+="il y a&nbsp;<b>"+((response[3]!=0)?response[3]:"aucune")+"&nbsp;ticket"+((tickets>1)?"s":"")+"</b>,&nbsp;";
				resume+="correspondant"+((tickets>1)?"s":"")+" à un montant total de&nbsp;<b>"+response[4]+"&nbsp;FCFA</b>.";
				resume+=((response[5]>0)?"&nbsp;Par ailleurs, &nbsp;<b>"+response[5]+"&nbsp;</b>pont"+((response[5]>1)?"s":"")+" sur&nbsp;<b>"+response[1]+"</b>":"");
				resume+=((response[5]>0)?"&nbsp;n"+((response[5]>1)?"'ont":"'a")+" pas de compte d'utilisateur.":"");
				$('#resultat').html(resume);

                var j = 5;
				
                for(var i = 0; i < response[1]; i++){
										
					$('.table-ponts').DataTable().row.add([
                        response[j+1],//IDENTIFIANT
						response[j+2],//STRUCTURE
						response[j+3],//MOIS
						response[j+4],//ANNEE
						// '<label>'+date.toLocaleDateString('fr-FR',{month: 'long'})+'</label>',
						// '<label>'+date.getFullYear()+'</label>',
						// response[j+5],//TYPE
						'<label>'+((/*cafe==1 && autres==0*/response[j+5]==1)?'CAFE CACAO':/*cafe==1 && autres==1*/'AUTRES PRODUITS')+'</label>',
						response[j+6],//PONT6
						response[j+10],//NBC10
						response[j+7],//NBT7
						response[j+8],//COUT8
						response[j+9],//ID_PONT9
						//response[j+6],//COMPTE
						'<a class="btn btn-danger " style="color: white;" title="Télécharger le PDF de la facture" href="models/load_facture.php?userid='+response[j+1]+'&pont='+ response[j+9] +'&debut='+debut+'&fin='+fin+'&cafe='+cafe+/*'&cajou='+cajou+*/'&autres='+autres+'" target="_blank" ><i class="mdi mdi-file-pdf "></i></a>',
						'<button class="btn btn-info button-chargeurs" name="'+debut+'_'+fin+'_'+response[j+1]+'_'+response[j+5]/*cafe*/+'_'/*autres*+cajou+*/+response[j+9]+'"title="Voir le détails des tickets par chargeur" style="color: white;"><i class="mdi mdi-magnify-plus"></i></button>'
					]).columns.adjust().draw(false);
					
					j += response[2];
				}
			
			}
			
		},
		error: function(jqXHR, status, error) {
			hideloader();
			mssg(lang,7,error);
		}
	});//end ajax

}


$('.table-ponts').on('click','.button-chargeurs', function(){

	var tr = $(this).closest('tr');
	var id = $(this).prop('name').split("_");
 	
	if(id == id){
		showloader() ;

		$.ajax({

			url: './models/Get_chargeurs_model.php',
			type: 'POST',
			data: '&debut='+id[0]+'&fin='+id[1]+'&user_id='+id[2]+((id[3]==1)?'&cafe=1'+'&autres=0':'&cafe=0'+'&autres=1')+'&pont='+id[4],
			dataType: 'json',
			success:function(response){
				// console.log(id);
			 hideloader();
				
             $('.table-chargeurs').DataTable().clear().draw(false);
			 
             if(response[0]==0){
                var j = 2;
                for(var i = 0; i < response[1]; i++){
				
					$('.table-chargeurs').DataTable().row.add([
                        response[j+1],//IDENTIFIANT
						response[j+2],//NOM
						response[j+3],//NBT
						response[j+4],//COUT
						'<a class="btn btn-danger " style="color: white;" title="Télécharger le PDF des tickets" href="models/load_tickets.php?pont='+id[4]+'&chrg='+response[j+1]+'&debut='+id[0]+'&fin='+id[1]+((id[3]==1)?'&cafe=1'+'&autres=0':'&cafe=0'+'&autres=1')+'" target="_blank" ><i class="mdi mdi-file-pdf "></i></a>'+'&nbsp &nbsp &nbsp'+
						'<a class="btn btn-success" style="color: white;" title="Extraire les demandes au format CSV afin de les traiter dans Excell" href="models/load_csv.php?pont='+id[4]+'&chrg='+response[j+1]+'&debut='+id[0]+'&fin='+id[1]+'&cafe='+((id[3]==1)?'&cafe=1'+'&autres=0':'&cafe=0'+'&autres=1')+'" target="_blank" ><i class="mdi mdi-file-excel"></i></a>'
					]).columns.adjust().draw(false);
					
					j += response[2];
			
				}
			
				$('#chargeursModal').modal('show');

			}

			
		},//SUCCESS
			error: function(jqXHR, status, error) {
				hideloader();
				mssg(lang,9,error);
								
		 	}//ERROR
			 
		});//AJAX
	}

});


// $('#parametres').on('click', function(){

// 	// document.forms["form_ajout"].elements["mail"].value='';
// 	$('#compModal').modal('show');


// });


    
$('.table-chargeurs').on('click','.button-chargeurs', function(){

	var tr = $(this).closest('tr');
	var id = $(this).prop('name');
    	
	if(id == id){
		showloader() ;

		$.ajax({

			url: './models/Get_chargeurs_model.php',
			type: 'POST',
			data: 'id='+id,
			dataType: 'json',
			success : function(response){
				var formulaire = '.form-request-applicant-details';

				hideloader();
				
				if(response[0]==0){
					
					//$(formulaire+' input[name="'+champ+'"]').val(val1+((val2!="")?" ("+val2+")":""));
					$(formulaire+' input[name="identifiant"]').val(response[3]); //identifiant
					$(formulaire+' input[name="nom"]').val(response[4]);    //nom
					$(formulaire+' input[name="blocked"]').val(response[5]); //blocked
					$(formulaire+' input[name="ville"]').val(response[6]);  //ville
					$(formulaire+' input[name="commune"]').val(response[7]); //commune
					$(formulaire+' input[name="adresse_geo"]').val(response[8]); //adresse_geo
					$(formulaire+' input[name="NUM_CC"]').val(response[9]); //NUM_CC
					$(formulaire+' input[name="TELEPHONE"]').val(response[10]); //TELEPHONE
					$(formulaire+' input[name="EMAIL"]').val(response[11]); //EMAIL
					$(formulaire+' input[name="BP"]').val(response[12]); //BP
					console.log(response[4]);

					$('#chargeursModal').modal('show');
					
				}else{
		 			
					mssg(lang,8,response[0]);
					
		 		}

			
		},//SUCCESS
			error: function(jqXHR, status, error) {
				hideloader();
				mssg(lang,9,error);
		 	}//ERROR
		});//AJAX
	 }

});

