<?php

namespace frontend\controllers;

use yii;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\vistas\VCamisasAcero;
use common\models\vistas\VTiemposMuertos;
use common\models\catalogos\Materiales;
use common\models\catalogos\Maquinas;
use common\models\vistas\VMaterialArania;
use common\models\datos\Cajas;
use common\models\catalogos\Areas;
use frontend\models\programacion\VProgramaciones;
use frontend\models\vistas\VCamisasDia;
use frontend\models\vistas\VFiltrosDia;
use frontend\models\vistas\VMetalDia;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReportesController extends Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
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

    
    public function LoadDias($semana = '')
    {
        $year = $semana == '' ? date('Y') : date('Y',strtotime($semana));
        $week = $semana == '' ? date('W') : date('W',strtotime($semana));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        
        for($x=1;$x<7;$x++){

            $dias['dia'.$x] = date('Y-m-d',strtotime($fecha));
            $fecha = date('Y-m-d',strtotime("+1 Day",strtotime($fecha)));
        }

        return $dias;
    }

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

    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMoldeo()
    {
        return $this->render('index',[
            'vista' => 'moldeo',
            'IdSubProceso' => 6
        ]);
    }
    
    public function actionCamisas(){
        return $this->render('index',[
            'vista' => 'Camisas',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionCamisasDia(){
        return $this->render('index',[
            'vista' => 'CamisasDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionFiltrosAcerosDia(){
        return $this->render('index',[
            'vista' => 'FiltrosDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionFiltrosBronces(){
        return $this->render('index',[
            'vista' => 'Filtros',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    
    public function actionFiltrosAceros(){
        return $this->render('index',[
            'vista' => 'Filtros',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionMetalDia(){
        return $this->render('index',[
            'vista' => 'MetalDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionMetalSemana(){
        return $this->render('index',[
            'vista' => 'MetalSemana',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionTiemposMuertos(){
        return $this->render('index',[
            'vista' => 'TiemposMuertos',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    public function actionSeriesAceros(){
        if (isset($_GET['serie'])) {
            $serie = $_GET['serie'];
        }else{
            $serie = false;
        }
        return $this->render('index',[
            'vista' => 'seriesAceros',
            'IdSubProceso' => 6,
            'IdArea' => 2,
            'serie' => $serie
            ]);
    }
    public function actionAlmas()
    {
        return $this->render('index',[
            'vista' => 'moldeo',
            'IdSubProceso' => 2
        ]);
    }
    
    public function actionAlmasCatalogo()
    {
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 3
        ]);
    }

	 public function actionAlmasCatalogoac()
    {
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 2
        ]);
    }
    
    public function actionAlmasCatalogoAcero()
    {
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 2
        ]);
    }
    
    public function actionVaciado()
    {
        return $this->render('index',[
            'vista' => 'vaciado',
            'IdSubProceso' => 10
        ]);
    }
    
    public function actionPedidosBronces()
    {
        return $this->render('pedidos',[
            'IdArea' => 3
        ]);
    }

    public function actionPromolDia()
    {
         return $this->render('index',[
            'vista' => 'PromolDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    
    public function actionMaterial(){
        
        $semanas = '';
        if(isset($_GET['semana'])){
           $semana = explode('-W',$_GET['semana']);
           $cantidad = $_GET['cantidad'];
           $anio = $semana[0];
           $semana = $semana[1];
        }  else { 
            $cantidad = 4;
            $semana = date("W");
            $anio = date("Y");
        }
        
        for ($i = 0; $i < $cantidad; $i++){
            $sem = $semana + $i;
            $semanas .= "[".$sem."],";
        } 
        
        $model = VMaterialArania::find()->asArray()->all();
        $commad = new VMaterialArania();
        $Material = $commad->getMaterial(substr($semanas,0,-1),$anio,$cantidad,$semana,$this->areas->getCurrent());
        $MaterialCasting = $commad->getMaterialCasting(substr($semanas,0,-1),$anio,$cantidad,$semana,$this->areas->getCurrent());
       
        //var_dump($Material);
        return $this->render('Material',[
            'model'=>$Material,
            'model2'=>$MaterialCasting,
        ]);
    }



    public function actionDataPromolDia(){
       $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMetalDia::find()->distinct()->select("Aleacion,Anio")->where([
            'IdArea' => $this->areas->getCurrent()
        ])->asArray()->all();
       
        foreach ($metales as &$metal) {
            $semanas = '';
            $x = 1;
            $metal['Totales'] = 0;
            foreach ($dias as $dia) {
               // $semanas .= "[".$dia."],";
                $metalTot = VMetalDia::find()->select("SUM(TonTotales) AS TonTotales")->where(
                    "IdArea = ".$_GET['IdArea']." AND 
                    Anio = ".date('Y',strtotime($_GET['semana']))." AND 
                    Dia = '".$dia."' AND 
                    Aleacion = '".$metal['Aleacion']."'
                    ")->asArray()->all();

                $metal['dias']["dia$x"]['dia'] = $dia;
                $metal['dias']["dia$x"]['TonTotales'] = $metalTot[0]['TonTotales'];
                $metal['Totales'] += $metalTot[0]['TonTotales'];
                $x++;
            }

        }
       
        return json_encode($metales);
    }

    public function actionDataMetal(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMaterialArania::find()->distinct()->select("Aleacion,Anio")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        
        foreach ($metales as &$metal) {
            $x=1;
            $metal['total'] = 0;
            foreach ($semanas as $semana){
                $metal['semanas']["semana$x"] = VMaterialArania::find()->select("SUM(TonTotales) AS TonTotales")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'Aleacion' => $metal['Aleacion']
                ])->asArray()->one();
                $metal['semanas']["semana$x"]['semana'] = $semana['week'];
                $metal['total'] += $metal['semanas']["semana$x"]['TonTotales'];
                $x++;
            }
        }
        //print_r($metales);
        return json_encode($metales);
    }

    public function actionDataMetalDia(){

        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMetalDia::find()->distinct()->select("Aleacion,Anio")->where([
            'IdArea' => $this->areas->getCurrent()
        ])->asArray()->all();
       
        foreach ($metales as &$metal) {
            $semanas = '';
            $x = 1;
            $metal['Totales'] = 0;
            foreach ($dias as $dia) {
               // $semanas .= "[".$dia."],";
                $metalTot = VMetalDia::find()->select("SUM(TonTotales) AS TonTotales")->where(
                    "IdArea = ".$_GET['IdArea']." AND 
                    Anio = ".date('Y',strtotime($_GET['semana']))." AND 
                    Dia = '".$dia."' AND 
                    Aleacion = '".$metal['Aleacion']."'
                    ")->asArray()->all();

                $metal['dias']["dia$x"]['dia'] = $dia;
                $metal['dias']["dia$x"]['TonTotales'] = $metalTot[0]['TonTotales'];
                $metal['Totales'] += $metalTot[0]['TonTotales'];
                $x++;
            }

        }
       
        return json_encode($metales);
    }
    
    public function actionDataProduccion()
    {
        $where = '';
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $IdSubProceso = $_REQUEST['IdSubProceso'];
            $where = " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        if($IdSubProceso != 10){
            $model = Producciones::find()
                ->where("IdSubProceso = $IdSubProceso".$where)
                ->joinWith('lances')
                ->joinWith('produccionesDetalles')
                ->joinWith('almasProduccionDetalles')
                ->joinWith('idEmpleado')
                ->joinWith('idMaquina')
                ->asArray()->all();
        }else{
            $model = Producciones::find()
                ->where("IdSubProceso = $IdSubProceso".$where)
                ->with('materialesVaciados')
                ->asArray()->all();
            $fechas = '';

            foreach ($model as &$mod){
                $fecha = date('Y-m-d',strtotime($mod['Fecha']));
                $fechas[$fecha]['Fecha'] = $fecha;
                foreach ($mod['materialesVaciados'] as &$material){
                    //var_dump($material);
                    $IdMaterial = $material['IdMaterial'];
                    
                    if(!isset($fechas[$fecha]['Material'][$IdMaterial])){
                        $fechas[$fecha]['Material'][$IdMaterial]['Cantidad'] = 0;
                    }
                    $fechas[$fecha]['Material'][$IdMaterial]['Identificador'] = $material['idMaterial']['Identificador'];
                    $fechas[$fecha]['Material'][$IdMaterial]['Material'] = $material['idMaterial']['Descripcion'];
                    $fechas[$fecha]['Material'][$IdMaterial]['Cantidad'] += $material['Cantidad'];
                }
            }
            return json_encode($fechas);
        }
        return json_encode($model);
    }
    
    public function actionDataPedidos()
    {
        $model = VProgramaciones::find()
                ->where($_GET)
                ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCatalogoAlmas()
    {
        $model = \common\models\datos\VAlmas::find()
                ->where($_GET)
                ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDataTiemposMuertos(){
        $whereFecha = '';
        $filtro = isset($_REQUEST['Filtro']) ? $_REQUEST['Filtro'] : 'false';
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $IdArea = $_REQUEST['IdArea'];
            $IdTurno = isset($_REQUEST['IdTurno']) ? $_REQUEST['IdTurno'] : 1;
            $whereFecha = " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        
        $dataProvider = VTiemposMuertos::find()->where("IdTurno = $IdTurno AND IdArea = $IdArea $whereFecha")->orderBy('Inicio ASC')->asArray()->all();
       
        $HIni = $IdTurno == 1 ? '07:00' : '22:00';
        $HFin = $IdTurno == 1 ? '17:00' : '07:00';
        $producciones = new ProduccionesDetalle();

        foreach ($dataProvider as &$value) {
            $value['Inicio'] = date('H:i',strtotime($value['Inicio']));
            $value['Fin'] = date('H:i',strtotime($value['Fin']));
            
            $Fecha = $value['Fecha'];
            $Fecha2 = strtotime($value['Inicio']) > strtotime($value['Fin']) ? date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) : $Fecha;
            
            $value['Inicio'] = "$Fecha ".date('H:i',strtotime($value['Inicio']));
            $value['Fin'] = "$Fecha2 ".date('H:i',strtotime($value['Fin']));
            
            if($filtro == 'true'){
                $res = $producciones->limiteHoras($value['Inicio'], $value['Fin'], "$Fecha $HIni",($HIni <= $HFin ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))))." $HFin");

                $value['Inicio'] = $res[0];
                $value['Fin'] = $res[1];
            }
            
            $value['Minutos'] = (strtotime($value['Fin']) - strtotime($value['Inicio']))/60;

            /*$a = date("d",strtotime($value['Fin']));
            $b = date("d",strtotime($value['Inicio']));
            $c = date("H",strtotime($value['Fin']));
            $d = date("H",strtotime($value['Inicio']));

            if(($a > $b))
                $value['Minutos'] = (strtotime(date('H:i', strtotime($value['Fin']))) - strtotime(date('H:i', strtotime($value['Inicio']))))/60;
            elseif(($a == $b) && ($c < $d))
                $value['Minutos'] = (strtotime(date('Y-m-d H:i',strtotime('+1 day',strtotime($value['Fin'])))) - strtotime(date('Y-m-d H:i',strtotime($value['Inicio']))))/60;
            else
                $value['Minutos'] = (strtotime($value['Fin']) - strtotime($value['Inicio']))/60;*/
            
            $value['Inicio'] = date('H:i',strtotime($value['Inicio']));
            $value['Fin'] = date('H:i',strtotime($value['Fin']));
        }
        
        return json_encode($dataProvider);
    }
    
    public function actionPiezascajas(){
       
        $command = \Yii::$app->db;
        
        if(isset($_GET['semana_ini'])){
            $semana1 = explode('-W',$_GET['semana_ini']);
            $semana2 = explode('-W',$_GET['semana_fin']);
            
            $anio1 = $semana1[0];
            $semana_ini = $semana1[1];
            
            $anio2 = $semana2[0];
            $semana_fin = $semana2[1];
        }else{
            $semana_ini = date("W");
            $anio1 = date("Y");
            
            $semana_fin = date("W");
            $anio2 = date("Y");
        }
        
        $model = new Cajas();
        $datos_cajas = $model->getDetalleCajas($semana_ini,$anio1,$semana_fin,$anio2);      
        $datos_pcajas = array();
    
        foreach ($datos_cajas as $key => $value) {
            if(!isset($datos_pcajas[$value['Tamano']]['Requerido'])){
                $datos_pcajas[$value['Tamano']]['Requerido'] = 0;
            }

            $datos_pcajas[$value['Tamano']]['Tamano'] = $value['Tamano'];
            $datos_pcajas[$value['Tamano']]['Requerido'] += $value['Requiere'];
            $datos_pcajas[$value['Tamano']]['CodigoDll'] = $value['CodDlls'];
            $datos_pcajas[$value['Tamano']]['CodigoPesos'] = $value['CodPesos'];
            $datos_pcajas[$value['Tamano']]['ExitTot'] = $value['CodPesos']+$value['CodDlls'];
        }
        
       // var_dump($datos_cajas);
        
        return $this->render('piezascajas', [
           'model' => $datos_pcajas,
           'detalle' => $datos_cajas,
        ]);
    }
    
    public function actionDataFiltros(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $filtros = \common\models\vistas\VFiltros::find()->distinct()->select("Descripcion,IdFiltroTipo")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        //$filtros = \common\models\catalogos\FiltrosTipo::find()->where("IdFiltroTipo <> 1")->with('filtros')->asArray()->all();
        
        foreach ($filtros as &$filtro) {
            $x=1;
            $filtro['total'] = 0;
            foreach ($semanas as $semana){
                $filtro['semanas']["semana$x"] = \common\models\vistas\VFiltros::find()->select("sum(Requeridas) AS Requeridas, avg(ExistenciaDolares) AS ExistenciaDolares, avg(ExistenciaPesos) AS ExistenciaPesos")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'IdFiltroTipo' => $filtro['IdFiltroTipo']
                ])->asArray()->one();
                $filtro['semanas']["semana$x"]['semana'] = $semana['week'];
                $filtro['total'] += $filtro['semanas']["semana$x"]['Requeridas'];
                $filtro['ExistenciaDolares'] = $filtro['semanas']["semana$x"]['ExistenciaDolares']*1;
                $filtro['ExistenciaPesos'] = $filtro['semanas']["semana$x"]['ExistenciaPesos']*1;
                $x++;
            }
        }
        
        return json_encode($filtros);
    }


    public function actionDataFiltrosDia(){
        
        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $filtros = VFiltrosDia::find()->distinct()->select("Descripcion,IdFiltroTipo")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        //$filtros = \common\models\catalogos\FiltrosTipo::find()->where("IdFiltroTipo <> 1")->with('filtros')->asArray()->all();
        
        foreach ($filtros as &$filtro) {
            $x=1;
            $filtro['total'] = 0;
            foreach ($dias as $dia){
                $filtro['dias']["dia$x"] = VFiltrosDia::find()->select("sum(Requeridas) AS Requeridas, avg(ExistenciaDolares) AS ExistenciaDolares, avg(ExistenciaPesos) AS ExistenciaPesos")->where([
                    'Anio' => date('Y',strtotime($dia)),
                    'Dia' => $dia,
                    'IdFiltroTipo' => $filtro['IdFiltroTipo']
                ])->asArray()->one();
                //$filtro['dias']["dias$x"]['dia'] = $semana['week'];
                $filtro['dias']["dia$x"]['dia'] = $dia;
                $filtro['total'] += $filtro['dias']["dia$x"]['Requeridas'];
                $filtro['ExistenciaDolares'] = $filtro['dias']["dia$x"]['ExistenciaDolares']*1;
                $filtro['ExistenciaPesos'] = $filtro['dias']["dia$x"]['ExistenciaPesos']*1;
                $x++;
            }
        }
        
        return json_encode($filtros);
    }
    
    public function actionDataCamisas(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $camisas = \common\models\catalogos\CamisasTipo::find()->where("IdCamisaTipo <> 1")->with('camisas')->asArray()->all();
        
        foreach ($camisas as &$camisa) {
            $x=1;
            $camisa['total'] = 0;
            foreach ($semanas as $semana){
                $camisa['semanas']["semana$x"] = \common\models\vistas\VCamisas::find()->select("sum(Requeridas) AS Requeridas, avg(ExistenciaDolares) AS ExistenciaDolares, avg(ExistenciaPesos) AS ExistenciaPesos")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'IdCamisaTipo' => $camisa['IdCamisaTipo']
                ])->asArray()->one();
                $camisa['semanas']["semana$x"]['semana'] = $semana['week'];
                $camisa['total'] += $camisa['semanas']["semana$x"]['Requeridas'];
                $camisa['ExistenciaDolares'] = $camisa['semanas']["semana$x"]['ExistenciaDolares']*1;
                $camisa['ExistenciaPesos'] = $camisa['semanas']["semana$x"]['ExistenciaPesos']*1;
                $x++;
            }
        }

        return json_encode($camisas);
    }

    public function actionDataCamisasDia(){
        
        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $camisas = \common\models\catalogos\CamisasTipo::find()->where("IdCamisaTipo <> 1")->with('camisas')->asArray()->all();
       
        foreach ($camisas as &$camisa) {
            $x=1;
            $camisa['total'] = 0;
            foreach ($dias as $dia){
               //echo date('Y',strtotime($dia));
                $camisa['dias']["dia$x"] = VCamisasDia::find()->select("sum(Requeridas) AS Requeridas, avg(ExistenciaDolares) AS ExistenciaDolares, avg(ExistenciaPesos) AS ExistenciaPesos")->where([
                    'Anio' => date('Y',strtotime($dia)),
                    'Dia' => $dia,
                    'IdCamisaTipo' => $camisa['IdCamisaTipo']
                ])->asArray()->one(); 
                $camisa['dias']["dia$x"]['dia'] = $dia;
                $camisa['total'] += $camisa['dias']["dia$x"]['Requeridas'];
                $camisa['ExistenciaDolares'] = $camisa['dias']["dia$x"]['ExistenciaDolares']*1;
                $camisa['ExistenciaPesos'] = $camisa['dias']["dia$x"]['ExistenciaPesos']*1;
                $x++;
            }
        }
        //print_r($camisas); exit();
        return json_encode($camisas);
    }
    
    /*public function actionVaciado(){
        
        $model = MaterialesVaciado::find()
                ->joinWith('idMaterial')
                ->joinWith('idProduccion')
                ->asArray()->all();
        //var_dump($model);exit;
        
        return $this->render('MaterialVaciado', [
            'model' => $model,
        ]);
    }*/

    

    public function Data_tiemposmuertos($ini, $fin){

        if($ini == 0){
            $where  = "";
        }else{
            $where = "WHERE tm.Fecha BETWEEN '$ini' AND '$fin' ";
        }
        //echo $where;
        
        //Pasar al modelo
        $command = \Yii::$app->db;
        $model =$command->createCommand("
            SELECT
            tm.IdTiempoMuerto,
            tm.IdCausa,
            tm.Inicio,
            tm.Fin,
            tm.Descripcion,
            m.Identificador AS Maquina,
            ct.Identificador AS TipoCausa,
            ct.Descripcion AS Tipo,
            c.Descripcion AS Causa

            FROM TiemposMuerto AS tm                 
            LEFT JOIN Maquinas AS m ON tm.IdMaquina = m.IdMaquina
            LEFT JOIN Causas AS c ON tm.IdCausa = c.IdCausa
            LEFT JOIN CausasTipo AS ct ON c.IdCausaTipo=ct.IdCausaTipo $where ")->queryAll();
        return $model;
    }
    
    public function actionDataEte(){
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = $_REQUEST['IdArea'];
        $turno = isset($_REQUEST['IdTurno']) ? $_REQUEST['IdTurno'] : 1;
        
        $where = "Producciones.IdTurno = $turno AND IdSubProceso = $IdSubProceso AND IdArea = $IdArea";
        
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $where .= " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        
        $model = Producciones::find()
            ->where($where)
            ->joinWith('produccionesDetalles')
            ->joinWith('almasProduccionDetalles')
            ->joinWith('idEmpleado')
            ->joinWith('idMaquina')
            ->asArray()
            ->all();
        
        foreach ($model as &$mod){
            $mod['Fecha'] = date('Y-m-d',strtotime($mod['Fecha']));
            $mod['Semana'] = date('W',strtotime($mod['Fecha']));
            $IdMaquina = $mod['IdMaquina'];
            $IdEmpleado = $mod['IdEmpleado'];

            foreach ($mod['almasProduccionDetalles'] as &$almas){
                $Fecha = $mod['Fecha'];
                $tIni = date('G:i:s',  strtotime($almas['Inicio']));
                $tFin = date('G:i:s',  strtotime($almas['Fin']));

                $almas['Inicio'] = "$Fecha ".date('G:i:s',  strtotime($tIni));
                $almas['Fin'] = (strtotime($tIni) <= strtotime($tFin) ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) )." ".date('G:i:s',  strtotime($tFin));
                
                $almas['Minutos'] = (strtotime($almas['Fin']) - strtotime($almas['Inicio']))/60;
                $almas['Hechas'] *= 1;
                $almas['Rechazadas'] *= 1;
                $almas['PiezasHora'] *= 1;
                
                $almas['SU'] = 0;
                $almas['MC'] = 0;
                $almas['MP'] = 0;
                $almas['TT'] = 0;
                $almas['MI'] = 0;
                $almas['MPRO'] = 0;
                
                $tiempos = VTiemposMuertos::find()->where(
                    "IdEmpleado = $IdEmpleado AND IdMaquina = $IdMaquina AND Fecha = '$Fecha'"
                )->asArray()->all();
                
                foreach ($tiempos as $time){
                    $tIni = date('G:i:s',  strtotime($time['Inicio']));
                    $tFin = date('G:i:s',  strtotime($time['Fin']));
                    
                    $time['Inicio'] = "$Fecha ".date('G:i:s',  strtotime($tIni));
                    $time['Fin'] = (strtotime($tIni) <= strtotime($tFin) ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) )." ".date('G:i:s',  strtotime($tFin));
                    
                    $tIni = strtotime($time['Inicio']) > strtotime($almas['Inicio']) ? $time['Inicio'] : $almas['Inicio'];
                    $tIni = strtotime($almas['Fin']) > strtotime($tIni) ? $tIni : $almas['Fin'];
                    
                    $tFin = strtotime($time['Fin']) > strtotime($almas['Fin']) ? $almas['Fin'] : $time['Fin'];
                    $tFin = strtotime($almas['Inicio']) > strtotime($tFin) ? $almas['Inicio'] : $tFin;
                    
                    $tIni = strtotime($tIni);
                    $tFin = strtotime($tFin);
                    
                    $min = ($tFin - $tIni)/60;

                    $almas[$time['ClaveTipo']] +=$min;
                    
                    /*echo "Nomina: ".$mod['idEmpleado']['Nomina'] ." Nombre: ".$mod['idEmpleado']['Nombre'] ." :::: Tiempo: ". $almas['Inicio']." - " . $almas['Fin'];
                    echo "Tiempo calculado: ".date('Y-m-d H:i',$tIni)." - ".date('Y-m-d H:i',$tFin)." ";
                    echo " :::::: ". $time['Inicio']." - ".$time['Fin']." -". $time['ClaveTipo']." = ".$min."<br />";*/
                }
                
                $almas['Inicio'] = date('H:i',strtotime($almas['Inicio']));
                $almas['Fin'] = date('H:i',strtotime($almas['Fin']));
            }
        }
        return json_encode($model);
    }
    
    public function actionEteAlmas(){
         return $this->render('EteAlmas');
    }
    
    public function actionEte(){
        $maquina = 0;
        $IdArea = 3;
        $ini = 0;
        $fin = 0;
        $turno = 1;
        
        if(isset($_GET['maquina'])){ 
            $maquina = $_GET['maquina'];
            $ini = $_GET['ini'];
            $fin = $_GET['fin'];
            $turno = $_GET['IdTurno'];
        }

        $model = new ProduccionesDetalle();
        $datos_ete = $model->getDatos($maquina,$ini,$fin, $this->areas->getCurrent(),$_GET['subProceso'],$turno);
        $ResumenSem = array();
        $Totales = array();
        foreach ($datos_ete as &$key) {
            
            if(!isset( $ResumenSem[$key['Semana']]['TTOT'])){
                $ResumenSem[$key['Semana']]['TTOT'] = 0;
                $ResumenSem[$key['Semana']]['TDISPO'] = 0;
                $ResumenSem[$key['Semana']]['SU'] = 0;
                $ResumenSem[$key['Semana']]['MC'] = 0;
                $ResumenSem[$key['Semana']]['MP'] = 0;
                $ResumenSem[$key['Semana']]['TT'] = 0;
                $ResumenSem[$key['Semana']]['MI'] = 0;
                $ResumenSem[$key['Semana']]['MPRO'] = 0;
                $ResumenSem[$key['Semana']]['DISPO'] = 0;
                $ResumenSem[$key['Semana']]['PESPERADO'] = 0;
                $ResumenSem[$key['Semana']]['PREAL'] = 0;
                $ResumenSem[$key['Semana']]['EFICIENCIA'] = 0;
                $ResumenSem[$key['Semana']]['Rechazadas'] = 0;
                $ResumenSem[$key['Semana']]['OK'] = 0;
                $ResumenSem[$key['Semana']]['CALIDAD'] = 0;
                $ResumenSem[$key['Semana']]['ETE'] = 0;
                $ResumenSem[$key['Semana']]['TotalDA'] = 0;
            }
            
            $Ti = strtotime($key['Inicio'])/ 60 ;
            $Tf = strtotime($key['Fin']) / 60 ;
            
            $Producesperada = (($key['MoldesHora']*0.86)/60);
            
            $ttot = $Tf - $Ti - ($key['TT'] + $key['MP']);
            $tdispo = $ttot - ($key['SU'] + $key['MC']);
            $dispo = $ttot <= 0 ? 0 : ($tdispo / $ttot)*100;
            $pesperado = round($Producesperada*$tdispo);
            $preal = $pesperado == 0 ? 0 : ($key['Hechas']/$pesperado)*100;
            $key['OK'] = abs($key['OK']);
            $key['Rec'] =abs($key['Rec']);
            $key['PRODUCESPERADO'] = $Producesperada; 
            $key['TTOT'] = $ttot;
            $key['TDISPO'] = $tdispo;
            $key['DISPO'] = $dispo;
            $key['PESPERADO'] =  $pesperado;
            $key['PREAL'] = $key['Hechas'];
            $key['EFICIENCIA'] = $preal;
            $key['CALIDAD'] = $key['OK'] == 0 ? 0 :($key['OK']/($key['OK']+$key['Rec']))*100;
            $key['ETE'] = ((($key['DISPO']/100)*($key['EFICIENCIA']/100)*($key['CALIDAD']/100))*100);

            $ResumenSem[$key['Semana']]['TTOT'] += $ttot;
            $ResumenSem[$key['Semana']]['TDISPO'] += $tdispo;
            $ResumenSem[$key['Semana']]['SU'] += $key['SU'];
            $ResumenSem[$key['Semana']]['MC'] += $key['MC'];
            $ResumenSem[$key['Semana']]['MP'] += $key['MP'];
            $ResumenSem[$key['Semana']]['TT'] += $key['TT'];
            $ResumenSem[$key['Semana']]['MI'] += $key['MI'];
            $ResumenSem[$key['Semana']]['MPRO'] += $key['MPRO'];
            $ResumenSem[$key['Semana']]['DISPO'] += $dispo;
            $ResumenSem[$key['Semana']]['PESPERADO'] += $pesperado;
            $ResumenSem[$key['Semana']]['PREAL'] += $key['Hechas'];
            $ResumenSem[$key['Semana']]['EFICIENCIA'] += $preal;
            $ResumenSem[$key['Semana']]['Rechazadas'] = $key['Rec'];
            $ResumenSem[$key['Semana']]['OK'] = $key['OK'];
            $ResumenSem[$key['Semana']]['CALIDAD'] = $key['CALIDAD'];
            $ResumenSem[$key['Semana']]['ETE'] += $key['ETE'];
            $ResumenSem[$key['Semana']]['TotalDA'] ++;
            
        
        } 
        //exit;
        return $this->render('Ete', [
            'model' => $datos_ete,
            'resumen'=>$ResumenSem,
            //'totales' =>$Totales,
        ]);
        
        
    }
    
    public function actionMaquinas(){
        $maquinas =Maquinas::find()->asArray()->all();
         
        return json_encode(
           $maquinas
        );   
    }

    public function actionProductoscolli(){

        $command = \Yii::$app->db;
        $model =$command->createCommand("SELECT
                                            dbo.Productos.IdProducto,
                                            dbo.Pedidos.IdPedido,
                                            dbo.Pedidos.IdAlmacen,
                                            dbo.Pedidos.OrdenCompra,
                                            dbo.Pedidos.EstatusEnsamble,
                                            dbo.Pedidos.SaldoExistenciaPT,
                                            dbo.Pedidos.Cantidad,
                                            dbo.Pedidos.SaldoCantidad,
                                            dbo.Pedidos.Cliente,
                                            dbo.Productos.Ensamble,
                                            dbo.Pedidos.FechaEmbarque,
                                            dbo.Pedidos.Observaciones,
                                            dbo.Productos.Identificacion
                                        FROM
                                            dbo.Productos
                                        INNER JOIN dbo.Pedidos ON dbo.Productos.IdProducto = dbo.Pedidos.IdProducto
                                        WHERE dbo.Productos.Ensamble = 1 ORDER BY dbo.Productos.IdProducto, dbo.Pedidos.IdPedido ASC"
                                        )->queryAll();
       

        //var_dump($Material);
        return $this->render('ProductosColli',['model'=>$model,]);
        
    }
            
    function calcular_tiempo($hora1,$hora2){
        
        $tiempo1 = date('H:i:s',strtotime($hora1));
        $fecha1 = date('Y-m-d',strtotime($hora1));
        
        $tiempo2 = date('H:i:s',strtotime($hora2));
        $fecha2 = date('Y-m-d',strtotime($hora2));
        
        $horas[1]=explode(':',$tiempo1);
        $fecha[1]=explode('-',$fecha1);
        
        $horas[2]=explode(':',$tiempo2);
        $fecha[2]=explode('-',$fecha2);
        
        //                 horas       minutos     segundos        mes          dia          año
        $fecha1=mktime($horas[1][0],$horas[1][1],$horas[1][2],$fecha[1][1],$fecha[1][2],$fecha[1][0]);
        $fecha2=mktime($horas[2][0],$horas[2][1],$horas[2][2],$fecha[2][1],$fecha[2][2],$fecha[2][0]);
        
        $segundos=$fecha2-$fecha1;
        $minutos=$segundos/60;  
        
      return $minutos;
    }
}