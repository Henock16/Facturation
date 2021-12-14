
<div class="modal fade" id="modal-confirmation" style="z-index: 1401;" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 3px;">
				<div class="modal-header" id="modal-confirmation-header">
          			<h4 class="modal-title lead" style="font-weight: bold;color:white" id="modal-confirmation-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
              <form class="form-confirmation">
				<div class="modal-body" style="max-height: 500px; overflow-y:auto;">
                    <div class="row" style="vertical-align: center">
                        <div class="col-md-3" >
                            <img id="confirmation-image" src="" width="100">
                        </div>
                        <input type="hidden"  name="confirmation-id" value="">
                        <input type="hidden"  name="action-id" value="">
                        <input type="hidden"  name="statut" value="">
                        <input type="hidden"  name="model" value="">
                        <input type="hidden"  name="table" value="">
                        
						<div class="col-md-9" style="margin-bottom: 0px">
                            <p id="confirmation-message" class="lead " style="margin-bottom: 20px;font-size: medium;vertical-align: center">

                            </p>
                        </div>
                    </div>
                </div>
				<div class="modal-footer"  style=" ">
					<button type="button" data-dismiss="modal"class="btn btn-danger pull-center ">Non</button>
					<button type="submit" id="submit"class="btn btn-success pull-right">Oui</button>
				</div>
			  </form>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>



