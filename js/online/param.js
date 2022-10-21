$('#param').on('click', function() {

    showloader();

    $.ajax({

        url: './models/Get_param_model.php',
        type: 'POST',
        data: '',
        dataType: 'json',
        success: function(response) {

            hideloader();

            if (response[0] != 0)
                mssg(lang, 9, response);
            else {

                $('#modal-param-title').html('<i class="mdi mdi-lead-pencil"></i>&nbsp; Modification des paramètres de l\'application');
                $('#modal-param-header').css("background-color", 'orange');


                var j = 3;
                var list = "";
                for (var i = 0; i < response[1]; i++) {
                    //list += "<option value=\""+response[j]+"\" "+((response[j]==response[1])?"selected=\"selected\"":"")+"> | "+((response[j+2]<10)?"&nbsp;&nbsp;":"")+""+((response[j+2]==null)?"0 ":response[j+2]+" ")+"hr | "+((response[j+3]<10)?"&nbsp;&nbsp;":"")+""+response[j+3]+" affect | "+response[j+1]+((response[j+4]!="")?" ["+response[j+4]+"]":"")+"</option>";							
                    list += '<div class="col-md-12" style="margin-bottom: 0px">';
                    list += '<label class="col-sm-5" style="padding-top:0px;height:30px;">' + response[j + 2] + '</label>';
                    list += '<label class="badge badge-primary" style="border-radius: 15px;height:30px;width:30px;padding-top: 9px" title="' + response[j + 4] + '"><i class="mdi mdi-information"></i></label>';
                    list += '<div class="input-group col-sm-6"  style="float:right">';
                    if (response[j + 5] == 'text' || response[j + 5] == 'number')
                        list += '<input type="' + response[j + 5] + '" class="form-control" name="' + response[j + 1] + '" value="' + response[j + 3] + '" placeholder="" style="height:30px" required/>';
                    else if (response[j + 5] == 'ouinon') {
                        list += '<label for="' + response[j + 1] + '1" class="col-sm-6 btn btn-success" style="color:white;height:30px;padding-top:5px;text-align:left">';
                        list += '<input type="radio" class="user-details" name="' + response[j + 1] + '" id="' + response[j + 1] + '1" value="1" ' + ((response[j + 3] == 1) ? 'checked' : '') + '/>';
                        list += 'OUI</label>';
                        list += '<label for="' + response[j + 1] + '0" class="col-sm-6 btn btn-danger" style="color:white;height:30px;padding-top:5px;text-align:left">';
                        list += '<input type="radio" class="user-details" name="' + response[j + 1] + '" id="' + response[j + 1] + '0" value="0" ' + ((response[j + 3] == 0) ? 'checked' : '') + '/>';
                        list += 'NON</label>';
                    }

                    list += '</div>';
                    list += "</div>";
                    j += response[2];
                }
                $('#param-form').html(list);


                $('#modal-param').modal('show');

            } //FIN 

        }, //SUCCESS
        error: function(jqXHR, status, error) {
                hideloader();
                mssg(lang, 9, error);
            } //ERROR
    }); //AJAX

}); //ONCLICK


$('.form-param').on('submit', function(e) {

    e.preventDefault();

    showloader();

    var postdata = $('.form-param').serialize();

    $.ajax({

        url: './models/Set_param_model.php',
        type: 'POST',
        data: postdata,
        dataType: 'json',
        success: function(response) {

            hideloader();

            if (response[0] != 0)
                mssg(lang, 11, response);
            else {

                $('#modal-param').modal('hide');
            } //FIN 

        }, //SUCCESS
        error: function(jqXHR, status, error) {
                hideloader();
                mssg(lang, 10, error);
            } //ERROR
    }); //AJAX

}); //ONSUBMIT
/////parametre js d'exclusion
//au click du boutton exclure dans parametre
$('#exclu').on('click', function() {

        loadselect('CHARGEUR', 'Get_chargeur_bds_model', '.form-exclu select[name="char_des"]', 0);
        loadselect('CHARGEUR', 'Get_chargeur_bdf_model', '.form-exclu select[name="char_act"]', 0);
        // showloader() ;
        $('#modal-exclu-title').html('<i class="mdi mdi-lead-pencil"></i>&nbsp;  Exclusion De chargeur');
        $('#modal-exclu-header').css("background-color", 'green');
         
        
        $('#modal-exclu').modal('show');
        
     });

