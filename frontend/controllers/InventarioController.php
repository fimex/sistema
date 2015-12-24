<?php

namespace frontend\controllers;

use Yii;
use frontend\models\inventario\VExistencias;
use frontend\models\inventario\Inventarios;
use frontend\models\inventario\InventarioMovimientos;
use frontend\models\inventario\Existencias;
use frontend\models\inventario\SerieMovimientos;
use frontend\models\inventario\ExistenciasDetalle;
use frontend\models\inventario\UnionInv;
use common\models\datos\Bitacora;
use common\models\datos\SerieCavidad;
use frontend\models\produccion\Series;
use frontend\models\produccion\ProduccionesDetalle;
use common\models\dux\Productos;
use common\models\catalogos\CentrosTrabajo;

class InventarioController extends \yii\web\Controller
{
    public function actionBronces()
    {
        return $this->render('index',[
            'IdArea' => 3
        ]);
    }
    
    public function actionAceros(){
        return $this->render('index',[
            'IdArea' => 2
        ]);
    }
    
    function actionInventario(){
        $model = VExistencias::find()->where($_REQUEST)->orderBy('IdSubProceso ASC, Descripcion ASC, Identificacion ASC')->asArray()->all();
        return json_encode($model);
    }
    
    function actionCentros(){
        $model = CentrosTrabajo::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }
    
    function actionSaveInventario(){
        $model = new Inventarios();
        $data = $_REQUEST;
        $data['IdEstatusInventario'];
        $model->load(['Inventarios' => $data]);
        $model->save();
    }
    
    function actionGetExistencia($data){
        $model = Existencias::find()->where($data)->one();
        if(is_null($model)){
            $model = new Existencias();
            
            $model->load(['Existencias' => $data]);
            $model->Cantidad = 0;
            $model->save();

            $model = Existencias::find()->where($data)->one();
        }
        return $model;
    }
    
    function actionGetInventario($data){
        $model = Inventarios::find()->where($data)->one();
        if(is_null($model)){
            $model = new Inventarios();
            
            $model->load(['Inventarios' => $data]);
            $model->IdEstatusInventario = 1;
            $model->save();
            //var_dump($model); exit();
            $model = Inventarios::find()->where($data)->one();
        }
        
        return $model;
    }
    
    function actionGetMovimientos($data){

        if (isset($data['Series'])) {
            $series = explode(",", $data['Series']);
            unset($data['Series']);
        }

        $model = InventarioMovimientos::find()->where($data)->one();
        if(is_null($model)){
            $model = new InventarioMovimientos();
            
            $model->load(['InventarioMovimientos' => $data]);
            $model->Tipo = 'E';
            $model->save();

            unset($data['IdCentroTrabajo']);
            unset($data['IdProducto']);
            unset($data['Cantidad']);
            //$model = Inventarios::find()->where($data)->one();
            $model = InventarioMovimientos::find()->where($data)->one();
        }

        if (isset($series) && $series != '') {
            $this->SetSerieMovimientos([
                'Series' => $series,
                'IdInventarioMovimiento' => $model->IdInventarioMovimiento,
                'IdProducto' => $model->IdProducto,
            ]); 
        }

        return $model;
    }

    function actionUnionInv($data){
        $model = UnionInv::find()->where($data)->one();
        if(is_null($model)){
            $model = new UnionInv();
            
            $model->load(['UnionInv' => $data]);
            $model->save();
            $model = UnionInv::find()->where($data)->one();
        }
        
        return $model;
    }

    function SetSerieMovimientos($data){
        foreach ($data['Series'] as $key => $serie) {
            if ($serie != "") {
                $Serie = $this->GetSerie([
                    'IdSerie' => $serie,
                ]);
                $model = new SerieMovimientos();
                $model->load([
                    'SerieMovimientos' => [
                        'IdSerie' => $Serie['IdSerie'],
                        'IdInventarioMovimiento' => $data['IdInventarioMovimiento'],
                    ] 
                ]);
                $model->save(); 
            }
        }
    }
 
    function actionSaveMovimiento(){
        $model = new InventarioMovimientos();
        $data = $_REQUEST;
        $model->load(['InventarioMovimientos' => $data]);
        $model->save();
    }

    function actionGetExistenciaDetalle($data){
        $model = new ExistenciasDetalle();

        $model = ExistenciasDetalle::find()->where("FechaMoldeo = '".$data['FechaMoldeo']."'")->one();
        if(is_null($model)){
            $model = new ExistenciasDetalle();
            
            $model->load(['ExistenciasDetalle' => $data]);
            $model->Cantidad = 0;
            $model->save();

            $model = ExistenciasDetalle::find()->where("FechaMoldeo = '".$data['FechaMoldeo']."'")->one();
        }
        return $model;
    }
    
