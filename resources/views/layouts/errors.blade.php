<!DOCTYPE html>
<html>


<body>
    <div id="app" v-cloak>
        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section>
    </div>
    @section('scripts')
        @include('adminlte::layouts.partials.scripts')
    @show
</body>
</html>