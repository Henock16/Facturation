

$('#param').on('click', function(){

	showloader() ;

	$.ajax({

		url: './models/Get_param_model.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(response){

			hideloader();

			if(response[0]!=0)
				mssg(lang,9,response);
			else{

				$('#modal-param-title').html('<i class="mdi mdi-lead-pencil"></i>&nbsp; Modification des paramètres de l\'application');
				$('#modal-param-header').css("background-color",'orange');


				var j = 3;
				var list = "";
				for(var i = 0; i < response[1]; i++){
					//list += "<option value=\""+response[j]+"\" "+((response[j]==response[1])?"selected=\"selected\"":"")+"> | "+((response[j+2]<10)?"&nbsp;&nbsp;":"")+""+((response[j+2]==null)?"0 ":response[j+2]+" ")+"hr | "+((response[j+3]<10)?"&nbsp;&nbsp;":"")+""+response[j+3]+" affect | "+response[j+1]+((response[j+4]!="")?" ["+response[j+4]+"]":"")+"</option>";							
					list += '<div class="col-md-12" style="margin-bottom: 0px">';							
					list += '<label class="col-sm-5" style="padding-top:0px;height:30px;">'+response[j+2]+'</label>';							
					list += '<label class="badge badge-primary" style="border-radius: 15px;height:30px;width:30px;padding-top: 9px" title="'+response[j+4]+'"><i class="mdi mdi-information"></i></label>';							
					list += '<div class="input-group col-sm-6"  style="float:right">';							
					if(response[j+5]=='text' || response[j+5]=='number')
						list += '<input type="'+response[j+5]+'" class="form-control" name="'+response[j+1]+'" value="'+response[j+3]+'" placeholder="" style="height:30px" required/>';							
					else if(response[j+5]=='ouinon'){
						list += '<label for="'+response[j+1]+'1" class="col-sm-6 btn btn-success" style="color:white;height:30px;padding-top:5px;text-align:left">';							
						list += '<input type="radio" class="user-details" name="'+response[j+1]+'" id="'+response[j+1]+'1" value="1" '+((response[j+3]==1)?'checked':'')+'/>';							
						list += 'OUI</label>';							
						list += '<label for="'+response[j+1]+'0" class="col-sm-6 btn btn-danger" style="color:white;height:30px;padding-top:5px;text-align:left">';							
						list += '<input type="radio" class="user-details" name="'+response[j+1]+'" id="'+response[j+1]+'0" value="0" '+((response[j+3]==0)?'checked':'')+'/>';							
						list += 'NON</label>';							
					}
					list += '</div>';							
					list += "</div>";							
					j += response[2];
				}
				$('#param-form').html(list);


				$('#modal-param').modal('show');		

			}//FIN 

		},//SUCCESS
		error: function(jqXHR, status, error) {
			hideloader();
			mssg(lang,9,error);
		}//ERROR
	});//AJAX

});//ONCLICK


$('.form-param').on('submit', function(e){

	e.preventDefault();

	showloader() ;

    var postdata = $('.form-param').serialize();

	$.ajax({

		url: './models/Set_param_model.php',
		type: 'POST',
		data: postdata,
		dataType: 'json',
		success : function(response){

			hideloader();

			if(response[0]!=0)
				mssg(lang,11,response);
			else{

				$('#modal-param').modal('hide');		
			}//FIN 

		},//SUCCESS
		error: function(jqXHR, status, error) {
			hideloader();
			mssg(lang,10,error);
		}//ERROR
	});//AJAX

});//ONSUBMIT
    




