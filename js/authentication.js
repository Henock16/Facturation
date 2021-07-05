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
            // //COMPTE DESACTIVE
            // else if(data[0] == 1){
            //     mssg(lang,3,0);
            // }
            // COMPTE EN COURS D'UTILISATION
            // else if(data[0] == 2){
            //     mssg(lang,4,session);
            // }
            // PREMIERE CONNEXION
             if(data[0] == 3){
                $('.form-authentication input[name="pass"]').val("");
                 
				
                 $('#compte').val(data[1]);
                 $('#statut').val(data[2]);
            //     $('#firstvco').val(data[3]);
                 $('#ville').val(data[4]);
            //     $('#lastac').val(data[5]);
            //     $('#dernierac').val(data[6]);
            //     $('#lastp').val(data[7]);

              
                $('#mdp').val('');
                $('#confmdp').val('');
                $('#modal-FirstConnection').modal('show');
                
                // window.location.replace('index.php'+((data[1]!='')?'?p='+data[1]:''));
                window.location.replace('index.php');
            }
            else
            	mssg(lang,5,data);
        },
        error: function(jqXHR, status, error) {
              mssg(lang,6,error);
        }
    });
});