$('.form-exclu').on('click', '#submit', function(e) {
        hideloader();
        var char_act = $('.form-exclu select[name="char_act"]').val();
        var char_des = $('.form-exclu select[name="char_des"]').val();
        var numcc= $('.form-exclu input[name="numcc_des"]').val();

        showloader();

        $.ajax({

            url: './models/Get_Exclu_chargeur_models.php',
            type: 'POST',
            data: '&char_act=' + char_act + '&char_des=' + char_des+'&numcc='+numcc,
            dataType: 'json',
            success: function(response) {

                hideloader();
                if (response[0] == 1) {

                    mssg(lang, 31);
                    hideloader();
                    loadselect('CHARGEUR', 'Get_chargeur_bdf_model', '.form-exclu select[name="char_act"]', 0);
                    loadselect('CHARGEUR', 'Get_chargeur_bds_model', '.form-exclu select[name="char_des"]', 0);

                }


            },
            error: function(jqXHR, status, error) {
                    hideloader();
                    // mssg(lang, 9, error);
                    mssg(lang, 33);
                } //ERROR
        });

    })
    
$('.form-exclu').on('click', '#submit_ex', function(e) {
    hideloader();
    var char_act = $('.form-exclu select[name="char_act"]').val();
    var char_des = $('.form-exclu select[name="char_des"]').val();
    var numcc= $('.form-exclu input[name="numcc_des"]').val();

    showloader();

    $.ajax({

        
        url: './functions/Exclu_chargeur_function.php',
        type: 'POST',
        data: '&char_act=' + char_act + '&char_des=' + char_des+'&numcc='+numcc,
        dataType: 'json',
        success: function(response) {

            hideloader();
            if (response[0] == 0) {
                mssg(lang, 30);
                hideloader();
                loadselect('CHARGEUR', 'Get_chargeur_bdf_model', '.form-exclu select[name="char_act"]', 0);
                loadselect('CHARGEUR', 'Get_chargeur_bds_model', '.form-exclu select[name="char_des"]', 0);
            } else if (response[0] == 2) {
                mssg(lang, 32);
                hideloader();
                loadselect('CHARGEUR', 'Get_chargeur_bdf_model', '.form-exclu select[name="char_act"]', 0);
                loadselect('CHARGEUR', 'Get_chargeur_bds_model', '.form-exclu select[name="char_des"]', 0);
                // $('#utilplate-structure').val($('#utilplate-expor option:selected').text());
             
            }

        },
        error: function(jqXHR, status, error) {
                hideloader();
                mssg(lang, 33, error);
                // mssg(lang, 9, error);
            } //ERROR
    });

})

///affichage dans les input type texte en fonction de la liste deroulante
    $('#des').on("change",function(){
        ///on utilise cette option que si on veut afficher le text du select
        // var selectext= $('#act :selected').text();
        // $('#texact').val(selectext);
        ///on utilise cette option que si on veut afficher la valeur du select (son id ou une autres valeur de la bd)
        var selValue = $("#des").val();
        $("#texdes").val(selValue);

    }).change();

    //  if($('.form-exclu input[name="numcc_act"]').val()==$('.form-exclu select[name="char_act"]').val())
    //  {
    //     $('#modif').prop('disabled', true);
    // }else $('#modif').prop('disabled', false);

    $('.form-exclu').on('click', '#modif', function(e) {
    hideloader();
    var char_act = $('.form-exclu select[name="char_act"]').val();
    var char_des = $('.form-exclu select[name="char_des"]').val();
    var numcc= $('.form-exclu input[name="numcc_act"]').val();
   
    showloader();

    $.ajax({

        
        url: './functions/Exclu_chargeur_function.php',
        type: 'POST',
        data: '&char_act=' + char_act + '&char_des=' + char_des+'&numcc='+numcc,
        dataType: 'json',
        success: function(response) {
             if (response[0] == 4) {
                mssg(lang, 34);
                hideloader();
                loadselect('CHARGEUR', 'Get_chargeur_bdf_model', '.form-exclu select[name="char_act"]', 0);
                loadselect('CHARGEUR', 'Get_chargeur_bds_model', '.form-exclu select[name="char_des"]', 0);
                // $('#utilplate-structure').val($('#utilplate-expor option:selected').text());
             }
             else{
                hideloader();
                mssg(lang, 35);
             }

        },
        error: function(jqXHR, status, error) {
                hideloader();
                mssg(lang, 35, error);
                // mssg(lang, 9, error);
            } //ERROR
    });

})