<?php

namespace frontend\controllers;

use Yii;

//Programacion
use frontend\models\programacion\VPedidos;
use frontend\models\programacion\Pedidos;
use frontend\models\programacion\Programacion;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\programacion\ProgramacionesDia;

//Produccion


abstract class ProduccionController extends \yii\web\Controller
{
    abstract function actionSaveDetalle();
    abstract function actionSaveProduccion();
     
    function actionIndex(){
        return $this->render('index');
    }
    
    public function actionActualizacion(){
        $model = new Programacion();
        return date('d-m-Y h:i',strtotime($model->getActualizacion()[0]['FechaInicio']));
    }
    
    public function Semanal($IdProceso,$IdArea){
        $this->layout = 'programacion';
        
        return $this->render('programacion',[
            'IdProceso' => $IdProceso,
            'IdArea' => $IdArea,
            'TipoUsuario' => Yii::$app->user->identity->role
        ]);
    }
    
    public function actionDataSemanal(){
        $IdArea = $_REQUEST['IdArea'];
        $IdProceso = $_REQUEST['IdProceso'];
        $Estatus = $_REQUEST['Estatus'];
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1'],$IdArea);

        $programacion = new Programacion();
        $dataProvider = $programacion->getProgramacionSemanal($IdArea,$IdProceso,$semanas,$Estatus);
     
        $Producto = '';
        
        //var_dump($dataProvider->allModels);exit;
        foreach ($dataProvider->allModels as &$value) {
            $value['Orden2'] = $value['OrdenCompra'];
            $value['FechaEnvio'] = $value['FechaEnvio'] == '' ? $value['FechaEnvio'] : date(DATE_ISO8601,  strtotime($value['FechaEnvio']));
            
            if($value['Producto'] == $value['ProductoCasting']){
                $value['SemanaActual'] = date('W',  strtotime($value['FechaEnvio']));
                $value['SemanaActual'] -= date('N',  strtotime($value['FechaEnvio'])) > 2 ? 1 : 2;
            }
            
            $value['Cantidad']*=1;
            $value['Prioridad1']*=1;
            $value['Prioridad2']*=1;
            $value['Prioridad3']*=1;
            $value['Prioridad4']*=1;
            
            $value['Programadas1']*=1;
            $value['Programadas2']*=1;
            $value['Programadas3']*=1;
            $value['Programadas4']*=1;
            
            $value['Kilos1'] = $value['Programadas1'] * $value['PesoCasting'];
            $value['Kilos2'] = $value['Programadas2'] * $value['PesoCasting'];
            $value['Kilos3'] = $value['Programadas3'] * $value['PesoCasting'];
            $value['Kilos4'] = $value['Programadas4'] * $value['PesoCasting'];
            $value['Kilos5'] = $value['Programadas5'] * $value['PesoCasting'];
            $value['Kilos6'] = $value['Programadas6'] * $value['PesoCasting'];
            
            $value['Prioridad1'] = $value['Prioridad1'] == 0 ? '' : $value['Prioridad1'];
            $value['Prioridad2'] = $value['Prioridad2'] == 0 ? '' : $value['Prioridad2'];
            $value['Prioridad3'] = $value['Prioridad3'] == 0 ? '' : $value['Prioridad3'];
            $value['Prioridad4'] = $value['Prioridad4'] == 0 ? '' : $value['Prioridad4'];
            
            $value['Programadas1'] = $value['Programadas1'] == 0 ? '' : $value['Programadas1'];
            $value['Programadas2'] = $value['Programadas2'] == 0 ? '' : $value['Programadas2'];
            $value['Programadas3'] = $value['Programadas3'] == 0 ? '' : $value['Programadas3'];
            $value['Programadas4'] = $value['Programadas4'] == 0 ? '' : $value['Programadas4'];

            $value['Moldes']= round($value['Moldes'],0,PHP_ROUND_HALF_UP);
            
            $value['SaldoCantidad']*=1;
            
            if($value['Producto'] != $Producto){
                $Casting = $value['Cast'];
                $Maquinado = $value['Maq'];
                $FaltaCasting = 0;
                $FaltaMaquinado = 0;
            }
            
            $Maquinado = $Maquinado < 0 ? 0 : $Maquinado;
            $Casting = $Casting < 0 ? 0 : $Casting;
            
            $value['ExitMaquinado'] = $Maquinado;
            $value['ExitCasting'] = $Casting;
            
            if($Maquinado > 0){
                $FaltaMaquinado = $Maquinado > $value['SaldoCantidad'] ? 0 : $value['SaldoCantidad'] - $Maquinado;
                $Maquinado -= $value['SaldoCantidad'];
            }else{
                $FaltaMaquinado = $value['SaldoCantidad'];
            }
            
            if($Casting > 0 && $Maquinado <= 0){
                $FaltaCasting = $Casting > $FaltaMaquinado ? 0 : $FaltaMaquinado - $Casting;
                $Casting -= $FaltaMaquinado;
            }else{
                $FaltaCasting = $FaltaMaquinado;
            }
            
            $value['FaltaMaquinado'] = $FaltaMaquinado;
            $value['FaltaCasting'] = $FaltaCasting;
            $value['class'] = $value['FaltaCasting'] == 0 ? 'background-color: lightgreen;' : '';
            
            $Producto  = $value['Producto'];
        }
        
        //print_r($dataProvider->allModels);
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
            ]);
        }
        
        /*if($area == 2){
            $dataResumen = $this->resumenAcero($dataProvider->allModels,1);
        }else{
            $dataResumen = $this->DataResumen($dataProvider->allModels,1,$area);
        }*/
        //$dataResumen = $this->DataResumen($dataProvider->allModels,1,$area);
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
//                'footer'=>$dataResumen[0],
        ]);
    }
    
    public function actionLoadSemana(){
        $val = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1']);
        return json_encode($val);
    }
    
    public function LoadSemana($semana1= '',$IdArea = 3){
        if($semana1 == ''){
            $mes = date('m');
            $semana1 = $mes == 12 && date('W') == 1 ? [date('Y')+1,date('W'),date('Y-m-d')] : [date('Y'),date('W'),date('Y-m-d')];
        }else{
            $semana1 = date('Y-m-d',strtotime($semana1));
            $mes = date('m',strtotime($semana1));

            $semana1 = $mes == 12 && date('W',strtotime($semana1)) == 1 ? [date('Y',strtotime($semana1))+1,1* date('W',strtotime($semana1)),$semana1] : [date('Y',strtotime($semana1)),1 * date('W',strtotime($semana1)),$semana1];
        }
        
        $totSemana = 6;
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'val'=>$semana1[2]];
        
        for($x=1; $x < $totSemana; $x++){
            $semanas['semana'.($x+1)] = $this->checarSemana($semanas['semana'.$x]);
        }
        //var_dump($semanas);exit;
        return $semanas;
    }
    
    public function checarSemana($semana){
        $ultimaSemana = date('W',strtotime($semana['year'].'-12-31'));
        if($semana['week'] == $ultimaSemana || $ultimaSemana == '01'){
            $semana['week'] = 1;
            $semana['year']++;
        }
        else
            $semana['week']++;
        $semana['val'] = date('Y-m-d',strtotime('+7 day',strtotime($semana['val'])));

        return $semana;
    }
    
    public function actionMarcas(){
        $this->layout = 'JSON';
        $model = new Pedidos();
        $dataProvider = $model->getMarcas(2);

        if(count($dataProvider)>0){
            return json_encode($dataProvider->allModels);
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionPedidos(){
        $this->layout = 'JSON';
        $model = new Pedidos();
        
        $fecha = isset($_REQUEST['fecha']) ? date('Y-m-d',strtotime($_REQUEST['fecha'])) : '';
        $dataProvider = $model->getSinProgramar($fecha , $_REQUEST['IdArea']);

        if(count($dataProvider)>0){
            return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
            ]);
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
}