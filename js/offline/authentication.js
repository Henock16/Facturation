$('.form-authentication').on('submit', function(e) {


    e.preventDefault();
    var data = $(this).serialize();

    $.ajax({

        url: './models/Authentication_model.php',
        type: 'POST',
        data: data,
        language: {'url': 'vendors/datatables/French.json'},
        dataType: 'json',
        success : function(data){
            //UTILISATEUR OU MOT DE PASSE ERRONE
            if(data[0] == 0){
                mssg(lang,2,0);
            }
            //COMPTE DESACTIVE
            else if(data[0] == 1){
                mssg(lang,3,0);
            }
            // COMPTE EN COURS D'UTILISATION
            else if(data[0] == 2){
                mssg(lang,4,session);
            }
            // MOT DE PASSE REINITIALISE
            else if(data[0] == 3){
                $('.form-authentication input[name="pass"]').val("");
                $('#form-NewPassword')[0].reset();
                $('#modal-NewPassword').modal('show');				
             }
            // PREMIERE CONNEXION
            else if(data[0] == 4){
				
               $('.form-authentication input[name="pass"]').val("");
                $('#form-FirstConnection')[0].reset();
                $('#title-FirstConnection').html('<i class="mdi mdi-head text-info"></i>&nbsp;<b>Bienvenue '+data[1]+'</b>');
				
                $('#bp').val(data[2]);
                $('#tel').val(data[3]);
                $('#numcc').val(data[4]);
                $('#adgeo').val(data[5]);
 
                if(data[6]!=null){
                    var mail=data[6].split(",");
                    for(var i = 0; i < mail.length; i++){
                        if(i>0)
                            $("#add_row1").click();
                        $('#mail'+i).val(mail[i]);
                    }
                }
                $('#mdp').val('');
                $('#confmdp').val('');
                $('#modal-FirstConnection').modal('show');

            }
            //CONNEXION
            else if(data[0] == 5){
                
                //window.location.replace('index.php'+((data[1]!='')?'?p='+data[1]:''));
                window.location.replace('index.php');
            }
        },
        error: function(jqXHR, status, error) {
              mssg(lang,6,error);
        }
    });
});