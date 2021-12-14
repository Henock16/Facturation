
// click sur le menu changer mot de passe
$("#password").on('click',function(){

    $('#modal-NewPassword').modal('show');

});

// Poster les informations du formulaire si les mots de passe concordent
$("#form-NewPassword").on('submit',function(event){

    event.preventDefault();

    var mdp=document.forms["NewPassword-form"].elements["mdp"];
    var confmdp=document.forms["NewPassword-form"].elements["confmdp"];

    if(mdp.value != confmdp.value)
        mssg(lang,20,0);
    else if(mdp.value==$('.form-authentication input[name="user"]').val())
        mssg(lang,21,2);
    else if(mdp.value==pass)
        mssg(lang,21,1);
    else if(mdp.value.length<5)
        mssg(lang,21,0);
    else{
        var donnees = $(this).serialize();
        $.ajax({
            url : 'models/New_password_model.php',
            type : 'POST',
            data : donnees,
            dataType : 'json',
            success : function(data){
                if(data[0]==0){
                    $('#form-NewPassword')[0].reset();
                    mssg(lang,26,0);
                    $('#modal-NewPassword').modal('hide');
                }else
                    mssg(lang,27,data);
            },
            error: function(jqXHR, status, error) {
                mssg(lang,28,error);
            }
        });
    }

});
