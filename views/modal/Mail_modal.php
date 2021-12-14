
 <!-- Modal -->
 <div id="modal-mail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background-color: lightblue;">
                          <h4 id="myModalLabel" style="margin-top: 5px;margin-bottom: 5px;"><i class="mdi mdi-magnify-plus"></i>Gestion des adresses électroniques</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form name="form_ajout" id="ajout_form" class="form-inline" style="display:block">
                                <div class="input-group">
                                    <input type="text" name="mail" class="form-control col-sm-10" placeholder="Entrer une nouvelle adresse électronique ici" style="height:30px;" aria-describedby="basic-addon1">
									<button type="button" class="btn btn-success col-sm-2" id="ajout_mail"  style="height:30px; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);">Ajouter</button>
                                </div>
								<input type="hidden" name="action" value="ajouter"/>
							</form>
                        </div>
                        <div class="col-sm-12" id="scroll" style="border: solid 0px #C2C2C2; padding-left:14px;">
                            <table id="mails" class="table table-sm " style="margin-bottom: 0px; font-size: 12px;margin-left:0px">
                                <thead id="head-tag">
                                </thead>
                                <tbody id="body-tag">		 
                                </tbody>                                  
                           </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" data-dismiss="modal"class="btn btn-info pull-center archive-request-div-to-hide archive-request-close">Fermer</button>
                        </div>
                    </div>		
                </div>		
</div>		

               