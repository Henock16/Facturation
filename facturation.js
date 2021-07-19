///
$(document).ready(function(){

    $(".table-affectations").DataTable({
        autoWidth: true,
        ordering:  false,
        language: {'url': 'vendors/datatables/French.json'},
        pageLength: 10,
		columnDefs: [
            { "visible": false, "targets": 0 },
       ],
		createdRow: function( row, data, dataIndex){
               if( data[1] ==  'JOUR'  ){
                    $(row).css({"background-color":"#dddd33"});
                }
		},
        
    });

	loadselect('PONT BASCULE / SITE D\'EMPOTAGE','Get_ponts_model','.form-triaffect select[name="pont"]',0);
	loadselect('ANNEE','Get_annee_model','.form-triaffect select[name="annee"]',0);
});
$('.form-triaffect').on('submit', function(e){
	
	e.preventDefault();

	trigeraffectations();
});	
//*/


function trigeraffectations(){
	
	
	var mois=$('.form-triaffect select[name="mois"]').val();
	var annee=$('.form-triaffect select[name="annee"]').val();
	var pont=$('.form-triaffect select[name="pont"]').val();
	loadChargeurs(mois,annee,pont);
}

// liste des chargeurs 
function loadChargeurs(mois,annee,pont)
{
	var debut='01/'+mois+'/'+annee;
	var fin='31/'+mois+'/'+annee;
	
	showloader() ;

	$.ajax({
		   
        url: './models/Get_facturation_model.php',
        type: 'POST',
		data: '&debut='+debut+'&fin='+fin+'&pont='+pont,
		dataType: 'json',
        success : function(response){
			hideloader();

            $('.table-affectations').DataTable().clear().draw(false);

            if(response[0] ==0){

                var j = 2,
                   
					details = '',
                    pdf = '';
                for(var i = 0; i < response[1]; i++){
					details='',
					pdf='<a class="btn btn-danger " style="color: white;" title="Télécharger le PDF de la demande" href="models/load_mpdf'+mpdf+'.php?id='+ response[j+1] +'&pont='+pont+'&debut='+debut+'&fin='+fin+'" target="_blank" ><i class="mdi mdi-file-pdf "></i></a>';
					$('.table-affectations').DataTable().row.add([
                        response[j+1],//IDENTIFIANT
						response[j+2],//NOM
						response[j+3],//NBT
						response[j+4],//COUT
						details='<button class="btn btn-info button-request-applicant-details" name="" title="Voir le détails de l\'affectation" style="color: white;"><i class="mdi mdi-magnify-plus"></i></button>',
						pdf
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
