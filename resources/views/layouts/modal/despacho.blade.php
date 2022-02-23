<div class="modal fade" id="myModalDespacho" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Seleccion o Ingrese Direccion de Despacho</h4>
            </div>

            <!--div class="modal-body">

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="direccion">Direccion</label>
                    <div class="col-md-8">
                        <input id="direccion" name="direccion" type="text" placeholder="Direccion" class="form-control input-md">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="ciudad">Ciudad</label>
                    <div class="col-md-8">
                        <input id="ciudad" name="ciudad" type="text" placeholder="Ciudad" class="form-control input-md">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="comuna">Comuna</label>
                    <div class="col-md-8">
                        <input id="comuna" name="comuna" type="text" placeholder="Comuna" class="form-control input-md">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="observacion">Observacion</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Observacion"></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-8 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <button id="singlebutton" name="singlebutton" class="btn btn-primary" onclick="guardar_direccion()">Grabar y Selecionar</button>
                    </div>
                </div>

            </div-->

            <div class="modal-body">

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="direccion">Direccion</label>
                    <div class="col-md-8">
                        <input id="direccion" name="direccion" type="text" placeholder="Direccion" class="form-control input-md">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="ciudad">Región</label>
                    <div class="col-md-8">
                      <select class="form-control input-md" name="">
                        <option value="">Arica-Parinacota</option>
                        <option value="">Tarapacá</option>
                        <option value="">Antofagasta</option>
                        <option value="">Atacama</option>
                        <option value="">Coquimbo</option>
                        <option value="">Valparaíso</option>
                        <option value="">Metropolitana de Santiago</option>
                        <option value="">Libertador General Bernardo O'Higgins</option>
                        <option value="">Maule</option>
                        <option value="">Ñuble</option>
                        <option value="">Biobío</option>
                        <option value="">Araucanía</option>
                        <option value="">Los Ríos</option>
                        <option value="">Los Lagos</option>
                        <option value="">Aysén del General Carlos Ibáñez del Campo</option>
                        <option value="">Magallanes y de la Antártica Chilena</option>
                      </select>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="ciudad">Ciudad</label>
                    <div class="col-md-8">
                      <select class="form-control input-md" name="">
                        <option value="">Ciudad 01</option>
                        <option value="">Santiago</option>
                        <option value="">Ciudad 03</option>
                        <option value="">Ciudad 04</option>
                        <option value="">Ciudad 05</option>
                        <option value="">Ciudad 06</option>
                        <option value="">Ciudad 07</option>
                        <option value="">Ciudad 08</option>
                        <option value="">Ciudad 09</option>
                        <option value="">Ciudad 10</option>
                      </select>
                    </div>
                </div>

                <div class="row form-group" id="row-comuna">
                    <label class="col-md-4 control-label" for="comuna">Comuna</label>
                    <div class="col-md-8">
                      <select class="form-control input-md" name="">
                        <option value="">Comuna 01</option>
                        <option value="">Comuna 02</option>
                        <option value="">Comuna 03</option>
                        <option value="">Comuna 04</option>
                        <option value="">Comuna 05</option>
                        <option value="">Comuna 06</option>
                        <option value="">Comuna 07</option>
                        <option value="">Comuna 08</option>
                        <option value="">Comuna 09</option>
                        <option value="">Comuna 10</option>
                      </select>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 control-label" for="observacion">Observacion</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Observacion"></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-8 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <button id="singlebutton" name="singlebutton" class="btn btn-primary" onclick="guardar_direccion()">Grabar y Selecionar</button>
                    </div>
                </div>

            </div>

            <div class="modal-body">
                <table id="lista_direccion" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Direccion</th>
                            <th>Ciudad</th>
                            <th>Comuna</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
