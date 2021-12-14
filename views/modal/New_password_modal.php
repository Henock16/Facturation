<!-- Modal -->
<div class="modal fade" id="modal-NewPassword" role="dialog" data-keyboard="false"  data-backdrop="static">

    <div class="modal-dialog" style="width:300px;">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title lead" style="font-weight: bold;"><i class="mdi mdi-lock-open-check text-warning"></i>&nbsp;Nouveau mot de passe</h4>
            </div>

            <div class="modal-body">

                <form class="form" role="form" method="post" action="#" name="NewPassword-form" id="form-NewPassword">


                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="mdp" id="mdp-new-password" placeholder="Nouveau mot de passe" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="confmdp" id="confmdp-new-password" placeholder="Confirmer le mot de passe" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
                        </div>
                    </div>

                    <div class="modal-footer">
						<table width="100%">
							<tr>
								<td style="margin-bottom:0px;margin-top:0px;">
									<button type="button" class="btn btn-danger pull-right" data-dismiss="modal" style=" height:30px;font-size:15px;text-align:center; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);">Annuler</button>
								</td>
								<td align="right" style="margin-bottom:0px;margin-top:0px;">
									<button type="submit" class="btn btn-success " style=" height:30px;font-size:15px;text-align:center; box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -moz-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5); -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.5);">Modifier</button>
								</td>
							</tr>
						</table>
                    </div>

                 </form>

            </div>
        </div>

    </div>
</div>