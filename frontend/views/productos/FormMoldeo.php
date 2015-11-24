<div class="panel panel-info">
    <div class="panel-heading">Datos Moldeo</div>
    <div class="panel-body" style="overflow: hidden">
        <div class="row">
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon" >Piezas por Molde</span>
                    <input type="text" ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.PiezasMolde" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon" >Peso Casting</span>
                    <input type="text" ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.PesoCasting" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">Peso Araña</span>
                    <input type="text" ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.PesoArania" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon" >Area Actual</span>
                    <select ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.IdAreaAct" class="form-control">
                        <option value="1">Kloster</option>
                        <option value="2">Varel</option>
                        <option value="3">Especial</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon" >Ciclos Kloster</span>
                    <input type="text" ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.CiclosMolde" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon" >Ciclos Varel</span>
                    <input type="text" ng-disabled="!producto" ng-change="saveMoldeo();" ng-model-options="{updateOn: 'blur'}" ng-model="producto.CiclosVarel" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>