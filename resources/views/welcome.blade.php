<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Punto de Venta - Appnet</title>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="css/stylus.css">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    </head>
<body>

    <div class="pop-up">
      <div id="cerrar-popup">
        <img src="img/cerrar.svg" alt="">
      </div>
      <img src="img/qr-code.png" alt="">
    </div>

    @include('layouts.partialsindex.menu')

    @include('layouts.partialsindex.header')

    

    

    <div class="seccion-01">
      <div class="fran-supa">
        <div class="buscador">
          <form action="">
            <input type="text" name="" id="formulario" value="" placeholder="Buscar" required>
            <button type="submit" name="button">
              <img class="buscar" src="img/buscar.svg" alt="">
            </button>
          </form>
        </div>
        <div class="filtro">
          <select class="" name="" id="lista_categoria" onchange="filtro_categoria(this.value);">
            <option value="0">Categoría</option>
            <option value="">Categoría 1</option>
            <option value="">Categoría 2</option>
            <option value="">Categoría 3</option>
          </select>
        </div>
      </div>
      <div class="listado-productos">
        <div class="col-1" id="lista_col1">
          <div class="prod">
            <img class="thumb" src="img/productos/k2mini.png" alt="">
            <div class="detal">
              <h3>K2 MINI</h3>
              <div class="nuevo">A Pedido</div>
            </div>
            <div class="mas"><i class="fa fa-plus fa-lg"></i></div>
            <div class="precio">$999.999</div>
          </div>
        </div>
        <div class="col-2" id="lista_col2">
          <div class="prod">
            <img class="thumb" src="img/productos/t2lite.png" alt="">
            <div class="detal">
              <h3>T2 LITE</h3>
              <div class="nuevo">en Stock</div>
            </div>
            <div class="mas"><i class="fa fa-plus fa-lg"></i></div>
            <div class="precio">$999.999</div>
          </div>
          
        </div>
      </div>
    </div>
    <form class="formulario" method="POST" action="{{ route('generar.venta') }}" autocomplete="off">@csrf
      <div class="seccion-02">
        <div class="carro">
          <div class="cerrar-carro">
            <i class="fa fa-times-circle fa-3x"></i>
          </div>
          <div class="cabecera">
            <div class="row">
              <div class="col-xs-4 col-sm-4">Producto</div>
              <div class="col-xs-3 col-sm-3 text-center">Cantidad</div>
              <div class="col-xs-2 col-sm-3 align-valor">Valor</div>
              <div class="col-xs-1 col-sm-1 align-valor">Eliminar</div>
            </div>
          </div>
          <table class="table table-hover">
            <tbody id="tb_lista_carro">
              <tr>
                <td>
                  <img class="thumb" src="img/productos/d2scombo.png" alt="">
                  <span>D2s COMBO</span>
                </td>
                <td>
                  <div class="menos"><i class="fa fa-minus fa-lg"></i></div>
                    1
                  <div class="mas"><i class="fa fa-plus fa-lg"></i></div>
                </td>
                <td>$999.999</td>
                <td><i class="fa fa-trash fa-lg"></i></td>
              </tr>
            
              
              
            </tbody>

          
          </table>
          <table class="table table-hover" hidden>
            <tbody id="tb_lista_carro_datos"></tbody>
          </table>
        </div>

        <div class="resultados">
          <form class="">
            <div class="row">
              <div class="col-sm-6" hidden>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Código dscto.</div>
                    <input type="text" class="form-control" id="exampleInputAmount" placeholder="">
                  </div>
                </div>
              </div>
              <div class="col-sm-6" hidden>
              </div>
              <div class="col-sm-6" hidden>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Descuento</div>
                    <input type="text" class="form-control" id="exampleInputAmount" placeholder="">
                    <div class="input-group-addon dscto">PS</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Neto</div>
                    <input type="text" class="form-control" id="id_neto" name="id_neto" placeholder="" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Iva 19%</div>
                    <input type="text" class="form-control" id="id_iva" name="id_iva" placeholder="" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="btn-group dcto" data-toggle="buttons">
                    <label class="btn btn-primary  active focus">
                      <input type="radio" name="options" id="option1" required value="39" checked="checked"> Boleta
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" name="options" id="option2" value="33"> Factura
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon total">Total</div>
                    <input type="text" class="form-control" id="id_total" name="id_total" placeholder="" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <label for="">Metodo de Pago</label>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="btn-group dcto" data-toggle="buttons">
                    <label class="btn btn-primary">
                      <input type="radio" name="options_pago" id="option3" required value="mach"> Match
                    </label>
                    
                    <label class="btn btn-primary active focus">
                      <input type="radio" name="options_pago" id="option45" value="flow" checked="checked"> Flow
                    </label>
                    <label class="btn btn-primary">
                      <input type="radio" name="options_pago" id="option6" value="trasferencia">Trasferencia
                    </label>
                    
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="btn-group dcto" data-toggle="buttons">
                  
                    <label class="btn btn-primary active focus" for="radios-0">
                      <input type="radio" name="tipo_entrega" required value="despacho" checked="checked"> Despacho
                    </label>
                    <label class="btn btn-primary " for="radios-1" data-toggle="modal" data-target="#myModal" onclick="work_flow_retiro();">
                      <input type="radio" name="tipo_entrega" value="retiro" > Retiro
                    </label>
                  
                    
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <button type="submit" class="comprar btn-block" name="button" id="singlebutton" disabled>Comprar</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </form>
    
    
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Seleccion de Tienda de Retiro</h4>
          </div>
          <div class="modal-body">
            
            <div class="row form-group">
              <label class="col-md-4 control-label" for="id_tienda_retiro">Tiendas de Retiro</label>
              <div class="col-md-8">
                <select id="id_tienda_retiro" class="form-control" onchange="work_flow_change_bodega();">
                  <option value="1">Option one</option>
                  <option value="2">Option two</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody id="lista_carro_bodega">
                  <tr>
                    <td>
                      <span>D2s COMBO</span>
                    </td>
                    <td>1</td>
                    <td>1</td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="myModalCompras" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Compra</h4>
          </div>
          <div class="modal-body">
          <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Folio</th>
                                    <th>Resepcion</th>
                                    <th>Descuento</th>
                                    <th>Afecto</th>
                                    <th>Exento</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Documento</th>
                                    <th>Forma Pago</th>
                                    <th>Fecha</th>
                                
                                </tr>
                            </thead>
                        </table>
                    </div>
            
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    

    @include('layouts.partialsindex.script')
  </body>
</html>
