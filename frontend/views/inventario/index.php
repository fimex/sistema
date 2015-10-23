<h1>Control de inventarios</h1>
<div ng-controller="Inventarios" ng-init="IdArea = <?=$IdArea?>;loadExistencias();">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">Existencias</div>
                <?= $this->render('Existencias',[]);?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">Encabezado</div>
                <div class="panel-body">
                    <?= $this->render('Ajuste',[]);?>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">Movimientos</div>
                <div class="panel-body">
                    <?= $this->render('Movimientos',[]);?>
                </div>
            </div>
        </div>
    </div>
</div>