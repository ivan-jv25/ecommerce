<div id="menu">
      <div id="cerrar-menu">
        <img src="img/cerrar.svg" alt="">
      </div>
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @guest
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <img src="img/ingresar.svg" class="ico-ingresa" alt=""> Iniciar Sesión
              </a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
              <form class="formulario" method="POST" action="{{ route('login') }}">
              @csrf
              <label for="usuario">Correo</label>
              <input type="text" class="form-control" name="email" value="" placeholder="Nombre usuario" required>
              <label for="contraseña">Contraseña</label>
              <input type="password" class="form-control" name="password" value="" placeholder="Contraseña" required>
              <button type="submit" class="boton"  name="button">Ingresar</button>
              <br>
              <a href="#">Recuperar contraseña</a>
              </form>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <img src="img/crear.svg" class="ico-ingresa" alt=""> Registrarse
              </a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
              <form class="formulario" action="{{ route('registro.usuario') }}" method="post">
              @csrf
                <strong>1. Datos de usuario</strong>
                <br>
                <label for="usuario">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre Apellido" required>
                <label for="usuario">Correo</label>
                <input type="email" class="form-control" name="correo" value="" placeholder="ejemplo@email.cl" required>
                <label for="usuario">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="" placeholder="+56 9 5555 55 55" required>
                <label for="usuario">Contraseña</label>
                <input type="password" class="form-control" name="password" value="" placeholder="Contraseña" required>
                <strong>2. Datos de Empresa</strong>
                <br>
                <label for="usuario">Rut Empresa</label>
                <input type="text" class="form-control" name="rut_empresa" value="" placeholder="76.555.555-k" required>
                <label for="usuario">Razón Social</label>
                <input type="text" class="form-control" name="razon_social" value="" placeholder="Razón Social" required>
                <label for="usuario">Giro</label>
                <input type="text" class="form-control" name="giro" value="" placeholder="Giro" required>
                <label for="usuario">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="" placeholder="Calle #55" required>
                <label for="usuario">Comuna</label>
                <input type="text" class="form-control" name="comuna" value="" placeholder="Comuna" required>
                <label for="usuario">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" value="" placeholder="Ciudad" required>

                <button type="submit" class="boton"  name="button">Registrar</button>
              </form>
            </div>
          </div>
        </div>
        @else

        @if (Auth::user()->is_admin === 1)
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" href="{{ route('home') }}">
                <img src="img/ingresar.svg" class="ico-ingresa" alt=""> Panel Admin
              </a>
            </h4>
          </div>
        </div>
        @endif


        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button"  data-toggle="modal" data-target="#myModalCompras" onclick="cerrar_menu();lista_compra();">
                <img src="img/ingresar.svg" class="ico-ingresa" alt=""> Registro de Compras
              </a>
            </h4>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="img/ingresar.svg" class="ico-ingresa" alt=""> Cerrar Session
              </a>
            </h4>
          </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>



        @endguest
      </div>

    </div>
