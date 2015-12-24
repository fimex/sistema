<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\AlmasProduccionDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\AlmasProduccionDefecto;
use frontend\models\programacion\Programacion;
use frontend\models\produccion\Producciones;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\produccion\MantenimientoHornos;
use frontend\models\produccion\VCapturaExceleada;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\programacion\VProgramacionesAlmaDia;
use frontend\models\programacion\VAlmasRebabeo;
use frontend\models\calidad\ProgramacionesAlmaSemanaUltimo;
use frontend\models\programacion\ProgramacionesAlmaDia;

use common\models\vistas\VAleaciones;
use common\models\catalogos\VDefectos;
use common\models\catalogos\VProduccion2;
use common\models\catalogos\Maquinas;
use common\models\catalogos\CentrosTrabajo;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\VEmpleados;
use common\models\catalogos\SubProcesos;
use common\models\catalogos\Areas;
use common\models\datos\Causas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Lances;
use common\models\vistas\VLances;
use common\models\dux\Aleaciones;
use common\models\catalogos\Turnos;

class AngularController extends \yii\web\Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
    
    /************************************************************
     *                    RUTAS PARA LOS MENUS
     ************************************************************/

    public function actionIndex()
    {
        return $this->render('Pruebas');
    }
    
    public function actionMoldeo()
    {
        return $this->CapturaProduccion(6,3);
    }
    
    public function actionAlmas()
    {
        return $this->CapturaProduccion(2,3);
    }
    
    public function actionAlmasac(){
        return $this->CapturaProduccion(2,2);
    }
	
    public function actionRebabeo(){
        return $this->CapturaProduccion(3,3);
    }
    
    public function actionPintadoac(){
        return $this->CapturaProduccion(4,2);
    }
    
    public function actionVaciado(){
        return $this->CapturaProduccion(10,3);
    }

    public function actionVaciadoAcero()
    {
        return $this->CapturaProduccion(10,2);
    }
    
    public function actionVaciadoAceros()
    {
        return $this->CapturaProduccion(10,2);
    }
    
    public function actionLimpieza()
    {
        return $this->CapturaProduccion(12,3);
    }
    
    public function actionLimpiezaAcero()
    {
        return $this->CapturaProduccion(12,2);
    }
    
    public function actionTratamientosTermicos()
    {
        return $this->CapturaProduccion(19,2);
    }
    
    public function actionPintado()
    {
        return $this->CapturaProduccion(8,2);
    }
    
    public function actionPintadoalm()
    {
        return $this->CapturaProduccion(4,2);
    }
	
    public function actionCerrado()
    {
        return $this->CapturaProduccion(9,2);
    }
    
    public function actionEmpaque()
    {
        return $this->CapturaProduccion(16,3);
    }

    public function actionTiemposmuertos()
    {
        return $this->CapturaTMA(3);
    }

    public function actionMantenimientoHorno()
    {
        $this->layout = 'produccion';
        return $this->render('MantenimientoHornos', [
            'title' => 'Mantenimiento de Hornos'
        ]);
    }
    
    public function CapturaProduccion($subProceso,$IdArea,$IdEmpleado = ' ')
    {
        $this->layout = 'produccion';
        
        return $this->render('CapturaProduccion', [
            'title' => 'Captura de Produccion',
            'IdSubProceso'=> $subProceso,
            'IdArea'=> $IdArea,
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
    
    /************************************************************
     *                    OBTENCION DE DATOS
     ************************************************************/
    
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
    
    public function actionBusqueda(){
        $model = VEmpleados::find()->where("IdEmpleadoEstatus <> 2 $depto"  )->orderBy('NombreCompleto')->asArray()->all();
        
        return json_encode(
            $model
        );   
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
    
    public function actionAleaciones(){
       
        $model = VAleaciones::find()->where(['IdPresentacion' => $this->areas->getCurrent(),])->orderBy('Identificador')->asArray()->all();
        
        foreach($model as &$mod){
            $mod['IdAleacion'] *= 1;
            $mod['IdAleacionTipo'] *= 1;
            $mod['IdPresentacion'] *= 1;
        }
        //var_dump($model);
        return json_encode($model);
    }
    
    public function actionMaterial($IdSubProceso,$IdArea){
        $model = Materiales::find()->where([
            'IdSubProceso' => $IdSubProceso,
            'IdArea'=>$IdArea,
        ])->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCentrosTrabajo(){
        $model = CentrosTrabajo::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }
    
    public function actionMaquinas(){
        if(isset($_REQUEST)){
            $model = VMaquinas::find()->where($_REQUEST)->asArray()->all();
            return json_encode($model);
        }
    }
    
    public function actionCentrosTarabajo($IdSubProceso = '',$IdArea = ''){
        if($IdSubProceso != '' && $IdArea != ''){
            $model = VMaquinas::find()->where([
                'IdSubProceso' => $IdSubProceso*1,
                'IdArea'=>$IdArea,
            ])->asArray()->all();

            return json_encode($model);
        }
    }
    
    public function actionSubprocesos(){
            $model = SubProcesos::find()->asArray()->all();
             return json_encode($model);
    }
	
    public function actionDefectos($IdSubProceso,$IdArea){
        $model = VDefectos::find()->where([
            'IdSubProceso' => $IdSubProceso,
            'IdArea'=>$IdArea,
        ])->asArray()->all();
        
        return json_encode($model);
    }

    public function actionTurnos(){
        $model = Turnos::find()->asArray()->all();

        return json_encode($model);
    }
    
    public function actionProduccion(){
        $busqueda = false;
        if(isset($_REQUEST['IdProduccion'])){
            $where = ['IdProduccion' => $_REQUEST['IdProduccion']];
        }else{
            if(isset($_REQUEST['busqueda'])){
                unset($_REQUEST['busqueda']);
                $busqueda = true;
            }
            $where = $_REQUEST;
        }

            if($busqueda == true){
                $model = Producciones::find()
                    ->leftJoin('Lances','Producciones.IdProduccion = Lances.IdProduccion')
                    //->leftJoin('ProduccionesDetalle','Producciones.IdProduccion = ProduccionesDetalle.IdProduccion')
                    //->leftJoin('AlmasProduccionDetalles','Producciones.IdProduccion = AlmasProduccionDetalles.IdProduccion')
                    ->where($where)
                    ->orderBy($_REQUEST['IdSubProceso'] == 10 ? 'Fecha ASC, Lance ASC' : 'Fecha ASC, Producciones.IdProduccion ASC, IdMaquina Asc')
                    ->with('lances')
                    ->with('idMaquina')
                    ->with('idCentroTrabajo')
                    ->with('idEmpleado')
                    ->with('idTurno')
                    ->with('produccionesDetalles')
                    ->with('almasProduccionDetalles')
                    ->with('idTratamientosTermicos')
                    ->asArray()
                    ->all();
                
                $model2 = [];
                $x=0;
                foreach ($model as &$mod){
                    foreach ($mod['almasProduccionDetalles'] as $alma){
                        $model2[] = [
                            'index' => $x,
                            'IdProduccion' => $mod['IdProduccion'],
                            'Fecha' => date('Y-m-d',strtotime($mod['Fecha'])),
                            'Lance' => isset($mod['lances']['Lance']) ? $mod['lances']['Lance'] : '',
                            'Turno' => $mod['idTurno']['Descripcion'],
                            'Semana' => date('W',strtotime($mod['Fecha'])),
                            'Empleado' => $mod['idEmpleado']['ApellidoPaterno']." ".$mod['idEmpleado']['ApellidoMaterno']." ".$mod['idEmpleado']['Nombre'],
                            'Producto' => $alma['idProducto']['Identificacion']."/".$alma['idAlmaTipo']['Descripcion'],
                            'Maquina' => $mod['idMaquina']['Identificador'],
                            'Hechas' => $alma['Hechas'],
                            'Rechazadas' => $alma['Rechazadas'],
                        ];
                    }
                    
                    foreach ($mod['produccionesDetalles'] as $detalles){
                        $model2[] = [
                            'index' => $x,
                            'IdProduccion' => $mod['IdProduccion'],
                            'Fecha' => date('Y-m-d',strtotime($mod['Fecha'])),
                            'Lance' => isset($mod['lances']['Lance']) ? $mod['lances']['Lance'] : '',
                            'Turno' => $mod['idTurno']['Descripcion'],
                            'Semana' => date('W',strtotime($mod['Fecha'])),
                            'Empleado' => $mod['idEmpleado']['ApellidoPaterno']." ".$mod['idEmpleado']['ApellidoMaterno']." ".$mod['idEmpleado']['Nombre'],
                            'Producto' => $detalles['idProductos']['Identificacion'],
                            'Maquina' => $mod['idMaquina']['Identificador'],
                            'Hechas' => $detalles['Hechas'],
                            'Rechazadas' => $detalles['Rechazadas'],
                        ];
                    }
                    $x++;
                }
                $model = $model2;
            }else{
                $model = Producciones::find()
                    ->where($where)
                    ->with('lances')
                    ->with('idMaquina')
                    ->with('idCentroTrabajo')
                    ->with('idEmpleado')
                    ->with('idTurno')
                    ->with('produccionesDetalles')
                    ->orderBy('Fecha Asc, IdMaquina')
                    ->asArray()
                    ->one();
                $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
                $model['Semana'] = date('W',strtotime($model['Fecha']));
            }
        //}
    
        return json_encode(
            $model
        );
    }
    
    public function actionMantHornos()
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

    
    public function actionCountProduccion(){
        $request = Yii::$app->request;
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = isset($_REQUEST['IdArea']) ? $_REQUEST['IdArea'] : $this->areas->getCurrent();

        $model = Producciones::find()
            ->select("Producciones.IdProduccion")
            ->leftJoin('Lances','Producciones.IdProduccion = Lances.IdProduccion')
            ->where("IdArea = $IdArea AND IdSubProceso = $IdSubProceso")
            ->orderBy($IdSubProceso == 10 ? 'Fecha ASC, Lance ASC' : 'Fecha ASC, Producciones.IdProduccion ASC')
            ->asArray()
            ->all();
        
        return json_encode(
            $model
        );
    }
    
    public function actionDetalle(){
        if(isset($_REQUEST['IdProduccion'])){
            $model = ProduccionesDetalle::find()->where($_REQUEST)
                ->with('idProduccion')
                ->with('idProductos')
                ->asArray()
                ->all();
            
            foreach($model as &$mod){
                $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
                $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
                $mod['Class'] = "";
                $mod['Hechas'] *= 1;
                $mod['Rechazadas'] *= 1;
            }
            return json_encode($model);
        }
    }
    
    public function actionAlmasDetalle(){
        $model = AlmasProduccionDetalle::find()->where($_REQUEST)->with('idProducto')->with('idAlmaTipo')->with('idProduccion')->asArray()->all();
        foreach($model as &$mod){
            $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
            $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
            $mod['Class'] = "";
        }
        return json_encode($model);
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
    
    public function actionRechazos(){
        if(isset($_REQUEST['IdProduccionDetalle']) || isset($_REQUEST['IdAlmaProduccionDetalle'])){
            $model = isset($_REQUEST['IdAlmaProduccionDetalle']) ? AlmasProduccionDefecto::find()->where($_REQUEST)->asArray()->all() : ProduccionesDefecto::find()->where($_REQUEST)->asArray()->all();
            foreach($model as &$mod){
                $mod['Rechazadas'] *= 1;
            }
            return json_encode($model);
        }
    }
    
    public function actionProgramacion(){
        $_REQUEST['Dia'] = date('Y-m-d',strtotime($_REQUEST['Dia']));
        unset($_REQUEST['IdMaquina']);
        
        if($_REQUEST['IdSubProceso'] == 2 || $_REQUEST['IdSubProceso'] == 4){
            unset($_REQUEST['IdSubProceso']);
            unset($_REQUEST['IdTurno']);
            $model = VProgramacionesAlmaDia::find()->where($_REQUEST)->asArray()->all();
        }elseif($_REQUEST['IdSubProceso'] == 3){
            unset($_REQUEST['IdSubProceso']);
            unset($_REQUEST['Dia']);
            unset($_REQUEST['IdTurno']);
            $model = VAlmasRebabeo::find()->where($_REQUEST)->asArray()->all();
        }else{
            unset($_REQUEST['IdSubProceso']);
            $model = VProgramacionesDia::find()->where($_REQUEST)->asArray()->all();
        }
        
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }
    
    public function actionProgramacionEmpaque(){
        $_REQUEST['Dia'] = date('Y-m-d',strtotime($_REQUEST['Dia']));
        
            unset($_REQUEST['IdMaquina']);
        if($_REQUEST['IdSubProceso']==2){
            unset($_REQUEST['IdSubProceso']);
            $model = VProgramacionesAlmaDia::find()->where($_REQUEST)->asArray()->all();
        }else{
            unset($_REQUEST['IdSubProceso']);
            $model = VProgramacionesDia::find()->where($_REQUEST)->asArray()->all();
        }
        
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }
    
    public function actionTiempos(){
        if(isset($_REQUEST['IdMaquina'])){
            $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
            $model = TiemposMuerto::find()->where($_REQUEST)->orderBy('Inicio ASC')->asArray()->all();

            foreach($model as &$mod){
                $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
                $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
            }

            return json_encode($model);
        }
    }
    
    public function actionConsumo(){
        if(isset($_REQUEST['IdProduccion'])){
            $model = MaterialesVaciado::find()->where($_REQUEST)->asArray()->all();
            foreach ($model as &$mod){
                $mod['Cantidad'] *=1; 
            }
            return json_encode($model);
        }
    }
    
    /************************************************************
     *                    FUNCIONES EN GENERAL
     ************************************************************/


    public function actionDeleteProducciones(){
            $almas = AlmasProduccionDetalle::find()->where("IdProduccion = ".$_REQUEST['IdProduccion']." ")->asArray()->all();
            $temperaturas  = Temperaturas::find()->where("IdProduccion = ".$_REQUEST['IdProduccion']." ")->asArray()->all();

        if ($almas == null || $temperaturas == null) {
            $model = Producciones::findOne($_REQUEST['IdProduccion'])->delete();
        }
    }
    
    function actionFindProduccion(){
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        return json_encode(Producciones::find()->where($_REQUEST)->asArray()->one());
    }
    
    public function actionSaveProduccion(){
        $update = false;

        if(!isset($_REQUEST['IdArea'])){
            $_REQUEST['IdArea'] = $this->areas->getCurrent();
        }
        
        if(!isset($_REQUEST['IdTurno'])){
            $_REQUEST['IdTurno'] = 1;
        }

        if(!isset($_REQUEST['Fecha'])){
            $_REQUEST['Fecha'] = date('Y-m-d');
        }
        
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));

        if(!isset($_REQUEST['IdCentroTrabajo'])){
            $_REQUEST['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$_REQUEST['IdMaquina']])->one()->IdCentroTrabajo;
        }
        
        if(!isset($_REQUEST['IdMaquina'])){
            $_REQUEST['IdMaquina'] = 1;
        }
        
        if(!isset($_REQUEST['IdProduccionEstatus'])){
            $_REQUEST['IdProduccionEstatus'] = 1;
        }
        
        if(!isset($_REQUEST['IdEmpleado'])){
            $_REQUEST['IdEmpleado'] = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        }
        
        if(!isset($_REQUEST['Observaciones'])){
            $_REQUEST['Observaciones'] = "";
        }
        
        if(isset($_REQUEST['IdProduccion'])){
            $_REQUEST['IdProduccion'] *= 1;
            $model = Producciones::findOne($_REQUEST['IdProduccion']);
            $update = true;
            if($model->IdSubProceso == 10){
                $dataLance = json_decode($_REQUEST['lances'],true);
                $dataLance['IdProduccion'] *= 1;
            }
        }else{
            $model = new Producciones();
        }
        
        $model->load(['Producciones' => $_REQUEST]);
        $model->Observaciones = $_REQUEST['Observaciones'];
        $r = $update ? $model->update() : $model->save();
        
        if(!$r){
            var_dump($model);
        }
        
        if($model->IdSubProceso == 10){
            if($update == false){
                $this->SaveLance($_REQUEST,$model);
                $materiales = json_decode($this->actionMaterial($model->IdSubProceso, $model->IdArea));

                foreach($materiales as $material){
                    $consumo = new MaterialesVaciado();
                    $consumo->IdProduccion = $model->IdProduccion;
                    $consumo->IdMaterial = $material->IdMaterial;
                    $consumo->Cantidad = 0;
                    $consumo->save();
                }
            }else{
                $lances = Lances::findOne($dataLance['IdLance']);
                $lances->load([
                    'Lances'=> $dataLance
                ]);
                $lances->update();
            }
        }

        $model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idCentroTrabajo')
            ->with('idEmpleado')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        
        return json_encode($model);
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
            ]
        ];
        $lances = new Lances();
        $lances->load($dat);
        $lances->save();
        
        $maq->Consecutivo++;
        $maq->save();
    }
    
    function actionSaveDetalle(){
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        $_REQUEST['Inicio'] = isset($_REQUEST['Inicio']) ? $_REQUEST['Inicio'] : '00:00';
        $_REQUEST['Fin'] = isset($_REQUEST['Fin']) ? $_REQUEST['Fin'] : '00:00';
        $_REQUEST['Inicio'] = str_replace('.',':',$_REQUEST['Inicio']);
        $_REQUEST['Fin'] = str_replace('.',':',$_REQUEST['Fin']);
        $_REQUEST['Inicio'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Inicio'];
        $_REQUEST['Fin'] = (strtotime($_REQUEST['Fin']) >= strtotime($_REQUEST['Inicio']) ? $_REQUEST['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_REQUEST['Fecha'])))) . " " . $_REQUEST['Fin'];
        $_REQUEST['Eficiencia'] = isset($_REQUEST['Eficiencia']) ? $_REQUEST['Eficiencia'] : 1;
        $_REQUEST['CiclosMolde'] *= 1;
        $_REQUEST['Hechas'] *= 1;
        $_REQUEST['Rechazadas'] *= 1;
        //var_dump($_REQUEST);exit;
        $model = new ProduccionesDetalle();
        $IdDetalle = 'ProduccionesDetalle';
        
        if(!isset($_REQUEST['IdProduccionDetalle'])){
            $model->load([
                "$IdDetalle"=>$_REQUEST
            ]);
            $model->save();
        }else{
            $model = $model::findOne($_REQUEST['IdProduccionDetalle']);
            $model->load([
                "$IdDetalle"=>$_REQUEST
            ]);
            $model->update();
            //var_dump($model);
        }
        $model = ProduccionesDetalle::find()->where(["IdProduccionDetalle" => $model->IdProduccionDetalle])->with('idProductos')->with('idProduccion')->asArray()->one();
        $model['Inicio'] = date('H:i',strtotime($model['Inicio']));
        $model['Fin'] = date('H:i',strtotime($model['Fin']));
        $model['Hechas'] *= 1;
        $model['Rechazadas'] *= 1;
        
        $this->actualizaHechas($model);

        return json_encode(
            $model
        );
    }
    
    function actionSaveAlmasDetalle(){
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        $_REQUEST['Inicio'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Inicio'];
        $_REQUEST['PiezasHora'] = isset($_REQUEST['PiezasHora']) ? $_REQUEST['PiezasHora'] : 0;
        $_REQUEST['Fin'] = (strtotime($_REQUEST['Fin']) >= strtotime($_REQUEST['Inicio']) ? $_REQUEST['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_REQUEST['Fecha'])))) . " " . $_REQUEST['Fin'];
        $_REQUEST['Eficiencia'] = isset($_REQUEST['Eficiencia']) ? $_REQUEST['Eficiencia'] : 1;
        $_REQUEST['Hechas'] *= 1;
        $_REQUEST['IdProduccion'] *= 1;
        $_REQUEST['IdProgramacionAlma'] *= 1;
        $_REQUEST['PiezasCaja'] *= 1;
        $_REQUEST['PiezasMolde'] *= 1;
        $_REQUEST['PiezasHora'] = isset($_REQUEST['PiezasHora']) ? $_REQUEST['PiezasHora'] : 0;$_REQUEST['PiezasHora'] *= 1;
        $_REQUEST['Programadas'] *= 1;
        $_REQUEST['Rechazadas'] *= 1;
        //var_dump($_REQUEST);exit;
        $model = new AlmasProduccionDetalle();
        $IdDetalle = 'AlmasProduccionDetalle';
        if(!isset($_REQUEST['IdAlmaProduccionDetalle'])){
            // var_dump($_REQUEST);exit;
            $model->load([
                "$IdDetalle"=>$_REQUEST
            ]);
			// $resp = $model->save();
			// var_dump($resp);
            if(!$model->save()){
                var_dump($model);
                return false;
            }
        }else{
            $model = $model::findOne($_REQUEST['IdAlmaProduccionDetalle']);
            $model->load([
                "$IdDetalle"=>$_REQUEST
            ]);
            if(!$model->update()){
                var_dump($model);
                return false;
            }
        }
        if(!$model->save()){
            var_dump($model);
            return false;
        }
        $model = AlmasProduccionDetalle::find()->where(["IdAlmaProduccionDetalle" => $model->IdAlmaProduccionDetalle])->with('idProducto')->with('idAlmaTipo')->with('idProduccion')->asArray()->one();
        $model['Inicio'] = date('H:i',strtotime($model['Inicio']));
        $model['Fin'] = date('H:i',strtotime($model['Fin']));
        
        //$this->actualizaHechas($model);
        ///Actualizar las hechas en la programacion
        $IdProgramacionAlma = $_GET['IdProgramacionAlma'];
        $Hechas = $_GET['Hechas'];   
        $modelo = ProgramacionesAlmaSemanaUltimo::find()->select('IdProgramacionAlmaSemana')->where(
            "IdProgramacionAlma = ".$IdProgramacionAlma
            )->asArray()->one();
        $IdProgramacionAlmaSemana = $modelo['IdProgramacionAlmaSemana'];

        $mod = new ProgramacionesAlmaDia();
        $mod = $mod::find()->where("IdProgramacionAlmaSemana=".$IdProgramacionAlmaSemana." AND Dia = '".$_GET['Fecha']."'")->one();
        $mod->Hechas = $Hechas;
        $mod->update();
        return json_encode(
            $model
        );
    }
    
    function actionDeleteProduccion(){
        $model = Producciones::findOne($_REQUEST['IdProduccion'])->delete();
    }
    
    function actionDeleteDetalle(){
        $model2 = ProduccionesDetalle::find()->where(['IdProduccionDetalle' => $_REQUEST['IdProduccionDetalle']])->with('idProductos')->with('idProduccion')->asArray()->one();
        //var_dump($model2);exit;
        $model = ProduccionesDetalle::findOne($_REQUEST['IdProduccionDetalle'])->delete();
        $this->actualizaHechas($model2);
    }
    
    function actionDeleteTemperatura(){
        $model2 = Temperaturas::find()->where(['IdTemperatura' => $_REQUEST['IdTemperatura']])->asArray()->one();
        //var_dump($model2);exit;
        $model = Temperaturas::findOne($_REQUEST['IdTemperatura'])->delete();
    }
    
    function actionDeleteAlmasDetalle(){
        $model2 = AlmasProduccionDetalle::find()->where(['IdAlmaProduccionDetalle' => $_REQUEST['IdAlmaProduccionDetalle']])->with('idProducto')->with('idAlmaTipo')->with('idProduccion')->asArray()->one();
        //var_dump($model2);exit;
        $model = AlmasProduccionDetalle::findOne($_REQUEST['IdAlmaProduccionDetalle'])->delete();
        //$this->actualizaHechas($model2);
    }
    
    function actualizaHechas($produccion){
        $where['IdProgramacion'] = $produccion['IdProgramacion'];
        $where['Dia'] = date('Y-m-d',strtotime($produccion['idProduccion']['Fecha']));
        $where['IdTurno'] = $produccion['idProduccion']['IdTurno'];
        
        if($produccion['idProduccion']['IdSubProceso'] == 10){
            //unset($where['IdTurno']);
        }

        $programacionDia = VProgramacionesDia::find()->where($where)->asArray()->one();
        $diario = $programacionDia;
        $programacionDia = ProgramacionesDia::findOne($programacionDia['IdProgramacionDia']);
        $hechas = 0;
        $ProduccionesDetalle = VProduccion2::find()->where([
            'Fecha'=> date('Y-m-d',strtotime($produccion['idProduccion']['Fecha'])),
            'IdProgramacion' => $produccion['IdProgramacion'],
            'IdSubProceso' => $produccion['idProduccion']['IdSubProceso'],
            'IdTurno' => $produccion['idProduccion']['IdTurno'],
        ])->asArray()->all();
        
        foreach($ProduccionesDetalle as $detalle){
            $hechas += $detalle['Hechas'];
            $hechas -= $produccion['idProduccion']['IdSubProceso'] == 6 ? 0 : $detalle['Rechazadas'];
        }
        
        if($produccion['idProduccion']['IdSubProceso'] == 6){
            $programacionDia->Llenadas = $hechas;
        }
        
        if($produccion['idProduccion']['IdSubProceso'] == 10){
            $programacionDia->Vaciadas = $hechas;
            $programacionDia->Hechas = $hechas * $produccion['PiezasMolde'];
        }
        
        $programacionDia->save();
        $produccion = new Producciones();
        $produccion->actualizaProduccion($diario);
        
    }
    
    function actionSaveTiempo(){
        $_REQUEST['Inicio'] = $_REQUEST['Fecha'] . " " . $_REQUEST['Inicio'];
        $_REQUEST['Inicio'] = str_replace('.',':',$_REQUEST['Inicio']);
        $_REQUEST['Fin'] = str_replace('.',':',$_REQUEST['Fin']);
        $_REQUEST['Fin'] = ($_REQUEST['Fin'] > $_REQUEST['Inicio'] ? $_REQUEST['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_REQUEST['Fecha'])))) . " " . $_REQUEST['Fin'];
        
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
    function actionSaveProgramacion(){
        $IdProgramacion = $_REQUEST['IdProgramacion'];
        $IdProgramacionSemana = $_REQUEST['IdProgramacionSemana'];
        $IdProgramacionDia = $_REQUEST['IdProgramacionDia'];
        $Fecha = $_REQUEST['Fecha'];
        
        $Programacion = new Programacion();
        $ProduccionesDetalle = ProduccionesDetalle::find()->where(['IdProgramacion'=>$IdProgramacion,])->with('idProduccion')->asArray()->all();
        
        foreach($ProduccionesDetalle as $detalle){
            
        }
        
        var_dump($totales);exit;
    }
    
    function actionSaveRechazo(){
        if(!isset($_REQUEST['IdProduccionDefecto'])){
            $model = new ProduccionesDefecto();
            $model->load([
                'ProduccionesDefecto'=>$_REQUEST
            ]);
        }else{
            $model = ProduccionesDefecto::findOne($_REQUEST['IdProduccionDefecto']);
            $model->load([
                'ProduccionesDefecto'=>$_REQUEST
            ]);
        }
        $model->IdDefectoTipo = $_REQUEST['IdDefectoTipo'];
        
        if(!$model->save()){
            return false;
        }
        $totalRechazo = ProduccionesDefecto::find()->select('sum(Rechazadas) AS Rechazadas')->where(['IdProduccionDetalle'=>$model->IdProduccionDetalle])->asArray()->one();
        $detalle = ProduccionesDetalle::findOne($model->IdProduccionDetalle);
        $detalle->load([
            'ProduccionesDetalle'=>$totalRechazo
        ]);
        $detalle->save();
        $model->Rechazadas *=1;
        return json_encode(
            $model->Attributes
        );
    }
    function actionDelRechazo(){
        $model = ProduccionesDefecto::findOne($_REQUEST['IdProduccionDefecto']);
        $elimina = ProduccionesDefecto::findOne($_REQUEST['IdProduccionDefecto'])->delete();
        $totalRechazo = ProduccionesDefecto::find()->select('SUM(Rechazadas) AS Rechazadas')->where(['IdProduccionDetalle'=>$model->IdProduccionDetalle])->asArray()->one();
        if($totalRechazo['Rechazadas'] == NULL || $totalRechazo['Rechazadas'] == null || $totalRechazo['Rechazadas'] == "") $totalRechazo['Rechazadas'] = 0;
        $detalle = ProduccionesDetalle::findOne($model->IdProduccionDetalle);
        $detalle->load(['ProduccionesDetalle'=>$totalRechazo]);
        $detalle->save();
    }
    function actionSaveAlmasRechazo(){
        if(!isset($_REQUEST['IdAlmaProduccionDefecto'])){
            $model = new AlmasProduccionDefecto();
            $model->load([
                'AlmasProduccionDefecto'=>$_REQUEST
            ]);
        }else{
            $model = AlmasProduccionDefecto::findOne($_REQUEST['IdAlmaProduccionDefecto']);
            $model->load([
                'AlmasProduccionDefecto'=>$_REQUEST
            ]);
        }
        $model->save();
        
        $model->Rechazadas *=1;
        return json_encode(
            $model->Attributes
        );
    }
    
    function actionTotalRechazo($IdAlmaProduccionDetalle = ''){
        
        $IdAlmaProduccionDetalle = isset($_REQUEST['IdAlmaProduccionDetalle']) ? $_REQUEST['IdAlmaProduccionDetalle'] : $IdAlmaProduccionDetalle;
        
        if($IdAlmaProduccionDetalle != ''){
            $totalRechazo = AlmasProduccionDefecto::find()->select('sum(Rechazadas) AS Rechazadas')->where(['IdAlmaProduccionDetalle'=>$IdAlmaProduccionDetalle])->asArray()->one();
            if($totalRechazo['Rechazadas'] == 0){
                $totalRechazo['Rechazadas'] = 0;
            }

            $detalle = AlmasProduccionDetalle::findOne($IdAlmaProduccionDetalle);
            $detalle->load([
                'AlmasProduccionDetalle'=>$totalRechazo
            ]);
            $detalle->save();
            return $totalRechazo['Rechazadas'];
        }
    }
    
    function actionDeleteAlmaRechazo(){
        if(!isset($_REQUEST['IdAlmaProduccionDefecto'])){
            return false;
        }
        $model = AlmasProduccionDefecto::findOne($_REQUEST['IdAlmaProduccionDefecto']);
        $detalle = $model->IdAlmaProduccionDetalle;
        $model->delete();
        return true;
    }
    
    function actionSaveConsumo(){
        if(!isset($_REQUEST['IdMaterialVaciado'])){
            $model = new MaterialesVaciado();
            $model->load([
                'MaterialesVaciado'=>$_REQUEST
            ]);
        }else{
            $model = MaterialesVaciado::findOne($_REQUEST['IdMaterialVaciado']);
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
    
    function actionDelete(){
        
    }
}