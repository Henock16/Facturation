//Expension du multiselect des ponts
var expanded = false;

$(document).ready(function(){

    $(".table-users").DataTable({
        autoWidth: true,
        ordering:  false,
        language: {'url': 'vendors/datatables/French.json'},
        pageLength: nbuser,
		columnDefs: [
            { "visible": false, "targets": 0 },
        ],
		createdRow: function( row, data, dataIndex){
               if( data[1] ==  'JOUR'  ){
                    $(row).css({"background-color":"#dddd33"});
                }
		},
        
    });
	
});


$('#users').on('click', function(){
	    
	LoadUtilisateurs();
 
});

function LoadUtilisateurs(){
	
	showloader() ;

	$.ajax({
		   
        url: './models/Get_users_model.php',
        type: 'POST',
        data: 'statut=1',
		dataType: 'json',
        success : function(response){
            hideloader();
            $('.table-users').DataTable().clear().draw(false);
			
            if(response[0] ==0){

                
                var j = 2,
                    actif = '',
                    modif = '',
                    reini = '';

                for(var i = 0; i < response[1]; i++){

                    if(response[j+2]==0)
						actif = '<button class="btn btn-danger button-users" name="'+response[j+1]+'_3_'+response[j+2]+'" title="Désactiver" style="color: white;"><i class="mdi mdi-cancel"></i></button>'; 
					else
						actif = '<button class="btn btn-success button-users" name="'+response[j+1]+'_3_'+response[j+2]+'" title="Activer" style="color: white;"><i class="mdi mdi-check"></i></button>'; 
					
					if(response[j+2]==0)
						modif = '<button class="btn btn-warning button-users" name="'+response[j+1]+'_2_'+response[j+2]+'" title="Modifier" style="color: white;"><i class="mdi mdi-lead-pencil"></i></button>';
					else
						modif='';

					if(response[j+2]==0 && response[j+3]==1)
						reini = '<button class="btn btn-secondary button-users" name="'+response[j+1]+'_4_'+response[j+2]+'" title="Réinitialiser le mot de passe" style="color: white;"><i class="mdi mdi-key"></i></button>';
					else
						reini='';
					
					$('.table-users').DataTable().row.add([
                        response[j+1],//IDENTIFIANT
						'<center><label class="badge badge-'+statuscolor((response[j+2]==0)?3:5)+'" style="border-radius: 5px;height:20px;padding-top:3px;">'+Statut(response[j+2])+'</label></center>',//STATUT
						response[j+4],//LOGIN
						response[j+5],//STRUCTURE
						response[j+6],//PONT
                        '<span style="white-space:nowrap">'+actif+' '+modif+' '+reini+'</span>',
					]).columns.adjust().draw(false);
					
					j += response[2];
                }
				
				$('#modal-users').modal('show');

            }

            },
            error: function(jqXHR, status, error) 
            {
                hideloader();
                mssg(lang,7,error);
            }

    });//end ajax
        
}

function LoadUser(id){
	
		showloader() ;

		$.ajax({

			url: './models/Get_user_details_model.php',
			type: 'POST',
			data: 'id='+id[0]+'&action='+id[1]+'&statut='+id[2],
			dataType: 'json',
			success : function(response){

				hideloader();

				if(response[0]!=0)
					mssg(lang,8,response[0]);
				else if(id[1]==0 || id[1]==1 || id[1]==2)//DETAILS //MODIFICATION
					loadform(id[0],id[1],id[2],'user','utilisateur',response);

			},//SUCCESS
			error: function(jqXHR, status, error) {
				hideloader();
				mssg(lang,9,error);
			}//ERROR
		});//AJAX
	
}

$('.table-users').on('click','.button-users', function(){
	
    var tr = $(this).closest('tr');
    var id = $(this).prop('name').split("_");

    if(id[1]==3 || id[1]==4){
		
		Confirmation(id[0],id[1],id[2],"Process_user_model","table-users","Voulez-vous vraiment "+((id[1]==4)?"réinitialiser le mot de passe de":((id[2]==0)?"dés":"")+"activer")+" cet utilisateur ?");

	}else if(id[1]==1 || id[1]==2){
		
		LoadUser(id);
	}
  
});//ONCLICK


$('#user-create-button').on('click', function(){
 
	var id=[0,0,0];

	LoadUser(id);
});


$('.form-user input[name="structure"]').on('keyup', function(){
 
	var login=$('.form-user input[name="structure"]').val().toLowerCase().split(' ');
 
	$('.form-user input[name="login"]').val(login[0]);
});

$('#pont').on('click', function(){
	 
	ChangeExpension(expanded) 
});

function ChangeExpension(exp){
	
  var checkboxes = document.getElementById("checkboxes");

  if(!exp){
    checkboxes.style.display = "block";
    expanded = true;
  }else{
    checkboxes.style.display = "none";
    expanded = false;
  }
	
}

$('.form-user').on('submit', function(e){
	
	e.preventDefault();

	showloader() ;

    var postdata = $(this).serialize();
	$.ajax({

		url: './models/Process_user_model.php',
		type: 'POST',
		data: postdata,
		dataType: 'json',
		success : function(response){

			hideloader();

			if(response[0]==0){
				
				$('#modal-user').modal('hide');
				
				LoadUtilisateurs();
				
			}else
				mssg(lang,11,response[0]); 
		},//SUCCESS
		error: function(jqXHR, status, error) {
			hideloader();
			mssg(lang,10,error);
		}//ERROR
	});//AJAX
});

