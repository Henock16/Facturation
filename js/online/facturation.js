$(document).ready(function(){

    $(".table-affectations").DataTable({
        autoWidth: true,
        ordering:  false,
        language: {'url': 'vendors/datatables/French.json'},
        //pageLength: nbreserv,
		createdRow: function( row, data, dataIndex){
               if( data[1] ==  'JOUR'  ){
                    $(row).css({"background-color":"#dddd33"});
                }
		},
        dom: 'Bfrtip',
		buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    });

	//loadselect('PONT BASCULE / SITE D\'EMPOTAGE','Get_ponts_model','.form-triaffect select[name="pont"]',0);
});
//END FUNCTION


///*
$('.form-triaffect').on('submit', function(e){
	
	e.preventDefault();

	trigeraffectations();
});	
//*/


function trigeraffectations(){
	
	var factur=$('.form-triaffect select[name="facturation"]').val();
	var debut=$('.form-triaffect input[name="debut"]').val();
	var fin=$('.form-triaffect input[name="fin"]').val();
	loadChargeurs(factur,debut,fin);
}

// liste des chargeurs 
function loadChargeurs(factur,debut,fin)
{
	showloader() ;

	$.ajax({
		   
        url: './models/Get_facturation_model.php',
        type: 'POST',
		data: 'factur='+factur+'&debut='+debut+'&fin='+fin,
		dataType: 'json',
        success : function(response){
			hideloader();

            $('.table-affectations').DataTable().clear().draw(false);

            if(response[0] > 0){

                var j = 1,
                   
					non = '',
                    oui = '';
                for(var i = 0; i < response[0]; i++){
					$('.table-affectations').DataTable().row.add([
                        response[j+1],//IDENTIFIANT
						response[j+2],//NOM
						response[j+3],//BLOCKED
						response[j+4],//VILLE
						response[j+5],//COMMUNE
						response[j+6],//ADRESSE_GEO
						response[j+7],//NUM_CC
						response[j+8],//TELEPHONE
						response[j+9],//EMAIL
						response[j+10],//BP
					]).columns.adjust().draw(false);
						j += 11;
			}
			
			}
			
		},
		error: function(jqXHR, status, error) {
			hideloader();
			mssg(lang,7,error);
		}
	});//end ajax
}
