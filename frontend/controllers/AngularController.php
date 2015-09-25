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
use common\models\vistas\VAleaciones;
use common\models\catalogos\VDefectos;
use common\models\catalogos\VProduccion2;
use common\models\catalogos\Maquinas;
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
    
	 public function actionAlmasac()
    {
        return $this->CapturaProduccion(2,2);
    }
	
    public function actionRebabeo()
    {
        return $this->CapturaProduccion(3,3);
    }
	public function actionPintadoac()
    {
        return $this->CapturaProduccion(4,2);
    }
    
    public function actionVaciado()
    {
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
    
    public function actionMaquinas($IdSubProceso = '',$IdArea = ''){
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
        if(isset($_POST['IdProduccion'])){
            $where = ['IdProduccion' => $_POST['IdProduccion']];
        }else{
            if(isset($_POST['busqueda'])){
                unset($_POST['busqueda']);
                $busqueda = true;
            }
            $where = $_POST;
        }

            if($busqueda == true){
                $model = Producciones::find()
                    ->where($where)
                    ->with('lances')
                    ->with('idMaquina')
                    ->with('idCentroTrabajo')
                    ->with('idEmpleado')
                    ->with('idTurno')
                    ->with('produccionesDetalles')
                    ->with('almasProduccionDetalles')
                    ->orderBy('Fecha Asc, IdProduccion ASC, IdMaquina Asc')
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
        $IdSubProceso = $_POST['IdSubProceso'];
        $IdArea = isset($_POST['IdArea']) ? $_POST['IdArea'] : $this->areas->getCurrent();

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
        if(isset($_GET['IdProduccion'])){
            $model = ProduccionesDetalle::find()->where($_GET)
                ->with('idProduccion')
                ->with('idProductos')
                ->asArray()
                ->all();
            
            foreach($model as &$mod){
                $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
                $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
                $mod['Class'] = "";
            }
            return json_encode($model);
        }
    }
    
    public function actionAlmasDetalle(){
        $model = AlmasProduccionDetalle::find()->where($_GET)->with('idProducto')->with('idAlmaTipo')->with('idProduccion')->asArray()->all();
        foreach($model as &$mod){
            $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
            $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
            $mod['Class'] = "";
        }
        return json_encode($model);
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
    
    public function actionRechazos(){
        if(isset($_GET['IdProduccionDetalle']) || isset($_GET['IdAlmaProduccionDetalle'])){
            $model = isset($_GET['IdAlmaProduccionDetalle']) ? AlmasProduccionDefecto::find()->where($_GET)->asArray()->all() : ProduccionesDefecto::find()->where($_GET)->asArray()->all();
            foreach($model as &$mod){
                $mod['Rechazadas'] *= 1;
            }
            return json_encode($model);
        }
    }
    
    public function actionProgramacion(){
        $_GET['Dia'] = date('Y-m-d',strtotime($_GET['Dia']));
        unset($_GET['IdMaquina']);
        
        if($_GET['IdSubProceso'] == 2 || $_GET['IdSubProceso'] == 4){
            unset($_GET['IdSubProceso']);
            unset($_GET['IdTurno']);
            $model = VProgramacionesAlmaDia::find()->where($_GET)->asArray()->all();
        }elseif($_GET['IdSubProceso'] == 3){
            unset($_GET['IdSubProceso']);
            unset($_GET['Dia']);
            unset($_GET['IdTurno']);
            $model = VAlmasRebabeo::find()->where($_GET)->asArray()->all();
        }else{
            $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
        }
        
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }
    
    public function actionProgramacionEmpaque(){
        $_GET['Dia'] = date('Y-m-d',strtotime($_GET['Dia']));
        
            unset($_GET['IdMaquina']);
        if($_GET['IdSubProceso']==2){
            unset($_GET['IdSubProceso']);
            $model = VProgramacionesAlmaDia::find()->where($_GET)->asArray()->all();
        }else{
            unset($_GET['IdSubProceso']);
            $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
        }
        
        
        foreach($model as &$mod){
            $mod['Class'] = "";
        }
        
        return json_encode($model);
    }
    
    public function actionTiempos(){
        if(isset($_GET['IdMaquina'])){
            $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
            $model = TiemposMuerto::find()->where($_GET)->orderBy('Inicio ASC')->asArray()->all();

            foreach($model as &$mod){
                $mod['Inicio'] = date('H:i',strtotime($mod['Inicio']));
                $mod['Fin'] = date('H:i',strtotime($mod['Fin']));
            }

            return json_encode($model);
        }
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
    
    /************************************************************
     *                    FUNCIONES EN GENERAL
     ************************************************************/


    public function actionDeleteProducciones(){
            $almas = AlmasProduccionDetalle::find()->where("IdProduccion = ".$_GET['IdProduccion']." ")->asArray()->all();
            $temperaturas  = Temperaturas::find()->where("IdProduccion = ".$_GET['IdProduccion']." ")->asArray()->all();

        if ($almas == null || $temperaturas == null) {
            $model = Producciones::findOne($_GET['IdProduccion'])->delete();
        }
    }
    
    function actionFindProduccion(){
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        return json_encode(Producciones::find()->where($_GET)->asArray()->one());
    }
    
    public function actionSaveProduccion(){
        $update = false;

        if(!isset($_GET['IdArea'])){
            $_GET['IdArea'] = $this->areas->getCurrent();
        }
        
        if(!isset($_GET['IdTurno'])){
            $_GET['IdTurno'] = 1;
        }

        if(!isset($_GET['Fecha'])){
            $_GET['Fecha'] = date('Y-m-d');
        }
        
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));

        if(!isset($_GET['IdCentroTrabajo'])){
            $_GET['IdCentroTrabajo'] = VMaquinas::find()->where(['IdMaquina'=>$_GET['IdMaquina']])->one()->IdCentroTrabajo;
        }
        
        if(!isset($_GET['IdMaquina'])){
            $_GET['IdMaquina'] = 1;
        }
        
        if(!isset($_GET['IdProduccionEstatus'])){
            $_GET['IdProduccionEstatus'] = 1;
        }
        
        if(!isset($_GET['IdEmpleado'])){
            $_GET['IdEmpleado'] = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        }
        
        if(!isset($_GET['Observaciones'])){
            $_GET['Observaciones'] = "";
        }
        
        if(isset($_GET['IdProduccion'])){
            $_GET['IdProduccion'] *= 1;
            $model = Producciones::findOne($_GET['IdProduccion']);
            $update = true;
            if($model->IdSubProceso == 10){
                $dataLance = json_decode($_GET['lances'],true);
                $dataLance['IdProduccion'] *= 1;
            }
        }else{
            $model = new Producciones();
        }
        
        $model->load(['Producciones' => $_GET]);
        $model->Observaciones = $_GET['Observaciones'];
        $r = $update ? $model->update() : $model->save();
        
        if(!$r){
            var_dump($model);
        }
        
        if($model->IdSubProceso == 10){
            if($update == false){
                $this->SaveLance($_GET,$model);
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
            ->with('idEmpleado')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        
        return json_encode($model);
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
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        $_GET['Inicio'] = isset($_GET['Inicio']) ? $_GET['Inicio'] : '00:00';
        $_GET['Fin'] = isset($_GET['Fin']) ? $_GET['Fin'] : '00:00';
        $_GET['Inicio'] = str_replace('.',':',$_GET['Inicio']);
        $_GET['Fin'] = str_replace('.',':',$_GET['Fin']);
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['Fin'] = (strtotime($_GET['Fin']) >= strtotime($_GET['Inicio']) ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
        $_GET['Eficiencia'] = isset($_GET['Eficiencia']) ? $_GET['Eficiencia'] : 1;
        //var_dump($_GET);exit;
        $model = new ProduccionesDetalle();
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
        }
        $model = ProduccionesDetalle::find()->where(["IdProduccionDetalle" => $model->IdProduccionDetalle])->with('idProductos')->with('idProduccion')->asArray()->one();
        $model['Inicio'] = date('H:i',strtotime($model['Inicio']));
        $model['Fin'] = date('H:i',strtotime($model['Fin']));
        
        $this->actualizaHechas($model);

        return json_encode(
            $model
        );
    }
    
    function actionSaveAlmasDetalle(){
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['PiezasHora'] = isset($_GET['PiezasHora']) ? $_GET['PiezasHora'] : 0;
        $_GET['Fin'] = (strtotime($_GET['Fin']) >= strtotime($_GET['Inicio']) ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
        $_GET['Eficiencia'] = isset($_GET['Eficiencia']) ? $_GET['Eficiencia'] : 1;
        $_GET['Hechas'] *= 1;
        $_GET['IdProduccion'] *= 1;
        $_GET['IdProgramacionAlma'] *= 1;
        $_GET['PiezasCaja'] *= 1;
        $_GET['PiezasMolde'] *= 1;
        $_GET['PiezasHora'] = isset($_GET['PiezasHora']) ? $_GET['PiezasHora'] : 0;$_GET['PiezasHora'] *= 1;
        $_GET['Programadas'] *= 1;
        $_GET['Rechazadas'] *= 1;
        //var_dump($_GET);exit;
        $model = new AlmasProduccionDetalle();
        $IdDetalle = 'AlmasProduccionDetalle';
        if(!isset($_GET['IdAlmaProduccionDetalle'])){
        // var_dump($_GET);exit;
            $model->load([
                "$IdDetalle"=>$_GET
            ]);
			// $resp = $model->save();
			// var_dump($resp);
            if(!$model->save()){
                var_dump($model);
                return false;
            }
        }else{
            $model = $model::findOne($_GET['IdAlmaProduccionDetalle']);
            $model->load([
                "$IdDetalle"=>$_GET
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
        
        return json_encode(
            $model
        );
    }
    
    function actionDeleteProduccion(){
        $model = Producciones::findOne($_GET['IdProduccion'])->delete();
    }
    
    function actionDeleteDetalle(){
        $model2 = ProduccionesDetalle::find()->where(['IdProduccionDetalle' => $_GET['IdProduccionDetalle']])->with('idProductos')->with('idProduccion')->asArray()->one();
        //var_dump($model2);exit;
        $model = ProduccionesDetalle::findOne($_GET['IdProduccionDetalle'])->delete();
        $this->actualizaHechas($model2);
    }
    
    function actionDeleteTemperatura(){
        $model2 = Temperaturas::find()->where(['IdTemperatura' => $_GET['IdTemperatura']])->asArray()->one();
        //var_dump($model2);exit;
        $model = Temperaturas::findOne($_GET['IdTemperatura'])->delete();
    }
    
    function actionDeleteAlmasDetalle(){
        $model2 = AlmasProduccionDetalle::find()->where(['IdAlmaProduccionDetalle' => $_GET['IdAlmaProduccionDetalle']])->with('idProducto')->with('idAlmaTipo')->with('idProduccion')->asArray()->one();
        //var_dump($model2);exit;
        $model = AlmasProduccionDetalle::findOne($_GET['IdAlmaProduccionDetalle'])->delete();
        //$this->actualizaHechas($model2);
    }
    
    function actualizaHechas($produccion){
        $where['IdProgramacion'] = $produccion['IdProgramacion'];
        $where['Dia'] = date('Y-m-d',strtotime($produccion['idProduccion']['Fecha']));
        $where['IdTurno'] = $produccion['idProduccion']['IdTurno'];
        
        if($produccion['idProduccion']['IdSubProceso'] == 10){
            unset($where['IdTurno']);
        }

        $programacionDia = VProgramacionesDia::find()->where($where)->asArray()->all();
        $diario = $programacionDia[0];
        $programacionDia = ProgramacionesDia::findOne($programacionDia[0]['IdProgramacionDia']);
        
        $hechas = 0;
        $ProduccionesDetalle = VProduccion2::find()->where([
            'Fecha'=> date('Y-m-d',strtotime($produccion['idProduccion']['Fecha'])),
            'IdProgramacion' => $produccion['IdProgramacion'],
            'IdSubProceso' => $produccion['idProduccion']['IdSubProceso'],
        ])->asArray()->all();
        
        //var_dump($programacionDia);exit;
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
        $_GET['Inicio'] = $_GET['Fecha'] . " " . $_GET['Inicio'];
        $_GET['Inicio'] = str_replace('.',':',$_GET['Inicio']);
        $_GET['Fin'] = str_replace('.',':',$_GET['Fin']);
        $_GET['Fin'] = ($_GET['Fin'] > $_GET['Inicio'] ? $_GET['Fecha'] : date('Y-m-d',strtotime( '+1 day' ,strtotime($_GET['Fecha'])))) . " " . $_GET['Fin'];
        
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
    function actionSaveProgramacion(){
        $IdProgramacion = $_GET['IdProgramacion'];
        $IdProgramacionSemana = $_GET['IdProgramacionSemana'];
        $IdProgramacionDia = $_GET['IdProgramacionDia'];
        $Fecha = $_GET['Fecha'];
        
        $Programacion = new Programacion();
        $ProduccionesDetalle = ProduccionesDetalle::find()->where(['IdProgramacion'=>$IdProgramacion,])->with('idProduccion')->asArray()->all();
        
        foreach($ProduccionesDetalle as $detalle){
            
        }
        
        var_dump($totales);exit;
    }
    
    function actionSaveRechazo(){
        if(!isset($_GET['IdProduccionDefecto'])){
            $model = new ProduccionesDefecto();
            $model->load([
                'ProduccionesDefecto'=>$_GET
            ]);
        }else{
            $model = ProduccionesDefecto::findOne($_GET['IdProduccionDefecto']);
            $model->load([
                'ProduccionesDefecto'=>$_GET
            ]);
        }
        $model->IdDefectoTipo = $_GET['IdDefectoTipo'];
        
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
        $model = ProduccionesDefecto::findOne($_GET['IdProduccionDefecto']);
        $elimina = ProduccionesDefecto::findOne($_GET['IdProduccionDefecto'])->delete();
        $totalRechazo = ProduccionesDefecto::find()->select('SUM(Rechazadas) AS Rechazadas')->where(['IdProduccionDetalle'=>$model->IdProduccionDetalle])->asArray()->one();
        if($totalRechazo['Rechazadas'] == NULL || $totalRechazo['Rechazadas'] == null || $totalRechazo['Rechazadas'] == "") $totalRechazo['Rechazadas'] = 0;
        $detalle = ProduccionesDetalle::findOne($model->IdProduccionDetalle);
        $detalle->load(['ProduccionesDetalle'=>$totalRechazo]);
        $detalle->save();
    }
    function actionSaveAlmasRechazo(){
        if(!isset($_GET['IdAlmaProduccionDefecto'])){
            $model = new AlmasProduccionDefecto();
            $model->load([
                'AlmasProduccionDefecto'=>$_GET
            ]);
        }else{
            $model = AlmasProduccionDefecto::findOne($_GET['IdAlmaProduccionDefecto']);
            $model->load([
                'AlmasProduccionDefecto'=>$_GET
            ]);
        }
        $model->save();
        
        $model->Rechazadas *=1;
        return json_encode(
            $model->Attributes
        );
    }
    
    function actionTotalRechazo($IdAlmaProduccionDetalle = ''){
        
        $IdAlmaProduccionDetalle = isset($_GET['IdAlmaProduccionDetalle']) ? $_GET['IdAlmaProduccionDetalle'] : $IdAlmaProduccionDetalle;
        
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
        if(!isset($_GET['IdAlmaProduccionDefecto'])){
            return false;
        }
        $model = AlmasProduccionDefecto::findOne($_GET['IdAlmaProduccionDefecto']);
        $detalle = $model->IdAlmaProduccionDetalle;
        $model->delete();
        return true;
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
    
    function actionDelete(){
        
    }
}