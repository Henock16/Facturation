
//Deconnexion de  l'application
$('#logout').on('click', function(e){
 
	var x = 1;
 
	e.preventDefault();

	$.ajax({

		url : './models/Deconnection_model.php',
		type : 'POST',
   		data: '&x='+x,
  		success : function(data){

			if(data[0] == 0){

				$("body").fadeOut(1500);
				setTimeout( function(){
					window.location.replace('index.php');
				}, 1500);
			}
		}
	});
});




