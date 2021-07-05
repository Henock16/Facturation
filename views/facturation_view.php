 <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
					<form class="form-triaffect">
						<div class="form-group row col-sm-12" style="margin-bottom:5px;">
							<!-- <h4 class="card-title col-sm-3 ">Facturation des affectations</h4> -->
						
							<input type="text" class="form-control col-sm-1 datepicker text-center" name="debut" value="" placeholder="DEBUT" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;"/>
							
							<input type="text" class="form-control col-sm-1 datepicker text-center" name="fin" value="" placeholder="FIN" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;"/>

							<!-- <select class="form-control col-sm-5" name="pont" style="float:left;height:30px;padding-right:5px;padding-top:5px;margin-left:5px;">
							</select> -->
		
							<button type="submit" id="submit-affectations" class="btn btn-success col-sm-1" style="float:left;height:30px;padding-left:5px;padding-right:5px;padding-top:5px;margin-left:5px;">Rechercher</button>
						</div>
					</form>
					<hr color="green" size="3" noshade />
                   <div class="table-responsive">
                    <table class="table table-hover table-affectations" width="100%">
                      <thead>
                        <tr>
                        <th>IDENTIFIANT</th>
                          <th>NOM</th>
                          <th>BLOCKED</th>
						              <th>VILLE</th>
                          <th>COMMUNE</th>
                          <th>ADRESSE_GEO</th>
                          <th>NUM_CC</th>
                          <th>TELEPHONE</th>
                          <th>EMAIL</th>
                          <th>BP</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                       </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>