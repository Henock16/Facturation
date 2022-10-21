<div id="modal-user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg"  style="width:600px;">
                    <div class="modal-content">
						<div class="modal-header" id="modal-user-header">
							<h4 class="modal-title lead" style="font-weight: bold;color:white" id="modal-user-title"></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
                        <form class="form-inline form-user" method="POST" style="display:block">
							<div class="modal-body">
								<input type="hidden" name="action-id"  value=""/>
								<input type="hidden" name="user-id"  value=""/>
								<div class="form-group row" id="statut" style="margin-bottom:0px;">
									<label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left">Statut</label>
									<div class="input-group col-sm-8"  style="float:right">
										<label for="statut0" class="col-sm-6 btn btn-success" style="color:white;height:30px;padding-top:5px;text-align:left">
										<input type="radio" class="user-details" name="statut" id="statut0" value="0"/>
										Actif</label>
										<label for="statut1" class="col-sm-6 btn btn-danger" style="height:30px;padding-top:5px;text-align:left">
										<input type="radio" class="user-details" name="statut" id="statut1" value="1"/>
										Inactif</label>
									</div>
								</div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Structure</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="structure" class="form-control user-details" style="height:30px" required  onkeyup='this.value=this.value.toUpperCase()'>
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Login</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="login" class="form-control user-details"  style="height:30px" required>
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Numéro C. C.</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="numcc" class="form-control user-details" style="height:30px"  maxlength="9" onkeyup='this.value=this.value.toUpperCase()'>
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Boite Postale</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="bp" class="form-control user-details" style="height:30px" >
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Numéro de téléphone</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="tel" class="form-control user-details" style="height:30px" maxlength="10" onkeypress="return ((event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 32 || event.charCode == 45 || event.charCode == 47))">
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Adresse géographique</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="text" name="adresse" class="form-control user-details" style="height:30px">
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;">
                                    <label class="col-sm-4" style="padding-top:0px;height:30px;text-align:left" >Acompte</label>
									<div class="input-group col-sm-8"  style="float:right">
										<input type="number" name="acompte" class="form-control user-details" style="height:30px">
									</div>
                                </div>
                                <div class="form-group row" style="margin-top:0px;margin-bottom:0px;vertical-align:top;">
									<input type="hidden" name="pont"  value=""/>
					                <label class="col-sm-4" style="padding-top:0px;height:30px; position: relative;" ></label>
									<div class="multiselect input-group col-sm-8"  style="float:right">
										<div id="pont" class="selectBox form-control user-details col-sm-12" style="height:100%;padding:0px">
										  <select >
											<option>Ponts bascules / Sites d'empotage et Impayés</option>
										  </select>
										  <div class="overSelect"></div>
										</div>
										<div id="checkboxes" class="col-sm-12" style="padding-left:2px;padding-right:2px;">
										</div>
									</div>
                                </div>
								
  
 							</div>							
							<div class="modal-footer">
							  <button type="button" data-dismiss="modal"class="btn btn-info pull-center archive-request-div-to-hide archive-request-close">Fermer</button>
							  <button type="submit" class="btn btn-primary" id="submit-user" style=" box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);"></button>
							</div>
                        </form>
                    </div>		
            </div>		
</div>		