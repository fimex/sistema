<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\CiclosVarel;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\programacion\VProgramaciones;
use frontend\models\produccion\ConfiguracionSeries;
use frontend\models\produccion\SeriesDetalles;
use frontend\models\produccion\Series;
use frontend\models\produccion\VCapturaExceleada;
use frontend\models\produccion\FechaMoldeo;
use frontend\models\produccion\FechaMoldeoDetalle;
use frontend\models\produccion\ResumenFechaMoldeo;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\produccion\VDetalleProduccion;
use frontend\models\produccion\VProgramacionDiaAcero;
use frontend\models\produccion\VProgramacionCiclosAcero;
use common\models\catalogos\VDefectos;
use common\models\catalogos\VProduccion2;
use common\models\catalogos\Maquinas;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Areas;
use common\models\catalogos\VEmpleados;
use common\models\datos\Causas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Lances;
use common\models\catalogos\PartesMolde;
use common\models\dux\Aleaciones;
use common\models\dux\Productos;


class ProduccionAceroController extends \yii\web\Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
    
    public function actionIndex()
    {
        return $this->render('index',[
            'title' => 'Configuracion de Series',
        ]);
    }


    
    /************************************************************
     *                    RUTAS PARA LOS MENUS
     ************************************************************/

    public function actionSeries()
    {
        return $this->CapturaSeries();
    }
    public function actionMoldeoV()
    {
        return $this->CapturaMoldeo(6,2);
    }
    public function actionMoldeoK()
    {
        return $this->CapturaMoldeo(6,1);
    }
    public function actionMoldeoE()
    {
        return $this->CapturaMoldeo(6,3);
    }
    public function actionCerradoK()
    {
        $this->layout = 'produccionAceros';

        return $this->render('CerradoK', [
            'title' => 'Cerrado Kloster',
            'IdSubProceso'=> 6,
            ]);
    }
    public function actionVaciado()
    {
       $this->layout = 'produccionAceros';

        return $this->render('Vaciado', [
            'title' => 'Vaciado',
            ]);
    }
    public function CapturaSeries()
    {
        $this->layout = 'produccionAceros';
        
        return $this->render('CapturaSeries', [
            'title' => 'Configuracion de Series',
        ]);
    }  

    public function CapturaMoldeo($subProceso, $IdArea, $IdEmpleado = ''){
        $this->layout = 'produccionAceros';
        return $this->render('CapturaProduccionAcero', [
            'title' => 'Captura de Produccion',
            'IdSubProceso'=> $subProceso,
            'IdArea' => $this->areas->getCurrent(),
            'IdAreaAct' => $IdArea,
            'IdEmpleado' => $IdEmpleado == ' ' ? Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'] : $IdEmpleado,
        ]);
    }


    public function actionProductosSeries(){

        $model = ConfiguracionSeries::find()->asArray()->all();

        return json_encode($model);
    }



    /************************************************************
     *                    OBTENCION DE DATOS
     ************************************************************/


    public function actionProduccion(){
        if ( $_GET['IdProduccion']) {
          
       
        $model = Producciones::find()
                ->where(['IdProduccion' => $_GET['IdProduccion']])
                ->with('lances')
                ->with('idMaquina')
                ->with('idCentroTrabajo')
                ->with('idEmpleado')
                ->asArray()
                ->one();
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        $model['Semana'] = date('W',strtotime($model['Fecha']));
        }else{
            $model = array();
        }    
        return json_encode(
            $model
        );
    }
    
    public function actionCountProduccion(){
        $IdSubProceso = $_GET['IdSubProceso'];
        $IdArea = $this->areas->getCurrent();
        $model = Producciones::find()->select("IdProduccion")->where("IdArea = $IdArea AND IdSubProceso = $IdSubProceso")->orderBy('Fecha ASC')->asArray()->all();
        return json_encode(
            $model
        );
    }


    public function actionProductos(){
       $productos = new Productos();
       $model = $productos->getProductosSeries();
        return json_encode($model);
    }

    public function actionDetalle(){
        //$model = VDetalleProduccion::find()->where($_GET)->asArray()->all();
        $_GET['Dia'] = date('Y-m-d',strtotime($_GET['Dia']));
       
        if ($_GET['Dia'] != '' && $_GET['IdArea'] != '' && $_GET['IdArea'] != 'IdProduccion') {
        
            $model = VProgramacionDiaAcero::find()->where("Dia =  '".$_GET['Dia']."' AND IdArea = ".$_GET['IdArea']." AND IdAreaAct = ".$_GET['IdAreaAct']." AND IdSubProceso = ".$_GET['IdSubProceso']." ")->asArray()->all();
            //var_dump($model);exit;
            if ($model != null) {
                foreach ($model as &$value ) {
                    $ciclos = VProgramacionCiclosAcero::find()->where("IdProductos = ".$value['IdProducto']." AND IdProgramacion = ".$value['IdProgramacion']." AND IdProduccion = ".$_GET['IdProduccion']." ")->asArray()->one();

                    if($ciclos != null){
                        $value['CiclosOk'] = ($ciclos['Cant'] ) - ($ciclos['RechazadasP'] + $ciclos['RechazadasC']);
                        $value['CiclosOkC'] =   $ciclos['CantC'];
                        $value['MoldesOK'] = (($ciclos['Cant'] - ($ciclos['RechazadasP'] + $ciclos['RechazadasC'])) / $value['CiclosMolde']) ; //floor se quito para que ya no redondeara a hacia arriba 1.5 = 1, 2.5 = 2
                        $value['RechazadasP'] = $ciclos['RechazadasP'];
                        $value['RechazadasC'] = $ciclos['RechazadasC'];
                        $value['RechazadasM'] = $ciclos['RechazadasM'];
                        $value['RechazadasR'] = $ciclos['RechazadasR'];
                        $value['CicRequeridosV'] = ($value['CicRequeridos'] + $ciclos['RechazadasP'] + $ciclos['RechazadasC']) - ($ciclos['Cant']);
                        
                        // Calculo para los ciclos requeridos en Kloster
                        $value['CiclosOkK'] = $ciclos['Cant'];

                        $RechazadasP = $ciclos['RechazadasP'] == 0 ? 0 : ($ciclos['RechazadasP'] * $value['CiclosMolde']);
                        $RechazadasC = $ciclos['RechazadasC'] == 0 ? 0 : ($ciclos['RechazadasC'] * $value['CiclosMolde']);
                        $RechazadasM = $ciclos['RechazadasM'] == 0 ? 0 : ($ciclos['RechazadasM'] * $value['CiclosMolde']);
                        $value['CicRequeridosK'] = ($value['CicRequeridos'] + $RechazadasP + $RechazadasC + $RechazadasM)  - $ciclos['Cant'];

                        $value['MoldesOKK'] = floor((($ciclos['Cant'] - ($ciclos['RechazadasP'] + $ciclos['RechazadasC'] + $ciclos['RechazadasM'])) / $value['CiclosMolde']));

                        $value['FaltaLlenadas'] = $value['Programadas'] - $value['Llenadas']; 
                        $value['FaltaCerradas'] = floor($ciclos['Cant'] / $value['CiclosMolde']) - $value['CiclosOkC'];

                    }else{
                        $value['CiclosOk'] = 0;
                         $value['CiclosOkK'] = 0;
                        $value['CiclosOkC'] = 0;
                        $value['MoldesOK'] = 0;
                        $value['MoldesOKK'] = 0;
                        $value['RechazadasP'] = 0;
                        $value['RechazadasC'] = 0;
                        $value['RechazadasM'] = 0;
                        $value['RechazadasR'] = 0;
                        $value['CicRequeridosK'] = $value['CicRequeridos'];
                        $value['CicRequeridosV'] = $value['CicRequeridos'];
                    }
                }
            }
        }else{ $model = array(); }

        return json_encode($model);
    }

    public function actionEmpleados($depto=''){
        if($depto != ''){
            $depto = (strpos($depto,",") ? explode(",",$depto) : $depto);
            $depto = (is_array($depto) ? implode("','",$depto) : $depto);
            $depto = "AND IDENTIFICACION IN('$depto')";
        }
        $model = VEmpleados::find()->where("IdEmpleadoEstatus <> 2 $depto"  )->orderBy('NombreCompleto')->asArray()->all();
        
        return json_encode(
            $model
        );   
    }

    public function actionMaquinas($IdSubProceso){
        $model = VMaquinas::find()->where([
            'IdSubProceso' => $IdSubProceso*1,
            'IdArea'=>$this->areas->getCurrent(),
        ])->asArray()->all();

      
        return json_encode($model);
    }
   

    public function actionProgramacion(){

        $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
    
        return json_encode($model);
    }


    public function actionPartesMolde(){
        switch ($_GET['IdAreaAct']) {
            case 1: $where = "Identificador IN('TAPA','BASE')"; break;
            case 2: $where = "Identificador IN('TAPA','BASE','C1','C2','C3','C4','C5','C6')"; break;
            case 3: $where = "Identificador IN('TAPA','BASE','C1','C2','C3','C4','C5','C6')"; break;
        }
        $model = PartesMolde::find()->where($where)->asArray()->all();
    
        return json_encode($model);
    }


    public function actionGetSerie(){
        $model = new ConfiguracionSeries;
        $serie = $model->getSerie($_GET);

        if ($serie != null) {
            return json_encode($serie[0]);
        }else{
            $serie[0] = 0;
        }

        return json_encode($serie[0]);
    }


    public function actionMostrarSeries(){
        $model = Series::find()->where($_GET)->asArray()->all();

        return json_encode($model);
    }
    
    public function actionProductosDia(){
        $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
       
        return json_encode($model);
    }

    public function actionDetallesDia(){
        $model = new VProgramacionesDia;
        $producto = $model->getDetallesDia($_GET);
        if ($producto != null) {
            return json_encode($producto[0]);
        }else{
            $producto[0] = 0;
        }

        return json_encode($producto[0]);
    }

    /************************************************************
     *                    FUNCIONES EN GENERAL
     ************************************************************/
    
    function actionSaveSerie(){

        $serie = isset($_GET['Serie']) ? $_GET['SerieInicio'] : 0 ;
        $producto = isset($_GET['IdProducto']) ? $_GET['IdProducto'] : 0 ;
        $model = ConfiguracionSeries::find()->where('SerieInicio = '.$serie.' OR IdProducto = '.$producto.'')->asArray()->one();

        if ($model == null) {
            $model = new ConfiguracionSeries();
            $model->load([
                'ConfiguracionSeries'=>$_GET
            ]);
            $model->save();
        }else{
            $model['Error'] = 1;
        }
        
        return json_encode($model);

    }


    public function actionSaveProduccion(){
        $data['Producciones'] = $_GET;
        $update = false;

        if(!isset($data['Producciones']['IdArea'])){
            $data['Producciones']['IdArea'] = $this->areas->getCurrent();
        }

        if(!isset($data['Producciones']['Fecha'])){
           $data['Producciones']['Fecha'] = date('Y-m-d');
        }
        
        $data['Producciones']['Fecha'] = date('Y-m-d',strtotime($data['Producciones']['Fecha']));

        if(!isset($data['Producciones']['IdCentroTrabajo'])){
            $data['Producciones']['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$data['Producciones']['IdMaquina']])->one()->IdCentroTrabajo;
        }
        
        if(!isset($data['Producciones']['IdProduccionEstatus'])){
            $data['Producciones']['IdProduccionEstatus'] = 1;
        }
        
        if(!isset($data['Producciones']['IdEmpleado'])){
            $data['Producciones']['IdEmpleado'] = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        }
        
        if(isset($data['Producciones']['IdProduccion'])){
            $model = Producciones::findOne($data['Producciones']['IdProduccion']);
            $update = true;
        }else{
            $model = new Producciones();
        }
        $model->load($data);
        $model->Observaciones = isset($data['Producciones']['Observaciones']) ? $data['Producciones']['Observaciones'] : "";

        $model1 = Producciones::find()->where("Fecha = '".$data['Producciones']['Fecha']."' AND IdSubProceso = ".$data['Producciones']['IdSubProceso']." AND IdArea = 2 ")->asArray()->one();

        if($model1){
            $datos[0] = $model1;
            $datos[1] = 1;
            return json_encode($datos);
        }else{
           $model->save();
        }
        
       if($model->IdSubProceso == 10 && $update == false){
            $this->SaveLance($data['Producciones'],$model);
            $materiales = json_decode($this->actionMaterial($model->IdSubProceso));

            foreach($materiales as $material){
                $consumo = new MaterialesVaciado();
                $consumo->IdProduccion = $model->IdProduccion;
                $consumo->IdMaterial = $material->IdMaterial;
                $consumo->Cantidad = 0;
                $consumo->save();
            }
        }
        
        $model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        $datos[0] = $model;
        $datos[1] = 0;
        return json_encode($datos);
    }
    
    function actionCerradoOk()
    {
        $programacionDia = new ProgramacionesDia();
        $programacionDia->incrementa($_GET['id']);
    }
    
    function actionSaveDetalleAcero(){  
        //var_dump($_GET); exit(); 

        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        $_GET['Inicio'] = isset($_GET['Inicio']) ? $_GET['Inicio'] : '00:00';
        $_GET['Fin'] = isset($_GET['Fin']) ? $_GET['Fin'] : '00:00';
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['Fin'] = ($_GET['Fin'] < $_GET['Inicio'] ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
        $_GET['Eficiencia'] = isset($_GET['Eficiencia']) ? $_GET['Eficiencia'] : 1;
        
        $partesK = strlen($_GET['IdParteMoldeCapK']) >= 2 ? explode(",", $_GET['IdParteMoldeCapK']) : '';

        if(strlen($_GET['IdParteMoldeCapK']) == 2){      
            $_GET['IdParteMolde'] = $partesK[0];
        }elseif (strlen($_GET['IdParteMoldeCapK']) == 4) {
            $_GET['IdParteMolde'] = 16;
        }elseif ($_GET['IdParteMoldeCapK'] == '') {
            $_GET['IdParteMolde'] = $_GET['IdParteMoldeCap'];
        }
        //var_dump($_GET); exit();
        //if($_GET['EstatusCiclos'] == 'B' || $_GET['EstatusCiclos'] == 'RE' || $_GET['EstatusCiclos'] == 'CB'){
        if($_GET['IdCicloTipo'] == 1 || $_GET['IdCicloTipo'] == 2 || $_GET['IdCicloTipo'] == 5){
            $_GET['CantidadCiclos'] = 1;
            $_GET['Hechas'] = 1;
            $rechazo = 0;
            $_GET['IdCicloTipo'] == 5 ? $_GET['SerieInicio'] = $_GET['SerieR'] : isset($_GET['SerieInicio']);
        }
        //if($_GET['EstatusCiclos'] == 'R' || $_GET['EstatusCiclos'] == 'RM' ||  $_GET['EstatusCiclos'] == 'RC' || $_GET['EstatusCiclos'] == 'RCl'){
        if($_GET['IdCicloTipo'] == 3 || $_GET['IdCicloTipo'] == 4 || $_GET['IdCicloTipo'] == 6 || $_GET['IdCicloTipo'] == 7){
            $_GET['Rechazadas'] = 1;
            $rechazo = 1;
            $_GET['SerieInicio'] = isset($_GET['SerieR']) == true ? $_GET['SerieR'] : 0;
        }

        
        $model = new ProduccionesDetalle();
        $IdDetalle = 'ProduccionesDetalle';
        
        if(!isset($_GET['IdProduccionDetalle'])){
            $model->load([
                "$IdDetalle"=>$_GET
            ]);
        }else{
            $model = $model::findOne($_GET['IdProduccionDetalle']);
            $model->load([
                "$IdDetalle"=>$_GET
            ]);
        }
         
        $model->save();
       
        $model = ProduccionesDetalle::find()->where(["IdProduccionDetalle" => $model->IdProduccionDetalle])->with('idProductos')->with('idProduccion')->asArray()->one();
   
        if($_GET['IdCicloTipo'] == 1){
           $this->actualizaHechas($model);
        }

      
        if ($partesK != '') {
            foreach ($partesK as $parte ) {  
                //echo "string ".$key;
                //$parte = isset($_GET['IdParteMoldeCap']) == true ? $_GET['IdParteMoldeCap'] : 0; 
                if ($model['idProductos']['IdParteMolde'] == $parte || $_GET['IdCicloTipo'] == 5 && $_GET['LlevaSerie'] == 'Si' && $_GET['SerieR'] != '' ) { 
                    $resultSerie = $this->Series($_GET,$rechazo);
                }            }
        }else{
            $parte = isset($_GET['IdParteMoldeCap']) == true ? $_GET['IdParteMoldeCap'] : 0;  
            if ($model['idProductos']['IdParteMolde'] == $parte || $_GET['IdCicloTipo'] == 5 && $_GET['LlevaSerie'] == 'Si' && $_GET['SerieR'] != '' ) {
                $resultSerie = $this->Series($_GET,$rechazo);
            }
        }

        //************ SERIE DE CICLOS BUENOS **************/
        /*if ($model['idProductos']['IdParteMolde'] == $parte || $_GET['IdCicloTipo'] == 5 && $_GET['LlevaSerie'] == 'Si' && $_GET['SerieR'] != '' ) {
            if(isset($_GET['Comentarios'])){
                $comentario = $_GET['Comentarios'];
            }else{
                $comentario = " ";
            }
            if (isset($_GET['LlevaSerie']) == 'Si') {
                $resultSerie = $this->setSeries($_GET['IdProducto'], $_GET['SubProceso'], $_GET['SerieInicio'], $_GET['IdProduccion'], $_GET['IdProgramacion'],$_GET['IdCicloTipo'],$rechazo,$comentario);
            }
        }*/

        //***********************  RECHAZO DE SERIES CERRADO  *************************/
        /*if ($_GET['EstatusCiclos'] == 'RC' && $_GET['SerieR'] != '') {
          //  $resultSerie = $this->setSeries($_GET['IdProducto'], $_GET['SubProceso'], $_GET['SerieInicio'], $_GET['IdProduccion'], $_GET['IdProgramacion'],$_GET['EstatusCiclos'],$rechazo,$_GET['Comentarios']);
        }*/

        /************************ SE ELIMINA EL CICLO SI ARROJA ERROR LA CAPTURA DE SERIES *********************/
        if(isset($resultSerie[0]) == 'E') {
            $produccion = ProduccionesDetalle::find()->where(['IdProduccionDetalle' => $model['IdProduccionDetalle']])->with('idProductos')->with('idProduccion')->asArray()->one();
            $model = ProduccionesDetalle::findOne($model['IdProduccionDetalle'])->delete();
            $this->actualizaHechas($produccion);
        }

        
        if ($_GET['FechaMoldeo']) {
            $_GET['FechaMoldeo2'] = date('Y-m-d',strtotime($_GET['FechaMoldeo2']));
            if(!$fechaMoldeo = FechaMoldeo::find()->where(["IdProducto" => $_GET["IdProducto"], "FechaMoldeo" => $_GET["FechaMoldeo2"]])->asArray()->one()){
                $fechaMoldeo = new FechaMoldeo();
                $fechaMoldeo->load([
                    "IdProducto" => $_GET,
                    "FechaMoldeo" => $_GET["FechaMoldeo2"]
                ]);
                $fechaMoldeo->save();
                $fechaMoldeo = FechaMoldeo::find()->where(["IdProducto" => $_GET["IdProducto"], "FechaMoldeo" => $_GET["FechaMoldeo2"]])->asArray()->one();
            }
            $fechaMoldeoDetalle = new FechaMoldeoDetalle();
            $fechaMoldeoDetalle->load(['FechaMoldeoDetalle'=>[
                "IdProduccionDetalle" =>  $model["IdProduccionDetalle"]*=1,
                "IdFechaMoldeo" => $fechaMoldeo["IdFechaMoldeo"]*=1
            ]]);
            $fechaMoldeoDetalle->save();
            if (!$resumenFechaMoldeo = ResumenFechaMoldeo::find()->where(["IdFechaMoldeo" => $fechaMoldeo["IdFechaMoldeo"]*=1, "IdSubProceso" => "1"])->asArray()->one()) {
                $resumenFechaMoldeo = new ResumenFechaMoldeo();
                $resumenFechaMoldeo->load(['ResumenFechaMoldeo'=>[
                    "IdFechaMoldeo" =>  $fechaMoldeo["IdFechaMoldeo"]*=1,
                    "IdSubProceso" => 1,
                    "Existencia" => 1
                ]]);
                $resumenFechaMoldeo->save();
            }else{
                $resumenFechaMoldeo = new ResumenFechaMoldeo();
                $resumenFechaMoldeo->incrementa($fechaMoldeo["IdFechaMoldeo"]*=1,1);
            }
        }
        return json_encode(
            $model
        );
    }
    
    function actualizaHechas($produccion){
        $programacionDia = VProgramacionDiaAcero::find()->where([
            'IdProgramacion' => $produccion['IdProgramacion'],
            'IdSubProceso' => $produccion['idProduccion']['IdSubProceso'],
            'Dia' => date('Y-m-d',strtotime($produccion['idProduccion']['Fecha']))
        ])->asArray()->one();
        $diario = $programacionDia;
        
        $programacionDia = ProgramacionesDia::findOne($programacionDia['IdProgramacionDia']);
        //var_dump($diario);
        $hechas = 0;
        $ProduccionesDetalle = VProduccion2::find()->where([
            'Fecha'=> date('Y-m-d',strtotime($produccion['idProduccion']['Fecha'])),
            'IdProgramacion' => $produccion['IdProgramacion'],
            'IdSubProceso' => $produccion['idProduccion']['IdSubProceso'],
        ])->asArray()->all();
        
        foreach($ProduccionesDetalle as $detalle){
            $hechas += $detalle['Hechas'];
            $hechas -= $produccion['idProduccion']['IdSubProceso'] == 6 ? 0 : $detalle['Rechazadas'];
        }

        //var_dump($programacionDia); exit();
        if($produccion['idProduccion']['IdSubProceso'] == 6){
            $programacionDia->Llenadas = $hechas/$diario['CiclosMolde'];
        }
        
        if($produccion['idProduccion']['IdSubProceso'] == 10){
            $programacionDia->Vaciadas = $hechas;
            $programacionDia->Hechas = $hechas * $produccion['PiezasMolde'];
        }
        
        $programacionDia->save();
        //var_dump($programacionDia);

        $produccion = new Producciones();
        $produccion->actualizaProduccion($diario);
    }

    public function updateConfSeries($IdConfiguracionSerie,$serieinicio){
        $configuracion = ConfiguracionSeries::findOne($IdConfiguracionSerie);
        $configuracion->SerieInicio =  $serieinicio + 1;
        $configuracion->update();
    }

    public function setSeries($IdProducto, $IdSubProceso, $serie, $IdProduccion, $IdProgramacion, $estatus,$rechazo,$comentarios){

        if ($rechazo == 1) {
            $estatu = 'R';
        }

        if ($rechazo == 0 || $estatus ==  5) {
            $estatu = 'R';
        }

        $model = array();
        $modelR = array();

        if(($rechazo == 0 && $estatus == 1 || $estatus == 2 ) || ($rechazo == 0 && $estatus == 3) || ($rechazo == 0 && $estatus == 4)  || ($rechazo == 0 && $estatus == 6) || ($rechazo == 0 && $estatus == 7)){
            $model = new Series();
            $model->IdProducto = $IdProducto;
            $model->IdSubProceso = $IdSubProceso;
            $model->Serie = $serie;
            if ($estatus == 1 || $estatus == 2) {
                $model->Estatus = 'B';
            }else{
                 $model->Estatus = 'R';
            } 
           
            $model->FechaHora = date("Y-m-d H:i:s");
            $model->save();
            if ($model == null) {
                return $model[0] = 'ERROR';
            }
        }else{
            $modelR = Series::find()->where("IdProducto = ".$IdProducto." AND Serie = ".$serie." ")->one();
            $modelR->IdSubProceso = $IdSubProceso;
            $modelR->Estatus = $estatu;
            $modelR->FechaHora = date("Y-m-d H:i:s");
            $modelR->update();
            
            if ($modelR == null) {
                return $model[0] = 'ERROR';
            }
        }

        if ($model != null || $modelR != null) {
            $this->setSeriesDetalles($serie,$IdProducto,$IdProduccion, $IdProgramacion,$estatus,$comentarios);
        }

        if (($rechazo == 0  && $estatus == 1 || $estatus == 2) || ($rechazo == 0  && $estatus == 3 || $estatus == 4 || $estatus == 6 || $estatus == 7)) {
            $this->updateConfSeries($_GET['IdConfiguracionSerie'], $_GET['SerieInicio']);
        }   

    }


    public function setSeriesDetalles($serie,$IdProducto,$IdProduccion, $IdProgramacion,$estatus,$comentarios){

        $lastId_pd = ProduccionesDetalle::find()->where('IdProductos = '.$IdProducto.' AND IdProduccion = '.$IdProduccion.' AND IdProgramacion = '.$IdProgramacion.' ')->orderBy('IdProduccionDetalle desc')->one();
        $lastId_se = Series::find()->where(" IdProducto = ".$IdProducto." AND Serie = ".$serie." ")->orderBy('IdSerie desc')->one();

        $model = new SeriesDetalles();
        $model->IdProduccionDetalle = $lastId_pd['IdProduccionDetalle'];
        $model->IdSerie = $lastId_se['IdSerie']; 
        $model->IdCicloTipo = $estatus;
        $model->Comentarios = $comentarios;
        $model->save();

        //var_dump($model);
    }

    public function Series($GET,$rechazo){
            //************ SERIE DE CICLOS BUENOS **************/
        //if ($model['idProductos']['IdParteMolde'] == $parte || $_GET['IdCicloTipo'] == 5 && $_GET['LlevaSerie'] == 'Si' && $_GET['SerieR'] != '' ) {
            if(isset($_GET['Comentarios'])){
                $comentario = $GET['Comentarios'];
            }else{
                $comentario = " ";
            }
            if (isset($GET['LlevaSerie']) == 'Si') {
                $resultSerie = $this->setSeries($GET['IdProducto'], $GET['SubProceso'], $GET['SerieInicio'], $GET['IdProduccion'], $GET['IdProgramacion'],$GET['IdCicloTipo'],$rechazo,$comentario);
            }
        //}
            return $resultSerie;
    }

    

}