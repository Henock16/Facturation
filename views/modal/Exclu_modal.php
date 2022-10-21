<div class="modal fade" id="modal-exclu" style="z-index: 1401;" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document" style="width:800px;">
		<div class="modal-content" style="border-radius: 3px;">
				<div class="modal-header" id="modal-exclu-header">
          			<h4 class="modal-title lead" style="font-weight: bold;color:white" id="modal-exclu-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
              <form class="form-exclu">
				<div class="modal-body" style=" overflow-y:auto;">
                    <div class="row" id="exclu-form" style="vertical-align: center">
						<div class="col-md-12" style="margin-bottom: 0px">
							<label style="float:left;">Liste des chargeurs à exclures</label>
							<div class="input-group col-sm-6"  style="float:right;">
								<select id="act" class="form-control"  name="char_des" style="height:30px">
									<option value="">CHARGEUR </option>
								</select>
								&nbsp;&nbsp;
								<input id="texact" type="text" name="numcc_des" class="form-control" placeholder="Entrez le NUM_CC "  style="height:30px">
								&nbsp;&nbsp;
								<button type="button" id="submit_ex"class="btn btn-success pull-right">Activer</button>
							</div>
						</div>
						<div class="col-md-12" style="padding-top:0px;height:30px;margin-bottom: 0px">
						</div>
						<div class="col-md-12" style="padding-top:0px;height:30px;margin-bottom: 0px">
						</div>
						<div class="col-md-12" style="padding-top:0px;height:30px;margin-bottom: 0px">
							<label style="float:left;">Liste des chargeurs exclu</label>
							<div class="input-group col-sm-8"  style="float:right;">
								<select id="des" class="form-control" name="char_act" style="height:30px">
									<option value="">CHARGEUR </option>
								</select>
								&nbsp;&nbsp;
								<input id="texdes" type="text" name="numcc_act" class="form-control"  style="height:30px">
								&nbsp;&nbsp;
								<button type="button" id="submit"class="btn btn-danger pull-right" >Desactiver</button>
								&nbsp;&nbsp;
								<button type="button" id="modif"class="btn btn-warning pull-right">Modifier</button>
							</div>
						</div>
                    </div>
                </div>
				<div class="modal-footer"  style=" ">
					<button type="button" data-dismiss="modal"class="btn btn-danger pull-center ">Fermer</button>
				</div>
			  </form>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>