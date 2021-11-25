<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true" id="myModalBodegaDefecto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Seleccione una tienda de retiro</h4>
          </div>
          <div class="modal-body">
            <div class="row form-group">
              <label class="col-md-12 control-label" for="id_tienda_retiro">
                Tiendas de Retiro <br>
              </label>
              <div class="col-md-12">
                <select id="id_tienda_retiro2" class="form-control" onchange="bodega_defecto();">
                  <option value="1">Option one</option>
                  <option value="2">Option two</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 text-center">
                <img class="tienda" src="img/tienda.svg" alt="">
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Siguiente</button>
          </div>
        </div>
      </div>
    </div>
