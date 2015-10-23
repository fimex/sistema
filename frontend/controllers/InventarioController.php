<?php

namespace frontend\controllers;

use frontend\models\inventario\VExistencias;
use frontend\models\inventario\Inventarios;
use frontend\models\inventario\InventarioMovimientos;
use frontend\models\inventario\Existencias;

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
    
    function actionSaveMovimiento(){
        $model = new InventarioMovimientos();
        $data = $_REQUEST;
        $model->load(['InventarioMovimientos' => $data]);
        $model->save();
    }
    
    function actionAfectar(){
        $encabezado = Inventarios::find()->where($_REQUEST)->one();
        $encabezado->IdEstatusInventario = 3;
        
        $partidas = InventarioMovimientos::find()->where([
            'IdInventario' => $encabezado->IdInventario
        ])->asArray()->all();
        
        foreach($partidas as $partida){
            $model = InventarioMovimientos::findOne();
            $existencia = Existencias::find()->where([
                'IdCentroTrabajo' => $model->IdCentroTrabajo,
                'IdProducto' => $model->IdProducto,
            ])->one();
            
            $existencia->cantidad += $model->cantidad;
            $model->Existencia = $existencia->cantidad;
            
            $existencia->update();
            $model->update();
        }
        $encabezado->update();
    }
    
    function actionGetMovimientos(){
        
    }

    function actionDesafectar(){
        
    }
    
}
