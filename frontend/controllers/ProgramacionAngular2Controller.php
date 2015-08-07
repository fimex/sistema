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
use frontend\models\programacion\VResumen;
use frontend\models\programacion\ProductosEnsamble;
use frontend\models\programacion\HistoriaExplosion;
use common\models\datos\Almas;
use common\models\datos\Programaciones;
use common\models\datos\Areas;
use common\models\dux\Productos;
use common\models\dux\Aleaciones;
use common\models\dux\AlmacenesProducto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgramacionesController implements the CRUD actions for programaciones model.
 */
class ProgramacionAngular2Controller extends Controller
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

    public function actionLoadSemana(){
        $val = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1']);
        return json_encode($val);
    }
    
    public function LoadSemana($semana1= ''){
        if($semana1 == ''){
            $mes = date('m');
            $semana1 = $mes == 12 && date('W') == 1 ? [date('Y')+1,date('W'),date('Y-m-d')] : [date('Y'),date('W'),date('Y-m-d')];
        }else{
            $semana1 = date('Y-m-d',strtotime($semana1));
            $mes = date('m',strtotime($semana1));

            $semana1 = $mes == 12 && date('W',strtotime($semana1)) == 1 ? [date('Y',strtotime($semana1))+1,1* date('W',strtotime($semana1)),$semana1] : [date('Y',strtotime($semana1)),1 * date('W',strtotime($semana1)),$semana1];
        }
        
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'val'=>$semana1[2]];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);
        
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
    
    public function actionDataSemanal()
    {
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1']);
        
        //var_dump($semanas);exit;
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
            $id2 = "TRA";
        }elseif($area == 3) {
            $id = "PTB";
            $id2 = "TRB";
        }else {
            $id = "GPT";
        }
        //var_dump($dataProvider->allModels);exit;
        foreach ($dataProvider->allModels as &$value) {
            $value['Cantidad']*=1;
            $value['Prioridad1']*=1;
            $value['Prioridad2']*=1;
            $value['Prioridad3']*=1;
            $value['Prioridad4']*=1;
            $value['Programadas1']*=1;
            $value['Programadas2']*=1;
            $value['Programadas3']*=1;
            $value['Programadas4']*=1;

            $value['Moldes']= round($value['Moldes'],0,PHP_ROUND_HALF_UP);
            
            $value['SaldoCantidad']*=1;
            $molsaldo = $value['PiezasMolde'] == 0 ? 0 : $value['SaldoCantidad'] / $value['PiezasMolde'];
            $value['MoldesSaldo']= round($molsaldo,0,PHP_ROUND_HALF_UP);
            
            if($value['Producto'] != $Producto){
                
                //Aqui entra para los primeros registros 
                if($ban >= 1 && $value['Producto'] != $Producto ){
                     
                    $faltaPTB = ($value["{$id}"]+$value["{$id2}"]) - $value['Cantidad'];
                    $faltaPTB2 = $value['Cantidad'] - ($value["{$id}"]+$value["{$id2}"]);
                    
                    if($value['Cantidad'] <= ($value["{$id}"]+$value["{$id2}"])){
                        $faltaPTB = 0;
                        $SaveExistPT =  ($value["{$id}"]+$value["{$id2}"]) - $value['Cantidad'];
                        $existPTB =  ($value["{$id}"]+$value["{$id2}"]);
                        
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
                        $faltaPTB = $value['Cantidad'] - ($value["{$id}"]+$value["{$id2}"]);
                        $existPTB = ($value["{$id}"]+$value["{$id2}"]);
                        $SaveExistPT = ($value["{$id}"]+$value["{$id2}"]) - $value['Cantidad'];
                        
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
                
                $RfaltaPTB = ($value["{$id}"]+$value["{$id2}"]) - $value['Cantidad'];
                $RexistPTB = $value['Cantidad'] - ($value["{$id}"]+$value["{$id2}"]);

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
                $mold_falt = $pzas_falt == '0' ? 0 : ($pzas_falt/$value['Moldes']);
            }else{
                $mold_falt = 0;
            }
            if ($area == 2) {
                $faltaCast = $faltaPTB - $value['Cast1'] < 0 ? 0 : $faltaPTB - $value['Cast1'];
                $existCast =  $value['Cast1'];
            }
            $value['Pzas_falt'] = $pzas_falt;
            $value['Mold_falt'] = number_format($mold_falt);
            $value['Exit'.$id] = $existPTB;
            $value['Falta'.$id] = $faltaPTB;
            $value['SaveExistPT'] = $SaveExistPT;
            $value['ExitCast'] = $existCast;
            $value['FaltaCast'] = round($faltaCast,0);
            $value['class'] = $value['FaltaCast'] == 0 ? 'background-color: lightgreen;' : '';
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
        
        /*if($area == 2){
            $dataResumen = $this->resumenAcero($dataProvider->allModels,1);
        }else{
            $dataResumen = $this->DataResumen($dataProvider->allModels,1,$area);
        }*/
        $dataResumen = $this->DataResumen($dataProvider->allModels,1,$area);
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
                'footer'=>$dataResumen[0],
        ]);
    }

    public function actionResumenSemanal(){
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana']) ? '' : $_REQUEST['semana']);
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        foreach ($semanas as $semana){
            $resumen[] = VResumen::find()->where([
            'IdArea' => $area,
            'Anio' => $semana['year'],
            'Semana' => $semana['week'],
            ])->asArray()->one();
        }
        
        return json_encode($resumen);
        
    }
            
    public function actionSemanal($semana1 = '',$fecha = '')
    {
        $this->layout = 'programacion';
        
        return $this->render('programacion',[
            'title'=>'Programacion Semanal',
        ]);
    }
    
    
    public function actionDiaria($AreaProceso,$subProceso=6,$semana = '')
    {
        $this->layout = 'programacion';
        
        $mes = date('m');
        if($semana == ''){
            $semana2 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana2 = explode('-W',$semana);
        }
        
        $semanas['semana1'] = ['año'=>$semana2[0],'semana'=>$semana2[1],'value'=>"$semana2[0]-W$semana2[1]"];
        
        $turnos = new Turnos();
        
        $AreaProceso = AreaProcesos::findOne($AreaProceso);
        
        return $this->render('programacionDiaria' . (Yii::$app->user->identity->role == 1 ? '' : '2'),[
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
    
    public function actionLoadDias($semana = '')
    {
        $diasSemana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

        $year = $semana == '' ? date('Y') : date('Y',strtotime($semana));
        $week = $semana == '' ? date('W') : date('W',strtotime($semana));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        //echo $fecha;exit;
        
        for($x=0;$x<6;$x++){
            $dias[] = $diasSemana[$x]." ".date('d-m-Y',strtotime($fecha));
            $fecha = date('Y-m-d',strtotime("+1 Day",strtotime($fecha)));
        }
        
        return json_encode($dias);
    }

    public function actionDataDiaria($semana='',$subProceso = 6)
    {
        $turno = isset($_REQUEST['turno']) ? $_REQUEST['turno'] : 1;
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $semana = $semana == '' ? [date('Y'),date('W')] : [date('Y',strtotime($semana)),date('W',strtotime($semana))];
        
        
        
        $this->layout = 'JSON';

        $semana['semana1'] = ['year'=>$semana[0],'week'=>$semana[1],'value'=>"$semana[0]-W$semana[1]"];

        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionDiaria($semana,$area,$subProceso,$turno);
        //var_dump($dataProvider->allModels);exit;
        if(Yii::$app->user->identity->role == 1){
            foreach($dataProvider->allModels as &$dat){
                $dat['Programadas']*=1;
                $dat['TotalProgramado']*=1;
                $dat['Hechas']*=1;
                $dat['Maquina1'] = $dat['Maquina1'] == null ? 1700 : $dat['Maquina1'];
                $dat['Maquina2'] = $dat['Maquina2'] == null ? 1700 : $dat['Maquina2'];
                $dat['Maquina3'] = $dat['Maquina3'] == null ? 1700 : $dat['Maquina3'];
                $dat['Maquina4'] = $dat['Maquina4'] == null ? 1700 : $dat['Maquina4'];
                $dat['Maquina5'] = $dat['Maquina5'] == null ? 1700 : $dat['Maquina5'];
                $dat['Maquina6'] = $dat['Maquina6'] == null ? 1700 : $dat['Maquina6'];
                $dat['Maquina7'] = $dat['Maquina7'] == null ? 1700 : $dat['Maquina7'];
            }
        }
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
                'ResumenSem'=>[],
            ]);
        }
        //var_dump($dataProvider->allModels);exit;
        $dataResumen = $this->DataResumen($dataProvider->allModels,2,$area);
        //$ResumenSem = $this->ResumenSem($dataProvider->allModels,2,$area);
        //print_r($dataResumen); exit();
        return json_encode([
            'total'=>count($dataProvider->allModels),
            'rows'=>$dataProvider->allModels,
            'footer'=>$dataResumen[0],
            'ResumenSem'=>$dataResumen[1],
        ]);
    }
    
    
    
    public function DataResumen($dataArray,$id,$area)
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
        $resultHorasH = 0;
        $tonPrg1 = 0; $tonPrg2 = 0; $tonPrg3 = 0; $tonPrg4 = 0;
        $tonVac1 = 0; $tonVac2 = 0; $tonVac3 = 0; $tonVac4 = 0;
        $moldPrg1 = 0; $moldPrg2 = 0; $moldPgr3 = 0; $moldPgr4 = 0; 
        $ciclos1 = 0; $ciclos2 = 0; $ciclos3 = 0; $ciclos4 = 0;
        
        $prodPorcM1 = 0; $prodPorcM2 = 0; $prodPorcM3 = 0; $prodPorcM4 = 0; $prodPorcM5 = 0; $prodPorcM6 = 0; $prodPorcM7 = 0;
        $prodPorcT1 = 0; $prodPorcT2 = 0; $prodPorcT3 = 0; $prodPorcT4 = 0; $prodPorcT5 = 0; $prodPorcT6 = 0; $prodPorcT7 = 0;
        $prodPorcP1 = 0;  $prodPorcP2 = 0; $prodPorcP3 = 0; $prodPorcP4 = 0; $prodPorcP5 = 0; $prodPorcP6 = 0; $prodPorcP7 = 0;
        $prodPorcH1 = 0; $prodPorcH2 = 0; $prodPorcH3 = 0; $prodPorcH4 = 0; $prodPorcH5 = 0; $prodPorcH6 = 0; $prodPorcH7 = 0;
        $prodPorcD1 = 0; $prodPorcD2 = 0; $prodPorcD3 = 0; $prodPorcD4 = 0; $prodPorcD5 = 0; $prodPorcD6 = 0; $prodPorcD7 = 0;
        
        $Rmol = 0; $Rton = 0; $RtonP =0; $Rpiezas = 0; $Rhoras = 0;
        $RmolH = 0; $RtonH = 0; $RtonPH =0; $RpiezasH = 0; $RhorasH = 0;
        $RmolF = 0; $RtonF = 0; $RtonPF =0; $RpiezasF = 0; $RhorasF = 0; 
        $RporMol = 0; $RporPiezas = 0; $RporTon = 0; $RporTonP = 0; $RporHrs = 0;
        $ResumeSem = 0;
                 
       
        $tonPrg1K = 0; $tonPrg2K = 0; $tonPrg3K = 0; $tonPrg4K = 0;
        $tonPrg1V = 0; $tonPrg2V = 0; $tonPrg3V = 0; $tonPrg4V = 0;
        $tonPrg1E = 0; $tonPrg2E = 0; $tonPrg3E = 0; $tonPrg4E = 0;
        
        
        $tonVac1K = 0; $tonVac2K = 0; $tonVac3K = 0; $tonVac4K = 0;
        $tonVac1V = 0; $tonVac2V = 0; $tonVac3V = 0; $tonVac4V = 0;
        $tonVac1E = 0; $tonVac2E = 0; $tonVac3E = 0; $tonVac4E = 0;
        
        $moldPrg1K = 0; $moldPrg2K = 0; $moldPgr3K = 0; $moldPgr4K = 0;
        $moldPrg1V = 0; $moldPrg2V = 0; $moldPgr3V = 0; $moldPgr4V = 0;
        $moldPrg1E = 0; $moldPrg2E = 0; $moldPgr3E = 0; $moldPgr4E = 0;
        
        $ciclos1K = 0; $ciclos2K = 0; $ciclos3K = 0; $ciclos4K = 0; 
        $ciclos1V = 0; $ciclos2V = 0; $ciclos3V = 0; $ciclos4V = 0; 
        $ciclos1E = 0; $ciclos2E = 0; $ciclos3E = 0; $ciclos4E = 0; 
        
        $tt1 = 0; $tt2 = 0; $tt3 = 0; $tt4 = 0;
        foreach ($dataArray as $key => $value) {
            //var_dump($value);exit;

            if ($id == 1 AND $area == 2) {
                //Kloster
                if($value['IdAreaAct'] == 1){
                    $moldPrg1K = $moldPrg1K + $value['Programadas1'];
                    $moldPrg2K = $moldPrg2K + $value['Programadas2'];
                    $moldPgr3K = $moldPgr3K + $value['Programadas3'];
                    $moldPgr4K = $moldPgr4K + $value['Programadas4'];
                    
                    $tonPrg1K = $tonPrg1K + ($value['Programadas1'] * $value['PesoArania']);
                    $tonPrg2K = $tonPrg2K + ($value['Programadas2'] * $value['PesoArania']);
                    $tonPrg3K = $tonPrg3K + ($value['Programadas3'] * $value['PesoArania']);
                    $tonPrg4K = $tonPrg4K + ($value['Programadas4'] * $value['PesoArania']);
                    
                    $tonVac1K = $tonVac1K + ($value['Hechas1'] * $value['PesoArania']);     
                    $tonVac2K = $tonVac2K + ($value['Hechas2'] * $value['PesoArania']);     
                    $tonVac3K = $tonVac3K + ($value['Hechas3'] * $value['PesoArania']);   
                    $tonVac4K = $tonVac4K + ($value['Hechas4'] * $value['PesoArania']);  
                    
                    $ciclos1K = $ciclos1K + $value['CiclosMolde'] * $value['Programadas1'];   
                    $ciclos2K = $ciclos2K + $value['CiclosMolde'] * $value['Programadas2']; 
                    $ciclos3K = $ciclos3K + $value['CiclosMolde'] * $value['Programadas3'];  
                    $ciclos4K = $ciclos4K + $value['CiclosMolde'] * $value['Programadas4'];  
                     
                    //$tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;
                }
                //Varel
                if($value['IdAreaAct'] == 2){
                    $moldPrg1V = $moldPrg1V + $value['Programadas1'];
                    $moldPrg2V = $moldPrg2V + $value['Programadas2'];
                    $moldPgr3V = $moldPgr3V + $value['Programadas3'];
                    $moldPgr4V = $moldPgr4V + $value['Programadas4'];
                    
                    $tonPrg1V = $tonPrg1V + ($value['Programadas1'] * $value['PesoArania']);
                    $tonPrg2V = $tonPrg2V + ($value['Programadas2'] * $value['PesoArania']);
                    $tonPrg3V = $tonPrg3V + ($value['Programadas3'] * $value['PesoArania']);
                    $tonPrg4V = $tonPrg4V + ($value['Programadas4'] * $value['PesoArania']);
                    
                    $tonVac1V = $tonVac1V + ($value['Hechas1'] * $value['PesoArania']);     
                    $tonVac2V = $tonVac2V + ($value['Hechas2'] * $value['PesoArania']);     
                    $tonVac3V = $tonVac3V + ($value['Hechas3'] * $value['PesoArania']);  
                    $tonVac4V = $tonVac4V + ($value['Hechas4'] * $value['PesoArania']); 
                    
                    $ciclos1V = $ciclos1V + $value['CiclosMolde'] * $value['Programadas1'];   
                    $ciclos2V = $ciclos2V + $value['CiclosMolde'] * $value['Programadas2'];   
                    $ciclos3V = $ciclos3V + $value['CiclosMolde'] * $value['Programadas3'];   
                    $ciclos4V = $ciclos4V + $value['CiclosMolde'] * $value['Programadas4'];   
                    //$tt = $tt + $tonPrg1 + $tonPrg2 + $tonPrg3;
                }
                //Especial
                if($value['IdAreaAct'] == 3){  
                    $moldPrg1E = $moldPrg1E + $value['Programadas1'];
                    $moldPrg2E = $moldPrg2E + $value['Programadas2'];
                    $moldPgr3E = $moldPgr3E + $value['Programadas3'];
                    $moldPgr4E = $moldPgr4E + $value['Programadas4'];
                    
                    $tonPrg1E = $tonPrg1E + ($value['Programadas1'] * $value['PesoArania']);
                    $tonPrg2E = $tonPrg2E + ($value['Programadas2'] * $value['PesoArania']);
                    $tonPrg3E = $tonPrg3E + ($value['Programadas3'] * $value['PesoArania']);
                    $tonPrg4E = $tonPrg4E + ($value['Programadas4'] * $value['PesoArania']);
                    
                    $tonVac1K = $tonVac1K + ($value['Hechas1'] * $value['PesoArania']);     
                    $tonVac2K = $tonVac2K + ($value['Hechas2'] * $value['PesoArania']);     
                    $tonVac3K = $tonVac3K + ($value['Hechas3'] * $value['PesoArania']);   
                    $tonVac4K = $tonVac4K + ($value['Hechas4'] * $value['PesoArania']);  
                    
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
            
            /**************************INI PROGRAMADAS**************************/
            $mol1 = $mol1 + $value['Programadas1'];
            $mol2 = $mol2 + $value['Programadas2'];
            $mol3 = $mol3 + $value['Programadas3'];
            $mol4 = $mol4 + $value['Programadas4'];
            
         
            $ton1 = $ton1 + ($value['Programadas1'] * $value['PesoArania']);
            $ton2 = $ton2 + ($value['Programadas2'] * $value['PesoArania']);
            $ton3 = $ton3 + ($value['Programadas3'] * $value['PesoArania']);
            $ton4 = $ton4 + ($value['Programadas4'] * $value['PesoArania']);
            
            $tonP1 = $tonP1 + (($value['Programadas1'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonP2 = $tonP2 + (($value['Programadas2'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonP3 = $tonP3 + (($value['Programadas3'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonP4 = $tonP3 + (($value['Programadas4'] * $value['PiezasMolde']) * $value['PesoCasting']);   
       
            if($value['MoldesHora']>20){
                //$minutos = 65/60;
                $resultHoras = $value['MoldesHora'];
                //$MoldesHora1 = $MoldesHora1 + ($value['Programadas1']  * $resultHoras)/60;
                $MoldesHora1 = $MoldesHora1 + $value['Programadas1'] / $resultHoras;
                $MoldesHora2 = $MoldesHora2 + $value['Programadas2'] / $resultHoras;
                $MoldesHora3 = $MoldesHora3 + $value['Programadas3'] / $resultHoras;
                $MoldesHora4 = $MoldesHora4 + $value['Programadas4'] / $resultHoras; 
            }  else {
                $resultHoras = 65;
                $MoldesHora1 = $MoldesHora1 + $value['Programadas1'] / $resultHoras;
                $MoldesHora2 = $MoldesHora2 + $value['Programadas2'] / $resultHoras;
                $MoldesHora3 = $MoldesHora3 + $value['Programadas3'] / $resultHoras;
                $MoldesHora4 = $MoldesHora4 + $value['Programadas4'] / $resultHoras; 
            }  
                
             if($id == 2){
                $resPiezasD1 = $resPiezasD1 + ($value['Programadas1'] * $value['PiezasMolde']);
                $resPiezasD2 = $resPiezasD2 + ($value['Programadas2'] * $value['PiezasMolde']);
                $resPiezasD3 = $resPiezasD3 + ($value['Programadas3'] * $value['PiezasMolde']);
                $resPiezasD4 = $resPiezasD4 + ($value['Programadas4'] * $value['PiezasMolde']);
                $resPiezasD5 = $resPiezasD5 + ($value['Programadas5'] * $value['PiezasMolde']);
                $resPiezasD6 = $resPiezasD6 + ($value['Programadas6'] * $value['PiezasMolde']);
                $resPiezasD7 = $resPiezasD7 + ($value['Programadas7'] * $value['PiezasMolde']);
                
                $Rpiezas = $Rpiezas + ($value['Programadas1'] * $value['PiezasMolde']) + ($value['Programadas2'] * $value['PiezasMolde']) + ($value['Programadas3'] * $value['PiezasMolde']) + ($value['Programadas4'] * $value['PiezasMolde']) + ($value['Programadas5'] * $value['PiezasMolde']) + ($value['Programadas6'] * $value['PiezasMolde']) + ($value['Programadas7'] * $value['PiezasMolde']);
                
                $mol5 = $mol5 + $value['Programadas5'];
                $mol6 = $mol6 + $value['Programadas6'];
                $mol7 = $mol7 + $value['Programadas7'];
                
                $ton5 = $ton5 + ($value['Programadas5'] * $value['PesoArania']);
                $ton6 = $ton6 + ($value['Programadas6'] * $value['PesoArania']);
                $ton7 = $ton7 + ($value['Programadas7'] * $value['PesoArania']);
            
                $tonP5 = $tonP5 + (($value['Programadas5'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonP6 = $tonP6 + (($value['Programadas6'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonP7 = $tonP7 + (($value['Programadas7'] * $value['PiezasMolde']) * $value['PesoCasting']);
            
                if($value['MoldesHora']>20){
                    $resultHoras = $value['MoldesHora'];
                    $MoldesHora5 = $MoldesHora5 + $value['Programadas5'] / $resultHoras;
                    $MoldesHora6 = $MoldesHora6 + $value['Programadas6'] / $resultHoras;
                    $MoldesHora7 = $MoldesHora7 + $value['Programadas7'] / $resultHoras;

                }  else {
                    $resultHoras = 65;
                    $MoldesHora5 = $MoldesHora5 + $value['Programadas5'] / $resultHoras;
                    $MoldesHora6 = $MoldesHora6 + $value['Programadas6'] / $resultHoras;
                    $MoldesHora7 = $MoldesHora7 + $value['Programadas7'] / $resultHoras;

                }
            }
           
            /*****************************END**********************************/
                
            /**************************INI PRODUCIDAS**************************/ 
            
            $molH1 = $molH1 + $value['Llenadas1'];
            $molH2 = $molH2 + $value['Llenadas2'];
            $molH3 = $molH3 + $value['Llenadas3'];
            $molH4 = $molH4 + $value['Llenadas4'];
         
            $tonH1 = $tonH1 + ($value['Llenadas1'] * $value['PesoArania']);
            $tonH2 = $tonH2 + ($value['Llenadas2'] * $value['PesoArania']);
            $tonH3 = $tonH3 + ($value['Llenadas3'] * $value['PesoArania']);
            $tonH4 = $tonH4 + ($value['Llenadas4'] * $value['PesoArania']);
            
            $tonPH1 = $tonPH1 + (($value['Llenadas1'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonPH2 = $tonPH2 + (($value['Llenadas2'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonPH3 = $tonPH3 + (($value['Llenadas3'] * $value['PiezasMolde']) * $value['PesoCasting']);
            $tonPH4 = $tonPH4 + (($value['Llenadas4'] * $value['PiezasMolde']) * $value['PesoCasting']);
            
            if($value['MoldesHora']>20){
                $resultHorasH = $value['MoldesHora'];
                $MoldesHoraH1 = $MoldesHoraH1 + $value['Llenadas1'] / $resultHorasH;
                $MoldesHoraH2 = $MoldesHoraH2 + $value['Llenadas2'] / $resultHorasH;
                $MoldesHoraH3 = $MoldesHoraH3 + $value['Llenadas3'] / $resultHorasH;
                $MoldesHoraH4 = $MoldesHoraH4 + $value['Llenadas4'] / $resultHorasH;  
                
            }  else {
                $resultHorasH = 65;
                $MoldesHoraH1 = $MoldesHoraH1 + $value['Llenadas1'] / $resultHorasH;
                $MoldesHoraH2 = $MoldesHoraH2 + $value['Llenadas2'] / $resultHorasH;
                $MoldesHoraH3 = $MoldesHoraH3 + $value['Llenadas3'] / $resultHorasH;
                $MoldesHoraH4 = $MoldesHoraH4 + $value['Llenadas4'] / $resultHorasH;   
            }
                       
                                
            if($id == 2){
                $resPiezasHD1 = $resPiezasHD1 + ($value['Llenadas1'] * $value['PiezasMolde']);
                $resPiezasHD2 = $resPiezasHD2 + ($value['Llenadas2'] * $value['PiezasMolde']);
                $resPiezasHD3 = $resPiezasHD3 + ($value['Llenadas3'] * $value['PiezasMolde']);
                $resPiezasHD4 = $resPiezasHD4 + ($value['Llenadas4'] * $value['PiezasMolde']);
                $resPiezasHD5 = $resPiezasHD5 + ($value['Llenadas5'] * $value['PiezasMolde']);
                $resPiezasHD6 = $resPiezasHD6 + ($value['Llenadas6'] * $value['PiezasMolde']);
                $resPiezasHD7 = $resPiezasHD7 + ($value['Llenadas7'] * $value['PiezasMolde']);
                
                //$molH4 = $molH4 + $value['Llenadas4'];
                $molH5 = $molH5 + $value['Llenadas5'];
                $molH6 = $molH6 + $value['Llenadas6'];
                $molH7 = $molH7 + $value['Llenadas7'];

                //$tonH4 = $tonH4 + ($value['Llenadas4'] * $value['PesoArania']);
                $tonH5 = $tonH5 + ($value['Llenadas5'] * $value['PesoArania']);
                $tonH6 = $tonH6 + ($value['Llenadas6'] * $value['PesoArania']);
                $tonH7 = $tonH7 + ($value['Llenadas7'] * $value['PesoArania']);

                //$tonPH4 = $tonPH4 + (($value['Llenadas4'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH5 = $tonPH5 + (($value['Llenadas5'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH6 = $tonPH6 + (($value['Llenadas6'] * $value['PiezasMolde']) * $value['PesoCasting']);
                $tonPH7 = $tonPH7 + (($value['Llenadas7'] * $value['PiezasMolde']) * $value['PesoCasting']);

                if($value['MoldesHora']>20 || $value['MoldesHora'] = ''){
                    $resultHoras = $value['MoldesHora'];
                    //$MoldesHoraH4 = $MoldesHoraH4 + ($value['Llenadas4'] * $resultHorasH)/60;
                    $MoldesHoraH5 = $MoldesHoraH5 + $value['Llenadas5'] / $resultHorasH;
                    $MoldesHoraH6 = $MoldesHoraH6 + $value['Llenadas6'] / $resultHorasH;
                    $MoldesHoraH7 = $MoldesHoraH7 + $value['Llenadas7'] / $resultHorasH;
                }  else {
                    $resultHorasH = 65;
                    //$MoldesHoraH4 = $MoldesHoraH4 + ($value['Llenadas4'] * $resultHorasH)/60;
                    $MoldesHoraH5 = $MoldesHoraH5 + $value['Llenadas5'] / $resultHorasH;
                    $MoldesHoraH6 = $MoldesHoraH6 + $value['Llenadas6'] / $resultHorasH;
                    $MoldesHoraH7 = $MoldesHoraH7 + $value['Llenadas7'] / $resultHorasH;
                }
                    
                //$prodPorcM4 = $prodPorcM4 + $mol4 == 0 ? 0 : ($molH4/$mol4);
                $prodPorcM5 = $prodPorcM5 + $mol5 == 0 ? 0 : ($molH5/$mol5);
                $prodPorcM6 = $prodPorcM6 + $mol6 == 0 ? 0 : $molH6/$mol6;
                $prodPorcM7 = $prodPorcM7 + $mol7 == 0 ? 0 : $molH7/$mol7;

                //$prodPorcT4 = $prodPorcT4 + $ton4 == 0 ? 0 : $tonH4/$ton4;
                $prodPorcT5 = $prodPorcT5 + $ton5 == 0 ? 0 : $tonH5/$ton5;
                $prodPorcT6 = $prodPorcT6 + $ton6 == 0 ? 0 : $tonH6/$ton6;
                $prodPorcT7 = $prodPorcT7 + $ton7 == 0 ? 0 : $tonH7/$ton7;    

                //$prodPorcP4 = $prodPorcP4 + $tonP4 == 0 ? 0 : $tonPH4/$tonP4;
                $prodPorcP5 = $prodPorcP5 + $tonP5 == 0 ? 0 : $tonPH5/$tonP5;
                $prodPorcP6 = $prodPorcP6 + $tonP6 == 0 ? 0 : $tonPH6/$tonP6;
                $prodPorcP7 = $prodPorcP7 + $tonP7 == 0 ? 0 : $tonPH7/$tonP7;

                //$prodPorcH4 = $prodPorcH4 + $MoldesHora4 == 0 ? 0 : $MoldesHoraH4/$MoldesHora4;
                $prodPorcH5 = $prodPorcH5 + $MoldesHora5 == 0 ? 0 : $MoldesHoraH5/$MoldesHora5;
                $prodPorcH6 = $prodPorcH6 + $MoldesHora6 == 0 ? 0 : $MoldesHoraH6/$MoldesHora6;
                $prodPorcH7 = $prodPorcH7 + $MoldesHora7 == 0 ? 0 : $MoldesHoraH7/$MoldesHora7; 
                
                $prodPorcD1 = $prodPorcD1 + $resPiezasD1 == 0 ? 0 : $resPiezasHD1/$resPiezasD1;
                $prodPorcD2 = $prodPorcD2 + $resPiezasD2 == 0 ? 0 : $resPiezasHD2/$resPiezasD2;
                $prodPorcD3 = $prodPorcD3 + $resPiezasD3 == 0 ? 0 : $resPiezasHD3/$resPiezasD3;
                $prodPorcD4 = $prodPorcD4 + $resPiezasD4 == 0 ? 0 : $resPiezasHD4/$resPiezasD4;
                $prodPorcD5 = $prodPorcD5 + $resPiezasD5 == 0 ? 0 : $resPiezasHD5/$resPiezasD5;
                $prodPorcD6 = $prodPorcD6 + $resPiezasD6 == 0 ? 0 : $resPiezasHD6/$resPiezasD6;
                $prodPorcD7 = $prodPorcD7 + $resPiezasD7 == 0 ? 0 : $resPiezasHD7/$resPiezasD7;
                
                // Resumen semanal diario de PROGRAMADAS                                
                $Rmol = $Rmol + $value['Programadas1'] + $value['Programadas2'] + $value['Programadas3'] + $value['Programadas4'] + $value['Programadas5'] + $value['Programadas6'] + $value['Programadas7']; 
             
                $Rton = $Rton + ($value['Programadas1'] * $value['PesoArania']) + ($value['Programadas2'] * $value['PesoArania']) + ($value['Programadas3'] * $value['PesoArania']) + ($value['Programadas4'] * $value['PesoArania']) + ($value['Programadas5'] * $value['PesoArania']) + ($value['Programadas6'] * $value['PesoArania']) + ($value['Programadas7'] * $value['PesoArania']); 
          
                $RtonP = $RtonP + (($value['Programadas1'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas2'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas3'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas4'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas5'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas6'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Programadas7'] * $value['PiezasMolde']) * $value['PesoCasting']); 
               
                $Rhoras = $Rhoras + ($value['Programadas1'] / $resultHoras) + ($value['Programadas2'] / $resultHoras) +($value['Programadas3'] / $resultHoras) + ($value['Programadas4'] / $resultHoras) + ($value['Programadas5'] / $resultHoras) + ($value['Programadas6'] / $resultHoras) + ($value['Programadas7'] / $resultHoras);
            
                // Resumen semanal diario de PRODUCIDAS
                $RpiezasH = $RpiezasH + ($value['Llenadas1'] * $value['PiezasMolde']) + ($value['Llenadas2'] * $value['PiezasMolde']) + ($value['Llenadas3'] * $value['PiezasMolde']) + ($value['Llenadas4'] * $value['PiezasMolde']) + ($value['Llenadas5'] * $value['PiezasMolde']) + ($value['Llenadas6'] * $value['PiezasMolde']) + ($value['Llenadas7'] * $value['PiezasMolde']); 
                                
                $RmolH = $RmolH + $value['Llenadas1'] + $value['Llenadas2'] + $value['Llenadas3'] + $value['Llenadas4'] + $value['Llenadas5'] + $value['Llenadas6'] + $value['Llenadas7']; 
             
                $RtonH = $RtonH + ($value['Llenadas1'] * $value['PesoArania']) + ($value['Llenadas2'] * $value['PesoArania']) + ($value['Llenadas3'] * $value['PesoArania']) + ($value['Llenadas4'] * $value['PesoArania']) + ($value['Llenadas5'] * $value['PesoArania']) + ($value['Llenadas6'] * $value['PesoArania']) + ($value['Llenadas7'] * $value['PesoArania']); 
          
                $RtonPH = $RtonPH + (($value['Llenadas1'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas2'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas3'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas4'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas5'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas6'] * $value['PiezasMolde']) * $value['PesoCasting']) + (($value['Llenadas7'] * $value['PiezasMolde']) * $value['PesoCasting']); 
               
                $RhorasH = $RhorasH + ($value['Llenadas1'] / $resultHoras) + ($value['Llenadas2'] / $resultHoras) +($value['Llenadas3'] / $resultHoras) + ($value['Llenadas4'] / $resultHoras) + ($value['Llenadas5'] / $resultHoras) + ($value['Llenadas6'] / $resultHoras) + ($value['Llenadas7'] / $resultHoras);

                
                // Resumen diario de % Producidas
                $RporMol = $RporMol + ($mol1 == 0 ? 0 : ($molH1/$mol1)) + ($mol2 == 0 ? 0 : ($molH2/$mol2)) + ($mol3 == 0 ? 0 : ($molH3/$mol3)) + ($mol4 == 0 ? 0 : ($molH4/$mol4))  + ($mol5 == 0 ? 0 : ($molH5/$mol5))  + ($mol6 == 0 ? 0 : ($molH6/$mol6))  + ($mol7 == 0 ? 0 : ($molH7/$mol7));//+ $mol2 == 0 ? 0 : ($molH2/$mol2) + $mol3 == 0 ? 0 : ($molH3/$mol3)+ $mol4 == 0 ? 0 : ($molH4/$mol4) + $mol6 == 0 ? 0 : ($molH6/$mol6) + $mol7 == 0 ? 0 : ($molH7/$mol7);
                $RporPiezas = $RporPiezas + ($resPiezasD1 == 0 ? 0 : $resPiezasHD1/$resPiezasD1) + ($resPiezasD2 == 0 ? 0 : $resPiezasHD2/$resPiezasD2) + ($resPiezasD3 == 0 ? 0 : $resPiezasHD3/$resPiezasD3) + ($resPiezasD4 == 0 ? 0 : $resPiezasHD4/$resPiezasD4) + ($resPiezasD5 == 0 ? 0 : $resPiezasHD5/$resPiezasD5) + ($resPiezasD6 == 0 ? 0 : $resPiezasHD6/$resPiezasD6) + ($resPiezasD7 == 0 ? 0 : $resPiezasHD7/$resPiezasD7);
                $RporTon = $RporTon + ($ton1 == 0 ? 0 : $tonH1/$ton1) + ($ton2 == 0 ? 0 : $tonH2/$ton2) + ($ton3 == 0 ? 0 : $tonH3/$ton3) + ($ton4 == 0 ? 0 : $tonH4/$ton4) + ($ton5 == 0 ? 0 : $tonH5/$ton5) + ($ton6 == 0 ? 0 : $tonH6/$ton6) + ($ton7 == 0 ? 0 : $tonH7/$ton7);
                $RporTonP = $RporTonP + ($tonP1 == 0 ? 0 : $tonPH1/$tonP1) + ($tonP2 == 0 ? 0 : $tonPH2/$tonP2) + ($tonP3 == 0 ? 0 : $tonPH3/$tonP3) + ($tonP4 == 0 ? 0 : $tonPH4/$tonP4) + ($tonP5 == 0 ? 0 : $tonPH5/$tonP5) + ($tonP6 == 0 ? 0 : $tonPH6/$tonP6) + ($tonP7 == 0 ? 0 : $tonPH7/$tonP7);
                $RporHrs = $RporHrs + ($MoldesHora1 == 0 ? 0 : $MoldesHoraH1/$MoldesHora1) + ($MoldesHora2 == 0 ? 0 : $MoldesHoraH2/$MoldesHora2) + ($MoldesHora3 == 0 ? 0 : $MoldesHoraH3/$MoldesHora3) + ($MoldesHora4 == 0 ? 0 : $MoldesHoraH4/$MoldesHora4) + ($MoldesHora5 == 0 ? 0 : $MoldesHoraH5/$MoldesHora5) + ($MoldesHora6 == 0 ? 0 : $MoldesHoraH6/$MoldesHora6) + ($MoldesHora7 == 0 ? 0 : $MoldesHoraH7/$MoldesHora7);
            }
          
      
            
            $prodPorcT1 = $prodPorcT1 + $ton1 == 0 ? 0 : ($tonH1/$ton1);
            $prodPorcT2 = $prodPorcT2 + $ton2 == 0 ? 0 : ($tonH2/$ton2);
            $prodPorcT3 = $prodPorcT3 + $ton3 == 0 ? 0 : ($tonH3/$ton3);
            $prodPorcT4 = $prodPorcT4 + $ton4 == 0 ? 0 : ($tonH4/$ton4);
            
            $prodPorcM1 = $prodPorcM1 + $mol1 == 0 ? 0 : ($molH1/$mol1);
            $prodPorcM2 = $prodPorcM2 + $mol2 == 0 ? 0 : ($molH2/$mol2);
            $prodPorcM3 = $prodPorcM3 + $mol3 == 0 ? 0 : ($molH3/$mol3);
            $prodPorcM4 = $prodPorcM4 + $mol4 == 0 ? 0 : ($molH4/$mol4);

            $prodPorcT1 = $prodPorcT1 + $ton1 == 0 ? 0 : ($tonH1/$ton1);
            $prodPorcT2 = $prodPorcT2 + $ton2 == 0 ? 0 : $tonH2/$ton2;
            $prodPorcT3 = $prodPorcT3 + $ton3 == 0 ? 0 : $tonH3/$ton3;
            $prodPorcT4 = $prodPorcT4 + $ton4 == 0 ? 0 : $tonH4/$ton4;
              
            $prodPorcP1 = $prodPorcP1 + $tonP1 == 0 ? 0 : $tonPH1/$tonP1;
            $prodPorcP2 = $prodPorcP2 + $tonP2 == 0 ? 0 : $tonPH2/$tonP2;
            $prodPorcP3 = $prodPorcP3 + $tonP3 == 0 ? 0 : $tonPH3/$tonP3;
            $prodPorcP4 = $prodPorcP4 + $tonP4 == 0 ? 0 : $tonPH4/$tonP4;

            $prodPorcH1 = $prodPorcH1 + $MoldesHora1 == 0 ? 0 : $MoldesHoraH1/$MoldesHora1;
            $prodPorcH2 = $prodPorcH2 + $MoldesHora2 == 0 ? 0 : $MoldesHoraH2/$MoldesHora2;
            $prodPorcH3 = $prodPorcH3 + $MoldesHora3 == 0 ? 0 : $MoldesHoraH3/$MoldesHora3;
            $prodPorcH4 = $prodPorcH4 + $MoldesHora4 == 0 ? 0 : $MoldesHoraH4/$MoldesHora4;
        }
   
            if($mol1 - $molH1 <= 0 ){ $falMol1 = 0; }  else { $falMol1 = $mol1 - $molH1; }
            if($mol2 - $molH2 <= 0 ){ $falMol2 = 0; }  else { $falMol2 = $mol2 - $molH2; }
            if($mol3 - $molH3 <= 0 ){ $falMol3 = 0; }  else { $falMol3 = $mol3 - $molH3; }
            if($mol4 - $molH4 <= 0 ){ $falMol4 = 0; }  else { $falMol4 = $mol4 - $molH4; }
             
            if($ton1 - $tonH1 <= 0 ){ $falTon1 = 0; }  else { $falTon1 = $ton1 - $tonH1; }
            if($ton2 - $tonH2 <= 0 ){ $falTon2 = 0; }  else { $falTon2 = $ton2 - $tonH2; }
            if($ton3 - $tonH3 <= 0 ){ $falTon3 = 0; }  else { $falTon3 = $ton3 - $tonH3; }
            if($ton4 - $tonH4 <= 0 ){ $falTon4 = 0; }  else { $falTon4 = $ton4 - $tonH4; }
            
            if($tonP1 - $tonPH1 <= 0 ){ $falTonPH1 = 0; }  else { $falTonPH1 = $tonP1 - $tonPH1; }
            if($tonP2 - $tonPH2 <= 0 ){ $falTonPH2 = 0; }  else { $falTonPH2 = $tonP2 - $tonPH2; }
            if($tonP3 - $tonPH3 <= 0 ){ $falTonPH3 = 0; }  else { $falTonPH3 = $tonP3 - $tonPH3; }
            if($tonP4 - $tonPH4 <= 0 ){ $falTonPH4 = 0; }  else { $falTonPH4 = $tonP4 - $tonPH4; }
  
            if($MoldesHora1 - $MoldesHoraH1 <= 0 ){ $falMH1 = 0; }  else { $falMH1 = $MoldesHora1 - $MoldesHoraH1; }
            if($MoldesHora2 - $MoldesHoraH2 <= 0 ){ $falMH2 = 0; }  else { $falMH2 = $MoldesHora2 - $MoldesHoraH2; }
            if($MoldesHora3 - $MoldesHoraH3 <= 0 ){ $falMH3 = 0; }  else { $falMH3 = $MoldesHora3 - $MoldesHoraH3; }
            if($MoldesHora4 - $MoldesHoraH4 <= 0 ){ $falMH4 = 0; }  else { $falMH4 = $MoldesHora4 - $MoldesHoraH4; }
           
        
            /*****************************END**********************************/
            
            if($id == 2){
               
                //if($mol4 - $molH4 <= 0 ){ $falMol4 = 0; }  else { $falMol4 = $mol4 - $molH4; }
                if($mol5 - $molH5 <= 0 ){ $falMol5 = 0; }  else { $falMol5 = $mol5 - $molH5; }
                if($mol6 - $molH6 <= 0 ){ $falMol6 = 0; }  else { $falMol6 = $mol6 - $molH6; }
                if($mol7 - $molH7 <= 0 ){ $falMol7 = 0; }  else { $falMol7 = $mol7 - $molH7; }
                
                //if($ton4 - $tonH4 <= 0 ){ $falTon4 = 0; }  else { $falTon4 = $ton4 - $tonH4; }
                if($ton5 - $tonH5 <= 0 ){ $falTon5 = 0; }  else { $falTon5 = $ton5 - $tonH5; }
                if($ton6 - $tonH6 <= 0 ){ $falTon6 = 0; }  else { $falTon6 = $ton6 - $tonH6; }
                if($ton7 - $tonH7 <= 0 ){ $falTon7 = 0; }  else { $falTon7 = $ton7 - $tonH7; }
            
               // if($tonP4 - $tonPH4 <= 0 ){ $falTonPH4 = 0; }  else { $falTonPH4 = $tonP4 - $tonPH4; }
                if($tonP5 - $tonPH5 <= 0 ){ $falTonPH5 = 0; }  else { $falTonPH5 = $tonP5 - $tonPH5; }
                if($tonP6 - $tonPH6 <= 0 ){ $falTonPH6 = 0; }  else { $falTonPH6 = $tonP6 - $tonPH6; }
                if($tonP7 - $tonPH7 <= 0 ){ $falTonPH7 = 0; }  else { $falTonPH7 = $tonP7 - $tonPH7; }
                
                //if($MoldesHora4 - $MoldesHoraH4 <= 0 ){ $falMH4 = 0; }  else { $falMH4 = $MoldesHora4 - $MoldesHoraH4; }
                if($MoldesHora5 - $MoldesHoraH5 <= 0 ){ $falMH5 = 0; }  else { $falMH5 = $MoldesHora5 - $MoldesHoraH5; }
                if($MoldesHora6 - $MoldesHoraH6 <= 0 ){ $falMH6 = 0; }  else { $falMH6 = $MoldesHora6 - $MoldesHoraH6; }
                if($MoldesHora7 - $MoldesHoraH7 <= 0 ){ $falMH7 = 0; }  else { $falMH7 = $MoldesHora7 - $MoldesHoraH7; }
                
                //Resumen semanal diario de faltantes
                $RmolF = ($Rmol - $RmolH);

                $RpiezasF = ($Rpiezas - $RpiezasH);

                $RtonF = ($Rton - $RtonH);

                $RtonPF = ($RtonP - $RtonPH); //$RtonPF + $falTonPH1 + $falTonPH2 + $falTonPH3 + $falTonPH4 + $falTonPH5 + $falTonPH6 + $falTonPH7;

                $RhorasF = ($Rhoras - $RhorasH);
            }
           
    
        if ($id == 2) {
            $ResumeSem = [
                [   
                    "PiezasMolde"=>"PRG",
                    "Prioridad1"=>$Rmol,
                    "Maquina1"=>$Rpiezas,
                    "Programadas1"=>$RtonP/1000,
                    "Hechas1"=>$Rton/1000,
                    "Horas1"=>$Rhoras
                ],
                [   
                    "PiezasMolde"=>"PROD",
                    "Prioridad1"=>$RmolH,
                   "Maquina1"=>$RpiezasH,
                    "Programadas1"=>$RtonPH/1000,
                    "Hechas1"=>$RtonH/1000,
                    "Horas1"=>$RhorasH
                ],
                [   
                    "PiezasMolde"=>"FALTAN",
                    "Prioridad1"=>$RmolF,
                    "Maquina1"=>$RpiezasF,
                    "Programadas1"=>$RtonPF/1000,
                    "Hechas1"=>$RtonF/1000,
                    "Horas1"=>$RhorasF
                ],
                [   
                    "PiezasMolde"=>"% PROD",
                    "Prioridad1"=>$RmolH == 0 && $Rmol == 0 ? 0 :($RmolH/$Rmol)*100,
                    "Maquina1"=>  $RpiezasH == 0 && $Rpiezas == 0 ? 0 : $RpiezasH/$Rpiezas*100,
                    "Programadas1"=> $RtonPH == 0 && $RtonP == 0 ? 0 : $RtonPH/$RtonP*100,
                    "Hechas1"=> $RtonH == 0 && $Rton == 0 ? 0 : $RtonH/$Rton*100,
                    "Horas1"=> $RhorasH == 0 && $Rhoras == 0 ? 0 : $RhorasH/$Rhoras*100

                ]
            ];
                     
        }
        
        //var_dump($ResumeSem);

        if ($id == 1 AND $area == 2) {

            $tt1 = $tt1 + $tonPrg1K + $tonPrg1V + $tonPrg1E;
            $tt2 = $tt2 + $tonPrg2K + $tonPrg2V + $tonPrg2E;
            $tt3 = $tt3 + $tonPrg3K + $tonPrg3V + $tonPrg3E;
            $tt4 = $tt4 + $tonPrg4K + $tonPrg4V + $tonPrg4E;
            
            $alea = $this->Datos_alea($ale);
            
            if(isset($alea)){
               $alea = $alea;
            }else{ $alea = ""; }
            
             $dataProvider2 = [
               
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
                    "Falta3"=>"",
                    "Prioridad4"=>$tonPrg4K,
                    "Programadas4"=>$tonPrg4V,
                    "Hechas4"=>$tonPrg4E,
                    "Falta4"=>""
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
                    "Falta3"=>"",
                    "Prioridad4"=>$tonVac4K,
                    "Programadas4"=>$tonVac4V,
                    "Hechas4"=>$tonVac4E,
                    "Falta4"=>""
                ],
                [   
                    "Programadas"=>"CICLOS",
                    "Prioridad1"=>$ciclos1K,
                    "Programadas1"=>$ciclos1V,
                    "Hechas1"=>"",
                    "Falta1"=>"",
                    "Prioridad2"=>$ciclos2K,
                    "Programadas2"=>$ciclos2V,
                    "Hechas2"=>"",
                    "Falta2"=>"",
                    "Prioridad3"=>$ciclos3K,
                    "Programadas3"=>$ciclos3V,
                    "Hechas3"=>"",
                    "Falta3"=>"",
                    "Prioridad4"=>$ciclos4K,
                    "Programadas4"=>$ciclos4V,
                    "Hechas4"=>"",
                    "Falta4"=>""
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
                    "Falta3"=>"",
                    "Prioridad4"=>$moldPgr4K,
                    "Programadas4"=>$moldPgr4V,
                    "Hechas4"=>$moldPgr4E,
                    "Falta4"=>""
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
                    "Falta3"=>"",
                    "Prioridad4"=>"",
                    "Programadas4"=>"TT",
                    "Hechas4"=>$tt4,
                    "Falta4"=>""
                ],
            ];
        }
    
        else{
            $dataProvider2 = [
            [   
                "Programadas"=>"PRG",
                "Prioridad1"=>$mol1,
                "Programadas1"=> round($ton1 / 1000,2),
                "Hechas1"=>round($tonP1 / 1000,2),
                "Horas1"=>round($MoldesHora1,0),
                
                "Prioridad2"=>$mol2,
                "Programadas2"=>round($ton2 / 1000,2),
                "Hechas2"=>round($tonP2 / 1000,2),
                "Horas2"=>round($MoldesHora2,0),
                
                "Prioridad3"=>$mol3,
                "Programadas3"=>round($ton3 / 1000,2),
                "Hechas3"=>round($tonP3 / 1000,2),                
                "Horas3"=>round($MoldesHora3,0),

                "Prioridad4"=>$mol4,
                "Programadas4"=>round($ton4 / 1000,2),
                "Hechas4"=>round($tonP4 / 1000,2),
                "Horas4"=>round($MoldesHora4,0)
            ],
            [
                "Programadas"=>"PROD",
                "Prioridad1"=>$molH1,
                "Programadas1"=>round($tonH1 / 1000,2),
                "Hechas1"=>round($tonPH1 / 1000,2),
                "Horas1"=>round($MoldesHoraH1,0),
                
                "Prioridad2"=>$molH2,
                "Programadas2"=>round($tonH2 / 1000,2),
                "Hechas2"=>round($tonPH2 / 1000,2),
                "Horas2"=>round($MoldesHoraH2,0),
                
                "Prioridad3"=>$molH3,
                "Programadas3"=>round($tonH3 / 1000,2),
                "Hechas3"=>round($tonPH3 / 1000,2),
                "Horas3"=>round($MoldesHoraH3,0),
                
                "Prioridad4"=>$molH4,
                "Programadas4"=>round($tonH4 / 1000,2),
                "Hechas4"=>round($tonPH4 / 1000,2),
                "Horas4"=>round($MoldesHoraH4,0)
            ],
            [
                "Programadas"=>"% PROD",
                "Prioridad1"=>($prodPorcM1*100),
                "Programadas1"=>$prodPorcT1*100,
                "Hechas1"=>$prodPorcP1*100,
                "Horas1"=>$prodPorcH1*100,
                
                "Prioridad2"=>$prodPorcM2*100,
                "Programadas2"=>$prodPorcT2*100,
                "Hechas2"=>$prodPorcP2*100,
                "Horas2"=>$prodPorcH2*100,
                
                "Prioridad3"=>$prodPorcM3*100,
                "Programadas3"=>$prodPorcT3*100,
                "Hechas3"=>$prodPorcP3*100,
                "Horas3"=>$prodPorcH3*100,
                
                "Prioridad4"=>$prodPorcM4*100,
                "Programadas4"=>$prodPorcT4*100,
                "Hechas4"=>$prodPorcP4*100,
                "Horas4"=>$prodPorcH4*100,
            ],
        ];
        }
        if ($id == 2) {
            $dataProvider2 = [
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
                "Horas2"=>round($MoldesHora2,0),
                
                "Prioridad3"=>$mol3,
                "Maquina3"=>$resPiezasD3,
                "Programadas3"=>$ton3,
                "Hechas3"=>$tonP3,
                "Horas3"=>round($MoldesHora3,0),
                
                "Prioridad4"=>$mol4,
                "Maquina4"=>$resPiezasD4,
                "Programadas4"=>$ton4,
                "Hechas4"=>$tonP4,
                "Horas4"=>round($MoldesHora4,0),
                
                "Prioridad5"=>$mol5,
                "Maquina5"=>$resPiezasD5,
                "Programadas5"=>$ton5,
                "Hechas5"=>$tonP5,
                "Horas5"=>round($MoldesHora5,0),
                
                "Prioridad6"=>$mol6,
                "Maquina6"=>$resPiezasD6,
                "Programadas6"=>$ton6,
                "Hechas6"=>$tonP6,
                "Horas6"=>round($MoldesHora6,0),
                
                "Prioridad7"=>$mol7,
                "Maquina7"=>$resPiezasD7,
                "Programadas7"=>$ton7,
                "Hechas7"=>$tonP7,
                "Horas7"=>round($MoldesHora7,0)
            ],
            [
                "PiezasMolde"=>"PROD",
                "Prioridad1"=>$molH1,
                "Maquina1"=>$resPiezasHD1,
                "Programadas1"=>$tonH1,
                "Hechas1"=>$tonPH1,
                "Horas1"=>  $MoldesHoraH1,
                
                "Prioridad2"=>$molH2,
                "Maquina2"=>$resPiezasHD2,
                "Programadas2"=>$tonH2,
                "Hechas2"=>$tonPH2,
                "Horas2"=>round($MoldesHoraH2,0),
                
                "Prioridad3"=>$molH3,
                "Maquina3"=>$resPiezasHD3,
                "Programadas3"=>$tonH3,
                "Hechas3"=>$tonPH3,
                "Horas3"=>round($MoldesHoraH3,0),
                
                 "Prioridad4"=>$molH4,
                "Maquina4"=>$resPiezasHD4,
                "Programadas4"=>$tonH4,
                "Hechas4"=>$tonPH4,
                "Horas4"=>round($MoldesHoraH4,0),
                
                "Prioridad5"=>$molH5,
                "Maquina5"=>$resPiezasHD5,
                "Programadas5"=>$tonH5,
                "Hechas5"=>$tonPH5,
                "Horas5"=>round($MoldesHoraH5,0),
                
                "Prioridad6"=>$molH6,
                "Maquina6"=>$resPiezasHD6,
                "Programadas6"=>$tonH6,
                "Hechas6"=>$tonPH6,
                "Horas6"=>round($MoldesHoraH6,0),
                
                "Prioridad7"=>$molH7,
                "Maquina7"=>$resPiezasHD7,
                "Programadas7"=>$tonH7,
                "Hechas7"=>$tonPH7,
                "Horas7"=>round($MoldesHoraH7,0)
            ],
            [
                "PiezasMolde"=>"FALTAN",
                "Prioridad1"=>$falMol1,
                "Maquina1"=>$resPiezasD1 - $resPiezasHD1,
                "Programadas1"=>$falTon1,
                "Hechas1"=>$falTonPH1,
                "Horas1"=>round($falMH1,0),
                
                "Prioridad2"=>$falMol2,
                "Maquina2"=>$resPiezasD2 - $resPiezasHD2,
                "Programadas2"=>$falTon2,
                "Hechas2"=>$falTonPH2,
                "Horas2"=>round($falMH2,0),
                
                "Prioridad3"=>$falMol3,
                "Maquina3"=>$resPiezasD3 - $resPiezasHD3,
                "Programadas3"=>$falTon3,
                "Hechas3"=>$falTonPH3,
                "Horas3"=>round($falMH3,0),
                
                "Prioridad4"=>$falMol4,
                "Maquina4"=>$resPiezasD4 - $resPiezasHD4,
                "Programadas4"=>$falTon4,
                "Hechas4"=>$falTonPH4,
                "Horas4"=>round($falMH4,0),
                
                "Prioridad5"=>$falMol5,
                "Maquina5"=>$resPiezasD5 - $resPiezasHD5,
                "Programadas5"=>$falTon5,
                "Hechas5"=>$falTonPH5,
                "Horas5"=>round($falMH5,0),
                
                "Prioridad6"=>$falMol6,
                "Maquina6"=>$resPiezasD6 - $resPiezasHD6,
                "Programadas6"=>$falTon6,
                "Hechas6"=>$falTonPH6,
                "Horas6"=>round($falMH6,0),
                
                "Prioridad7"=>$falMol7,
                "Maquina7"=>$resPiezasD7 - $resPiezasHD7,
                "Programadas7"=>$falTon7,
                "Hechas7"=>$falTonPH7,
                "Horas7"=>round($falMH7,0)
            ],
            [
                "PiezasMolde"=>"% PROD",
                "Prioridad1"=>round($prodPorcM1*100,0),
                "Maquina1"=>($prodPorcD1*100),

                "Programadas1"=>round($prodPorcT1*100,0),
                "Hechas1"=>$prodPorcP1*100,
                "Horas1"=> $prodPorcH1*100,
                
                "Prioridad2"=>$prodPorcM2*100,
                "Maquina2"=>$prodPorcD2*100,
                "Programadas2"=>$prodPorcT2*100,
                "Hechas2"=>$prodPorcP2*100,
                "Horas2"=>$prodPorcH2*100,
                
                "Prioridad3"=>$prodPorcM3*100,
                "Maquina3"=>$prodPorcD3*100,
                "Programadas3"=>$prodPorcT3*100,
                "Hechas3"=>$prodPorcP3*100,
                "Horas3"=>$prodPorcH3*100,
         
                "Prioridad4"=>$prodPorcM4*100,
                "Maquina4"=>$prodPorcD4*100,
                "Programadas4"=>$prodPorcT4*100,
                "Hechas4"=>$prodPorcP4*100,
                "Horas4"=>$prodPorcH4*100,
                
                "Prioridad5"=>$prodPorcM5*100,
                "Maquina5"=>$prodPorcD5*100,
                "Programadas5"=>$prodPorcT5*100,
                "Hechas5"=>$prodPorcP5*100,
                "Horas5"=>$prodPorcH5*100,
                
                "Prioridad6"=>$prodPorcM6*100,
                "Maquina6"=>$prodPorcD6*100,
                "Programadas6"=>$prodPorcT6*100,
                "Hechas6"=>$prodPorcP6*100,
                "Horas6"=>$prodPorcH6*100,
                
                "Prioridad7"=>$prodPorcM7*100,
                "Maquina7"=>$prodPorcD7*100,
                "Programadas7"=>$prodPorcT7*100,
                "Hechas7"=>$prodPorcP7*100,
                "Horas7"=>$prodPorcH7*100,
            ],    
        ];
        }    
        
        $datos[0] = $dataProvider2;
        $datos[1] = $ResumeSem;
             
        return $datos;
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
        
        //$data = json_decode(isset($_REQUEST['Data']));
                
        $aleacion = new Aleaciones;
        $ale = $aleacion->find()->where("Identificador = '".$data."' ")->asArray()->all();
        
        if($ale){
            $ale = $ale;
        }else{
            $ale = "";
        }
       
        return $ale[0]['Identificador'];
    }

    public function actionPedidos()
    {
        $this->layout = 'JSON';
        $model = new Pedidos();
        $dataProvider = $model->getSinProgramar(isset($_REQUEST['fecha']) ? date('Y-m-d',strtotime($_REQUEST['fecha'])) : '');

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
    public function actionSaveSemanal()
    {
        $model = new Programacion();

        $dat = $_REQUEST;
        $datosSemana1 = $dat['IdProgramacion'].",".$dat['Anio'].",".$dat['Semana'].",".$dat['Prioridad'].",".$dat['Programadas'];
        return $model->setProgramacionSemanal($datosSemana1);
    }
    
    public function actionDatosDux()
    {
        $model = new Programacion();
        $model->setDatosDux();
    }
    
    public function actionActualizacion()
    {
        $model = new Programacion();
        return date('d-m-Y h:i',strtotime($model->getActualizacion()[0]['FechaInicio']));
    }
    
    public function actionSaveDiario()
    {
        $model = new Programacion();
        $maquinas = new VMaquinas();
        $dat = $_REQUEST;
        $AreaProceso = $_REQUEST['IdAreaProceso'];
        $guardado = false;

        if(isset($dat['Programadas'])){
            $maq = $maquinas->find()->where("IdMaquina = ".$dat['Maquina'])->asArray()->all();
            $datosSemana = $dat['IdProgramacionSemana'].",'".$dat['Dia']."',".$dat['Prioridad'].",".$dat['Programadas'].",".$AreaProceso.",".$dat['IdTurno'].",".$dat['Maquina'].",".$maq[0]['IdCentroTrabajo'];
            $model->setProgramacionDiaria($datosSemana);
            $guardado = true;
        }
        
        return $guardado;
    }
    
    public function actionSavePedidos()
    {
        $model = new Programacion();
        $pedido = new Pedidos();
        
        $area = Yii::$app->session->get('area');
        $data = $_REQUEST;
        $CantidadPT = 0;
        foreach($data as $dat){
            $pedidoDat = $pedido->findOne($dat);
            $producto = Productos::findOne($pedidoDat->IdProducto);

            if ($producto['Ensamble'] == 1) {

                $pedidosSaldos = Pedidos::find()->where('IdProducto = '.$pedidoDat->IdProducto.' AND SaldoExistenciaPT > 0 ')->limit('1')->orderBy('Fecha desc')->asArray()->all();
                //print_r($pedidosSaldos);

                if (isset($pedidosSaldos[0]['SaldoExistenciaPT']) > 0) {
                    $CantidadPT = $pedidosSaldos[0]['SaldoExistenciaProceso']; // 0
                }else{
                    $almacen = AlmacenesProducto::find()->where('IdProducto = '.$pedidoDat->IdProducto.' AND IdAlmacen = 61 ')->asArray()->all();
                    $CantidadPT = $almacen[0]['Existencia'];
                }

                $SaldoPT = $CantidadPT - $pedidoDat['Cantidad'] < 0 ? $pedidoDat['Cantidad'] - $CantidadPT : 0 ; 
                           
                //exit();
                if ($pedidoDat['Cantidad'] < $CantidadPT AND isset( $pedidosSaldos[0]['SaldoExistenciaPT']) == '') {
                    $saldo = Pedidos::findOne($pedidoDat->IdPedido);
                    $saldo->SaldoExistenciaPT =  $CantidadPT; //- $pedidoDat['Cantidad'];
                    $saldo->SaldoExistenciaProceso =  $CantidadPT - $pedidoDat['Cantidad'];
                    $saldo->EstatusEnsamble = 1;
                    $saldo->update();
                }else{

                    if($pedidoDat['Cantidad'] < $CantidadPT) {
                        $saldo = Pedidos::findOne($pedidoDat->IdPedido);
                        $saldo->SaldoExistenciaPT =  $CantidadPT; //- $pedidoDat['Cantidad'];
                        $saldo->SaldoExistenciaProceso =  $CantidadPT - $pedidoDat['Cantidad'];
                        $saldo->EstatusEnsamble = 1;
                        $saldo->update();
                    }else{
                        $saldo = Pedidos::findOne($pedidoDat->IdPedido);
                        $saldo->SaldoExistenciaPT =  $CantidadPT;//$pedidoDat['Cantidad'] -  $CantidadPT;
                        $saldo->SaldoExistenciaProceso = $CantidadPT -  $pedidoDat['Cantidad'] < 0 ? 0 : $CantidadPT -  $pedidoDat['Cantidad'];
                        $saldo->EstatusEnsamble = 2;
                        $saldo->update();
                        echo $pedidoDat['Cantidad']. " - ". $CantidadPT;
                        //exit();

                        $this->ExplosionValvulas($pedidoDat,$producto,$area['IdArea'],$SaldoPT);
                    }

                }
            }
           // exit();
            $this->SetPedProgramacion($pedidoDat,$producto,$area['IdArea']);
        }
        return true;
    }



    public function ExplosionValvulas($pedidoDat,$producto,$area,$cant){
        
        $explosion = ProductosEnsamble::find()->where('IdProducto = '.$producto['IdProducto'].'')->asArray()->all();

            
        foreach ($explosion as $key ) {  

            $model = new HistoriaExplosion();
            $model->IdProductosEnsamble = $key['IdProducto'];
            $model->IdProducto = $key['IdProducto'];
            $model->Componente = $key['IdProducto'];
            $model->Cantidad = $key['IdProducto'];
            //$model->save();

            $prod = Productos::findOne($key['IdComponente']);
            $prod->Ensamble = 2;
            $prod->update();

            $pedidoDat->IdProducto = $key['IdComponente'];
            $pedidoDat->Cantidad = $key['Cantidad'] * $cant; 
            $pedidoDat->SaldoCantidad = $cant * $key['Cantidad'];

            //exit();
            $this->SetPedProgramacion($pedidoDat,$producto,$area);
           
        }
    }


    public function actionUpdatePedidos(){
      
        $model = new Programaciones();
        $data = $_GET;

        foreach ($data as $datos) {

            $programaciones = $model->findOne($datos);
            $programaciones->IdProgramacionEstatus = 2003;
            $programaciones->FechaCerrado = date('Y-m-d');
            $programaciones->HoraCerrado = date('H:i:s');
            $programaciones->CerradoPor = Yii::$app->user->identity->username;
            $programaciones->CerradoPC = gethostname(); ;
            $programaciones->update();
        }
    }

    
    public function SetPedProgramacion($pedidoDat,$producto, $Area){
        $command = \Yii::$app->db;
        $Acumulado = Programaciones::find()->where("IdProgramacionEstatus = 1 AND IdProducto = $pedidoDat->IdProducto")->asArray()->all();
        $area = Areas::findOne("$Area");

        //print_r($pedidoDat);
        //exit();
        if($area['AgruparPedidos'] == 1){
            //var_dump($Acumulado);
            if(isset($Acumulado[0]['IdProgramacion'])){

                $programacion = Programaciones::findOne($Acumulado[0]['IdProgramacion']);
                $programacion->Cantidad = $Acumulado[0]['Cantidad'] + $pedidoDat->Cantidad;
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
                    $model->Cantidad = intval(strval($pedidoDat->Cantidad*1));
                    $model->save();

                    $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                    $almas = Almas::find()->where("IdProducto = $casting")->asArray()->one();

                    if(count($almas)>0){
                        $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                        $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);
                        foreach($almas as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $programacion['IdProgramacion'],
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
            //$ped = Pedidos::find($pedidoDat->IdPedido);
            $ped = Pedidos::find()->where('IdProducto = '.$pedidoDat->IdProducto.'AND IdPedido = '.$pedidoDat->IdPedido.'')->asArray()->all();

            //exit();
            if(isset($ped[0]['EstatusEnsamble']) == null){
                $model = new Programaciones();
                $model->IdPedido= $pedidoDat->IdPedido;
                $model->IdArea = $area['IdArea'];
                $model->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                $model->IdProgramacionEstatus = 1;
                $model->IdProducto = $pedidoDat->IdProducto;
                $model->Programadas = 0;
                $model->Hechas = 0;
                $model->Cantidad = intval(strval($pedidoDat->Cantidad*1)); 
                $model->save();
       
                $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                $almas = Almas::find()->where("IdProducto = $casting")->asArray()->all();

            
                if(count($almas)>0){
                    $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                    $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);
                    //print_r($programacion);
                    //exit();
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

                $lastId_La = Programaciones::find()->where('IdProducto = '.$pedidoDat->IdProducto.'AND IdPedido = '.$pedidoDat->IdPedido.'')->one();
                
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