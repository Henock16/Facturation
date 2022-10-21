<!-- <script type="text/javascript">
    windows.onload = function(){
    var a =document.getElementById("submit-text");
    a.onclick = function() {
      function dowloadInnerHtml(filename,elId,mineType){
        var elHtml = document.getElementById(elId).innerHTML;
        var link = document.createElement('a');
        mineType= mineType || 'text/plain';
        link.setAttribute('dowload',filename);
        link.setAttribute('href','data:' +mineType+';charset=utf-8,'+encodeURIComponent(elHtml));
        link.click();
      }
      var fileName ='myexportedhtml.txt';
      dowloadInnerHtml(fileName,'text','text/plain');

      return false;
    }
  }
</script> -->
<div class="col-lg-12 grid-margin stretch-card" style="margin-top:30px">

              <div class="card">
                <div class="card-body">
				
					<form class="form-ponts">
					
						<div class="form-group row col-sm-12" style="margin-bottom:5px;">
									
						<!-- <h4 class="card-title col-sm-3 ">Facturation des affectations</h4> -->
								
						  
						<!-- <select class="form-control col-sm-1" name="annee" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;" required>
							<option value="">ANNEE</option>
						</select> -->

                  <div class="col-sm-2">
                      <input class="form-control datepicker" name="dateD" placeholder="Date de début" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;" required>
                  </div>
                  <div class="col-sm-2">
                      <input class="form-control datepicker" name="dateF" placeholder="Date de fin" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;" required>
                  </div>
						
            <select class="form-control col-sm" name="strc" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;">
							<option value="">PROPRIETAIRE</option>
						</select>
              &nbsp;&nbsp;
            <select class="form-control col-sm" name="char" style="float:left;height:30px;padding-left:5px;padding-right:5px;margin-left:5px;">
              <option value="">CHARGEUR</option>
            </select>

						<input type="hidden" name="pont" value="">
            <input type="hidden" name="user_id" value="">   
					 
						<label class="btn btn-light" style="float:left;height:30px;padding-right:5px;padding-top:3px;padding-left:5px;margin-left:5px;">&nbsp;<input type="checkbox" value="1" name="cafe">&nbsp;&nbsp;CAFE & CACAO&nbsp;</label>              
						<label class="btn btn-light" style="float:left;height:30px;padding-right:5px;padding-top:3px;padding-left:5px;margin-left:5px;">&nbsp;<input type="checkbox" value="1" name="autres">&nbsp;&nbsp;AUTRES&nbsp;</label>              

						<button type="submit" id="submit-ponts" class="btn btn-success" style="float:left;height:30px;padding-left:5px;padding-right:5px;padding-top:5px;margin-left:5px;"><i class ="mdi mdi-magnify"></i></button>
            &nbsp;&nbsp;
            <button type="button" id="submit-text" class="btn btn-info" style="float:left;height:30px;padding-left:5px;padding-right:5px;padding-top:5px;margin-left:5px;"><i class ="mdi mdi-note-text"></i></button>
            
						</div>
					</form>
					
					<hr color="green" size="3" noshade />
						<div id="resultat" class="form-group row col-sm-12" style="margin-bottom:5px;">
						</div>
					<hr color="green" size="3" noshade />
					
                   <div id="text" class="table-responsive">
                    <table id="input_report" class="table table-hover table-ponts" width="100%">
                      <thead>
                        <tr>
                        <th>IDENTIFIANT</th>
                        <th>TYPE</th> 
                        <th>STRUCTURE</th>
                        <th>MOIS</th>
                        <th>ANNEE</th>
                        <th>PRODUIT</th>
                        <th>PONT</th>
                        <th>TICKETS</th>
                        <th>COUT</th>
                        <th>COMPTE</th>
                        <th>FACTURE</th>
                        <th>CHARGEURS</th>
                        <th>MAIL</th>
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

