<?php

namespace frontend\controllers;

use Yii;
use frontend\models\programacion\Programacion;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\programacion\Pedidos;
use common\models\catalogos\PedProg;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Turnos;
use common\models\catalogos\SubProcesos;
use common\models\catalogos\AreaProcesos;
use frontend\models\programacion\ProgramacionesAlma;
use frontend\models\programacion\ProgramacionesAlmaSemana;
use frontend\models\programacion\ProgramacionesAlmaDia;
use common\models\datos\Almas;
use common\models\datos\Programaciones;
use common\models\datos\Areas;
use common\models\dux\Productos;
use common\models\dux\Aleaciones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgramacionesController implements the CRUD actions for programaciones model.
 */
class Programacion2Controller extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionSemanal($semana1 = '',$fecha = '')
    {
        $mes = date('m');
        if($semana1 == ''){
            $semana1 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana1 = explode('-W',$semana1);
        }
        
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'value'=>"$semana1[0]-W".(strlen($semana1[1]) == 1 ? "0" : "").$semana1[1]];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);
        
        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionSemanal($semanas,Yii::$app->session->get('area'));
        
        $pedidos = new Pedidos();
        $dataProvider2 = $pedidos->getSinProgramar($fecha);
        //var_dump($dataProvider2);exit;
        return $this->render('programacion',[
            'title'=>'Programacion Semanal',
            'semanas'=>$semanas,
            'programacion'=>$programacion,
            //'data'=>json_encode($dataProvider->allModels),
        ]);
    }
    
    
    public function actionSemanala($semana1 = '',$fecha = '')
    {
        $mes = date('m');
        if($semana1 == ''){
            $semana1 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana1 = explode('-W',$semana1);
        }
        
        
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'value'=>"$semana1[0]-W".(strlen($semana1[1]) == 1 ? "0" : "").$semana1[1]];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);
        
        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionSemanal($semanas,Yii::$app->session->get('area'));
        
        $pedidos = new Pedidos();
        $dataProvider2 = $pedidos->getSinProgramar($fecha);
        //var_dump($dataProvider2);exit;
        return $this->render('programacionA',[
            'title'=>'Programacion Semanal',
            'semanas'=>$semanas,
            'programacion'=>$programacion,
            //'data'=>json_encode($dataProvider->allModels),
        ]);
    }
    
    public function actionDiaria($AreaProceso,$subProceso,$semana = '')
    {
        $mes = date('m');
        if($semana == ''){
            $semana2 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana2 = explode('-W',$semana);
        }
        
        $semanas['semana1'] = ['año'=>$semana2[0],'semana'=>$semana2[1],'value'=>"$semana2[0]-W$semana2[1]"];
        
        $turnos = new Turnos();
        
        $AreaProceso = AreaProcesos::findOne($AreaProceso);
        
        return $this->render('programacionDiaria',[
            'title'=>'Programacion diaria',
            'area'=>$AreaProceso->IdArea,
            'IdSubProceso'=>6,
            'turnos'=>$turnos,
            'semana'=>$semana,
            'AreaProceso'=>$AreaProceso->IdAreaProceso,
            'turno'=>1,
            'semanas'=>$semanas,
        ]);
    }
    
    public function actionData_semanal()
    {
        $this->layout = 'JSON';
        $semana1 = isset($_POST['semana1']) ? explode('-W',$_POST['semana1']) : array(date('Y'),date('W'));
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'value'=>"$semana1[0]-W$semana1[1]"];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);
        
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        
        $programacion = new Programacion();
        $dataProvider = $programacion->getProgramacionSemanal($semanas);
     
        $Producto = '';
        $ban = 1;
        $faltaPTB = 0; $RfaltaPTB = 0; $faltaCast = 0;
        $existPTB = 0; $RexistPTB = 0; $existCast = 0;
        $SaveFaltaPT = 0; $SaveExistPT = 0;
        $SaveExistCast = 0; $SaveFaltaCast = 0;
        $Save2 = 0; $faltaAnterior = 0; $id = '';
        if($area == 2){
            $id = "PTA";
        }elseif($area == 3) {
            $id = "PTB";
        }else {
            $id = "GPT";
        }

        //var_dump($dataProvider->allModels);exit;
        foreach ($dataProvider->allModels as &$value) {
            $value['Cantidad']*=1;
            $value['Moldes']= round($value['Moldes'],0,PHP_ROUND_HALF_UP);
            
            $value['SaldoCantidad']*=1;
            $value['MoldesSaldo']= round($value['SaldoCantidad'] / $value['PiezasMolde'],0,PHP_ROUND_HALF_UP);
            
            if($value['Producto'] != $Producto){
                
                if($ban >= 1 && $value['Producto'] != $Producto ){
                    
                    $faltaPTB = $value["{$id}"] - $value['Cantidad'];
                    $faltaPTB2 = $value['Cantidad'] - $value["{$id}"];
                    
                    if($value['Cantidad'] <= $value["{$id}"]){
                        $faltaPTB = 0;
                        $SaveExistPT = $value["{$id}"] - $value['Cantidad'];
                        $existPTB = $value["{$id}"];
                        
                        if($faltaPTB <= $value['Cast']){
                            $existCast = $value['Cast'];
                            $faltaCast = 0;
                            $SaveExistCast = $value['Cast'] - $faltaCast;
                             
                        }  else {
                            $existCast = $value['Cast'];
                            $faltaCast = $faltaPTB - $SaveExistCast;
                            $SaveExistCast = 0;
                        }
                        
                    }else{
                        $faltaPTB = $value['Cantidad'] - $value["{$id}"];
                        $existPTB = $value["{$id}"];
                        $SaveExistPT = $value["{$id}"] - $value['Cantidad'];
                        
                        if($faltaPTB <= $value['Cast']){
                            $existCast = $value['Cast'];
                            $faltaCast = 0;
                            $SaveExistCast = $value['Cast'] - $faltaCast;
                        }  else {
                            $existCast = $value['Cast'];
                            $faltaCast = $faltaPTB - $value['Cast'];
                            $SaveExistCast = 0;
                        }
                        
                    }
                }
                    
            }else{
                
                $RfaltaPTB = $value["{$id}"] - $value['Cantidad'];
                $RexistPTB = $value['Cantidad'] - $value["{$id}"];

                if($value['Cantidad'] <= $SaveExistPT){
                    $existPTB = $SaveExistPT - $value['Cantidad'];
                    $faltaPTB = 0;
                    $SaveExistPT = $existPTB;             
                }
                
                if($value['Cantidad'] >= $SaveExistPT){
                    $faltaPTB = $value['Cantidad'] - $SaveExistPT;
                    $existPTB = $SaveExistPT;
                    $SaveExistPT = 0;
                }    
                    
                if($faltaAnterior){
                    $SaveExistPT = 0;
                    $existPTB = 0;
                    $faltaPTB = $value['Cantidad'];
                }
                
                if($faltaPTB >= $SaveExistCast){
                    $faltaCast = $faltaPTB - $SaveExistCast;
                    $existCast = 0;
                    $SaveExistCast = 0;
                }  else {
                    $faltaCast = 0;
                    $existCast = 0;
                    $SaveExistCast = $SaveExistCast;
                }
                             
            }
            
            $pzas_falt = $value['Cantidad'] - $value['Cast1'];
            if($value['Moldes'] != 0){
                $mold_falt = $pzas_falt/$value['Moldes'];
            }else{
                $mold_falt = 0;
            }
            
            $value['Pzas_falt'] = $pzas_falt;
            $value['Mold_falt'] = number_format($mold_falt);
            $value['Exit'.$id] = $existPTB;
            $value['Falta'.$id] = $faltaPTB;
            $value['SaveExistPT'] = $SaveExistPT;
            $value['ExitCast'] = $existCast;
            $value['FaltaCast'] = $faltaCast;
            $value['SaveExistCast'] = $SaveExistCast;
            $faltaAnterior =  $value['Falta'.$id];         
            
            $ban++;
            
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
        
        if($area == 2){
            $dataResumen = $this->resumenAcero($dataProvider->allModels,1);
        }else{
            $dataResumen = $this->DataResumen($dataProvider->allModels,1);
        }
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
                'footer'=>$dataResumen,
        ]);
    }

    public function actionData_diaria($AreaProceso,$semana='')
    {
        $turno = isset($_POST['turno']) ? $_POST['turno'] : 1;
        $semana = $semana == '' ? array(date('Y'),date('W')) : explode('-W',$semana);
        
        $this->layout = 'JSON';

        $semanas['semana1'] = ['año'=>$semana[0],'semana'=>$semana[1],'value'=>"$semana[0]-W$semana[1]"];

        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionDiaria($semanas,$AreaProceso,$turno);
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
            ]);
        }
        //var_dump($dataProvider->allModels);exit;
        $dataResumen = $this->DataResumen($dataProvider->allModels,2);
        //print_r($dataResumen); exit();
        return json_encode([
            'total'=>count($dataProvider->allModels),
            'rows'=>$dataProvider->allModels,
            'footer'=>$dataResumen,
        ]);
    }
    
    public function DataResumen($dataArray,$id)
    {
        $mol1 = 0; $mol2 = 0; $mol3 = 0; $mol4 = 0;  $mol5 = 0;  $mol6 = 0;  $mol7 = 0;
        $ton1 = 0; $ton2 = 0; $ton3 = 0; $ton4 = 0; $ton5 = 0; $ton6 = 0; $ton7 = 0;
        $tonP1 = 0; $tonP2 = 0; $tonP3 = 0;  $tonP4 = 0; $tonP5 = 0; $tonP6 = 0; $tonP7 = 0;
        $MoldesHora1 = 0; $MoldesHora2 = 0; $MoldesHora3 = 0; $MoldesHora4 = 0; $MoldesHora5 = 0; $MoldesHora6 = 0; $MoldesHora7 = 0;
        $resPiezasD1 = 0; $resPiezasD2 = 0; $resPiezasD3 = 0; $resPiezasD4 = 0; $resPiezasD5 = 0; $resPiezasD6 = 0; $resPiezasD7 = 0; 
        
        $molH1 = 0; $molH2 = 0; $molH3 = 0; $molH4 = 0; $molH5 = 0; $molH6 = 0; $molH7 = 0;
        $tonH1 = 0; $tonH2 = 0; $tonH3 = 0; $tonH4 = 0; $tonH5 = 0; $tonH6 = 0; $tonH7 = 0;
        $tonPH1 = 0; $tonPH2 = 0; $tonPH3 = 0; $tonPH4 = 0; $tonPH5 = 0; $tonPH6 = 0;  $tonPH7 = 0;
        $MoldesHoraH1 = 0; $MoldesHoraH2 = 0; $MoldesHoraH3 = 0; $MoldesHoraH4 = 0; $MoldesHoraH5 = 0; $MoldesHoraH6 = 0; $MoldesHoraH7 = 0;
        $resPiezasHD1 = 0; $resPiezasHD2 = 0; $resPiezasHD3 = 0; $resPiezasHD4 = 0; $resPiezasHD5 = 0; $resPiezasHD6 = 0; $resPiezasHD7 = 0;
        
        $tonPrg1 = 0; $tonPrg2 = 0; $tonPrg3 = 0;
        $tonVac1 = 0; $tonVac2 = 0; $tonVac3 = 0;
        $moldPrg1 = 0; $moldPrg2 = 0; $moldPgr3 = 0; 
        $ciclos1 = 0; $ciclos2 = 0; $ciclos3 = 0;
        
        
        foreach ($dataArray as $key => $value) {
            
            /**************************INI PROGRAMADAS**************************/
            $mol1 = $mol1 + $value['Programadas1'];
            $mol2 = $mol2 + $value['Programadas2'];
            $mol3 = $mol3 + $value['Programadas3'];
            
         
            $ton1 = $ton1 + ($value['Programadas1'] * $value['PesoArania']);
            $ton2 = $ton2 + ($value['Programadas2'] * $value['PesoArania']);
            $ton3 = $ton3 + ($value['Programadas3'] * $value['PesoArania']);
            
            $tonP1 = $tonP1 + (($value['Programadas1'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonP2 = $tonP2 + (($value['Programadas2'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonP3 = $tonP3 + (($value['Programadas3'] * $value['PiezasMolde']) * $value['PesoCasting']);
            
            /*if($value['MoldesHora']){
                $resultHoras = $value['MoldesHora']/60;
                $MoldesHora1 = $MoldesHora1 + ($value['Programadas1'] * $resultHoras)/60;
                $MoldesHora2 = $MoldesHora2 + ($value['Programadas2'] * $resultHoras)/60;
                $MoldesHora3 = $MoldesHora3 + ($value['Programadas3'] * $resultHoras)/60;
                
            }  else {*/
                $resultHoras = 65/60;
                $MoldesHora1 = $MoldesHora1 + ($value['Programadas1'] * $resultHoras)/60;
                $MoldesHora2 = $MoldesHora2 + ($value['Programadas2'] * $resultHoras)/60;
                $MoldesHora3 = $MoldesHora3 + ($value['Programadas3'] * $resultHoras)/60;
                
           // }
                
             if($id == 2){
                $resPiezasD1 = $resPiezasD1 + ($value['Programadas1'] * $value['PiezasMolde']);
                $resPiezasD2 = $resPiezasD2 + ($value['Programadas2'] * $value['PiezasMolde']);
                $resPiezasD3 = $resPiezasD3 + ($value['Programadas3'] * $value['PiezasMolde']);
                $resPiezasD4 = $resPiezasD4 + ($value['Programadas4'] * $value['PiezasMolde']);
                $resPiezasD5 = $resPiezasD5 + ($value['Programadas5'] * $value['PiezasMolde']);
                $resPiezasD6 = $resPiezasD6 + ($value['Programadas6'] * $value['PiezasMolde']);
                $resPiezasD7 = $resPiezasD7 + ($value['Programadas7'] * $value['PiezasMolde']);
                
                $mol4 = $mol4 + $value['Programadas4'];
                $mol5 = $mol5 + $value['Programadas5'];
                $mol6 = $mol6 + $value['Programadas6'];
                $mol7 = $mol7 + $value['Programadas7'];
                
                $ton4 = $ton4 + ($value['Programadas4'] * $value['PesoArania']);
                $ton5 = $ton5 + ($value['Programadas5'] * $value['PesoArania']);
                $ton6 = $ton6 + ($value['Programadas6'] * $value['PesoArania']);
                $ton7 = $ton7 + ($value['Programadas7'] * $value['PesoArania']);
            
                $tonP4 = $tonP4 + (($value['Programadas4'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonP5 = $tonP5 + (($value['Programadas5'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonP6 = $tonP6 + (($value['Programadas6'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonP7 = $tonP7 + (($value['Programadas7'] * $value['PiezasMolde']) * $value['PesoCasting']);
            
                /*if($value['MoldesHora']){
                    $resultHoras = $value['MoldesHora']/60;
                    $MoldesHora4 = $MoldesHora4 + ($value['Programadas4'] * $resultHoras)/60;
                    $MoldesHora5 = $MoldesHora5 + ($value['Programadas5'] * $resultHoras)/60;
                    $MoldesHora6 = $MoldesHora6 + ($value['Programadas6'] * $resultHoras)/60;
                 * $MoldesHora7 = $MoldesHora7 + ($value['Programadas7'] * $resultHoras)/60;

                }  else {*/
                    $resultHoras = 65/60;
                    $MoldesHora4 = $MoldesHora4 + ($value['Programadas4'] * $resultHoras)/60;
                    $MoldesHora5 = $MoldesHora5 + ($value['Programadas5'] * $resultHoras)/60;
                    $MoldesHora6 = $MoldesHora6 + ($value['Programadas6'] * $resultHoras)/60;
                    $MoldesHora7 = $MoldesHora7 + ($value['Programadas7'] * $resultHoras)/60;

               // }
            }
           
            /*****************************END**********************************/
                
            /**************************INI PRODUCIDAS**************************/ 
            
            $molH1 = $molH1 + $value['Hechas1'];
            $molH2 = $molH2 + $value['Hechas2'];
            $molH3 = $molH3 + $value['Hechas3'];
         
            $tonH1 = $tonH1 + ($value['Hechas1'] * $value['PesoArania']);
            $tonH2 = $tonH2 + ($value['Hechas2'] * $value['PesoArania']);
            $tonH3 = $tonH3 + ($value['Hechas3'] * $value['PesoArania']);
            
            $tonPH1 = $tonPH1 + (($value['Hechas1'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonPH2 = $tonPH2 + (($value['Hechas2'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonPH3 = $tonPH3 + (($value['Hechas3'] * $value['PiezasMolde']) * $value['PesoCasting']);
            
            /*if($value['MoldesHora']){
                $resultHoras = $value['MoldesHora']/60;
                $MoldesHora1 = $MoldesHora1 + ($value['Hechas1'] * $resultHoras)/60;
                $MoldesHora2 = $MoldesHora2 + ($value['Hechas2'] * $resultHoras)/60;
                $MoldesHora3 = $MoldesHora3 + ($value['Hechas3'] * $resultHoras)/60;
                
            }  else {*/
                $resultHorasH = 65/60;
                $MoldesHoraH1 = $MoldesHoraH1 + ($value['Hechas1'] * $resultHorasH)/60;
                $MoldesHoraH2 = $MoldesHoraH2 + ($value['Hechas2'] * $resultHorasH)/60;
                $MoldesHoraH3 = $MoldesHoraH3 + ($value['Hechas3'] * $resultHorasH)/60;
                
           // }
                
            if($id == 2){
                $resPiezasHD1 = $resPiezasHD1 + ($value['Hechas1'] * $value['PiezasMolde']);
                $resPiezasHD2 = $resPiezasHD2 + ($value['Hechas2'] * $value['PiezasMolde']);
                $resPiezasHD3 = $resPiezasHD3 + ($value['Hechas3'] * $value['PiezasMolde']);
                $resPiezasHD4 = $resPiezasHD4 + ($value['Hechas4'] * $value['PiezasMolde']);
                $resPiezasHD5 = $resPiezasHD5 + ($value['Hechas5'] * $value['PiezasMolde']);
                $resPiezasHD6 = $resPiezasHD6 + ($value['Hechas6'] * $value['PiezasMolde']);
                $resPiezasHD7 = $resPiezasHD7 + ($value['Hechas7'] * $value['PiezasMolde']);
                
                $molH4 = $molH4 + $value['Hechas4'];
                $molH5 = $molH5 + $value['Hechas5'];
                $molH6 = $molH6 + $value['Hechas6'];
                $molH7 = $molH7 + $value['Hechas7'];

                $tonH4 = $tonH4 + ($value['Hechas4'] * $value['PesoArania']);
                $tonH5 = $tonH5 + ($value['Hechas5'] * $value['PesoArania']);
                $tonH6 = $tonH6 + ($value['Hechas6'] * $value['PesoArania']);
                $tonH7 = $tonH7 + ($value['Hechas7'] * $value['PesoArania']);

                $tonPH4 = $tonPH4 + (($value['Hechas4'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH5 = $tonPH5 + (($value['Hechas5'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH6 = $tonPH6 + (($value['Hechas6'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH7 = $tonPH7 + (($value['Hechas7'] * $value['PiezasMolde']) * $value['PesoCasting']);

                /*if($value['MoldesHora']){
                    $resultHoras = $value['MoldesHora']/60;
                    $MoldesHora4 = $MoldesHora4 + ($value['Hechas4'] * $resultHoras)/60;
                    $MoldesHora5 = $MoldesHora5 + ($value['Hechas5'] * $resultHoras)/60;
                    $MoldesHora6 = $MoldesHora6 + ($value['Hechas6'] * $resultHoras)/60;
                    $MoldesHora7 = $MoldesHora7 + ($value['Hechas7'] * $resultHoras)/60;

                }  else {*/
                    $resultHorasH = 65/60;
                    $MoldesHoraH4 = $MoldesHoraH4 + ($value['Hechas4'] * $resultHorasH)/60;
                    $MoldesHoraH5 = $MoldesHoraH5 + ($value['Hechas5'] * $resultHorasH)/60;
                    $MoldesHoraH6 = $MoldesHoraH6 + ($value['Hechas6'] * $resultHorasH)/60;
                    $MoldesHoraH7 = $MoldesHoraH7 + ($value['Hechas7'] * $resultHorasH)/60;
               // }
                
            }
        }
                
            
            if($mol1 - $molH1 <= 0 ){ $falMol1 = 0; }  else { $falMol1 = $mol1 - $molH1; }
            if($mol2 - $molH2 <= 0 ){ $falMol2 = 0; }  else { $falMol2 = $mol2 - $molH2; }
            if($mol3 - $molH3 <= 0 ){ $falMol3 = 0; }  else { $falMol3 = $mol3 - $molH3; }
            
            
            if($ton1 - $tonH1 <= 0 ){ $falTon1 = 0; }  else { $falTon1 = $ton1 - $tonH1; }
            if($ton2 - $tonH2 <= 0 ){ $falTon2 = 0; }  else { $falTon2 = $ton2 - $tonH2; }
            if($ton3 - $tonH3 <= 0 ){ $falTon3 = 0; }  else { $falTon3 = $ton3 - $tonH3; }
            
            
            
            if($tonP1 - $tonPH1 <= 0 ){ $falTonPH1 = 0; }  else { $falTonPH1 = $tonP1 - $tonPH1; }
            if($tonP2 - $tonPH2 <= 0 ){ $falTonPH2 = 0; }  else { $falTonPH2 = $tonP2 - $tonPH2; }
            if($tonP3 - $tonPH3 <= 0 ){ $falTonPH3 = 0; }  else { $falTonPH3 = $tonP3 - $tonPH3; }
            
         
            if($MoldesHora1 - $MoldesHoraH1 <= 0 ){ $falMH1 = 0; }  else { $falMH1 = $MoldesHora1 - $MoldesHoraH1; }
            if($MoldesHora2 - $MoldesHoraH2 <= 0 ){ $falMH2 = 0; }  else { $falMH2 = $MoldesHora2 - $MoldesHoraH2; }
            if($MoldesHora3 - $MoldesHoraH3 <= 0 ){ $falMH3 = 0; }  else { $falMH3 = $MoldesHora3 - $MoldesHoraH3; }
           
             /*****************************END**********************************/
            
            if($id == 2){
               
                if($mol4 - $molH4 <= 0 ){ $falMol4 = 0; }  else { $falMol4 = $mol4 - $molH4; }
                if($mol5 - $molH5 <= 0 ){ $falMol5 = 0; }  else { $falMol5 = $mol5 - $molH5; }
                if($mol6 - $molH6 <= 0 ){ $falMol6 = 0; }  else { $falMol6 = $mol6 - $molH6; }
                if($mol7 - $molH7 <= 0 ){ $falMol7 = 0; }  else { $falMol7 = $mol7 - $molH7; }
                
                if($ton4 - $tonH4 <= 0 ){ $falTon4 = 0; }  else { $falTon4 = $ton4 - $tonH4; }
                if($ton5 - $tonH5 <= 0 ){ $falTon5 = 0; }  else { $falTon5 = $ton5 - $tonH5; }
                if($ton6 - $tonH6 <= 0 ){ $falTon6 = 0; }  else { $falTon6 = $ton6 - $tonH6; }
                if($ton7 - $tonH7 <= 0 ){ $falTon7 = 0; }  else { $falTon7 = $ton7 - $tonH7; }
            
                if($tonP4 - $tonPH4 <= 0 ){ $falTonPH4 = 0; }  else { $falTonPH4 = $tonP4 - $tonPH4; }
                if($tonP5 - $tonPH5 <= 0 ){ $falTonPH5 = 0; }  else { $falTonPH5 = $tonP5 - $tonPH5; }
                if($tonP6 - $tonPH6 <= 0 ){ $falTonPH6 = 0; }  else { $falTonPH6 = $tonP6 - $tonPH6; }
                if($tonP7 - $tonPH7 <= 0 ){ $falTonPH7 = 0; }  else { $falTonPH7 = $tonP7 - $tonPH7; }
                
                if($MoldesHora4 - $MoldesHoraH4 <= 0 ){ $falMH4 = 0; }  else { $falMH4 = $MoldesHora4 - $MoldesHoraH4; }
                if($MoldesHora5 - $MoldesHoraH5 <= 0 ){ $falMH5 = 0; }  else { $falMH5 = $MoldesHora5 - $MoldesHoraH5; }
                if($MoldesHora6 - $MoldesHoraH6 <= 0 ){ $falMH6 = 0; }  else { $falMH6 = $MoldesHora6 - $MoldesHoraH6; }
                if($MoldesHora7 - $MoldesHoraH7 <= 0 ){ $falMH7 = 0; }  else { $falMH7 = $MoldesHora7 - $MoldesHoraH7; }
            }
           
        
        if($id == 1){
            $dataProvider2 = [
            [   
                "Prioridad1"=>"MOL",
                "Programadas1"=>"TON",
                "Hechas1"=>"TON P",
                "Horas1"=>"HRS",
                "Prioridad2"=>"MOL",
                "Programadas2"=>"TON",
                "Hechas2"=>"TON P",
                "Horas2"=>"HRS",
                "Prioridad3"=>"MOL",
                "Programadas3"=>"TON",
                "Hechas3"=>"TON P",
                "Horas3"=>"HRS"
            ],
            [   
                "Programadas"=>"PRG",
                "Prioridad1"=>$mol1,
                "Programadas1"=>$ton1,
                "Hechas1"=>$tonP1,
                "Horas1"=>$MoldesHora1,
                "Prioridad2"=>$mol2,
                "Programadas2"=>$ton2,
                "Hechas2"=>$tonP2,
                "Horas2"=>$MoldesHora2,
                "Prioridad3"=>$mol3,
                "Programadas3"=>$ton3,
                "Hechas3"=>$tonP3,
                "Horas3"=>$MoldesHora3
            ],
            [
                "Programadas"=>"PROD",
                "Prioridad1"=>$molH1,
                "Programadas1"=>$tonH1,
                "Hechas1"=>$tonPH1,
                "Horas1"=>$MoldesHoraH1,
                "Prioridad2"=>$molH2,
                "Programadas2"=>$tonH2,
                "Hechas2"=>$tonPH2,
                "Horas2"=>$MoldesHoraH2,
                "Prioridad3"=>$molH3,
                "Programadas3"=>$tonH3,
                "Hechas3"=>$tonPH3,
                "Horas3"=>$MoldesHoraH3
            ],
            [
                "Programadas"=>"% PROD",
                "Prioridad1"=>"",
                "Programadas1"=>"",
                "Hechas1"=>"",
                "Horas1"=>"",
                "Prioridad2"=>"",
                "Programadas2"=>"",
                "Hechas2"=>"",
                "Horas2"=>"",
                "Prioridad3"=>"",
                "Programadas3"=>"",
                "Hechas3"=>"",
                "Horas3"=>"" 
            ],
        ];
        }elseif ($id == 2) {
            $dataProvider2 = [
            [   
                "Prioridad1"=>"MOL",
                "Maquina1"=>"PZS",
                "Programadas1"=>"TON",
                "Hechas1"=>"TON P",
                "Horas1"=>"HRS",
                "Prioridad2"=>"MOL",
                "Maquina2"=>"PZS",
                "Programadas2"=>"TON",
                "Hechas2"=>"TON P",
                "Horas2"=>"HRS",
                "Prioridad3"=>"MOL",
                "Maquina3"=>"PZS",
                "Programadas3"=>"TON",
                "Hechas3"=>"TON P",
                "Horas3"=>"HRS",
                
                "Prioridad4"=>"MOL",
                "Maquina4"=>"PZS",
                "Programadas4"=>"TON",
                "Hechas4"=>"TON P",
                "Horas4"=>"HRS",
                
                "Prioridad5"=>"MOL",
                "Maquina5"=>"PZS",
                "Programadas5"=>"TON",
                "Hechas5"=>"TON P",
                "Horas5"=>"HRS",
                
                "Prioridad6"=>"MOL",
                "Maquina6"=>"PZS",
                "Programadas6"=>"TON",
                "Hechas6"=>"TON P",
                "Horas6"=>"HRS",
                
                "Prioridad7"=>"MOL",
                "Maquina7"=>"PZS",
                "Programadas7"=>"TON",
                "Hechas7"=>"TON P",
                "Horas7"=>"HRS"
            ],
            [   
                "PiezasMolde"=>"PRG",
                "Prioridad1"=>$mol1,
                "Maquina1"=>$resPiezasD1,
                "Programadas1"=>$ton1,
                "Hechas1"=>$tonP1,
                "Horas1"=>$MoldesHora1,
                "Prioridad2"=>$mol2,
                "Maquina2"=>$resPiezasD2,
                "Programadas2"=>$ton2,
                "Hechas2"=>$tonP2,
                "Horas2"=>$MoldesHora2,
                "Prioridad3"=>$mol3,
                "Maquina3"=>$resPiezasD3,
                "Programadas3"=>$ton3,
                "Hechas3"=>$tonP3,
                "Horas3"=>$MoldesHora3,
                
                "Prioridad4"=>$mol4,
                "Maquina4"=>$resPiezasD4,
                "Programadas4"=>$ton4,
                "Hechas4"=>$tonP4,
                "Horas4"=>$MoldesHora4,
                
                "Prioridad5"=>$mol5,
                "Maquina5"=>$resPiezasD5,
                "Programadas5"=>$ton5,
                "Hechas5"=>$tonP5,
                "Horas5"=>$MoldesHora5,
                
                "Prioridad6"=>$mol6,
                "Maquina6"=>$resPiezasD6,
                "Programadas6"=>$ton6,
                "Hechas6"=>$tonP6,
                "Horas6"=>$MoldesHora6,
                
                "Prioridad7"=>$mol7,
                "Maquina7"=>$resPiezasD7,
                "Programadas7"=>$ton7,
                "Hechas7"=>$tonP7,
                "Horas7"=>$MoldesHora7
            ],
            [
                "PiezasMolde"=>"PROD",
                "Prioridad1"=>$molH1,
                "Maquina1"=>$resPiezasHD1,
                "Programadas1"=>$tonH1,
                "Hechas1"=>$tonPH1,
                "Horas1"=>$MoldesHoraH1,
                "Prioridad2"=>$molH2,
                "Maquina2"=>$resPiezasHD2,
                "Programadas2"=>$tonH2,
                "Hechas2"=>$tonPH2,
                "Horas2"=>$MoldesHoraH2,
                "Prioridad3"=>$molH3,
                "Maquina3"=>$resPiezasHD3,
                "Programadas3"=>$tonH3,
                "Hechas3"=>$tonPH3,
                "Horas3"=>$MoldesHoraH3
            ],
            [
                "PiezasMolde"=>"FALTAN",
                "Prioridad1"=>$falMol1,
                "Maquina1"=>0,
                "Programadas1"=>$falTon1,
                "Hechas1"=>$falTonPH1,
                "Horas1"=>$falMH1,
                "Prioridad2"=>$falMol2,
                "Maquina2"=>0,
                "Programadas2"=>$falTon2,
                "Hechas2"=>$falTonPH2,
                "Horas2"=>$falMH2,
                "Prioridad3"=>$falMol3,
                "Maquina3"=>0,
                "Programadas3"=>$falTon3,
                "Hechas3"=>$falTonPH3,
                "Horas3"=>$falMH3,
            ],
            [
                "PiezasMolde"=>"% PROD",
                "Prioridad1"=>"",
                "Maquina1"=>"",
                "Programadas1"=>"",
                "Hechas1"=>"",
                "Horas1"=>"",
                "Prioridad2"=>"",
                "Maquina2"=>"",
                "Programadas2"=>"",
                "Hechas2"=>"",
                "Horas2"=>"",
                "Prioridad3"=>"",
                "Maquina3"=>"",
                "Programadas3"=>"",
                "Hechas3"=>"",
                "Horas3"=>"" 
            ],
                
        ];
        }    
             
        return $dataProvider2;
    }
    
    function resumenAcero($dataArray,$id){
        
        $tonPrg1K = 0; $tonPrg2K = 0; $tonPrg3K = 0;
        $tonPrg1V = 0; $tonPrg2V = 0; $tonPrg3V = 0;
        $tonPrg1E = 0; $tonPrg2E = 0; $tonPrg3E = 0;
        
        $tonVac1K = 0; $tonVac2K = 0; $tonVac3K = 0;
        $tonVac1V = 0; $tonVac2V = 0; $tonVac3V = 0;
        $tonVac1E = 0; $tonVac2E = 0; $tonVac3E = 0;
        
        $moldPrg1K = 0; $moldPrg2K = 0; $moldPgr3K = 0; 
        $moldPrg1V = 0; $moldPrg2V = 0; $moldPgr3V = 0; 
        $moldPrg1E = 0; $moldPrg2E = 0; $moldPgr3E = 0; 
        
        $ciclos1K = 0; $ciclos2K = 0; 
        $ciclos1V = 0; $ciclos2V = 0; 
        $ciclos1E = 0; $ciclos2E = 0; 
        
        $tt1 = 0; $tt2 = 0; $tt3 = 0;
                
        foreach ($dataArray as $key => $value) {
            //Kloster
            if($value['IdAreaAct'] == 1){
                $moldPrg1K = $moldPrg1K + $value['Programadas1'];
                $moldPrg2K = $moldPrg2K + $value['Programadas2'];
                $moldPgr3K = $moldPgr3K + $value['Programadas3'];
                
                $tonPrg1K = $tonPrg1K + ($value['Programadas1'] * $value['PesoArania']);
                $tonPrg2K = $tonPrg2K + ($value['Programadas2'] * $value['PesoArania']);
                $tonPrg3K = $tonPrg3K + ($value['Programadas3'] * $value['PesoArania']);
                
                $tonVac1K = $tonVac1K + ($value['Hechas1'] * $value['PesoArania']);     
                $tonVac2K = $tonVac2K + ($value['Hechas2'] * $value['PesoArania']);     
                $tonVac3K = $tonVac3K + ($value['Hechas3'] * $value['PesoArania']);     
                
                $ciclos1K = $ciclos1K + $value['CiclosMolde'] * $value['Programadas1'];   
                $ciclos2K = $ciclos2K + $value['CiclosMolde'] * $value['Programadas2'];   
                 
                //$tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;
            }
            //Varel
            if($value['IdAreaAct'] == 2){
                $moldPrg1V = $moldPrg1V + $value['Programadas1'];
                $moldPrg2V = $moldPrg2V + $value['Programadas2'];
                $moldPgr3V = $moldPgr3V + $value['Programadas3'];
                
                $tonPrg1V = $tonPrg1V + ($value['Programadas1'] * $value['PesoArania']);
                $tonPrg2V = $tonPrg2V + ($value['Programadas2'] * $value['PesoArania']);
                $tonPrg3V = $tonPrg3V + ($value['Programadas3'] * $value['PesoArania']);
                
                $tonVac1V = $tonVac1V + ($value['Hechas1'] * $value['PesoArania']);     
                $tonVac2V = $tonVac2V + ($value['Hechas2'] * $value['PesoArania']);     
                $tonVac3V = $tonVac3V + ($value['Hechas3'] * $value['PesoArania']);     
                
                $ciclos1V = $ciclos1V + $value['CiclosMolde'] * $value['Programadas1'];   
                $ciclos2V = $ciclos2V + $value['CiclosMolde'] * $value['Programadas2'];   
                //$tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;
            }
            //Especial
            if($value['IdAreaAct'] == 3){  
                $moldPrg1E = $moldPrg1E + $value['Programadas1'];
                $moldPrg2E = $moldPrg2E + $value['Programadas2'];
                $moldPgr3E = $moldPgr3E + $value['Programadas3'];
                
                $tonPrg1E = $tonPrg1E + ($value['Programadas1'] * $value['PesoArania']);
                $tonPrg2E = $tonPrg2E + ($value['Programadas2'] * $value['PesoArania']);
                $tonPrg3E = $tonPrg3E + ($value['Programadas3'] * $value['PesoArania']);
                
                $tonVac1K = $tonVac1K + ($value['Hechas1'] * $value['PesoArania']);     
                $tonVac2K = $tonVac2K + ($value['Hechas2'] * $value['PesoArania']);     
                $tonVac3K = $tonVac3K + ($value['Hechas3'] * $value['PesoArania']);     
                
                //$tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;    
            }
                /*$moldPrg1 = $moldPrg1 + $value['Programadas1'];
                $moldPrg2 = $moldPrg2 + $value['Programadas2'];
                $moldPrg3 = $moldPrg3 + $value['Programadas3'];
                
                $tonPrg1 = $tonPrg1 + ($value['Programadas1'] * $value['PesoArania']);
                $tonPrg2 = $tonPrg2 + ($value['Programadas2'] * $value['PesoArania']);
                $tonPrg3 = $tonPrg3 + ($value['Programadas3'] * $value['PesoArania']);
                
                $tonVac1 = $tonVac1 + ($value['Hechas1'] * $value['PesoArania']);
                $tonVac2 = $tonVac2 + ($value['Hechas2'] * $value['PesoArania']);
                $tonVac3 = $tonVac3 + ($value['Hechas3'] * $value['PesoArania']);
            
                $ciclos1 = $ciclos1 + $value['CiclosMolde'];
                $ciclos2 = $ciclos2 + $value['CiclosMolde'];
                $ciclos3 = $ciclos3 + $value['CiclosMolde'];
                
                $tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;*/  
            
                $ale = $value['Aleacion'];
            }
        
            
            
            $tt1 = $tt1 + $tonPrg1K + $tonPrg1V + $tonPrg1E;
            $tt2 = $tt2 + $tonPrg2K + $tonPrg2V + $tonPrg2E;
            $tt3 = $tt3 + $tonPrg3K + $tonPrg3V + $tonPrg3E;
            
            $alea = $this->Datos_alea($ale);
            
            if(isset($alea)){
               $alea = $alea;
            }else{ $alea = ""; }
            
            //echo "Aleacion".$alea;
                
            $dataProvider2 = [
                [   
                    "Programadas"=>"",
                    "Prioridad1"=>"K",
                    "Programadas1"=>"V",
                    "Hechas1"=>"E",
                    "Falta1"=>"",
                    "Prioridad2"=>"K",
                    "Programadas2"=>"V",
                    "Hechas2"=>"E",
                    "Falta2"=>"",
                    "Prioridad3"=>"K",
                    "Programadas3"=>"V",
                    "Hechas3"=>"E",
                    "Falta3"=>""
                ],
                [   
                    "Programadas"=>"TON PRG",
                    "Prioridad1"=>$tonPrg1K,
                    "Programadas1"=>$tonPrg1V,
                    "Hechas1"=>$tonPrg1E,
                    "Falta1"=>"",
                    "Prioridad2"=>$tonPrg2K,
                    "Programadas2"=>$tonPrg2V,
                    "Hechas2"=>$tonPrg2E,
                    "Falta2"=>"",
                    "Prioridad3"=>$tonPrg3K,
                    "Programadas3"=>$tonPrg3V,
                    "Hechas3"=>$tonPrg3E,
                    "Falta3"=>""
                ],
                [   
                    "Programadas"=>"TON VAC",
                    "Prioridad1"=>$tonVac1K,
                    "Programadas1"=>$tonVac1V,
                    "Hechas1"=>$tonVac1E,
                    "Falta1"=>"",
                    "Prioridad2"=>$tonVac2K,
                    "Programadas2"=>$tonVac2V,
                    "Hechas2"=>$tonVac2E,
                    "Falta2"=>"",
                    "Prioridad3"=>$tonVac3K,
                    "Programadas3"=>$tonVac3V,
                    "Hechas3"=>$tonVac3E,
                    "Falta3"=>""
                ],
                [   
                    "Programadas"=>"CICLOS",
                    "Prioridad1"=>$ciclos1K,
                    "Programadas1"=>$ciclos1V,
                    "Hechas1"=>"",
                    "Falta1"=>"",
                    "Prioridad2"=>$ciclos2K,
                    "Programadas2"=>$ciclos1V,
                    "Hechas2"=>"",
                    "Falta2"=>"",
                    "Prioridad3"=>0,
                    "Programadas3"=>0,
                    "Hechas3"=>"",
                    "Falta3"=>""
                ],
                [   
                    "Programadas"=>"MOLD PRG",
                    "Prioridad1"=>$moldPrg1K,
                    "Programadas1"=>$moldPrg1V,
                    "Hechas1"=>$moldPrg1E,
                    "Falta1"=>"",
                    "Prioridad2"=>$moldPrg2K,
                    "Programadas2"=>$moldPrg2V,
                    "Hechas2"=>$moldPrg2E,
                    "Falta2"=>"",
                    "Prioridad3"=>$moldPgr3K,
                    "Programadas3"=>$moldPgr3V,
                    "Hechas3"=>$moldPgr3E,
                    "Falta3"=>""
                ],
                [   
                    "Programadas"=>"ALEA",
                    "Prioridad1"=> "",
                    "Programadas1"=>"TT",
                    "Hechas1"=>$tt1,
                    "Falta1"=>"",
                    "Prioridad2"=>"",
                    "Programadas2"=>"TT",
                    "Hechas2"=>$tt2,
                    "Falta2"=>"",
                    "Prioridad3"=>"",
                    "Programadas3"=>"TT",
                    "Hechas3"=>$tt3,
                    "Falta3"=>""
                ],
            ];
        
        
        return $dataProvider2;
    }
    
    public function Datos_alea($data){
        
        //$data = json_decode(isset($_GET['Data']));
                
        $aleacion = new Aleaciones;
        $ale = $aleacion->find()->where("Identificador = '".$data."' ")->asArray()->all();
        
        if($ale){
            $ale = $ale;
        }else{
            $ale = "";
        }
       
        return $ale[0]['Identificador'];
    }

    public function actionData_maquina($subProceso)
    {
        $this->layout = 'JSON';
        
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
                
        $maquinas = new VMaquinas();
        $dataProvider = $maquinas->find("subProceso = $subProceso AND IdArea = $area")->asArray()->all();
        
        return json_encode($dataProvider);
    }
    
  
    
    public function actionData_diaria2($subProceso)
    {
        $Dia = isset($_POST['Dia']) ? $_POST['Dia'] : date('Y-m-d');
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        
        $this->layout = 'JSON';
        $subProceso = SubProcesos::findOne($subProceso);
        $programacion = new VProgramacionesDia();
        $dataProvider = $programacion->find()->where([
            'IdProceso'=> $subProceso->IdProceso,
            'Dia' => $Dia,
            'IdPresentacion' => $area,
        ])->asArray()->all();

        return json_encode([
                'total'=>count($dataProvider),
                'rows'=>$dataProvider,
        ]);
    }
    
    public function actionPedidos()
    {
        $this->layout = 'JSON';
        $model = new Pedidos();
        $dataProvider = $model->getSinProgramar();

        //var_dump($dataProvider->allModels);
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
    
    public function actionMarcas()
    {
        $this->layout = 'JSON';
        $model = new Pedidos();
        $dataProvider = $model->getMarcas();

        if(count($dataProvider)>0){
            return json_encode($dataProvider->allModels);
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    /**
     * Creates a new programaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new programacion();
        //var_dump(Yii::$app->request->post()); exit;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->IdProgramacion]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing programaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSave_semanal()
    {
        $model = new Programacion();
        $data = json_decode($_GET['Data']);
        
        var_dump($data);
        
        foreach($data as $dat){
            if($dat->Prioridad1 != '0' || $dat->Programadas1 != '0'){
                $datosSemana1 = "$dat->IdProgramacion,$dat->Anio1,$dat->Semana1,$dat->Prioridad1,$dat->Programadas1";
                $model->setProgramacionSemanal($datosSemana1);
            }
            if($dat->Prioridad2 != '0' || $dat->Programadas2 != '0'){
                $datosSemana2 = "$dat->IdProgramacion,$dat->Anio2,$dat->Semana2,$dat->Prioridad2,$dat->Programadas2";
                $model->setProgramacionSemanal($datosSemana2);
            }
            if($dat->Prioridad3 != '0' || $dat->Programadas3 != '0'){
                $datosSemana3 = "$dat->IdProgramacion,$dat->Anio3,$dat->Semana3,$dat->Prioridad3,$dat->Programadas3";
                $model->setProgramacionSemanal($datosSemana3);
            }
        }
        return var_dump($data);
        
    }
    
    public function actionSave_diario()
    {
        $model = new Programacion();
        $maquinas = new VMaquinas();
        $data = $_GET['Data'];
        $AreaProceso = $_GET['IdAreaProceso'];

        foreach($data as $dat){
            for($x=1;$x<=7;$x++){
                if($dat['Prioridad'.$x] != '' || $dat['Programadas'.$x] != ''){
                    $maq = $maquinas->find()->where("IdMaquina = ".$dat['Maquina'.$x])->asArray()->all();
                    $datosSemana = $dat['IdProgramacionSemana'].",'".$dat['Dia'.$x]."',".$dat['Prioridad'.$x].",".$dat['Programadas'.$x].",".$AreaProceso.",".$dat['IdTurno'].",".$dat['Maquina'.$x].",".$maq[0]['IdCentroTrabajo'];
                    $model->setProgramacionDiaria($datosSemana);
                }
            }
        }
    }
    
    public function actionSave_pedidos()
    {
        $model = new Programacion();
        $pedido = new Pedidos();
        
        /*if (isset($_GET['Data'])) {
           echo "si";
        }else{ echo "no"; }
        exit();*/
        $area = Yii::$app->session->get('area');
        $data = json_decode($_GET['Data']);

        foreach($data as $dat){   
            $pedidoDat = $pedido->findOne($dat->IdPedido);
            $producto = Productos::findOne($pedidoDat->IdProducto);
            
            $this->SetPedProgramacion($pedidoDat,$producto,$area['IdArea']);
        } 
        return true;
    }

    /**
     * Deletes an existing programaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete_diario()
    {
        if(isset($_POST['IdProgramacionDia']))
            $this->findProgramacionDia($_POST['IdProgramacionDia'])->delete();
        return "true";
    }

    public function checarSemana($semana){
        $ultimaSemana = date('W',strtotime($semana['year'].'-12-31'));
        if($semana['week'] == $ultimaSemana || $ultimaSemana == '01'){
            $semana['week'] = 1;
            $semana['year']++;
        }
        else
            $semana['week']++;
        $semana['value'] = $semana['year']."-W".(strlen($semana['week']) ==1 ? "0" : "").$semana['week'] ;

        return $semana;
    }
    
    public function SetPedProgramacion($pedidoDat,$producto, $Area){
        $command = \Yii::$app->db;  
        $Acumulado = Programaciones::find()->where("IdProgramacionEstatus = 1 AND IdProducto = $pedidoDat->IdProducto")->asArray()->all();
        $area = Areas::findOne("$Area");
       
        if($area['AgruparPedidos'] == 1){
            //var_dump($Acumulado);       
            if(isset($Acumulado[0]['IdProgramacion'])){

                $programacion = Programaciones::findOne($Acumulado[0]['IdProgramacion']);
                $programacion->Cantidad = $Acumulado[0]['Cantidad'] + $pedidoDat->Cantidad ;
                $programacion->update();               
             
                $command->createCommand()->insert('PedProg', [
                    'IdPedido' => $pedidoDat->IdPedido,
                    'IdProgramacion' => $Acumulado[0]['IdProgramacion'],
                    'OrdenCompra' => $pedidoDat->OrdenCompra,
                    'FechaMovimiento' => date('Y-m-d H:i:s'),
                ])->execute();                 
            }else{
                $model = PedProg::findOne($pedidoDat->IdPedido);
                           
                if($model == null){  
                    $model = new Programaciones();
                    $model->IdPedido= $pedidoDat->IdPedido;
                    $model->IdArea = $area['IdArea'];
                    $model->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                    $model->IdProgramacionEstatus = 1;
                    $model->IdProducto = $pedidoDat->IdProducto;
                    $model->Programadas = 0;
                    $model->Hechas = 0;
                    $model->Cantidad = $pedidoDat->Cantidad;
                    $model->save();

                    $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                    $almas = Almas::find()->where("IdProducto = $casting")->asArray()->all();

                    if(count($almas)>0){
                        $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                        $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);
                        foreach($almas as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $programacion[0]['IdProgramacion'],
                                'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                                'IdProgramacionEstatus' => 1,
                                'IdAlmas' => $alma['IdAlma'],
                                'Programadas' => 0,
                                'Hechas' => 0,
                            ];
                            $almasProgramadas->load($almas_prog);
                            $almasProgramadas->save();
                        }
                    }

                    $lastId_La = Programaciones::find()->limit('1')->orderBy('IdProgramacion desc')->one();

                    $command->createCommand()->insert('PedProg', [
                        'IdPedido' => $pedidoDat->IdPedido,
                        'IdProgramacion' => $lastId_La['IdProgramacion'],
                        'OrdenCompra' => $pedidoDat->OrdenCompra,
                        'FechaMovimiento' => date('Y-m-d H:i:s'),
                    ])->execute();  
                }
            }
            }else{               
                $model = PedProg::findOne($pedidoDat->IdPedido);
                //print_r($model);
              
                if($model == null){
                    $model = new Programaciones();
                    $model->IdPedido= $pedidoDat->IdPedido;
                    $model->IdArea = $area['IdArea'];
                    $model->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                    $model->IdProgramacionEstatus = 1;
                    $model->IdProducto = $pedidoDat->IdProducto;
                    $model->Programadas = 0;
                    $model->Hechas = 0;
                    $model->Cantidad = $pedidoDat->Cantidad;
                    $model->save();

                    $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                    $almas = Almas::find()->where("IdProducto = $casting")->asArray()->all();

                    if(count($almas)>0){
                        $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                        $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);

                        foreach($almas as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $programacion[0]['IdProgramacion'],
                                'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                                'IdProgramacionEstatus' => 1,
                                'IdAlmas' => $alma['IdAlma'],
                                'Programadas' => 0,
                                'Hechas' => 0,
                            ];
                            $almasProgramadas->load($almas_prog);
                            $almasProgramadas->save();
                        }
                    }

                    $lastId_La = Programaciones::find()->limit('1')->orderBy('IdProgramacion desc')->one();

                    $command->createCommand()->insert('PedProg', [
                        'IdPedido' => $pedidoDat->IdPedido,
                        'IdProgramacion' => $lastId_La['IdProgramacion'],
                        'OrdenCompra' => $pedidoDat->OrdenCompra,
                        'FechaMovimiento' => date('Y-m-d H:i:s'),
                    ])->execute();   
            }
        }  
    }

        /**
     * Finds the programaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return programaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProgramacionDia($id)
    {
        if (($model = ProgramacionesDia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}