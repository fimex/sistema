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
use frontend\models\programacion\VResumenDiario;
use frontend\models\programacion\VResumenAcero;
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
class ProgramacionController extends Controller
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

    /*
     *  URL Y ENVIO DE DATOS
     */
    
    public function actionSemanalMoldeoAceros(){
        return $this->Semanal(1,2);
    }
    
    public function actionSemanalLimpiezaAceros(){
        return $this->Semanal(2,2);
    }
    
    public function actionSemanalMoldeoBronces(){
        return $this->Semanal(1,3);
    }
    
    public function actionSemanalLimpiezaBronces(){
        return $this->Semanal(1,3);
    }
    
    public function actionDiariaMoldeoAceros(){
        return $this->Diaria(1,2);
    }
    
    public function actionDiariaLimpiezaAceros(){
        return $this->Diaria(2,2);
    }
    
    public function actionDiariaMoldeoBronces(){
        return $this->Diaria(1,3);
    }
    
    public function actionDiariaLimpiezaBronces(){
        return $this->Diaria(2,3);
    }
    
    /*
     *  INICIA PROGRAMACION SEMANAL
     */
    
    public function Semanal($IdProceso,$IdArea){
        $this->layout = 'programacion';

        switch ($IdArea) {
            case 2:
                $title = $IdProceso == 1 ? 'Reporte de programación semanal ( Acero ) ' : ($IdProceso == 2 ? 'Reporte de programación semanal ( Limpieza Acero) ' : '');
                break;
            
            case 3:
                $title = $IdProceso == 1 ? 'Reporte de programación semanal ( Bronce )  F-PC-7.0-48/1' : ($IdProceso == 2 ? 'Reporte de programación semanal ( Limpieza Bronce) ' : '');
                break;
        }
        
        return $this->render('programacion',[
            'title'=>$title,
            'IdProceso' => $IdProceso,
            'IdArea' => $IdArea,
            'TipoUsuario' => Yii::$app->user->identity->role
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
        
        $totSemana = $IdArea == 3 ? 4 : 6;
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
    
    /*
     *  INICIA PROGRAMACION DIARIA
     */
    
    public function Diaria($IdProceso,$IdArea){
        $this->layout = 'programacion';

        switch ($IdArea) {
            case 2:
                $title = $IdProceso == 1 ? 'Reporte de programación diario ( Aceros )' : ($IdProceso == 2 ? 'Reporte de programación diario ( Limpieza Acero)' : '');
                break;
            
            case 3:
                $title = $IdProceso == 1 ? 'Reporte de programación diario ( Bronces ) F-PC-7.0-47' : ($IdProceso == 2 ? 'Reporte de programación diario ( Limpieza Bronce)' : '');
                break;
        }

        return $this->render('programacionDiaria',[
            'title'=>$title,
            'IdArea'=>$IdArea,
            'IdProceso'=>$IdProceso,
            'turno'=>1,
            'TipoUsuario' => Yii::$app->user->identity->role
        ]);
    }
    
    public function actionLoadDias($semana = ''){
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

    public function actionDataDiaria(){
        $IdProceso = $_REQUEST['IdProceso'];
        $turno = isset($_REQUEST['turno']) ? $_REQUEST['turno'] : 1;
        $area = $_REQUEST['IdArea'];

        $semana = !isset($_REQUEST['semana']) ? [date('Y'),date('W')] : [date('Y',strtotime($_REQUEST['semana'])),date('W',strtotime($_REQUEST['semana']))];
        
        $this->layout = 'JSON';

        $semana['semana1'] = ['year'=>$semana[0],'week'=>$semana[1],'value'=>"$semana[0]-W$semana[1]"];

        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionDiaria($semana,$area,$IdProceso,$turno);
        //var_dump($dataProvider->allModels);exit;
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
                'ResumenSem'=>[],
            ]);
        }
        
       // echo "-------------------------------------------------------------------" 1749;
       
            if(Yii::$app->user->identity->role == 1){
                foreach($dataProvider->allModels as &$dat){
                    $dat['Programadas']*=1;
                    $dat['Programadas1']*=1;
                    $dat['Programadas2']*=1;
                    $dat['Programadas3']*=1;
                    $dat['Programadas4']*=1;
                    $dat['Programadas5']*=1;
                    $dat['Programadas6']*=1;
                    $dat['MoldesHora']*=1;
                    $dat['TotalProgramado']*=1;
                    $dat['Hechas']*=1;
                    if($area == 3){
                        $dat['Maquina1'] = $dat['Maquina1'] == null ? 1700 : ($dat['Maquina1']*1);
                        $dat['Maquina2'] = $dat['Maquina2'] == null ? 1700 : ($dat['Maquina2']*1);
                        $dat['Maquina3'] = $dat['Maquina3'] == null ? 1700 : ($dat['Maquina3']*1);
                        $dat['Maquina4'] = $dat['Maquina4'] == null ? 1700 : ($dat['Maquina4']*1);
                        $dat['Maquina5'] = $dat['Maquina5'] == null ? 1700 : ($dat['Maquina5']*1);
                        $dat['Maquina6'] = $dat['Maquina6'] == null ? 1700 : ($dat['Maquina6']*1);
                        $dat['Maquina7'] = $dat['Maquina7'] == null ? 1700 : ($dat['Maquina7']*1);
                    }else{
                        $dat['Maquina1'] = $dat['Maquina1'] == null ? 1755 : ($dat['Maquina1']*1);
                        $dat['Maquina2'] = $dat['Maquina2'] == null ? 1755 : ($dat['Maquina2']*1);
                        $dat['Maquina3'] = $dat['Maquina3'] == null ? 1755 : ($dat['Maquina3']*1);
                        $dat['Maquina4'] = $dat['Maquina4'] == null ? 1755 : ($dat['Maquina4']*1);
                        $dat['Maquina5'] = $dat['Maquina5'] == null ? 1755 : ($dat['Maquina5']*1);
                        $dat['Maquina6'] = $dat['Maquina6'] == null ? 1755 : ($dat['Maquina6']*1);
                        $dat['Maquina7'] = $dat['Maquina7'] == null ? 1755 : ($dat['Maquina7']*1);
                    }
                }
            }
        
        //var_dump($dataProvider);
        //exit;
        //var_dump($dataProvider->allModels);exit;
        //$dataResumen = $this->DataResumen($dataProvider->allModels,2,$area);
        //$ResumenSem = $this->ResumenSem($dataProvider->allModels,2,$area); comandanteranchitodignidad@hotmail.com
        //print_r($dataResumen); exit();
        return json_encode([
            'total'=>count($dataProvider->allModels),
            'rows'=>$dataProvider->allModels,
            //'footer'=>$dataResumen[0],
            //'ResumenSem'=>$dataResumen[1],
        ]);
    }
    
    public function actionSaveDiario(){
        $model = new Programacion();
        $maquinas = new VMaquinas();
        $dat = $_REQUEST;
        $guardado = false;
        
        if(isset($dat['Programadas'])){
            $maquina = isset($dat['Maquina']) ? $dat['Maquina'] : 1;
            if(isset($dat['IdCentroTrabajo'])){
                $IdCentroTrabajo = $dat['IdCentroTrabajo'];
            }else{
                $maq = $maquinas->find()->where("IdMaquina = $maquina")->asArray()->all();
                $IdCentroTrabajo = $maq[0]['IdCentroTrabajo'];
            }
            $datosSemana = $dat['IdProgramacionSemana'].",'".$dat['Dia']."',".$dat['Prioridad'].",".$dat['Programadas'].",".$dat['IdTurno'].",$maquina,$IdCentroTrabajo";
            $model->setProgramacionDiaria($datosSemana);

            if(isset($dat['Tarimas'])){
                $where = [
                    'IdProgramacionSemana' => $dat['IdProgramacionSemana'],
                    'Dia' => $dat['Dia'],
                    'IdTurno' => $dat['IdTurno']
                ];
                $tarimas = json_decode($dat['Tarimas'],true);
                $ciclosMolde = !isset($dat['CiclosMolde']) || $dat['CiclosMolde'] == 0 ? 1 : $dat['CiclosMolde'];
                $programacionDia = ProgramacionesDia::find()->where($where)->one();
                
                foreach($tarimas as $tarima){
                    $datosTarima = "$datosSemana,".$tarima['Loop'].",".$tarima['Tarima'].",".(isset($dat['Delete'])?1:0);
                    $model->setProgramacionTarima($datosTarima);
                }
                
                $programadas = VTarimas::find()->select('count(IdProgramacionDia) AS Programadas')->where(['IdProgramacionDia' => $programacionDia->IdProgramacionDia])->one();
                $programacionDia->Programadas = $programadas->Programadas / $ciclosMolde;
                $programacionDia->update();
            }
            $guardado = true;
        }
        
        return $guardado;
    }
    
    public function actionResumenDiario(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $turno = isset($_REQUEST['turno']) ? $_REQUEST['turno'] : 1;
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        for($x=1;$x<7;$x++){
            $res = VResumenDiario::find()->where([
                'IdArea' => $area,
                'Anio' => $year,
                'Semana' => $week,
                'Dia' => $fecha,
                'IdTurno' => $turno,
                ])->asArray()->one();
            if($res == null){
                $res = [
                    'IdArea' => $area,
                    'Anio' => $year,
                    'Semana' => $week,
                    'Dia' => $fecha,
                    'IdTurno' => $turno,
                    'PrgMol' => 0,
                    'PrgPzas' => 0,
                    'PrgTonP' => 0,
                    'PrgTon' => 0,
                    'PrgHrs' => 0,
                    'HecMol' => 0,
                    'HecPzas' => 0,
                    'HecTonP' => 0,
                    'HecTon' => 0,
                    'HecHrs' => 0
                ];
            }
            $resumen[] = $res;
            $fecha = date('Y-m-d',strtotime('+1day',strtotime($fecha)));
        }
        return json_encode($resumen);
    }
    
    public function actionResumenDiarioAcero(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        for($x=1;$x<7;$x++){
            $res = VResumenDiario::find()->where([
                'IdArea' => $area,
                'Anio' => $year,
                'Semana' => $week,
                'Dia' => $fecha,
                ])->asArray()->one();
            if($res == null){
                $res = [
                    'IdArea' => $area,
                    'Anio' => $year,
                    'Semana' => $week,
                    'Dia' => $fecha,
                    'PrgMol' => 0,
                    'PrgPzas' => 0,
                    'PrgTonP' => 0,
                    'PrgTon' => 0,
                    'PrgHrs' => 0,
                    'HecMol' => 0,
                    'HecPzas' => 0,
                    'HecTonP' => 0,
                    'HecTon' => 0,
                    'HecHrs' => 0
                ];
            }
            $resumen[] = $res;
            $fecha = date('Y-m-d',strtotime('+1day',strtotime($fecha)));
        }
        
        return json_encode($resumen);
    }
    
    /*
     *  DATOS PARA LA PARTE DE PROGRAMACION
     */
    
    public function actionMarcas(){
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
    
    public function actionPedidos(){
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
    
    public function actionActualizacion(){
        $model = new Programacion();
        return date('d-m-Y h:i',strtotime($model->getActualizacion()[0]['FechaInicio']));
    }
    
    public function actionDataSemanal(){
        $IdArea = $_REQUEST['IdArea'];
        $IdProceso = $_REQUEST['IdProceso'];
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1'],$IdArea);

        $programacion = new Programacion();
        $dataProvider = $programacion->getProgramacionSemanal($IdArea,$IdProceso,$semanas);
     
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
    
    public function actionResumenSemanal(){
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana']) ? '' : $_REQUEST['semana']);
        $filtro =json_decode($_REQUEST['filtro'],true);
        $IdArea = $_REQUEST['IdArea'];
        
        $Orden = !isset($filtro['orden']) ? '' : "dbo.v_Programaciones.OrdenCompra LIKE '%".$filtro['orden']."%' AND";
        $Orden2 = !isset($filtro['orden2']) ? '' : "dbo.v_Programaciones.OrdenCompra NOT LIKE '%".$filtro['orden2']."%' AND";
        $Descripcion = !isset($filtro['descripcion']) ? '' : "dbo.v_Programaciones.Descripcion LIKE '%".$filtro['descripcion']."%' AND";
        $FechaCliente = !isset($filtro['embarque']) ? '' : "dbo.v_Programaciones.FechaEmbarque ='".$filtro['embarque']."' AND";
        $FechaEmbarque = !isset($filtro['envio']) ? '' : "dbo.v_Programaciones.FechaEnvio = '".$filtro['envio']."' AND";
        $Aleacion = !isset($filtro['aleacion']) ? '' : "dbo.v_Programaciones.Aleacion LIKE '%".$filtro['aleacion']."%' AND";
        $Cliente = !isset($filtro['cliente']) ? '' : "dbo.v_Programaciones.Marca LIKE '%".$filtro['cliente']."%' AND";
        $producto = !isset($filtro['producto']) ? '' : "dbo.v_Programaciones.Producto LIKE '%".$filtro['producto']."%' AND";
        $casting = !isset($filtro['casting']) ? '' : "dbo.v_Programaciones.ProductoCasting LIKE '%".$filtro['casting']."%' AND";

        foreach ($semanas as $semana){
            $sql = "
                SELECT
                    dbo.v_Programaciones.IdArea,
                    dbo.ProgramacionesSemana.Anio,
                    dbo.ProgramacionesSemana.Semana,
                    dbo.v_Programaciones.Aleacion,
                    sum(dbo.ProgramacionesSemana.Programadas) AS PrgMol,
                    ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesSemana.Programadas*  dbo.v_Programaciones.PesoCasting)/1000,2)  AS PrgTonP,
                    ROUND(sum(dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoArania)/1000,2)  AS PrgTon,
                    ROUND(sum(CAST(dbo.ProgramacionesSemana.Programadas AS FLOAT) / CAST(ISNULL(dbo.v_Programaciones.MoldesHora,65) as FLOAT)),1) AS PrgHrs,
                    sum(dbo.ProgramacionesSemana.Llenadas) AS HecMol,
                    ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesSemana.Llenadas * dbo.v_Programaciones.PesoCasting)/1000,2)  AS HecTonP,
                    ROUND(sum(dbo.ProgramacionesSemana.Llenadas * dbo.v_Programaciones.PesoArania)/1000,2)  AS HecTon,
                    ROUND(sum(
                            CASE WHEN dbo.ProgramacionesSemana.Llenadas = 0 THEN
                                    0
                            ELSE CAST(dbo.ProgramacionesSemana.Llenadas AS FLOAT) / CAST(dbo.v_Programaciones.MoldesHora AS FLOAT)
                            END
                    ),1) AS HecHrs

                FROM dbo.v_Programaciones
                INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
                WHERE
                    $Descripcion
                    $FechaCliente
                    $FechaEmbarque
                    $Aleacion
                    $Cliente
                    $producto
                    $casting
                    IdArea = $IdArea AND
                    Anio = ".$semana['year']." AND
                    Semana = ".$semana['week']." AND
                    dbo.ProgramacionesSemana.Programadas > 0 AND
                    dbo.v_Programaciones.Estatus <> 'Cerrado' AND
                    dbo.v_Programaciones.SaldoCantidad > 0 
                GROUP BY 
                    dbo.v_Programaciones.IdArea,
                    dbo.ProgramacionesSemana.Anio,
                    dbo.ProgramacionesSemana.Semana,
                    dbo.v_Programaciones.Aleacion
            ";
            //echo $sql;
            $command = \Yii::$app->db;
            $res = $command->createCommand($sql)->queryAll();

            $datos = [
                "IdArea" => $IdArea,
                "Anio" => $semana['year'],
                "Semana" => $semana['week'],
                "PrgMol" => 0,
                "PrgTonP" => 0,
                "PrgTon" => 0,
                "PrgHrs" => 0,
                "HecMol" => 0,
                "HecTonP" => 0,
                "HecTon" => 0,
                "HecHrs" => 0,
                "aleaciones" => ""
            ];
            
            if($res == null){
                $res[] = [
                    "IdArea" => $IdArea,
                    "Anio" => $semana['year'],
                    "Semana" => $semana['week'],
                    "PrgMol" => 0,
                    "PrgTonP" => 0,
                    "PrgTon" => 0,
                    "PrgHrs" => 0,
                    "HecMol" => 0,
                    "HecTonP" => 0,
                    "HecTon" => 0,
                    "HecHrs" => 0,
                    "aleaciones" => ""
                ];
            }
            
            foreach($res as $res2){
                $datos['PrgMol'] += $res2['PrgMol'];
                $datos['PrgTonP'] += $res2['PrgTonP'];
                $datos['PrgTon'] += $res2['PrgTon'];
                $datos['PrgHrs'] += $res2['PrgHrs'];
                $datos['HecMol'] += $res2['HecMol'];
                $datos['HecTonP'] += $res2['HecTonP'];
                $datos['HecTon'] += $res2['HecTon'];
                $datos['HecHrs'] += $res2['HecHrs'];
                if($IdArea == 2)$datos['aleaciones'][$res2['Aleacion']] = isset($datos['aleaciones'][$res2['Aleacion']]) ? $res2['PrgTon'] : $datos['aleaciones'][$res2['Aleacion']];
            }
            
            $resumen[] = $datos;
        }
        return json_encode($resumen);
    }
    
    public function actionResumenSemanalAcero(){
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana']) ? '' : $_REQUEST['semana']);
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        foreach ($semanas as $semana){
            
            $res = VResumenAcero::find()->where([
                'IdArea' => $area,
                'Anio' => $semana['year'],
                'Semana' => $semana['week'],
                ])->asArray()->all();
            
            $datos = [
                "IdArea" => $area,
                "Anio" => $semana['year'],
                "Semana" => $semana['week'],
                "TonPrgK" => 0,
                "TonPrgV" => 0,
                "TonPrgE" => 0,
                "TonVacK" => 0,
                "TonVacV" => 0,
                "TonVacE" => 0,
                "CiclosK" => 0,
                "CiclosV" => 0,
                "CiclosE" => 0,
                "MolPrgK" => 0,
                "MolPrgV" => 0,
                "MolPrgE" => 0,
                "aleaciones" => []
            ];

            if(count($res)>0){
                
                foreach($res as $res2){
                    $datos['TonPrgK'] += $res2['TonPrgK'];
                    $datos['TonPrgV'] += $res2['TonPrgV'];
                    $datos['TonPrgE'] += $res2['TonPrgE'];
                    $datos['TonVacK'] += $res2['TonVacK'];
                    $datos['TonVacV'] += $res2['TonVacV'];
                    $datos['TonVacE'] += $res2['TonVacE'];
                    $datos['CiclosK'] += $res2['CiclosK'];
                    $datos['CiclosV'] += $res2['CiclosV'];
                    $datos['CiclosE'] += $res2['CiclosE'];
                    $datos['MolPrgK'] += $res2['MolPrgK'];
                    $datos['MolPrgV'] += $res2['MolPrgV'];
                    $datos['MolPrgE'] += $res2['MolPrgE'];

                    $datos['aleaciones'][] = [
                        'Aleacion' => $res2['Aleacion'],
                        'Total' => ($res2['TonPrgK'] + $res2['TonPrgV'] + $res2['TonPrgE'])
                    ];
                }
            }
            
            $resumen[] = $datos;
        }
        
        return json_encode($resumen);
    }
    
    public function actionSaveSemanal()
    {
        $model = new Programacion();

        $dat = $_REQUEST;
        
        $dat['Prioridad'] = $dat['Prioridad'] != '' ? $dat['Prioridad'] : 'NULL';
        $dat['Programadas'] = $dat['Programadas'] != '' ? $dat['Programadas'] : 'NULL';
        //var_dump($dat);exit;
        $datosSemana1 = $dat['IdProceso'].",".$dat['IdProgramacion'].",".$dat['Anio'].",".$dat['Semana'].",".$dat['Prioridad'].",".$dat['Programadas'];
        return $model->setProgramacionSemanal($datosSemana1);
    }
}