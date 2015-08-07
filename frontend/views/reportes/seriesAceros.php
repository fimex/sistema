<div ng-controller="ReporteSerie">
	<h3>Reporte Serie <?= $serie?></h3>
	<table class="table table-striped width-80p text-center">
		<tr>
			<?php if ($serie == ''):?>
				<td>
					<strong>Producto</strong>
					<input type="text" class="form-control" ng-model="producto">
				</td>
  			<?php endif;?>
  			<td>
  				<strong>Serie</strong>
  				<input type="text" class="form-control" ng-model="serie">
  			</td>
  			<td>
  				<strong>Ciclo</strong>
  			</td>
  			<td>
  				<strong>Llenado</strong>
  			</td>
  			<td>
  				<strong>Cerrado</strong>
  			</td>
  			<td>
  				<strong>Vaciado</strong>
  			</td>
  			<td>
  				<strong>Comentarios</strong>
  			</td>
		</tr>
		<tr ng-repeat="serie in series | filter:{producto:producto,serie:serie}">
			<?php if ($serie == ''):?><td>{{serie.producto}}</td><?php endif;?>
  			<td>{{serie.serie}}</td>
  			<td>{{serie.estatus.ciclo}}</td>
  			<td>{{serie.estatus.llenado}}</td>
  			<td>{{serie.estatus.cerrado}}</td>
  			<td>{{serie.estatus.vaciado}}</td>
  			<td>{{serie.estatus.comentario}}</td>
		</tr>
	</table>
</div>