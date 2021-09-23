<html>
	<header>
        <title></title>
    </header>
	<style>
        @page { margin : 10px; }
        .teacherPage {
            page: teacher;
            page-break-after: always;
        }
        p { line-height:1px; font-size:13px; }
	</style>
<body style="padding-left: 2px; paddind-right:2px;">
	<table width="100%" style="padding-top: 1px padding-bottom:0px; padding-right: 50%; ">
		<tbody>
			<tr>
				<td style=" border: 2px solid black; border-collapse: collapse; padding-bottom:0px;">
					<p align="center" style="line-height:1px;">R.U.T : 22222222-2</p>
					<p align="center" style="line-height:1px;">VENTA</p>
					<p align="center" style="line-height:1px;">N° {{ $venta->id}}</p>
				</td>
			</tr>
		</tbody>
	</table>
	<div width="100%" align="center" style="padding-bottom: 0px;">
        <p style="font-size: 9px; lin line-height:1px;"><strong>APPNET TECHNOLOGY (DEMO)</strong></p>
		<p style="font-size: 9px; lin line-height:1px;"><strong>EDICION DE PROGRAMAS INFORMATICO</strong></p>
        <p style="font-size: 9px; line-height:1px;">VARAS MENA 980 - SANTIAGO - SANTIAGO</p>
	</div>

	<div width="100%" style="font-size:11px; padding-top:0px;">
		<p style="line-height:2px;">FECHA : {!! substr($venta->created_at, 0, 10) !!}</p>
		
		<table width="100%">
			<thead style=" border: 1px solid black; border-collapse: collapse;">
				<tr style="font-size: 9px;">
					<th><small>PRODUCTO</small></th>
					<th><small>CANTIDAD x PRECIO</small></th>
					
					<th><small>VALOR</small></th>
				</tr>
			</thead>
			<tbody>
                @foreach ($detalle as $d)
				<tr style="font-size:10px;">
					<td ><small>{{ $d->nombre}}</small></td>
					<td align="center" ><small>{{ $d->cantidad.' x '.$d->valor_producto }}</small></td>
					
					<td align="center"><small>{{ $d->total }}</small></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div>
		<table style="float: right;">
			<tbody style="font-size:10px;" align="right">
				
				<tr>
					<td>NETO</td>
					<td align="right">{{ $venta->neto }}</td>
				</tr>
				
				<tr>
					<td>19% I.V.A</td>
					<td align="right">{{ $venta->iva }}</td>
				</tr>
				<tr>
					<td>TOTAL</td>
					<td align="right">{{ $venta->total_venta }}</td>
				</tr>
			</tbody>
		</table>
	</div>

</body>

</html>

