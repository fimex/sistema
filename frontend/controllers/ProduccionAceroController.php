<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\VProbetas;
use frontend\models\produccion\Charpy;
use frontend\models\produccion\Dureza;
use frontend\models\produccion\Tension;
use frontend\models\produccion\Probetas;
use frontend\models\produccion\PruebasDestructivas;
use frontend\models\produccion\VLecturasCharpy;
use frontend\models\produccion\VLecturasTension;
use frontend\models\produccion\VLecturasDureza;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\TiempoAnalisis;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesCiclosDetalle;
use frontend\models\produccion\ProduccionesCiclos;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use common\models\catalogos\MaterialesTipo;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\CiclosVarel;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\programacion\VProgramaciones;
use frontend\models\produccion\ConfiguracionSeries;
use frontend\models\produccion\SeriesDetalles;
use frontend\models\produccion\Series;
use frontend\models\produccion\VCapturaExceleada;
use frontend\models\produccion\VProduccionCiclos;
use frontend\models\produccion\VProgramacionesCiclos;
use frontend\models\produccion\FechaMoldeo;
use frontend\models\produccion\FechaMoldeoDetalle;
use frontend\models\produccion\ResumenFechaMoldeo;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\produccion\VDetalleProduccion;
use frontend\models\produccion\VProgramacionDiaAcero;
use frontend\models\produccion\VProgramacionCiclosAcero;
use frontend\models\produccion\MantenimientoHornos;
use frontend\models\produccion\VSeries;
use common\models\vistas\VAleaciones;
use common\models\catalogos\VDefectos;
use common\models\catalogos\VProduccion2;
use common\models\catalogos\Maquinas;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Areas;
use common\models\catalogos\VEmpleados;
use common\models\datos\Causas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Lances;
use common\models\vistas\VLances;
use common\models\catalogos\PartesMolde;
use common\models\dux\Aleaciones;
use common\models\dux\Productos;
use common\models\dux\VProductos;
use common\models\catalogos\Turnos;
use frontend\models\tt\TratamientosTermicos;
use frontend\models\tt\TTTipoEnfriamientos;
use frontend\models\produccion\VTratamientosTermicos;
use frontend\models\produccion\VProductosProgramadosTT;
use frontend\models\produccion\TratamientosProbetas;

use frontend\models\Archivos;
use yii\web\UploadedFile;


