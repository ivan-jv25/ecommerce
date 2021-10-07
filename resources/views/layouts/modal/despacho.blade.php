<div class="modal fade" id="myModalDespacho" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Seleccion o Ingrese Direccion de Despacho</h4>
            </div>
            <div class="modal-body">
                
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