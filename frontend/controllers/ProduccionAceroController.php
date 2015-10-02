<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\Charpy;
use frontend\models\produccion\Dureza;
use frontend\models\produccion\Probetas;
use frontend\models\produccion\PruebasDestructivas;
use frontend\models\produccion\VLecturasCharpy;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\TiempoAnalisis;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesCiclosDetalle;
use frontend\models\produccion\ProduccionesCiclos;
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
use common\models\catalogos\Turnos;

use frontend\models\tt\TratamientosTermicos;
use frontend\models\tt\TTTipoEnfriamientos;


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
        return $this->CapturaProduccion(10,1);
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
    
    /*
     *    INICIA CODIGO AGREGADO POR IVAN DE SANTIAGO
     */
    
    function actionDataProgramaciones(){
        $_GET['Dia'] = date('Y-m-d',  strtotime($_GET['Dia']));
        $model = VProgramacionesCiclos::find()->where($_GET)->orderBy('Prioridad ASC')->asArray()->all();
        return json_encode($model);
    }
    
    function actionDataProduccion(){
        $_GET['Fecha'] = date('Y-m-d',  strtotime($_GET['Fecha']));
        $model = Producciones::find()->where($_GET)->asArray()->one();
        return json_encode($model);
    }
    
    /*
     *    FINALIZA CODIGO AGREGADO POR IVAN DE SANTIAGO
     */

    public function CapturaProduccion($subProceso, $IdArea, $IdAreaActual = ''){
        $this->layout = 'produccionAceros';
        
        switch ($subProceso){
            case 6: $url = 'CapturaProduccionAcero'; $title = 'Moldeo Kloster';break;
            case 7: $url = 'CapturaProduccionAcero'; $title = 'Moldeo Varel';break;
            case 8: $url = 'CapturaProduccionAcero'; $title = 'Pintado '. ($IdAreaActual == 1 ? 'Kloster' : 'Varel') ;break;
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
            'title' => 'Pruebas de Impacto Charpy',   
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
        $model = ConfiguracionSeries::find()->asArray()->all();
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

    public function actionDataCharpy(){
        $model = VLecturasCharpy::find()->where($_GET)->asArray()->all();
        $i = 1;
        $PromedioLBFT = 0;
        /*foreach ($model as &$key) {
            $PromedioLBFT += $key['ResultadoLBFT']/$i;
            $key['PromedioLBFT'] = $PromedioLBFT;
            $i++;
        }*/

        return json_encode($model);    
    }


    public function actionProduccion(){
        if ( $_GET['IdProduccion']) {
          
        $model = Producciones::find()
                ->where(['IdProduccion' => $_GET['IdProduccion']])
                ->with('lances')
                ->with('idMaquina')
                ->with('idCentroTrabajo')
                ->with('idEmpleado')
                ->with('idTratamientoTermico')
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
        $IdSubProceso = $_POST['IdSubProceso'];
        $IdArea = $_POST['IdArea'];

        $model = Producciones::find()->select("IdProduccion")->where("IdArea = $IdArea AND IdSubProceso = $IdSubProceso")->orderBy('Fecha ASC')->asArray()->all();
        return json_encode(
            $model
        );
    }

    public function actionCountProduccionPruebas(){
        $IdSubProceso = $_GET['IdSubProceso'];
        $IdArea = $this->areas->getCurrent();
        $model = Producciones::find()->select("IdProduccion")->where($_GET)->orderBy('Fecha ASC')->asArray()->all();
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
        $model = VProgramacionDiaAcero::find()->where("Dia = '".$_GET['Dia']."' AND IdArea = ".$_GET['IdArea']." AND IdSubProceso = ".$_GET['IdSubProceso']." ")->asArray()->all();

        foreach ($model as &$value) {
            $detalle = ProduccionesDetalle::find()->where("IdProgramacion = ".$value['IdProgramacion']." AND IdProductos = ".$value['IdProducto']." AND IdProduccion = ".$_GET['IdProduccion']."")->asArray()->one();

            if ($detalle != null) {
                $value['Hechas'] = $detalle['Hechas'];
                $value['IdProduccionDetalle'] = $detalle['IdProduccionDetalle'];
                $value['Rechazadas'] = $detalle['Rechazadas'];
            }else{
                $value['Rechazadas'] = 0;
            }
        }
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }

    public function actionDetalle(){
        //$model = VDetalleProduccion::find()->where($_GET)->asArray()->all();
        $_GET['Dia'] = date('Y-m-d',strtotime($_GET['Dia']));
        $in = '';

        if ($_GET['Dia'] != '' && $_GET['IdArea'] != '' && $_GET['IdArea'] != 'IdProduccion') {
        
            $model = VProgramacionDiaAcero::find()->where("Dia =  '".$_GET['Dia']."' AND IdArea = ".$_GET['IdArea']." AND IdAreaAct = ".$_GET['IdAreaAct']." AND IdSubProceso = ".$_GET['IdSubProceso']." ")->asArray()->all();
            if ($model != null) {
                foreach ($model as &$value ) {
                    $in = '';
                    $produccion = Producciones::find()->where("Fecha = '".$_GET['Dia']."' AND IdArea = ".$_GET['IdArea']." AND IdCentroTrabajo = ".$_GET['IdCentroTrabajo']." AND IdMaquina = ".$_GET['IdMaquina']." AND IdEmpleado = ".$_GET['IdEmpleado']." AND IdSubProceso IN (8,9) ")->asArray()->all();
                    foreach ($produccion as $key) {
                        $in .= "".$key['IdProduccion'].",";
                    }
                    $in .= $_GET['IdProduccion'];

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
        $model = TiemposMuerto::find('IdTiempoMuerto')->where($_GET)->orderBy('Fecha ASC')->asArray()->all();
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
        $IdSubProceso = $_GET['IdSubProceso'];
        $IdArea = $_GET['IdArea'];
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
        if(isset($_GET['IdMaquina'])){
            $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
            $model = TiemposMuerto::find()->where("IdEmpleado = ".$_GET['IdEmpleado']." AND Fecha = '".$_GET['Fecha']."' ")->orderBy('Inicio ASC')->asArray()->all();
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
       // $_GET['Fecha'] = date('Y-m-d'); 
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['Inicio'] = str_replace('.',':',$_GET['Inicio']);
        $_GET['Fin'] = str_replace('.',':',$_GET['Fin']);
        $_GET['Fin'] = ($_GET['Fin'] < $_GET['Inicio'] ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
               // var_dump($_GET); exit();

        if(!isset($_GET['IdTiempoMuerto'])){
            $model = new TiemposMuerto();
            $model->load([
                'TiemposMuerto'=>$_GET
            ]);
        }else{
            $model = TiemposMuerto::findOne($_GET['IdTiempoMuerto']);
            $model->load([
                'TiemposMuerto'=>$_GET
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
        $model = TiemposMuerto::findOne($_GET['IdTiempoMuerto'])->delete();
    }

    public function actionProgramacion(){
		 unset($_GET['IdSubProceso']); // añadido par atratamientos
        $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
        return json_encode($model);
    }

    public function actionPartesMolde(){
        switch ($_GET['IdAreaAct']) {
            case 1: $where = "Identificador IN('TAPA','BASE')"; break;
            case 2: $where = "Identificador IN('TAPA','BASE','C1','C2','C3','C4','C5','C6')"; break;
            case 3: $where = "Identificador IN('TAPA','BASE')"; break;
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

    public function actionMaterial($IdSubProceso){
        $model = Materiales::find()->where([
            'IdSubProceso' => $IdSubProceso,
            'IdArea'=>$this->areas->getCurrent(),
        ])->asArray()->all();
        return json_encode($model);
    }

    public function actionConsumo(){
        if(isset($_GET['IdProduccion'])){
            $model = MaterialesVaciado::find()->where($_GET)->asArray()->all();
            foreach ($model as &$mod){
                $mod['Cantidad'] *=1; 
            }
            return json_encode($model);
        }
    }

    public function actionTemperaturas($IdTemperatura = ''){
        if(isset($_GET['IdProduccion']) || $IdTemperatura != ''){
            $params = $IdTemperatura != '' ? ['IdTemperatura' => $IdTemperatura] : $_GET;
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
        if(isset($_GET['IdProduccion'])){
            $model = TiempoAnalisis::find()->where($_GET)->asArray()->all();

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
    
    

    function SaveColada($data,$produccion){
       var_dump($data); exit();
        $model = VLances::find()->where([
            'IdArea' => $this->areas->getCurrent(),
            'IdMaquina' => $data['IdMaquina']
        ])->orderBy('Colada Desc')->asArray()->one(  );
        
        if(is_null($model)){
            $colada = 1;
            $lance = 1;
        }else{
            $colada = $model['Colada'] + 1;
        }
        if ($data['Cantidad']) {

            $dat =[
                'Lances'=>[
                    'IdAleacion' => $data['IdAleacion'] *1,
                    'IdProduccion' => $produccion['IdProduccion'] *1,
                    'Colada' => $colada,
                    'Lance' => 1,
                    'HornoConsecutivo' => 1,
                ]
            ];
            $lances = new Lances();
            $lances->load($dat);
            $lances->save(); 
        }
        $probetas = $this->setProbetas([
            'IdLance' => $lances['IdLance'],
            'Tipo' => 'Charpy',
            'Cantidad' => 1
        ]);
    }

    public function setProbetas($data){
        //print_r($data);
        $model = Probetas::find()->where([
            'IdLance' => $data['IdLance']
        ])->one();
        if ($model == null) {
            $model = new Probetas();
            $model->load(['Probetas' => $data]);
            $model->save();
        }else{
            $model->Cantidad = $model['Cantidad'] + 1;
            $model->update();
        }
        return $model;
    } 
  
    public function setPruebasDestructivas($data){
        $model = new PruebasDestructivas();
        $model->load(['PruebasDestructivas' => $data]);
        $model->save();
        return $model;
    }

    function actionSaveSerie(){
        $serie = isset($_GET['Serie']) ? $_GET['SerieInicio'] : 0 ;
        $producto = isset($_GET['IdProducto']) ? $_GET['IdProducto'] : 0 ;
        $model = ConfiguracionSeries::find()->where('SerieInicio = '.$serie.' AND IdProducto = '.$producto.'')->asArray()->one();

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
            $data['Producciones']['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$_GET['IdMaquina']])->one()->IdCentroTrabajo;
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

        $model1 = Producciones::find()->where("Fecha = '".$data['Producciones']['Fecha']."' AND IdSubProceso = ".$data['Producciones']['IdSubProceso']." AND IdMaquina = ". $data['Producciones']['IdMaquina']." AND IdEmpleado = ".$data['Producciones']['IdEmpleado']." AND IdArea = 2 ")->asArray()->one();

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
            $materiales = json_decode($this->actionMaterial($model->IdSubProceso));

            foreach($materiales as $material){
                $consumo = new MaterialesVaciado();
                $consumo->IdProduccion = $model->IdProduccion;
                $consumo->IdMaterial = $material->IdMaterial;
                $consumo->Cantidad = 0;
                $consumo->save();
            }
        }

        if ($model->IdSubProceso == 14) {
            //echo "entroo";
            $this->SaveColada($data['Producciones'],$model);
        }
		
		// if ($model->IdSubProceso == 18) { // tratamientos 
            // echo "entroo";
			
            // $this->SaveTT($data['Tratamientos'],$model->IdProduccion);
        // }
        
        $model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->with('idTratamientoTermico')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        $datos[0] = $model;
        $datos[1] = 0;
        return json_encode($datos);
    }
	
	function actionSavePruebas(){


        $data['Producciones'] = json_decode($_GET['Produccion'],true);
        $data['tratamientos'] = json_decode($_GET['PruebasDestructivas'],true);
        //var_dump($data['PruebasDestructivas']);

        

        $tratamientos = new TratamienotsTermicos();
        $tratamientos->load([
            'tratamientos' => [
                
                'Espesor' => $data['PruebasDestructivas']['Espesor'],
                'Ancho' => $data['PruebasDestructivas']['Ancho'],
                'Largo' => $data['PruebasDestructivas']['Largo'],
                'Profundo' => $data['PruebasDestructivas']['Profundo'],
                'Angulo' => $data['PruebasDestructivas']['Angulo'],
                'ResultadoLBFT' => $data['PruebasDestructivas']['ResultadoLBFT'],
                'Temperatura' => $data['PruebasDestructivas']['Temperatura']
            ]
        ]);
        $tratamientos->save();

        if ($data['Producciones']['IdSubProceso'] == 14) {
            $probetas = Probetas::find()->where('IdLance = '.$data['PruebasDestructivas']['IdLance'].'')->one();
            $data['Producciones']['Cantidad'] = $probetas['Cantidad'];
            $data['Producciones']['IdLance'] = $probetas['IdLance'];
            $this->SaveColada($data['Producciones'],$pruebasD);
        }

        return json_encode($charpy);
    }
    
    function actionCerradoOk(){
        $programacionDia = new ProgramacionesDia();
        $programacionDia->incrementa($_GET['id']);
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
        if(is_null($model)){
            if(!isset($datos['Eficiencia'])){
                $datos['Eficiencia'] = 1;
            }
            
            $model = new ProduccionesDetalle();
            $model->load(['ProduccionesDetalle' => $datos]);
            $model->save();
            $model = ProduccionesDetalle::findOne($model->IdProduccionDetalle);
        }
        return $model;
    }

    function actionSaveVaciado(){
        //var_dump($_GET); exit();
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        $_GET['Inicio'] = isset($_GET['Inicio']) ? $_GET['Inicio'] : '00:00';
        $_GET['Fin'] = isset($_GET['Fin']) ? $_GET['Fin'] : '00:00';
        $_GET['Inicio'] = str_replace('.',':',$_GET['Inicio']);
        $_GET['Fin'] = str_replace('.',':',$_GET['Fin']);
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['Fin'] = ($_GET['Fin'] < $_GET['Inicio'] ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
        $_GET['Eficiencia'] = isset($_GET['Eficiencia']) ? $_GET['Eficiencia'] : 1;
        $_GET['IdProductos'] = $_GET['IdProducto'];
      
        $produccionDetalle = $this->getProduccionDetalle([
            'IdProduccion' => $_GET['IdProduccion'],
            'IdProgramacion' => $_GET['IdProgramacion'],
            'IdProductos' => $_GET['IdProducto']
        ]);

        /*$model = new ProduccionesDetalle();
        $IdDetalle = 'ProduccionesDetalle';
        
        if(!isset($_GET['IdProduccionDetalle'])){
            $model->load([
                "$IdDetalle"=>$_GET
            ]);
            $model->save();
        }else{
            $model = $model::findOne($_GET['IdProduccionDetalle']);
            $model->load([
                "$IdDetalle"=>$_GET
            ]);
            $model->update();
        }*/

        $produccionDetalle = ProduccionesDetalle::find()->where(["IdProduccionDetalle" => $produccionDetalle->IdProduccionDetalle])->with('idProductos')->with('idProduccion')->asArray()->one();
   
        //var_dump($produccionDetalle); 
        $this->actualizaHechas($produccionDetalle,$_GET);

        $series = explode(",", $_GET['Series']);

        foreach ($series as $key => $serie) {
            if ($serie != "") {
                $modelS = Series::find()->where("IdProducto = ".$_GET['IdProducto']." AND IdSerie = ".$serie." AND Estatus = 'B' ")->one();
                if ($modelS != null) {
                    /*$modelS->IdSubProceso = $_GET['IdSubProceso'];
                    $modelS->FechaHora = date("Y-m-d H:i:s");
                    if ($_GET['op'] == 0) {
                         $modelS->Estatus = 'R';
                    }else{  $modelS->Estatus = 'B'; }
                    $modelS->update();*/

                        $series = $this->setSeries([
                            'IdProducto' => $_GET['IdProducto'],
                            'IdSubProceso' => $_GET['IdSubProceso'],
                            'Serie' => $modelS['Serie'],
                            'Estatus' => $_GET['op'] == 0 ? 'R' : 'B',
                            'FechaHora' => date('Y-m-d H:i:s'),
                        ]);

                    if ($series != null) {         
                        $seriesD = $this->setSeriesDetalle([
                            'IdProduccionDetalle' => $produccionDetalle['IdProduccionDetalle'],
                            'IdSerie' => $serie,
                            'Estatus' => $_GET['op'] == 0 ? 'R' : 'B',
                        ]);
                    }
                }     
            }
        }

        $totalOK = VSeries::find()->select("IdProducto, IdProduccionDetalle, Estatus, count(CASE WHEN Estatus = 'B' THEN IdProduccionDetalle END) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle['IdProduccionDetalle']." AND IdProducto = ".$produccionDetalle['IdProductos']." AND Estatus = 'B'")->groupby("IdProducto, IdProduccionDetalle, Estatus")->asArray()->one();
        $totalRech = VSeries::find()->select("IdProducto, IdProduccionDetalle, Estatus, count(CASE WHEN Estatus = 'R' THEN IdProduccionDetalle END) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle['IdProduccionDetalle']." AND IdProducto = ".$produccionDetalle['IdProductos']." AND Estatus = 'R'")->groupby("IdProducto, IdProduccionDetalle, Estatus")->asArray()->one();
        //var_dump($totalRech);     
        $model = new ProduccionesDetalle();
        $model = $model::findOne($_GET['IdProduccionDetalle']);
        $model->Hechas = $totalOK['Ciclos'] == null ? 0 : $totalOK['Ciclos'] ;
        $model->Rechazadas = $totalRech['Ciclos'] == null ? 0 : $totalRech['Ciclos'];
        $model->update();
       
        return json_encode(
            $produccionDetalle
        );
    }
    
    /*function actionSaveDetalleAcero(){  
       
        $produccion = $this -> getProduccion($_GET);
        if (isset($produccion['IdProduccion']) != null) {
            $_GET['IdProduccion'] = $produccion['IdProduccion'];
        }
       // var_dump($_GET); exit();

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
        $data['Producciones'] = json_decode($_GET['Produccion'],true);
        $data['ProduccionesDetalleMoldeo'] = json_decode($_GET['ProduccionesDetalleMoldeo'],true);
        $data['Producciones']['Fecha'] = date('Y-m-d',strtotime($data['Producciones']['Fecha']));
        //var_dump($data);exit;
        $comentarios = isset($data['ProduccionesDetalleMoldeo']['Comentarios']) ? $data['ProduccionesDetalleMoldeo']['Comentarios'] : '';
        //print_r($data['ProduccionesDetalleMoldeo']['IdParteMolde']); exit();
        //OBETENER PRODUCCION
        $produccion = $this->getProduccion($data['Producciones']);
        //OBETENER DETALLE DE PRODUCCION
        $produccionDetalle = $this->getProduccionDetalle([
            'IdProduccion' => $produccion['IdProduccion'],
            'IdProgramacion' => $data['ProduccionesDetalleMoldeo']['IdProgramacion'],
            'IdProductos' => $data['ProduccionesDetalleMoldeo']['IdProducto']
        ]);

        foreach ($data['ProduccionesDetalleMoldeo']['IdPartesMoldes'] as $parte) {
            if ($parte) {
                //GENERAR CICLO
                $ProduccionesCiclos = new ProduccionesCiclos();
                $ProduccionesCiclos->load([
                    'ProduccionesCiclos' => [
                        'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                        'IdEstatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus']
                    ]
                ]);
                $ProduccionesCiclos->save();
                
                $ProduccionesCiclos = ProduccionesCiclos::find()->where([
                    'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                    'IdEstatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus']
                ])->one();

                //GENERAR DETALLES DE CICLO
                $ProduccionesCiclosDetalle = new ProduccionesCiclosDetalle();
                $ProduccionesCiclosDetalle->load([
                    'ProduccionesCiclosDetalle' => [
                        'IdProduccionCiclos' => $ProduccionesCiclos->IdProduccionCiclos,
                        'IdParteMolde' => $parte
                    ]
                ]);
                $ProduccionesCiclosDetalle->save();
                
                $totalOK = $ProduccionesCiclos::find()->select("count(IdProduccionDetalle) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle->IdProduccionDetalle." AND IdEstatus <> 3")->asArray()->one();
                $totalREC = $ProduccionesCiclos::find()->select("count(IdProduccionDetalle) AS Ciclos")->where("IdProduccionDetalle = ".$produccionDetalle->IdProduccionDetalle." AND IdEstatus = 3")->asArray()->one();
                
                $produccionDetalle->Hechas = $totalOK['Ciclos'];
                $produccionDetalle->Rechazadas = $totalREC['Ciclos'];
                $produccionDetalle->update();
                $model = ProduccionesCiclosDetalle::find()->where([
                    'IdProduccionCiclos' => $ProduccionesCiclos->IdProduccionCiclos,
                    'IdParteMolde' => $parte
                ])->asArray()->one();
                
                /*if($data['ProduccionesDetalleMoldeo']['IdCicloTipo'] == 1){
                   $this->actualizaHechas($model,$data);
                }*/

                //// CONTROL DE SERIES ----->INICIO
                if ($data['ProduccionesDetalleMoldeo']['LlevaSerie'] == 'Si' && $model['IdParteMolde'] == $data['ProduccionesDetalleMoldeo']['IdParteMolde']) {
                    $IdConfiguracionSerie = $data['ProduccionesDetalleMoldeo']['IdConfiguracionSerie'];
                    
                    if($produccion['IdSubProceso'] == 6 || $produccion['IdSubProceso'] == 7) {
                        //echo "entro";
                        $this->updateConfSeries($IdConfiguracionSerie);
                    }
                    
                    $serie = $this->setSeries([
                        'IdProducto' => $data['ProduccionesDetalleMoldeo']['IdProducto'],
                        'IdSubProceso' => $produccion['IdSubProceso'],
                        'Serie' => $data['ProduccionesDetalleMoldeo']['SerieInicio'],
                        'Estatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 3 ? 'R' : 'B',
                        'FechaHora' => date('Y-m-d G:i:s'),
                    ]);
                    $serie = $this->setSeriesDetalle([
                        'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
                        'IdSerie' => $serie->IdSerie,
                        'Estatus' => $data['ProduccionesDetalleMoldeo']['IdEstatus'] == 3 ? 'R' : 'B',
                        'Comentarios' => $comentarios
                    ]);
                }
                //// CONTROL DE SERIES -----> FIN
            }
        }
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
            'IdSubProceso' => $produccion['idProduccion']['IdSubProceso'],
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
        //var_dump($model);
        $model->save();
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
            $this->updateConfSeries($_GET['IdConfiguracionSerie'], $_GET['SerieInicio']);
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
        //if ($model['idProductos']['IdParteMolde'] == $parte || $_GET['IdCicloTipo'] == 5 && $_GET['LlevaSerie'] == 'Si' && $_GET['SerieR'] != '' ) {
        if(isset($_GET['Comentarios'])){
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
        if(!isset($_GET['IdMaterialVaciado'])){
            $model = new MaterialesVaciado();
            $model->load([
                'MaterialesVaciado'=>$_GET
            ]);
        }else{
            $model = MaterialesVaciado::findOne($_GET['IdMaterialVaciado']);
            $model->load([
                'MaterialesVaciado'=>$_GET
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
        $model = Producciones::findOne($_GET['IdProduccion'])->delete();
    }

    function actionSaveTemperatura(){
        $_GET['Fecha'] = str_replace('.',':',$_GET['Fecha']);
        $_GET['Fecha'] = $_GET['Fecha2'] . " " . $_GET['Fecha'];
        $_GET['IdMaquina'] *= 1;
        $_GET['IdProduccion'] *= 1;
        $_GET['Temperatura'] *= 1;
        $_GET['Temperatura2'] *= 1;
        
        if(!isset($_GET['IdTemperatura'])){
            $model = new Temperaturas();
            $model->load([
                'Temperaturas'=>$_GET
            ]);
        }else{
            $model = Temperaturas::findOne($_GET['IdTemperatura']);
            if(is_null($model)){
                return false;
            }
            $model->load([
                'Temperaturas'=>$_GET
            ]);
        }
        if(!$model->save()){
            return false;
        }else{
            return $this->actionTemperaturas($model->IdTemperatura);
        }
    }

    function actionSaveTiempoAnalisis(){
        //var_dump($_GET); exit();
        $_GET['Tiempo'] = $_GET['Fecha'] . " " . $_GET['Tiempo'];

        if(!isset($_GET['IdTiempoAnalisis'])){
            $model = new TiempoAnalisis();
            $model->load([
                'TiempoAnalisis'=>$_GET
            ]);
        }else{
            $model = TiempoAnalisis::findOne($_GET['IdTiempoAnalisis']);
            $model->load([
                'TiempoAnalisis'=>$_GET
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
        $maquina = \frontend\models\produccion\Maquinas::findOne($_GET['IdMaquina']);
        $_GET['Fecha'] = date('Y-m-d', strtotime($_GET['Fecha']));
        $_GET['Consecutivo'] = $maquina->Consecutivo;
        
        $model->load(['MantenimientoHornos'=>$_GET]);
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
	
	 public function actionNormalizado(){
        return $this->CapturaProducciontt(18,2);
    }
	// public function actionRevenido(){
        // return $this->CapturaProducciontt(20,2);
    // }
	// public function actionTemple(){
        // return $this->CapturaProducciontt(21,2);
    // }
	// public function actionSolubilizado(){
        // return $this->CapturaProducciontt(22,2);
    // }
    
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

        $data['Producciones'] = json_decode($_GET['Produccion'],true);
        $data['tratamientos'] = json_decode($_GET['tratamientos'],true);
        //var_dump($data['PruebasDestructivas']);

		 $data['Producciones']['IdArea'] =  isset( $data['Producciones']['IdArea'])  ?  $data['Producciones']['IdArea'] :$this->areas->getCurrent();
		 $data['Producciones']['IdTurno'] = isset( $data['Producciones']['IdTurno']) ?  $data['Producciones']['IdTurno']:1;
		 $data['Producciones']['Fecha'] = isset( $data['Producciones']['Fecha']) ? date('Y-m-d',strtotime( $data['Producciones']['Fecha'])):date('Y-m-d');;
		 $data['Producciones']['IdCentroTrabajo'] = isset( $data['Producciones']['IdCentroTrabajo']) ?  $data['Producciones']['IdCentroTrabajo']:VMaquinas::find()->where(['IdMaquina'=> $data['Producciones']['IdMaquina']])->one()->IdCentroTrabajo;
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
		var_dump($model);
		$tratamientos['IdProduccion'] = $model->IdProduccion;
		
		$tratamientos = new TratamientosTermicos();
		
        $tratamientos->load(['tratamientos' =>  $data['tratamientos'] ]);
		$r = $update ? $tratamientos->update() : $tratamientos->save();
      
		$model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->with('TratamientosTermicos')
            ->asArray()->one();
	  
        return json_encode($model);
    }

}