class ProduccionAceroController extends InventarioController
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
        return $this->CapturaProduccion(7,2,2);
    }
    public function actionMoldeoK()
    {
        return $this->CapturaProduccion(6,2,1);
    }
    public function actionMoldeoE()
    {
        return $this->CapturaProduccion(17,2,3);
    }
    public function actionPintado()
    {
        return $this->CapturaProduccion(8,2);
    }
    public function actionCerradoK()
    {
        return $this->CapturaProduccion(9,2,1);
    }
    public function actionCerradoV()
    {
        return $this->CapturaProduccion(9,2,2);
    }
    
    public function actionVaciado() //Correcto
    {
       $this->layout = 'produccionAceros';

        return $this->render('Vaciado', [
            'title' => 'Vaciado',
            ]);
    }
    public function actionVaciadoAcero()
    {
        return $this->CapturaProduccion(10,2);
    }
    
    public function CapturaSeries()
    {
        $this->layout = 'produccionAceros';
        
        return $this->render('CapturaSeries', [
            'title' => 'Configuracion de Series',
        ]);
    }

    public function actionTiemposmuertos()
    {
        return $this->CapturaTMA(3);
    }

    public function actionCharpy()
    {
       return $this->CapturaPruebasDestructivas(14,2,2242,1050);
    }

    public function actionPruebasmecanicas(){
        return $this->CapturaPruebasDestructivas(14,2,2243,1050);
    }
    
    /*
     *    INICIA CODIGO AGREGADO POR IVAN DE SANTIAGO
     */
    
    function actionDataProgramaciones(){
        $_REQUEST['Dia'] = date('Y-m-d',  strtotime($_REQUEST['Dia']));
        //var_dump($_REQUEST);
        $model = VProgramacionesCiclos::find()->where($_REQUEST)->orderBy('Prioridad ASC')->asArray()->all();
        return json_encode($model);
    }
    
    function actionDataProduccion(){
        if(!isset($_GET['IdProduccion'])){
            $_GET['Fecha'] = date('Y-m-d',  strtotime($_GET['Fecha']));
            $model = Producciones::find()->where($_GET)->asArray()->one();
        }else{
            if ( $_GET['IdProduccion']) {
                $model = Producciones::find()
                    ->where(['IdProduccion' => $_GET['IdProduccion']])
                    ->with('lances')
                    ->with('idMaquina')
                    ->with('idCentroTrabajo')
                    ->with('idEmpleado')
                    ->with('idTratamientosTermicos')
                    ->with('pruebasDestructivas')
                    ->asArray()
                    ->one();
                $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
                $model['Semana'] = date('W',strtotime($model['Fecha']));
            }else{
                $model = array();
            } 
        }

        return json_encode($model);
    }
    
    /*
     *    FINALIZA CODIGO AGREGADO POR IVAN DE SANTIAGO
     */

    public function CapturaProduccion($subProceso, $IdArea, $IdAreaActual = null){
        $this->layout = 'produccionAceros';
        
        switch ($subProceso){
            case 6: $url = 'CapturaProduccionAcero'; $title = 'Moldeo Kloster';break;
            case 7: $url = 'CapturaProduccionAcero'; $title = 'Moldeo Varel';break;
            case 8: $url = 'CapturaProduccionAcero'; $title = 'Pintado ';break;
            case 9: $url = 'CapturaProduccionAcero'; $title = 'Cerrado '. ($IdAreaActual == 1 ? 'Kloster' : 'Varel') ;break;
            case 10: $url = 'CapturaProduccion'; $title = 'Vaciado';break;
            case 17: $url = 'CapturaProduccionAcero'; $title = 'Moldeo Especial';break;
        }
        return $this->render($url, [
            'title' => $title,
            'IdSubProceso'=> $subProceso,
            'IdArea' => $IdArea,
            'IdAreaAct' => $IdAreaActual,
            'IdEmpleado' => Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'],
        ]);
    }

    public function CapturaPruebasDestructivas($IdSubProceso, $IdArea, $IdMaquina, $IdCentroTrabajo){
        //$this->layout = 'PruebasDestructivas';

        return $this->render('CapturaPruebasDestructivas',[
            'IdSubProceso' => $IdSubProceso,
            'IdArea' => $IdArea, 
            'IdMaquina' => $IdMaquina,
            'IdCentroTrabajo' => $IdCentroTrabajo,
            'IdEmpleado' => Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'],
        ]);
    }

    public function CapturaCerrado($IdEmpleado = ''){
        $this->layout = 'produccionAceros';

        return $this->render('CapturaCerrado', [
            'title' => 'Cerrado Kloster',
            'IdSubProceso'=> 9,    
            'Proceso' => 'Cerrado',  
            'IdEmpleado' => $IdEmpleado == ' ' ? Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'] : $IdEmpleado,
        ]);
    }

    public function CapturaTMA($subProceso)
    {
        $this->layout = 'produccion';
        
        return $this->render('CapturaTMAcero', [
            'title' => 'Captura de Tiempos Muertos',
            'IdSubProceso'=> $subProceso,
        ]);
    } 

    public function actionProductosSeries(){
        $model2 = [];
        $model = Productos::find()
            ->where([
                'IdPresentacion' => 2,
                'LlevaSerie' => 'Si'
            ])
            ->with('idConfiguracionSerie')
            ->with('idMarca')
            ->orderBy('IdMarca')
            ->asArray()
            ->all();
        
        foreach($model as &$mod){
            $mod['Marca'] = $mod['idMarca']['Descripcion'];
        }
        
        return json_encode($model);
    }

    public function actionAleaciones(){
        $model = VAleaciones::find()->where(['IdPresentacion' => $this->areas->getCurrent(),])->orderBy('Identificador')->asArray()->all();
        
        foreach($model as &$mod){
            $mod['IdAleacion'] *= 1;
            $mod['IdAleacionTipo'] *= 1;
            $mod['IdPresentacion'] *= 1;
        }
        
        return json_encode($model);
    }


    /************************************************************
     *                    OBTENCION DE DATOS
     ************************************************************/

    public function actionProbetas(){
        $model = VProbetas::find()->where($_GET)->asArray()->all();
        return json_encode($model);
    }

    public function actionDataCharpy(){
        $model = VLecturasCharpy::find()->where($_REQUEST)->asArray()->all();
        $i = 1;
        $PromedioLBFT = 0;
        $PromedioJoules = 0;
        foreach ($model as &$key) { 
            $PromedioLBFT += $key['ResultadoLBFT'];
            $PromedioJoules += $key['ResultadoJoules'];
            if(($i % 3 ) == 0){
                $key['PromedioLBFT'.$i] = 0;
                $key['PromedioJoules'.$i] = 0;
                $key['PromedioLBFT'.$i] = $PromedioLBFT; 
                $key['PromedioJoules'.$i] = $PromedioJoules;
                $key['num'] = $i;
                $PromedioLBFT = 0;
            }

            $i++;
        }

        return json_encode($model);    
    }

    public function actionDataPruebasMecanicas(){
        $model = VLecturasTension::find()->where($_GET)->asArray()->all();

        return json_encode($model);    
    }

       public function actionDataDureza(){
        $model = VLecturasDureza::find()->where($_GET)->asArray()->all();

        return json_encode($model);    
    }

    public function actionProduccion(){
        if ( $_REQUEST['IdProduccion']) {
          
        $model = Producciones::find()
                ->where(['IdProduccion' => $_REQUEST['IdProduccion']])
                ->with('lances')
                ->with('idMaquina')
                ->with('idCentroTrabajo')
                ->with('idEmpleado')
                ->with('tratamientosTermicos')
                ->with('pruebasDestructivas')
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
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = $_REQUEST['IdArea'];

        $model = Producciones::find()->select("IdProduccion")->where("IdArea = $IdArea AND IdSubProceso = $IdSubProceso")->orderBy('Fecha ASC')->asArray()->all();
        return json_encode(
            $model
        );
    }

    public function actionCountProduccionPruebas(){
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = $this->areas->getCurrent();
        $model = Producciones::find()->select("IdProduccion")->where($_REQUEST)->orderBy('Fecha ASC')->asArray()->all();
        return json_encode(
            $model
        );
    }

    public function actionProductos(){
       $productos = new Productos();
       $model = $productos->getProductosSeries();
        return json_encode($model);
    }

    public function actionDetalleVaciado(){
        $model = VProgramacionDiaAcero::find()->where("Dia = '".$_REQUEST['Dia']."' AND IdArea = ".$_REQUEST['IdArea']."")->asArray()->all();

        foreach ($model as &$value) {
            $detalle = ProduccionesDetalle::find()->where("IdProgramacion = ".$value['IdProgramacion']." AND IdProductos = ".$value['IdProducto']." AND IdProduccion = ".$_REQUEST['IdProduccion']."")->asArray()->one();

            $value['Hechas'] = 0;
            if ($detalle != null) {
                $value['Hechas'] = $detalle['Hechas'];
                $value['IdProduccionDetalle'] = $detalle['IdProduccionDetalle'];
                $value['Rechazadas'] = $detalle['Rechazadas'];
            }else{
                $value['Rechazadas'] = 0;
            }
            $value['Hechas'] *= 1;
            $value['Rechazadas'] *= 1;
        }
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }

    public function actionDetalle(){
        //$model = VDetalleProduccion::find()->where($_REQUEST)->asArray()->all();
        $_REQUEST['Dia'] = date('Y-m-d',strtotime($_REQUEST['Dia']));
        $in = '';

        if ($_REQUEST['Dia'] != '' && $_REQUEST['IdArea'] != '' && $_REQUEST['IdArea'] != 'IdProduccion') {
        
            $model = VProgramacionDiaAcero::find()->where("Dia =  '".$_REQUEST['Dia']."' AND IdArea = ".$_REQUEST['IdArea']." AND IdAreaAct = ".$_REQUEST['IdAreaAct']." AND IdSubProceso = ".$_REQUEST['IdSubProceso']." ")->asArray()->all();
            if ($model != null) {
                foreach ($model as &$value ) {
                    $in = '';
                    $produccion = Producciones::find()->where("Fecha = '".$_REQUEST['Dia']."' AND IdArea = ".$_REQUEST['IdArea']." AND IdCentroTrabajo = ".$_REQUEST['IdCentroTrabajo']." AND IdMaquina = ".$_REQUEST['IdMaquina']." AND IdEmpleado = ".$_REQUEST['IdEmpleado']." AND IdSubProceso IN (8,9) ")->asArray()->all();
                    foreach ($produccion as $key) {
                        $in .= "".$key['IdProduccion'].",";
                    }
                    $in .= $_REQUEST['IdProduccion'];

                    $ciclos = VProgramacionCiclosAcero::find()->select('IdProducto, IdProgramacion, 
                                                                        SUM(CantK) AS CantK, 
                                                                        SUM(CantV) AS CantV, 
                                                                        SUM(CantE) AS CantE, 
                                                                        SUM(ReposicionK) AS ReposicionK, 
                                                                        SUM(ReposicionV) AS ReposicionV, 
                                                                        SUM(ReposicionE) AS ReposicionE, 
                                                                        SUM(CantC) AS CantC,
                                                                        SUM(RechazadasP) AS RechazadasP, 
                                                                        SUM(RechazadasC) AS RechazadasC, 
                                                                        SUM(RechazadasM) AS RechazadasM, 
                                                                        SUM(RechazadasR) AS RechazadasR, 
                                                                        SUM(RechazadasV) AS RechazadasV, 
                                                                        SUM(CantVaciadas) AS CantVaciadas')
                                                                ->where("IdProducto = ".$value['IdProducto']." 
                                                                        AND IdProgramacion = ".$value['IdProgramacion']."
                                                                        AND IdProduccion IN ($in)")->groupby('IdProducto, IdProgramacion')
                                                                ->asArray()->one();
                   

                    if($ciclos != null){
                        $value['CiclosOkV'] = ($ciclos['CantV'] ) - ($ciclos['RechazadasP'] + $ciclos['RechazadasC']); //Varel
                        $value['CiclosOkE'] = ($ciclos['CantE'] ) - ($ciclos['RechazadasP'] + $ciclos['RechazadasC']); //Especial
                        $value['CiclosOkC'] =   $ciclos['CantC'];
                        $value['MoldesOKV'] = (($ciclos['CantV'] - ($ciclos['RechazadasP'] + $ciclos['RechazadasC'])) / $value['CiclosMolde']) ; //floor se quito para que ya no redondeara a hacia arriba 1.5 = 1, 2.5 = 2
                        $value['MoldesOKE'] = (($ciclos['CantE'] - ($ciclos['RechazadasP'] + $ciclos['RechazadasC'])) / $value['CiclosMolde']) ; //floor se quito para que ya no redondeara a hacia arriba 1.5 = 1, 2.5 = 2
                        $value['RechazadasP'] = $ciclos['RechazadasP'];
                        $value['RechazadasC'] = $ciclos['RechazadasC'];
                        $value['RechazadasM'] = $ciclos['RechazadasM'];
                        $value['RechazadasR'] = $ciclos['RechazadasR'];
                        $value['RechazadasV'] = $ciclos['RechazadasV'];
                        $value['CantVaciadas'] = $ciclos['CantVaciadas'];
                        $value['CicRequeridosV'] = ($value['CicRequeridos'] + $ciclos['RechazadasP'] + $ciclos['RechazadasC']) - ($ciclos['CantV']);
                        $value['CicRequeridosE'] = ($value['CicRequeridos'] + $ciclos['RechazadasP'] + $ciclos['RechazadasC']) - ($ciclos['CantE']);

                        // Calculo para los ciclos requeridos en Kloster
                        $value['CiclosOkK'] = $ciclos['CantK'];

                        $RechazadasP = $ciclos['RechazadasP'] == 0 ? 0 : ($ciclos['RechazadasP'] / $value['CiclosMolde']);
                        $RechazadasC = $ciclos['RechazadasC'] == 0 ? 0 : ($ciclos['RechazadasC'] / $value['CiclosMolde']);
                        $RechazadasM = $ciclos['RechazadasM'] == 0 ? 0 : ($ciclos['RechazadasM'] / $value['CiclosMolde']);
                        $value['CicRequeridosK'] = ($value['CicRequeridos'] + $RechazadasP + $RechazadasC + $RechazadasM + $value['RechazadasR']) - $ciclos['CantK'];

                        $value['MoldesOKK'] = floor((($ciclos['CantK'] - ($ciclos['RechazadasP'] + $ciclos['RechazadasC'] + $ciclos['RechazadasM'])) / $value['CiclosMolde']));
                        $value['RechazoK'] = ($ciclos['RechazadasP']  + $ciclos['RechazadasC']  + $ciclos['RechazadasM']  + $value['RechazadasR']) / $value['CiclosMolde'];

                        $value['FaltaLlenadasV'] = $value['Programadas'] - $value['CiclosOkV']; 
                        $value['FaltaLlenadasE'] = $value['Programadas'] - $value['CiclosOkE']; 
                        $value['FaltaLlenadasK'] = $value['Programadas'] - $value['CiclosOkK']; 
                        $value['FaltaCerradasV'] = floor($ciclos['CantV'] / $value['CiclosMolde']) - $value['CiclosOkC'];
                        $value['FaltaCerradasE'] = floor($ciclos['CantE'] / $value['CiclosMolde']) - $value['CiclosOkC'];
                        $value['FaltaCerradasK'] = floor($ciclos['CantK'] / $value['CiclosMolde']) - $value['CiclosOkC'];

                    }else{
                        $value['CiclosOkV'] = 0;
                        $value['CiclosOkE'] = 0;
                        $value['CiclosOkK'] = 0;
                        $value['CiclosOkC'] = 0;
                        $value['MoldesOKV'] = 0;
                        $value['MoldesOKE'] = 0;
                        $value['MoldesOKK'] = 0;
                        $value['RechazoK'] = 0;
                        $value['RechazadasP'] = 0;
                        $value['RechazadasC'] = 0;
                        $value['RechazadasM'] = 0;
                        $value['RechazadasR'] = 0;
                        $value['RechazadasV'] = 0;
                        $value['CantVaciadas'] = 0;
                        $value['CicRequeridosK'] = $value['CicRequeridos'];
                        $value['CicRequeridosV'] = $value['CicRequeridos'];
                    }
                }
            }
        }else{ $model = array(); }

        return json_encode($model);
    }


    public function actionCountTiempos(){
        $model = TiemposMuerto::find('IdTiempoMuerto')->where($_REQUEST)->orderBy('Fecha ASC')->asArray()->all();
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

    public function actionFallas(){
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = $_REQUEST['IdArea'];
        $model = \common\models\catalogos\CausasTipo::find()->with('causas')->asArray()->all();
        
        foreach($model as $key => $mod){
            if(count($mod['causas'])>0){
                foreach($mod['causas'] as $key2 => $causa){
                    if($causa['IdSubProceso'] != $IdSubProceso || $causa['IdArea'] != $IdArea){
                        unset($model[$key]['causas'][$key2]);
                    }
                }
            }else{
                unset($model[$key]);
            }
        }
        return json_encode($model);
    }

    public function actionTiempos(){
        if(isset($_REQUEST['IdMaquina'])){
            $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
            $model = TiemposMuerto::find()->where("IdEmpleado = ".$_REQUEST['IdEmpleado']." AND Fecha = '".$_REQUEST['Fecha']."' ")->orderBy('Inicio ASC')->asArray()->all();
            //var_dump($model);

            foreach($model as &$mod){
                $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
                $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
            }

            return json_encode($model);
        }
    }

    public function actionTurnos(){
        $model = Turnos::find()->asArray()->all();
        return json_encode($model);
    }


    function actionSaveTiempo(){
       // $_REQUEST['Fecha'] = date('Y-m-d'); 
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        $_REQUEST['Inicio'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Inicio'];
        $_REQUEST['Inicio'] = str_replace('.',':',$_REQUEST['Inicio']);
        $_REQUEST['Fin'] = str_replace('.',':',$_REQUEST['Fin']);
        $_REQUEST['Fin'] = ($_REQUEST['Fin'] < $_REQUEST['Inicio'] ? $_REQUEST['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_REQUEST['Fecha'])))) . " " . $_REQUEST['Fin'];
               // var_dump($_REQUEST); exit();

        if(!isset($_REQUEST['IdTiempoMuerto'])){
            $model = new TiemposMuerto();
            $model->load([
                'TiemposMuerto'=>$_REQUEST
            ]);
        }else{
            $model = TiemposMuerto::findOne($_REQUEST['IdTiempoMuerto']);
            $model->load([
                'TiemposMuerto'=>$_REQUEST
            ]);
        }

        $model->save();
        $model = TiemposMuerto::find()->where(['IdTiempoMuerto' => $model->IdTiempoMuerto])->with('idCausa')->asArray()->one();
        $model['Inicio'] = date('H:i',strtotime($model['Inicio']));
        $model['Fin'] = date('H:i',strtotime($model['Fin']));

        return json_encode(
            $model
        );
    }
    
    function actionDeleteTiempo(){
        $model = TiemposMuerto::findOne($_REQUEST['IdTiempoMuerto'])->delete();
    }

    public function actionProgramacion(){
        unset($_REQUEST['IdSubProceso']); // añadido par atratamientos
        $model = VProgramacionesDia::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    public function actionPartesMolde(){
        $IdArea = isset($_REQUEST['IdAreaAct']) ? $_REQUEST['IdAreaAct'] : '';
        switch ($IdArea) {
            case 1: $where = "Identificador IN('TAPA','BASE')"; break;
            case 2: $where = ""; break;
            case 3: $where = "Identificador IN('TAPA','BASE')"; break;
            default: $where = ""; break;
        }
        $model = PartesMolde::find()->where($where)->asArray()->all();
        $i = 1;
        foreach ($model as &$key ) {
            $key['Num'] = $i;
            $i++;
        }

        return json_encode($model);
    }

    public function actionGetSerie(){
        //$model = ConfiguracionSeries::findOne($_REQUEST['IdConfiguracionSerie']);
        $model1 = VProductos::findOne($_REQUEST);
        //var_dump($model1->IdConfiguracionSerie);
        //exit();
        if ($model1 != null) {
            $model = ConfiguracionSeries::findOne($model1->IdConfiguracionSerie);
            //var_dump($model);
            return $model->SerieInicio;
            //return json_encode($model);
        }else{
            //$serie[0] = 0;
            //return json_encode($serie[0]);
            return 0;            
        }      
    }

    public function actionMostrarSeries(){
        $model = Series::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }
    
    public function actionProductosDia(){
        unset($_REQUEST['IdSubProceso']);
        $model = VProgramacionesDia::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    public function actionDetallesDia(){
        $model = new VProgramacionesDia;
        $producto = $model->getDetallesDia($_REQUEST);
        if ($producto != null) {
            return json_encode($producto[0]);
        }else{
            $producto[0] = 0;
        }

        return json_encode($producto[0]);
    }

    public function actionMaterial($IdSubProceso){
        $model = Materiales::find()->where([
                'IdSubProceso' => $IdSubProceso,
                'IdArea'=>$this->areas->getCurrent()
            ])
            ->with('idMaterialTipo')
            ->asArray()
            ->all();
        
        $IdMaterialTipo = '';
        
        foreach($model as $mod){
            if($IdMaterialTipo != $mod['idMaterialTipo']['IdMaterialTipo']){
                $IdMaterialTipo = $mod['idMaterialTipo']['IdMaterialTipo'];
                $model2[$IdMaterialTipo] = $mod['idMaterialTipo'];
            }
            
            unset($mod['idMaterialTipo']);
            $model2[$IdMaterialTipo]['materiales'][] = $mod;
            //var_dump($mod);
        }
        
        $model = $model2;
        return json_encode($model);
    }

    public function actionConsumo(){
        if(isset($_REQUEST['IdProduccion'])){
            $model = MaterialesVaciado::find()->where($_REQUEST)->with('idMaterial')->asArray()->all();
            foreach ($model as &$mod){
                $mod['Cantidad'] *=1; 
            }
            return json_encode($model);
        }
    }

    public function actionTemperaturas($IdTemperatura = ''){
        if(isset($_REQUEST['IdProduccion']) || $IdTemperatura != ''){
            $params = $IdTemperatura != '' ? ['IdTemperatura' => $IdTemperatura] : $_REQUEST;
            if( $IdTemperatura != ''){
                $model = Temperaturas::find()->where($params)->orderBy('Fecha')->asArray()->one();
                        
                $model['Temperatura'] *= 1;
                $model['Temperatura2'] *= 1;
                $model['Fecha2'] = date('Y-m-d',strtotime($model['Fecha']));
                $model['Fecha'] = date('H:i',strtotime($model['Fecha']));
            }else{
                $model = Temperaturas::find()->where($params)->orderBy('Fecha')->asArray()->all();
                        
                foreach($model as &$mod){
                    $mod['Temperatura'] *= 1;
                    $mod['Temperatura2'] *= 1;
                    $mod['Fecha2'] = date('Y-m-d',strtotime($mod['Fecha']));
                    $mod['Fecha'] = date('H:i',strtotime($mod['Fecha']));
                }
            }
            return json_encode($model);
        }
    }

    public function actionTiempoAnalisis(){
        if(isset($_REQUEST['IdProduccion'])){
            $model = TiempoAnalisis::find()->where($_REQUEST)->asArray()->all();

            foreach ($model as &$key) {
               $key['Tiempo'] = date('H:i',strtotime($key['Tiempo']));
               $key['Fecha'] =  date('Y-m-d',strtotime($key['Tiempo']));
            }
            return json_encode($model);
        }
    }

    /************************************************************
     *                    FUNCIONES EN GENERAL
     ************************************************************/
    
    function actionSavePruebas(){

        $data['Producciones'] = json_decode($_REQUEST['Produccion'],true);
        $data['PruebasDestructivas'] = json_decode($_REQUEST['PruebasDestructivas'],true);
       
        //var_dump($data['PruebasDestructivas']['IdProbeta']); exit();
        $pruebas = PruebasDestructivas::find()->where("IdProbeta = ".$data['PruebasDestructivas']['IdProbeta']." ")->one();
        if ($pruebas == null) {
            $pruebasD = $this->setPruebasDestructivas([
                'IdProduccion' => $data['Producciones']['IdProduccion'],
                'IdProbeta' => $data['PruebasDestructivas']['IdProbeta'],
                'SpecimenStandard' => isset($data['PruebasDestructivas']['SpecimenStandard']) ? 'ASTM-E23' : '',
            ]);
            $pruebas['IdPruebaDestructiva'] = $pruebasD['IdPruebaDestructiva'];
        }
       
        
        if ($data['PruebasDestructivas']['Tipo'] == 'Charpy') {
            $model = $this->setCharpy($data['PruebasDestructivas'], $pruebas['IdPruebaDestructiva']);
        }
        if (isset($data['PruebasDestructivas']['DiametroHuella']) != null) {
            $model = $this->setDureza($data['PruebasDestructivas'], $pruebas['IdPruebaDestructiva']);
        }
        if ($data['PruebasDestructivas']['Tipo'] == 'Tension') {
            $model = $this->setTension($data['PruebasDestructivas'], $pruebas['IdPruebaDestructiva']);
        }
        
        return json_encode($model);
    }

    public function setCharpy($data,$IdPruebaDestructiva){
        //var_dump($data);  exit();
        $model = new Charpy();
        $model->load([
            'Charpy' => [
                'IdPruebaDestructiva' => $IdPruebaDestructiva,
                'Espesor' => $data['Espesor'],
                'Ancho' => $data['Ancho'],
                'Largo' => $data['Largo'],
                'Profundo' => $data['Profundo'],
                'Angulo' => $data['Angulo'],
                'ResultadoLBFT' => $data['ResultadoLBFT'],
                'Temperatura' => $data['Temperatura'],
                'Resultado' => $data['ResultadoLBFT'] >= 20 ? 'A' : 'R',
            ]
        ]);
        $model->save();
    }

    public function setDureza($data,$IdPruebaDestructiva){
        $model = new Dureza();
        $model->load([
            'Dureza' => [
                'IdPruebaDestructiva' => $IdPruebaDestructiva,
                'DiametroHuella' => $data['DiametroHuella'],
            ]
        ]);
        $model->save();
    }

    public function setTension($data,$IdPruebaDestructiva){
        $model = new Tension();
        $model->load([
            'Tension' => [
                'IdPruebaDestructiva' => $IdPruebaDestructiva,
                'PsiTensileStrength' => $data['PsiTensileStrength'],
                'PsiYieldStrength' => $data['PsiYieldStrength'],
                'Elongacin' => $data['Elongacin'],
                'ReduccionArea' => $data['ReduccionArea'],
            ]
        ]);
        $model->save();
    }

    public function setPruebasDestructivas($data){
        $model = new PruebasDestructivas();
        $model->load(['PruebasDestructivas' => $data]);
        $model->save();
        return $model;
    }

    function actionSaveSerie(){
        $_REQUEST['idConfiguracionSerie'] = json_decode($_REQUEST['idConfiguracionSerie'], true);
        $producto = Productos::findOne($_REQUEST['IdProducto']);

        if(isset($_REQUEST['IdConfiguracionSerie'])){
            $model = ConfiguracionSeries::findOne($_REQUEST['IdConfiguracionSerie']);
            $model->SerieInicio = $_REQUEST['idConfiguracionSerie']['SerieInicio'];
            $model->update();
        }else{
            $model = new ConfiguracionSeries();
            $model->load([
                'ConfiguracionSeries'=>$_REQUEST['idConfiguracionSerie']
            ]);
            if(!$model->save()){
                
            }
        }
        $producto->IdConfiguracionSerie = $model->IdConfiguracionSerie;
        $producto->update();
        
        $model = Productos::find()
            ->where(['IdProducto' => $_REQUEST['IdProducto']])
            ->with('idConfiguracionSerie')
            ->with('idMarca')
            ->asArray()
            ->one();
        
        $model['Marca'] = $model['idMarca']['Descripcion'];
        return json_encode($model);
    }

    public function actionSaveProduccion(){
        
        $data['Producciones'] = $_REQUEST;
        $update = false;
       // exit();
        if ($data['Producciones']['IdSubProceso'] == 9) {
            $data['Producciones']['IdMaquina'] = 1;
            $data['Producciones']['IdCentroTrabajo'] = 1;
        }

        if(!isset($data['Producciones']['IdArea'])){
            $data['Producciones']['IdArea'] = $this->areas->getCurrent();
        }

        if(!isset($data['Producciones']['Fecha'])){
           $data['Producciones']['Fecha'] = date('Y-m-d');
        }
        
        $data['Producciones']['Fecha'] = date('Y-m-d',strtotime($data['Producciones']['Fecha']));

        if(!isset($data['Producciones']['IdCentroTrabajo'])){
            $data['Producciones']['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$_REQUEST['IdMaquina']])->one()->IdCentroTrabajo;
        }
        //echo $data['Producciones']['IdMaquina']; exit();
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

        $model1 = null;
        if($data['Producciones']['IdSubProceso'] != 10){
            $model1 = Producciones::find()->where("Fecha = '".$data['Producciones']['Fecha']."' AND IdSubProceso = ".$data['Producciones']['IdSubProceso']." AND IdMaquina = ". $data['Producciones']['IdMaquina']." AND IdEmpleado = ".$data['Producciones']['IdEmpleado']." AND IdArea = 2 ")->asArray()->one();
        }

        if($model1){
            $datos[0] = $model1;
            $datos[1] = 1;
           // print_r($datos);
            return json_encode($datos);
        }else{
           $model->save();
        }
        
        if($model->IdSubProceso == 10){

            $this->SaveLance($data['Producciones'],$model);
        }
        
        if ($model->IdSubProceso == 18) { // tratamientos 
            //echo "entroo";
            $this->SaveTT($data['Tratamientos'],$model->IdProduccion);
        }
        
        $model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->with('idTratamientosTermicos')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        $datos[0] = $model;
        $datos[1] = 0;
        return json_encode($datos);
    }
    
    function actionCerradoOk(){
        $programacionDia = new ProgramacionesDia();
        $programacionDia->incrementa($_REQUEST['id']);
    }

    function getProduccion($datos){
        
        $model = Producciones::find()->where($datos)->one();
       
        if(is_null($model)){
           // exit();
            $datos['IdArea'] = !isset($datos['IdArea']) ? $this->areas->getCurrent() : $datos['IdArea'];
            $datos['Fecha'] = !isset($datos['Fecha']) ? date('Y-m-d') : date('Y-m-d',strtotime($datos['Fecha']));
            $datos['IdEmpleado'] = !isset($datos['IdEmpleado']) ? Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'] : $datos['IdEmpleado'];
            $datos['IdProduccionEstatus'] = !isset($datos['IdProduccionEstatus']) ? 1 : $datos['IdProduccionEstatus'];
            $datos['IdCentroTrabajo'] = !isset($datos['IdCentroTrabajo']) ? VMaquinas::find()->where(['IdMaquina'=>$datos['IdMaquina']])->one()->IdCentroTrabajo : $datos['IdCentroTrabajo'];
           
            $model = new Producciones();
            $model->load(['Producciones' => $datos]);
            $model->Observaciones = isset($datos['Observaciones']) ? $datos['Observaciones'] : "";
            $model->save();
            $model = Producciones::findOne($model->IdProduccion);
        }
        
        return $model;
    }
    
    function getProduccionDetalle($datos){
        $model = ProduccionesDetalle::find()->where($datos)->one();
        var_dump($model);
        if(is_null($model)){
            if(!isset($datos['Eficiencia'])){
                $datos['Eficiencia'] = 1;
            }
            
            $model = new ProduccionesDetalle();
            $model->load(['ProduccionesDetalle' => $datos]);
            $model->save();
            //var_dump($model);
            $model = ProduccionesDetalle::findOne($model->IdProduccionDetalle);
        }
        return $model;
    }

    function actionSaveVaciado(){
        //var_dump($_REQUEST);exit;
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        $_REQUEST['Inicio'] = isset($_REQUEST['Inicio']) ? $_REQUEST['Inicio'] : '00:00';
        $_REQUEST['Fin'] = isset($_REQUEST['Fin']) ? $_REQUEST['Fin'] : '00:00';
        $_REQUEST['Inicio'] = str_replace('.',':',$_REQUEST['Inicio']);
        $_REQUEST['Fin'] = str_replace('.',':',$_REQUEST['Fin']);
        $_REQUEST['Inicio'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Inicio'];
        $_REQUEST['Fin'] = ($_REQUEST['Fin'] < $_REQUEST['Inicio'] ? $_REQUEST['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_REQUEST['Fecha'])))) . " " . $_REQUEST['Fin'];
        $_REQUEST['Eficiencia'] = isset($_REQUEST['Eficiencia']) ? $_REQUEST['Eficiencia'] : 1;
        $_REQUEST['IdProductos'] = $_REQUEST['IdProducto'];
        
        $produccion = $this->getProduccion([
            'IdProduccion' => $_REQUEST['IdProduccion']
        ]);
                
        $produccionDetalle = $this->getProduccionDetalle([
            'IdProduccion' => $_REQUEST['IdProduccion'],
            'IdProgramacion' => $_REQUEST['IdProgramacion'],
            'IdProductos' => $_REQUEST['IdProducto']
        ]);
        //var_dump($produccionDetalle);exit;

        $series = explode(",", $_REQUEST['Series']);

        foreach ($series as $key => $serie) {
            if ($serie != "") {
                $modelS = Series::find()->where("IdProducto = ".$_REQUEST['IdProducto']." AND IdSerie = ".$serie." AND Estatus = 'B' ")->one();
                if ($modelS != null) {
                    $series = $this->setSeries([
                        'IdProducto' => $_REQUEST['IdProducto'],
                        'IdSubProceso' => 10,
                        'Serie' => $modelS['Serie'],
                        'Estatus' => $_REQUEST['op'] == 0 ? 'R' : 'B',
                        'FechaHora' => date('Y-m-d H:i:s'),
                    ]);

                    if($series != null) {         
                        $seriesD = $this->setSeriesDetalle([
                            'IdProduccionDetalle' => $produccionDetalle['IdProduccionDetalle'],
                            'IdSerie' => $serie,
                            'Estatus' => $_REQUEST['op'] == 0 ? 'R' : 'B',
                        ]);
                    }
                }     
            }
        }
        
        if(isset($_REQUEST['LlevaSerie'])){
            $totalOK = VSeries::find()->select("IdProducto, IdProduccionDetalle, Estatus, count(CASE WHEN Estatus = 'B' THEN IdProduccionDetalle END) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle['IdProduccionDetalle']." AND IdProducto = ".$produccionDetalle['IdProductos']." AND Estatus = 'B'")->groupby("IdProducto, IdProduccionDetalle, Estatus")->asArray()->one();
            $_REQUEST['Hechas'] = is_null($totalOK['Ciclos']) ? 0 : $totalOK['Ciclos'];
            
            $totalRech = VSeries::find()->select("IdProducto, IdProduccionDetalle, Estatus, count(CASE WHEN Estatus = 'R' THEN IdProduccionDetalle END) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle['IdProduccionDetalle']." AND IdProducto = ".$produccionDetalle['IdProductos']." AND Estatus = 'R'")->groupby("IdProducto, IdProduccionDetalle, Estatus")->asArray()->one();
            $_REQUEST['Rechazadas'] = is_null($totalRech['Ciclos']) ? 0 : $totalRech['Ciclos'];
        }else{
            $totalOK = $_REQUEST['Hechas'];
            $totalRech = $_REQUEST['Rechazadas'];
        }

        $produccionDetalle->Hechas = $_REQUEST['Hechas'];
        $produccionDetalle->Rechazadas = $_REQUEST['Rechazadas'];
        $produccionDetalle->update();
        
        $this->actualizaHechas($produccionDetalle,$_REQUEST);
        
        $encabezado = $this->actionGetInventario([
            'Fecha' => $produccion['Fecha'],
            'IdEmpleado' => $produccion['IdEmpleado']
        ]);
        
        $movimiento = $this->actionGetMovimientos([
            'idInventario' => $encabezado->IdInventario,
            'IdCentroTrabajo' => 0,
            'IdProducto' => $produccionDetalle->IdProductos
        ]);
        var_dump($encabezado);
        //Generar Transacciones
       
        return json_encode(
            $produccionDetalle->attributes
        );
    }
    
    /*function actionSaveDetalleAcero(){  
       
        $produccion = $this -> getProduccion($_REQUEST);
        if (isset($produccion['IdProduccion']) != null) {
            $_REQUEST['IdProduccion'] = $produccion['IdProduccion'];
        }
       // var_dump($_REQUEST); exit();

            if(!isset($datos['Fecha'])){
                $datos['Fecha'] = date('Y-m-d');
            }

            $datos['Fecha'] = date('Y-m-d',strtotime($datos['Fecha']));

            if(!isset($datos['IdCentroTrabajo'])){
                $datos['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$datos['IdMaquina']])->one()->IdCentroTrabajo;
            }

            if(!isset($datos['IdMaquina'])){
                $datos['IdMaquina'] = 1;
            }

            if(!isset($datos['IdProduccionEstatus'])){
                $datos['IdProduccionEstatus'] = 1;
            }

            if(!isset($datos['IdEmpleado'])){
                $datos['IdEmpleado'] = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
            }

            if(!isset($datos['Observaciones'])){
                $datos['Observaciones'] = "";
            }

            if(isset($datos['IdProduccion'])){
                $datos['IdProduccion'] *= 1;
                $model = Producciones::findOne($datos['IdProduccion']);
                $update = true;
                if($model->IdSubProceso == 10){
                    $dataLance = json_decode($datos['lances'],true);
                    $dataLance['IdProduccion'] *= 1;
                }
            }else{
                $model = new Producciones();
            }

            $model->load(['Producciones' => $datos]);
            $model->Observaciones = $datos['Observaciones'];
            $r = $update ? $model->update() : $model->save();
            $model = Producciones::find()->where($datos)->one();
        }
        return $model;
    }*/
    function actionSaveDetalleAcero(){
        //exit();
        $data['Producciones'] = json_decode($_REQUEST['Produccion'],true);
        $data['ProduccionesDetalleMoldeo'] = json_decode($_REQUEST['ProduccionesDetalleMoldeo'],true);
        $data['Producciones']['Fecha'] = date('Y-m-d',strtotime($data['Producciones']['Fecha']));
        $data['ProduccionesDetalleMoldeo']['CiclosMoldeA'] *= 1;
        $IdParteMolde = '';
                
        $comentarios = isset($data['ProduccionesDetalleMoldeo']['Comentarios']) ? $data['ProduccionesDetalleMoldeo']['Comentarios'] : '';
        
        //OBETENER PRODUCCION
        $produccion = $this->getProduccion($data['Producciones']);
        $producto = Productos::findOne($data['ProduccionesDetalleMoldeo']['IdProducto']);
        
        //OBETENER DETALLE DE PRODUCCION
        $produccionDetalle = $this->getProduccionDetalle([
            'IdProduccion' => $produccion['IdProduccion'],
            'IdProgramacion' => $data['ProduccionesDetalleMoldeo']['IdProgramacion'],
            'IdProductos' => $data['ProduccionesDetalleMoldeo']['IdProducto']
        ]);
        
        if(($produccion['IdSubProceso'] == 9 || $produccion['IdSubProceso'] == 8) && $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 1){
            $data['ProduccionesDetalleMoldeo']['IdPartesMoldes'] = [];
            $IdParteMolde = $data['ProduccionesDetalleMoldeo']['LlevaSerie'] == 'Si' && $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 1 ? $data['ProduccionesDetalleMoldeo']['IdParteMolde'] : '';
        }
        
        $ProduccionesCiclos = new ProduccionesCiclos();
        
        $cicloGenerado = false;
        $FechaCreacion = date("Y-m-d H:i:s");
        $Tipo = $produccion['IdSubProceso'] != 9 ? 'C' : 'M';
        
        if(!is_array($data['ProduccionesDetalleMoldeo']['IdPartesMoldes'])){
            $data['ProduccionesDetalleMoldeo']['IdPartesMoldes'] = [$data['ProduccionesDetalleMoldeo']['IdPartesMoldes']];
        }

        //var_dump($ProduccionesCiclos);
        foreach ($data['ProduccionesDetalleMoldeo']['IdPartesMoldes'] as $parte) {
            //if ($parte && $produccion['IdSubProceso'] != 17) { Se modifico el dia 9 Nov. 2015 para moldeo especial 
            if ($parte) {
                
                $parte *= 1;
                //GENERAR CICLO
                if($data['ProduccionesDetalleMoldeo']['CiclosMoldeA'] > 1 || $cicloGenerado == false){
                    $ProduccionesCiclos = new ProduccionesCiclos();
                    $ProduccionesCiclos->load([
                        'ProduccionesCiclos' => [
                            'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                            'IdEstatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus'],
                            'Tipo' => $Tipo,
                            'FechaCreacion' => $FechaCreacion,
                            'Linea' => isset($data['ProduccionesDetalleMoldeo']['Linea']) == true ? $data['ProduccionesDetalleMoldeo']['Linea'] : ''
                        ]
                    ]);
                    
                    $cicloGenerado = true;
                }
                
                $ProduccionesCiclos->save();
                //var_dump($ProduccionesCiclos);
                
                $ProduccionesCiclos = ProduccionesCiclos::find()->where([
                    'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                    'IdEstatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus']
                ])->orderBy('IdProduccionCiclos DESC')->one();

                //GENERAR DETALLES DE CICLO
                $ProduccionesCiclosDetalle = new ProduccionesCiclosDetalle();
                
                $ProduccionesCiclosDetalle->load([
                    'ProduccionesCiclosDetalle' => [
                        'IdProduccionCiclos' => $ProduccionesCiclos->IdProduccionCiclos,
                        'IdParteMolde' => $parte
                    ]
                ]);
                
                $ProduccionesCiclosDetalle->save();
                //var_dump($ProduccionesCiclosDetalle);
                
                $model = ProduccionesCiclosDetalle::find()->where([
                    'IdProduccionCiclos' => $ProduccionesCiclos->IdProduccionCiclos,
                    'IdParteMolde' => $parte
                ])->asArray()->one();
                $IdParteMolde = $model['IdParteMolde'] == $data['ProduccionesDetalleMoldeo']['IdParteMolde'] ? $model['IdParteMolde'] : $IdParteMolde;
            }
        }
        //echo "IDPARET MOLDE".$IdParteMolde;

        //// CONTROL DE CICLOS DE CERRADO
        if ($produccion['IdSubProceso'] == 9) {
            if($data['ProduccionesDetalleMoldeo']['CiclosMoldeA'] > 1 || $cicloGenerado == false){
                $ProduccionesCiclos = new ProduccionesCiclos();
                $ProduccionesCiclos->load([
                    'ProduccionesCiclos' => [
                        'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                        'IdEstatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus'],
                        'Tipo' => $Tipo,
                        'FechaCreacion' => $FechaCreacion,
                        'Linea' => isset($data['ProduccionesDetalleMoldeo']['Linea']) == true ? $data['ProduccionesDetalleMoldeo']['Linea'] : ''
                    ]
                ]);   
                $cicloGenerado = true;
            }
            $ProduccionesCiclos->save();
        }

        //if ($produccion['IdSubProceso'] != 17) { Se modifico el dia 9 Nov. 2015 para moldeo especial 
        if ($produccion['IdSubProceso'] != 9) {
            if(($produccion['IdSubProceso'] == 6 || $produccion['IdSubProceso'] == 7 || $produccion['IdSubProceso'] == 17)){
                $totalOK = $ProduccionesCiclos::find()->select("count(IdProduccionDetalle) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle->IdProduccionDetalle." AND IdEstatus = 1")->asArray()->one();
                $produccionDetalle->Hechas = $totalOK['Ciclos'] / $data['ProduccionesDetalleMoldeo']['CiclosMolde'];
            }elseif($data['ProduccionesDetalleMoldeo']['IdEstatus'] == 1){
                $produccionDetalle->Hechas += 1;
            }
          
            $totalREC = $ProduccionesCiclos::find()->select("count(IdProduccionDetalle) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle->IdProduccionDetalle." AND IdEstatus = 3")->asArray()->one();
            //var_dump($totalREC['Ciclos']);exit;
            $produccionDetalle->Rechazadas = $totalREC['Ciclos'] == 0 ? 0 : $totalREC['Ciclos'] / $data['ProduccionesDetalleMoldeo']['CiclosMolde'];

            $produccionDetalle->update();
            //var_dump($produccionDetalle);

        }elseif ($produccion['IdSubProceso'] == 17) {
           /* $produccionDetalle->Hechas =  $produccionDetalle->Hechas*1; 
            $produccionDetalle->Rechazadas = $produccionDetalle->Rechazadas*1;

            $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 1 ? $produccionDetalle->Hechas =  $produccionDetalle->Hechas + 1 :  $produccionDetalle->Rechazadas = $produccionDetalle->Rechazadas + 1;
            $produccionDetalle->update();*/
        }

        //// CONTROL DE SERIES ----->INICIO
        //var_dump("Producto ".$producto->IdParteMolde);
        if($data['ProduccionesDetalleMoldeo']['LlevaSerie'] == 'Si' && $IdParteMolde == $producto->IdParteMolde){
            $IdConfiguracionSerie = $data['ProduccionesDetalleMoldeo']['IdConfiguracionSerie'];
            //echo "entro";
            //if($produccion['IdSubProceso'] == 6  || $produccion['IdSubProceso'] == 17){
            if(($produccion['IdSubProceso'] == 6  || $produccion['IdSubProceso'] == 17) || ($produccion['IdSubProceso'] == 7 && $data['ProduccionesDetalleMoldeo']['IdEstatus'] != 3 )){
                //echo "entro";
                $this->updateConfSeries($IdConfiguracionSerie);
            }

            $estatus = $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 3 ? 'R' : 'B';

            $serie = $this->setSeries([
                'IdProducto' => $data['ProduccionesDetalleMoldeo']['IdProducto'],
                'IdSubProceso' => $produccion['IdSubProceso'],
                'Serie' => $data['ProduccionesDetalleMoldeo']['SerieInicio'],
                'Estatus' => $estatus,
                'FechaHora' => date('Y-m-d G:i:s'),
            ]);
            $serie = $this->setSeriesDetalle([
                'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                'IdSerie' => $serie->IdSerie,
                'Estatus' => $estatus,
                'Comentarios' =>  isset($data['ProduccionesDetalleMoldeo']['Descripcion']) == true ? $data['ProduccionesDetalleMoldeo']['Descripcion'] : ''
            ]);
        }
        
        //// CONTROL DE SERIES -----> FIN
        //var_dump($model);
        exit();
        
        /************************ SE ELIMINA EL CICLO SI ARROJA ERROR LA CAPTURA DE SERIES *********************/
        /*if(isset($resultSerie[0]) == 'E') {
            $produccion = ProduccionesDetalleMoldeo::find()->where(['IdProduccionDetalleMoldeo' => $model['IdProduccionDetalleMoldeo']])->with('idProducto')->with('idProduccion')->asArray()->one();
            $model = ProduccionesDetalleMoldeo::findOne($model['IdProduccionDetalleMoldeo'])->delete();
            $this->actualizaHechas($produccion);
        }*/
        
        if ($data['FechaMoldeo']) {
            $data['FechaMoldeo2'] = date('Y-m-d',strtotime($data['FechaMoldeo2']));
            if(!$fechaMoldeo = FechaMoldeo::find()->where(["IdProducto" => $data["IdProducto"], "FechaMoldeo" => $data["FechaMoldeo2"]])->asArray()->one()){
                $fechaMoldeo = new FechaMoldeo();
                $fechaMoldeo->load([
                    "IdProducto" => $data,
                    "FechaMoldeo" => $data["FechaMoldeo2"]
                ]);
                $fechaMoldeo->save();
                $fechaMoldeo = FechaMoldeo::find()->where(["IdProducto" => $data["IdProducto"], "FechaMoldeo" => $data["FechaMoldeo2"]])->asArray()->one();
            }
            $fechaMoldeoDetalle = new FechaMoldeoDetalle();
            $fechaMoldeoDetalle->load(['FechaMoldeoDetalle'=>[
                "IdProduccionDetalleMoldeo" =>  $model["IdProduccionDetalleMoldeo"]*=1,
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
        return json_encode($model);
    }
    
    function actualizaHechas($produccion,$datos){
       // var_dump($datos);
        $programacionDia = VProgramacionDiaAcero::find()->where([
            'IdProgramacion' => $produccion['IdProgramacion'],
            'Dia' => date('Y-m-d',strtotime($produccion['idProduccion']['Fecha']))
        ])->asArray()->one();
        $diario = $programacionDia;
        
        $programacionDia = ProgramacionesDia::findOne($programacionDia['IdProgramacionDia']);

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

        if($produccion['idProduccion']['IdSubProceso'] == 6){
            $programacionDia->Llenadas = $produccion['idProduccion']['IdSubProceso'] == 6 ? floor($datos['CiclosOkK']/$diario['CiclosMolde']) : 0 ;
            $programacionDia->Cerradas = $datos['CiclosOkC'];
        }
        if($produccion['idProduccion']['IdSubProceso'] == 7){
            $programacionDia->Llenadas = $datos['CiclosOkV']/$diario['CiclosMolde'];
            $programacionDia->Cerradas = $datos['CiclosOkC'];
        }
        if($produccion['idProduccion']['IdSubProceso'] == 17){
            $programacionDia->Llenadas = $datos['CiclosOkE']/$diario['CiclosMolde'];
            $programacionDia->Cerradas = $datos['CiclosOkC'];
        }
        
        if($produccion['idProduccion']['IdSubProceso'] == 10){
            $programacionDia->Vaciadas = $hechas;
            $programacionDia->Hechas = $hechas * $datos['PiezasMolde'];
        }
        
        $programacionDia->save();
        $produccion = new Producciones();
        $produccion->actualizaProduccion($diario);
    }

    function updateConfSeries($IdConfiguracionSerie){
        $configuracion = ConfiguracionSeries::findOne($IdConfiguracionSerie);
        $configuracion->SerieInicio += 1;
        $configuracion->update();
        //var_dump($configuracion);
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
        var_dump($model);
        return $model;
    }
    
    function setSeries2($IdProducto, $IdSubProceso, $serie, $IdProduccion, $IdProgramacion, $estatus,$rechazo,$comentarios){

        if ($rechazo == 1) {
            $estatu = 'R';
        }

        if ($rechazo == 0 || $estatus ==  5) {
            $estatu = 'R';
        }

        $model = array();
        $modelR = array();
        //if(($rechazo == 0 && $estatus == 1 || $estatus == 2 ) || ($rechazo == 0 && $estatus == 3) || ($rechazo == 0 && $estatus == 4)  || ($rechazo == 0 && $estatus == 6) || ($rechazo == 0 && $estatus == 7)){
        if(($rechazo == 0 && $IdSubProceso != 9 && $IdSubProceso != 10  && $estatus == 1 || $estatus == 2 ) || ($rechazo == 0 && $estatus == 3) || ($rechazo == 0 && $estatus == 4) || ($rechazo == 1 && $estatus == 4)){
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
            var_dump($model);
            if ($model == null) {
                return $model[0] = 'ERROR';
            }
        }else{
            $modelR = Series::find()->where("IdProducto = ".$IdProducto." AND Serie = ".$serie." ")->one();
            $modelR->IdSubProceso = $IdSubProceso;

            if ($estatus == 1 || $estatus == 2) {
                $modelR->Estatus = 'B';
            }else{
                 $modelR->Estatus = 'R';
            } 
            $modelR->FechaHora = date("Y-m-d H:i:s");
            $modelR->update();
            
            if ($modelR == null) {
                return $model[0] = 'ERROR';
            }
        }

        if ($model != null || $modelR != null) {
            $this->setSeriesDetalles($serie,$IdProducto,$IdProduccion, $IdProgramacion,$estatus,$comentarios);
        }

        //if (($rechazo == 0  && $estatus == 1 || $estatus == 2) || ($rechazo == 0  && $estatus == 3 || $estatus == 4 || $estatus == 6 || $estatus == 7)) {
        if (($rechazo == 0  && $estatus == 1 && $IdSubProceso != 9 && $IdSubProceso != 10  || $estatus == 2) || ($rechazo == 0  && $estatus == 3) || ($rechazo == 1  && $estatus == 4)) {
            $this->updateConfSeries($_REQUEST['IdConfiguracionSerie'], $_REQUEST['SerieInicio']);
        }   
    }

    function setSeriesDetalles($serie,$IdProducto,$IdProduccion, $IdProgramacion,$estatus,$comentarios){

        $lastId_pd = ProduccionesDetalleMoldeo::find()->where('IdProducto = '.$IdProducto.' AND IdProduccion = '.$IdProduccion.' AND IdProgramacion = '.$IdProgramacion.' ')->orderBy('IdProduccionDetalleMoldeo desc')->one();
        $lastId_se = Series::find()->where(" IdProducto = ".$IdProducto." AND Serie = ".$serie." ")->orderBy('IdSerie desc')->one();

        $model = new SeriesDetalles();
        $model->IdProduccionDetalleMoldeo = $lastId_pd['IdProduccionDetalleMoldeo'];
        $model->IdSerie = $lastId_se['IdSerie']; 
        $model->IdCicloTipo = $estatus;
        $model->Comentarios = $comentarios;
        $model->save();

        //var_dump($model);
    }

    function Series($GET,$rechazo,$parte){
        //************ SERIE DE CICLOS BUENOS **************/
         $resultSerie = '';
        //if ($model['idProductos']['IdParteMolde'] == $parte || $_REQUEST['IdCicloTipo'] == 5 && $_REQUEST['LlevaSerie'] == 'Si' && $_REQUEST['SerieR'] != '' ) {
        if(isset($_REQUEST['Comentarios'])){
            $comentario = $GET['Comentarios'];
        }else{
            $comentario = " ";
        }
        //if ((isset($GET['LlevaSerie']) == 'Si' || $GET['IdParteMoldeCap'] == $parte) || ($GET['IdSubProceso'] == 9)) {
        if (($GET['IdParteMoldeCap'] == $parte) || ($GET['IdSubProceso'] == 9) || ($GET['IdSubProceso'] == 8) || ($GET['SubProceso'] == 9) || ($GET['SubProceso'] == 10) ) {
              echo "entroo00 ".$GET['SerieInicio'];
              $resultSerie = $this->setSeries($GET['IdProducto'], $GET['SubProceso'], $GET['SerieInicio'], $GET['IdProduccion'], $GET['IdProgramacion'],$GET['IdCicloTipo'],$rechazo,$comentario);
        }
        //}
        return $resultSerie;
    }
	
	
    function SaveLance($data,$produccion){
        
        $model = VLances::find()->where([
            'IdArea' => $this->areas->getCurrent()
        ])->orderBy('Colada Desc')->asArray()->one();
        
        //var_dump($model);
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        $data['Fecha'] = date('Y-m-d',strtotime($data['Fecha']));
        
        if(is_null($model)){
            $colada = 1;
            $lance = 1;
        }else{
            $colada = date('Y',strtotime($data['Fecha'])) != date('Y',strtotime($model['Fecha'])) ? 1 : $model['Colada'] + 1;
            $lance = date('Y-m-d',strtotime($data['Fecha'])) != date('Y-m-d',strtotime($model['Fecha'])) ? 1 : $model['Lance'] + 1;
        }

        $maq = Maquinas::findOne($produccion['IdMaquina']);
        
        $dat =[
            'Lances'=>[
                'IdAleacion' => $data['IdAleacion'] *1,
                'IdProduccion' => $produccion['IdProduccion'] *1,
                'HornoConsecutivo' => $maq->Consecutivo * 1,
                'Colada' => $colada,
                'Lance' => $lance,
                'Kellblocks' => isset($data['Kellblocks']) ? $data['Kellblocks'] : '',
                'Lingotes' => isset($data['Lingotes']) ? $data['Lingotes'] : '',
                'Probetas' => isset($data['Probetas']) ? $data['Probetas'] : '',
            ]
        ];
        $lances = new Lances();
        $lances->load($dat);
        $lances->save();
        
        $maq->Consecutivo++;
        $maq->save();
    }

    function actionSaveConsumo(){
        if(!isset($_REQUEST['IdMaterialVaciado'])){
            $model = new MaterialesVaciado();
            $model->load([
                'MaterialesVaciado'=>$_REQUEST
            ]);
        }else{
            $model = MaterialesVaciado::findOne($_REQUEST['IdMaterialVaciado'])->with('idMaterial');
            $model->load([
                'MaterialesVaciado'=>$_REQUEST
            ]);
        }
        if(!$model->save()){
            return false;
        }
        
        return json_encode(
            $model->Attributes
        );
    }

    function deleteConsumo(){
        $model = Producciones::findOne($_REQUEST['IdProduccion'])->delete();
    }

    function actionSaveTemperatura(){
        $_REQUEST['Fecha'] = str_replace('.',':',$_REQUEST['Fecha']);
        $_REQUEST['Fecha'] = $_REQUEST['Fecha2'] . " " . $_REQUEST['Fecha'];
        $_REQUEST['IdMaquina'] *= 1;
        $_REQUEST['IdProduccion'] *= 1;
        $_REQUEST['Temperatura'] *= 1;
        $_REQUEST['Temperatura2'] *= 1;
        
        if(!isset($_REQUEST['IdTemperatura'])){
            $model = new Temperaturas();
            $model->load([
                'Temperaturas'=>$_REQUEST
            ]);
        }else{
            $model = Temperaturas::findOne($_REQUEST['IdTemperatura']);
            if(is_null($model)){
                return false;
            }
            $model->load([
                'Temperaturas'=>$_REQUEST
            ]);
        }
        if(!$model->save()){
            return false;
        }else{
            return $this->actionTemperaturas($model->IdTemperatura);
        }
    }

    function actionSaveTiempoAnalisis(){
        //var_dump($_REQUEST); exit();
        $_REQUEST['Tiempo'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Tiempo'];

        if(!isset($_REQUEST['IdTiempoAnalisis'])){
            $model = new TiempoAnalisis();
            $model->load([
                'TiempoAnalisis'=>$_REQUEST
            ]);
        }else{
            $model = TiempoAnalisis::findOne($_REQUEST['IdTiempoAnalisis']);
            $model->load([
                'TiempoAnalisis'=>$_REQUEST
            ]);
        }
        $model->save();
        var_dump($model);
        if(!$model->save()){
            return false;
        }
        
        return json_encode(
            $model->Attributes
        );
    }

    function actionMantHornos()
    {
        $model = MantenimientoHornos::find()
        ->with('idMaquina')
        ->asArray()
        ->all();
        foreach ($model as $key => $value) {
            $model[$key]['Fecha'] = date('Y-m-d', strtotime($value['Fecha']));
        }
        return json_encode(
            $model
        );
    }


    function actionSaveHornos(){
        $model = new MantenimientoHornos();
        $maquina = \frontend\models\produccion\Maquinas::findOne($_REQUEST['IdMaquina']);
        $_REQUEST['Fecha'] = date('Y-m-d', strtotime($_REQUEST['Fecha']));
        $_REQUEST['Consecutivo'] = $maquina->Consecutivo;
        
        $model->load(['MantenimientoHornos'=>$_REQUEST]);
        $model->save();
        
        //Reiniciar consecutivo
        $maquina->Consecutivo = 1;
        $maquina->update();
    }
	///****************Tratamientos*******************
	
	public function actionTtenfriamientos(){
		$model = TTTipoEnfriamientos::find()->asArray()->all();

	return json_encode($model);
	}
	
	public function actionTratamientos(){
        return $this->CapturaProducciontt(18,2);
    }
	public function actionRevenido(){
        return $this->CapturaProducciontt(20,2);
    }
	public function actionTemple(){
        return $this->CapturaProducciontt(21,2);
    }
	public function actionSolubilizado(){
        return $this->CapturaProducciontt(22,2);
    }
    
	 public function CapturaProducciontt($subProceso,$IdArea,$IdEmpleado = ' ')
    {
        $this->layout = 'produccion';
        
        return $this->render('CapturaProducciontt', [
            'title' => 'Captura de Produccion',
            'IdSubProceso'=> $subProceso,
            'IdArea'=> $IdArea,
            'IdEmpleado' => $IdEmpleado == ' ' ? Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'] : $IdEmpleado,
        ]);
    }

	public function actionSaveTratamientos(){
        
        $update = false;
        $data['Producciones'] = json_decode($_GET['Produccion'],true);
        $data['tratamientos'] = json_decode($_GET['tratamientos'],true);

        //var_dump($data['tratamientos']); exit();

        $anio = date('Y');
        $mes = date('m');
        $fecha_dia = date('Ymd'); 
        $path = "TratamientosTermicos/$anio/$mes/".$data['tratamientos']['Imagen'];
        $IdMaquina = isset( $data['Producciones']['IdMaquina']) ?  $data['Producciones']['IdMaquina']:1;
        $data['tratamientos']['ArchivoGrafica'] = $path;
		$data['Producciones']['IdArea'] =  isset( $data['Producciones']['IdArea'])  ?  $data['Producciones']['IdArea'] :$this->areas->getCurrent();
		$data['Producciones']['IdTurno'] = isset( $data['Producciones']['IdTurno']) ?  $data['Producciones']['IdTurno']:1;
		$data['Producciones']['Fecha'] = isset( $data['Producciones']['Fecha']) ? date('Y-m-d',strtotime( $data['Producciones']['Fecha'])):date('Y-m-d');;
		$data['Producciones']['IdCentroTrabajo'] = isset( $data['Producciones']['IdCentroTrabajo']) ?  $data['Producciones']['IdCentroTrabajo']:VMaquinas::find()->where(['IdMaquina'=> $IdMaquina])->one()->IdCentroTrabajo;
		$data['Producciones']['IdMaquina'] = isset( $data['Producciones']['IdMaquina']) ?  $data['Producciones']['IdMaquina']:1;
		$data['Producciones']['IdProduccionEstatus'] = isset( $data['Producciones']['IdProduccionEstatus']) ?  $data['Producciones']['IdProduccionEstatus']:1;
		$data['Producciones']['IdEmpleado'] = isset( $data['Producciones']['IdEmpleado']) ?  $data['Producciones']['IdEmpleado']:Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
		$data['Producciones']['Observaciones'] = isset( $data['Producciones']['Observaciones']) ?  $data['Producciones']['Observaciones']:"";
		
		if(isset( $data['Producciones']['IdProduccion'])){
            $data['Producciones']['IdProduccion'] *= 1;
            $model = Producciones::findOne( $data['Producciones']['IdProduccion']);
            $update = true;
        }else{
            $model = new Producciones();
        }
		
		$model->load(['Producciones' => $data['Producciones'] ]);
        $r = $update ? $model->update() : $model->save();

        if(isset($data['tratamientos']['IdTratamientoTermico'])){
            $data['tratamientos']['IdTratamientoTermico'] *= 1;
            $tratamientos = TratamientosTermicos::findOne( $data['tratamientos']['IdTratamientoTermico']);
            $update = true;
        }else{
            $data['tratamientos']['idAprobo'] = $data['tratamientos']['idAprobo']['IdEmpleado'];
            $data['tratamientos']['idOperador'] = $data['tratamientos']['idOperador']['IdEmpleado'];
            $data['tratamientos']['idSuperviso']= $data['tratamientos']['idSuperviso']['IdEmpleado'];
            $tratamientos = new TratamientosTermicos();
        }

		$data['tratamientos']['IdProduccion'] = $model->IdProduccion;
		
        $tratamientos->load(['TratamientosTermicos' =>  $data['tratamientos'] ]);
		$r = $update ? $tratamientos->update() : $tratamientos->save();
		var_dump($tratamientos);
      
		$model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->with('idTratamientosTermicos')
            ->asArray()->one();
	  
        return json_encode($model);
    }  
	
	 public function actionDetallett(){
		 
	    $IdProduccion  = $_GET['IdProduccion'];
		 // $model =  VTratamientosTermicos::find()
		 $model =  ProduccionesDetalle::find()
						->where(" IdProduccion = ".$IdProduccion)
						->asArray()
						->all();
						
		   return json_encode($model);
	 }
	 
	 public function actionProductosprogramadostt($fecha){
		 
		$model = VProductosProgramadosTT::find()
						->where(" Fecha > '".$fecha."'")
						->asArray()
						->all();
		 return json_encode($model);
		 
	 }
	 
	 public function actionSaveDetallett(){

		 $datos = [
			 'FechaMoldeo' => $_REQUEST['FechaMoldeo'],
			 'Hechas' => $_REQUEST['Hechas'],
			 'IdProduccion' => $_REQUEST['IdProduccion'],
			 'IdProductos' => $_REQUEST['IdProductos'],
			 'IdProgramacion' => $_REQUEST['IdProgramacion'],
			 'Eficiencia' => $_REQUEST['Eficiencia'],
			 'IdProduccionDetalle' => isset($_REQUEST['IdProduccionDetalle']) ?  $_REQUEST['IdProduccionDetalle'] : 0
		];
		  
		$model = ProduccionesDetalle::find()->where(
						['IdProduccionDetalle' =>$datos['IdProduccionDetalle'] ] 
													)->one();
		
        if(is_null($model)){
			echo 1;
            $model = new ProduccionesDetalle();
            $model->load(['ProduccionesDetalle' => $datos]);
            $model->save();

        }else{
			echo 2;
			$model->load(['ProduccionesDetalle' => $datos]);
			$model->update();
			var_dump($model);
			
		}
        //return $model;
		 
		 
	 }
	 
	 
	 public function actionDeleteDetallett(){
		
		   $model = ProduccionesDetalle::findOne($_REQUEST['IdProduccionDetalle'])->delete();
		 
	 }
	 
	 public function actionSeriestt(){
		 
	    $IdProduccionDetalle  = $_GET['IdProduccionDetalle'];
		 
            $model =  VSeries::find()
            ->where(" IdProduccionDetalle = ".$IdProduccionDetalle)
            ->asArray()
            ->all();
						
            return json_encode($model);
	 }
	 
	 public function actionLseriestt(){
		 
	    $IdProducto  = $_GET['IdProducto'];
		 
            $model =  VSeries::find()
           ->where(" IdProducto = ".$IdProducto)
           ->asArray()
           ->all();
						
            return json_encode($model);
	 }

	public function actionSaveseriestt(){
		 
		  $datos = [
			 'IdSerie' => $_GET['IdSerie'],
			 //'Comentarios' => $_GET['Comentarios'],
			 'IdProduccionDetalle' => $_GET['IdProduccionDetalle'],
			  'IdSeriesDetalles' => isset($_REQUEST['IdSeriesDetalles']) ?  $_REQUEST['IdSeriesDetalles'] : 0
		];
		  
	  
		$model = SeriesDetalles::find()->where(
						['IdSeriesDetalles' =>$datos['IdSeriesDetalles'] ] 
													)->one();
		
        if(is_null($model)){
		
            $model = new SeriesDetalles();
            $model->load(['SeriesDetalles' => $datos]);
            $model->save();
            //$model = SeriesDetalles::findOne($model->IdProduccionDetalle);*/
        }else{
			
			$model->load(['SeriesDetalles' => $datos]);
			$model->update();
			var_dump($model);
			
		}
		 
	 }
	 public function actionDeleteseriestt(){
		
		   $model = SeriesDetalles::findOne(
		  
			[
			   'IdSerie' => $_REQUEST['IdSerie'],
			   'IdProduccionDetalle' => $_REQUEST['IdProduccionDetalle']
			]
		   
		   )->delete();
		 
	 }
	 
	 public function actionProbetastt(){
		 
	    $IdProduccion  = $_GET['IdProduccion'];
		 // $model =  VTratamientosTermicos::find()
		 $model =  TratamientosProbetas::find()
						->where(" idProduccion = ".$IdProduccion)
						->asArray()
						->all();
						
		   return json_encode($model);
	 }
	 
	 public function actionLances(){
	
	  $model = VLances::find()->where([
            'IdArea' => $this->areas->getCurrent()
        ])->orderBy('Colada Desc')->asArray()->all();
	 	
		return json_encode($model);
	 }    
	
	 public function actionSaveprobetadetalle(){	
		$datos = [
			 'IdLance' => $_GET['IdLance'],
			 'Cantidad' => $_GET['Cantidad'],
			 'idProduccion' => $_GET['idProduccion'],
			 'idTratamientoProbetas' => isset($_REQUEST['idTratamientoProbetas']) ?  $_REQUEST['idTratamientoProbetas'] : 0
		];
		
		$model = TratamientosProbetas::find()->where(['idTratamientoProbetas' =>$datos['idTratamientoProbetas']])->one();
		
        if(is_null($model)){
			echo 1;
            $model = new TratamientosProbetas();
            $model->load(['TratamientosProbetas' => $datos]);
            $model->save();
        }else{
			echo 2;
			$model->load(['TratamientosProbetas' => $datos]);
			$model->update();
			var_dump($model);
		}
        //return $model;
	 }
	 
	 public function actionDeleteprobetasdetallett(){
		
		   $model = TratamientosProbetas::findOne($_REQUEST['idTratamientoProbetas'])->delete();
		 
	 }
	 
	 public function actionProbetasvaciado(){
		 
	    $IdProduccion  = $_GET['IdProduccion'];
		 // $model =  VTratamientosTermicos::find()
		 $model =  VProbetas::find()
						->where(" idProduccion = ".$IdProduccion)
						->asArray()
						->all();
						
		   return json_encode($model);
	 }
	 
	 
	  public function actionSaveprobetadetallevaciado(){	
		$datos = [
			 'IdLance' => $_GET['IdLance'],
			 'Cantidad' => $_GET['Cantidad'],
			 //'idProduccion' => $_GET['idProduccion'],
			 'idProbeta' => isset($_REQUEST['idProbeta']) ?  $_REQUEST['idProbeta'] : 0
		];
		
		$model = Probetas::find()->where(['idProbeta' =>$datos['idProbeta']])->one();
		
        if(is_null($model)){
			echo 1;
            $model = new Probetas();
            $model->load(['Probetas' => $datos]);
            $model->save();
        }else{
			echo 2;
			$model->load(['Probetas' => $datos]);
			$model->update();
			var_dump($model);
		}
        //return $model;
	 }
	 
	 public function actionDeleteprobetasdetallevaciado(){
		
		   $model = Probetas::findOne($_REQUEST['IdProbeta'])->delete();
		 
	 }
	 
	 
	 public function actionUploadtt(){

        if ($_FILES) {

            $anio = date('Y');
            $mes = date('m');
            $fecha_dia = date('Ymd'); 

            if(file_exists("frontend/assets/img/TratamientosTermicos/$anio/$mes/") == false){
                mkdir("frontend/assets/img/TratamientosTermicos/$anio/$mes/", 0755, true);
            }

            $path = 'frontend/assets/img/TratamientosTermicos/'.$anio.'/'.$mes.'/';

            $uploadfile = $path . basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
            $data['url'] = $uploadfile;
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['error'] = 'No se pudo subir la imagen';
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode($data);
        }
       
    }
	 
}