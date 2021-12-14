	<!-- Modal -->
			<div class="modal fade" id="modal-FirstConnection" role="dialog" data-backdrop="static" data-keyboard="false">
			
				<div class="modal-dialog">
    
					<!-- Modal content-->
					<div class="modal-content">
					
						<div class="modal-header" style="background-color:lightgreen;height:50px">
							<h2 class="modal-title"  id="title-FirstConnection" style="font-weight: bold;color:white"></h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-weight: bold;color:white">&times;</span></button>
						</div>
						
						<div class="modal-body">
							<p align="center" style="color: red;font-size:12px"><i>Pour votre premi&egrave;re connexion &agrave; l'application, veuillez s'il vous pla&icirc;t corriger ou renseigner soigneusement vos informations personnelles.</i></p>  
							<p align="center" style="color: blue;font-size:12px">Celles-ci sont importantes car elles vous permettront de récupérer votre mot de passe en cas de perte ou d'oubli de celui-ci.</p>  
		
							<form class="form" role="form" method="post" action="#" name="FirstConnection-form"  id="form-FirstConnection">
						
								<div class="col-sm-12" align="left" style="background-color:lightgray">
									<p style="font-weight: bold; color: #337ab7; font-size: 16px">STRUCTURE</p>							
								</div>
				
								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="numcc" style="height:30px">Numéro C. C.</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="numcc" id="numcc" placeholder="Numéro de compte contribuable" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required maxlength="8" onkeyup='this.value=this.value.toUpperCase()'/>
									</div>
								</div>
					
								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="bp" style="height:30px">Boite Postale</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="bp" id="bp" placeholder="Boite Postale" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</div>
								</div>
			
								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="tel" style="height:30px">Numéro de téléphone</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="tel" id="tel" placeholder="Numéro de téléphone" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required maxlength="10" onkeypress="return ((event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 32 || event.charCode == 45 || event.charCode == 47))"/>
									</div>
								</div>
						
								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="adgeo" style="height:30px">Adresse Geographique</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="adgeo" id="adgeo" placeholder="Adresse Geographique" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</div>
								</div>
			
								<div class="form-group row" style="margin-bottom:10px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" style="height:30px">Adresse(s) électronique(s)<br/></label>
									<div class="col-sm-7">
										<div class="row clearfix">
											<div class="col-md-12 column" >
												<table class="table table-bordered table-hover" id="tab_logic1">
													<tr id='addrm0'>
														<td style="padding-bottom:2px;padding-top:2px;padding-left:2px;padding-right:2px;">
															<input type="text" name='mail0' id='mail0' placeholder='Adresse mail' style="height:30px" class="form-control" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required onkeypress="return ((event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 64 || event.charCode == 45 || event.charCode == 46))"/>
														</td>
													</tr>
													<tr id='addrm1'></tr>
												</table>
											</div>
										</div>
										
										<table border="0" width="100%">
											<tr>
												<td>
										<a id='delete_row1' class="btn btn-danger" style="align:left;border-radius:3px; height:20px;font-size:12px;text-align:center;color:white;font-weight: bold;box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);margin-top:-3px;padding-top:3px;padding-left:5px;padding-right:5px;" title="Supprimer un mail">-</a>
												</td><td align="right">
										<a id="add_row1" class="btn btn-success" style="align:right;border-radius:3px; height:20px;font-size:12px;text-align:center;color:white;font-weight: bold;box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);margin-top:-3px;padding-top:3px;padding-left:5px;padding-right:5px;" title="Ajouter un mail">+</a>
												</td>
											</tr>
										</table>
			
									</div>
								</div>
								
								<div class="col-sm-12" align="left" style="background-color:lightgray">
									<p style="font-weight: bold; color: #337ab7; font-size: 16px">MOT DE PASSE</p>							
								</div>

								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="mdp-first-connect" style="height:30px">Nouveau mot de passe</label>
									<div class="col-sm-7">
										<input type="password" class="form-control" name="mdp" id="mdp-first-connect" placeholder="Nouveau mot de passe" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</div>
								</div>
								
								<div class="form-group row" style="margin-bottom:0px;margin-top:0px;">
									<label  class="col-sm-5 col-form-label" for="confmdp-first-connect" style="height:30px">Confirmer le mot de passe</label>
									<div class="col-sm-7">
										<input type="password" class="form-control" name="confmdp" id="confmdp-first-connect" placeholder="Confirmer mot de passe" style="height:30px" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</div>
								</div>
			
								<div class="form-group" style="margin-bottom:0px;margin-top:10px;">
									<table width="100%">
										<tr>
											<td style="margin-bottom:0px;margin-top:0px;">
												<button type="button" class="btn btn-danger" style="border-radius:3px; height:30px;font-size:15px;text-align:center; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);" data-dismiss="modal" >Fermer</button>
											</td>
											<td align="right" style="margin-bottom:0px;margin-top:0px;">
												<button type="submit" class="btn btn-success" style="border-radius:3px; height:30px;font-size:15px;text-align:center; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);">Valider</button>
											</td>
										</tr>
									</table>
								</div>
								
							</form>
		
						</div>
					</div>
      
				</div>
			</div>

