<?php

namespace frontend\controllers;

use Yii;
use frontend\models\inventario\VExistencias;
use frontend\models\inventario\Inventarios;
use frontend\models\inventario\InventarioMovimientos;
use frontend\models\inventario\Existencias;
use common\models\datos\Bitacora;

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

            $model = Inventarios::find()->where($data)->one();
        }
        
        return $model;
    }
    
    function actionGetMovimientos($data){
        $model = InventarioMovimientos::find()->where($data)->one();
        if(is_null($model)){
            $model = new InventarioMovimientos();
            
            $model->load(['InventarioMovimientos' => $data]);
            $model->Tipo = 'E';
            $model->save();
            //var_dump($data);exit;
            $model = Inventarios::find()->where($data)->one();
        }
        
        return $model;
    }
    
    function actionSaveMovimiento(){
        $model = new InventarioMovimientos();
        $data = $_REQUEST;
        $model->load(['InventarioMovimientos' => $data]);
        $model->save();
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
            
            //var_dump($existencia);exit;
            
            $existencia->Cantidad += $model->Cantidad;
            $model->Existencia = $existencia->Cantidad;
            
            $existencia->update();
            $model->update();
        }
        $encabezado->update();
    }

    function actionDesafectar(){
        
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
        var_dump($model);
    }
    
}
