<header>
      <img src="img/logo/logo.png" class="logo" alt="Logo Appnet">
      @guest
      <div class="sesion"><a onclick="abrir_registrarte()"><i class="fa fa-user fa-lg"></i> Registrate</a></div>
      @else
      <div class="sesion"><i class="fa fa-user fa-lg"></i> Bienvenido {{ Auth::user()->name }}</div>
      @endguest

      <div class="ico-carro">
        <div class="conteo" id="dv_carrito">0</div>
        <img src="img/carro.svg" alt="">
      </div>
      <div class="hamburguesa">
        <img src="img/menu.svg" alt="Menu">
      </div>
    </header>