    function actionAfectar($IdInventario){
        $encabezado = Inventarios::findOne($IdInventario);
        $encabezado->IdEstatusInventario = 3;
        
        $partidas = InventarioMovimientos::find()->where([
            'IdInventario' => $encabezado->IdInventario
        ])->asArray()->all();
        
        foreach($partidas as $partida){
            $model = InventarioMovimientos::findOne($partida['IdInventarioMovimiento']);
            $existencia = $this->actionGetExistencia([
                'IdSubProceso' => $encabezado->IdSubProceso,
                'IdCentroTrabajo' => $model->IdCentroTrabajo,
                'IdProducto' => $model->IdProducto
            ]);
            
            $productos = $this -> GetProducto(['IdProducto' => $model->IdProducto]);
            $inioninv = $this -> GetUnionInv(['IdInventarioMovimiento' => $model->IdInventarioMovimiento]);
            $produccion = $this -> GetProduccionesDetalle(['IdProduccionDetalle' => $inioninv['IdProduccionDetalle']]); 
            $productos['IdProducto'];
            
            //var_dump($existencia);exit;
            if ($productos['FechaMoldeo'] == 1) {
                $ExistenciasDetalle = $this->actionGetExistenciaDetalle([
                    'IdExistencia' => $existencia['IdExistencias'],
                    'FechaMoldeo' => $produccion['FechaMoldeo'],
                ]);
                $ExistenciasDetalle->Cantidad = $model->Cantidad;
                $existencia->Cantidad += $ExistenciasDetalle->Cantidad;
                //$model->Cantidad = $existencia->Cantidad;
                $model->Existencia = $existencia->Cantidad;

                $ExistenciasDetalle->update();

            }else{
                $existencia->Cantidad += $model->Cantidad;
                $model->Existencia = $existencia->Cantidad;
            }

            $existencia->update();
            $model->update();
            
            if ($productos['LlevaSerie'] == 'Si' && $productos['PiezasMolde'] > 1 ) {
                $this->SeriesMoldesPiezas($model->IdProducto,$model->IdInventarioMovimiento,$encabezado->IdSubProceso); 
            }
        }
        $encabezado->update();
    }

    function SeriesMoldesPiezas($IdProducto,$IdInventarioMovimiento,$IdSubProceso){
        $cavidad = SerieCavidad::find()->where("IdProducto = ".$IdProducto."")->asArray()->all();
        $movimientos = SerieMovimientos::find()->where("IdInventarioMovimiento = ".$IdInventarioMovimiento."")->asArray()->all();
        
        foreach ($movimientos as $key => $value) {
            $serieCons = $this->GetSerie([
                'IdSerie' => $value['IdSerie'],
            ]);
            foreach ($cavidad as $key => $value) {
                $Series = new Series(); 
                $Series->load([
                    'Series' => [
                        'IdProducto' => $IdProducto,
                        'IdSubProceso' => $IdSubProceso,
                        'Serie' => $serieCons['Serie'].$value['Prefijo'].$value['ConsecutivoCavidad'],
                        'Estatus' => 'B',
                        'FechaHora' => date('Y-m-d H:i:s'),
                        'IdSeriePadre' => $serieCons['IdSerie'],
                    ]
                ]);
                //$Series->save();
                //var_dump($Series);
            }
        }
    }

    function actionDesafectar(){
        
    }

    function GetSerie($data){
        return Series::find()->where($data)->asArray()->one();
    }

    function GetProducto($data){
        return Productos::find()->where($data)->asArray()->one();
    }

    function GetUnionInv($data){
        return UnionInv::find()->where($data)->asArray()->one();
    }

    function GetProduccionesDetalle($data){
        return ProduccionesDetalle::find()->where($data)->asArray()->one();
    }

    function setSeriesDetalle($data){
        $serie = new SeriesDetalles();
        $serie->load(['SeriesDetalles' => $data]);
        $serie->save();
        //var_dump($serie);
        return $serie;
    }

    function setSeries($data){
        $model = Series::find()->where([
            'IdProducto' => $data['IdProducto'],
            'Serie' => $data['Serie']
        ])->one();
        if(is_null($model)){
            $model = new Series();
        }
        $model->load(['Series' => $data]);
        $model->save();
        //var_dump($model);
        return $model;
    }   
    
    function SetBitacora($descripcion,$tabla,$campo,$valorNuevo,$valorAnterior){
        $data = [
            'Bitacora' => [
                'Descripcion' => $descripcion,
                'Tabla' => $tabla,
                'Campo' => $campo,
                'ValorNuevo' => $valorNuevo,
                'ValorAnterior' => $valorAnterior,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'IdUsuario' => Yii::$app->user->identity->username
            ]
        ];
        
        $model = new Bitacora();
        $model->load($data);
        $model->save();
        //var_dump($model);
    }
    
}
