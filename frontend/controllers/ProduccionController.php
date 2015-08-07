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

use frontend\models\produccion\VCapturaExceleada;
use frontend\models\programacion\VProgramacionesDia;
use common\models\catalogos\VDefectos;
use common\models\catalogos\Maquinas;
use common\models\catalogos\Areas;
use common\models\datos\Causas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Lances;
use common\models\dux\Aleaciones;

class ProduccionController extends \yii\web\Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
    
    public function actionIndex()
    {
        return $this->render('index',[
            'title' => 'Captura de Produccion',
        ]);
    }
    
    public function actionAdd()
    {
        $registro = json_decode(Yii::$app->request->get('row'));
        $grid = Yii::$app->request->get('grid');
        
        $empleado = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        //var_dump($registro);exit;
        
        //Carga los registros de produccion
        $produccion = Producciones::findOne([
            'IdMaquina' => $registro->IdMaquina,
            'IdEmpleado' => $empleado,
            'Fecha' => $registro->Dia,
            'IdSubProceso' => $registro->IdSubProceso,
            'IdArea' => $this->areas->getCurrent(),
        ]);
        $ProduccionesDetalle = new ProduccionesDetalle();
        $programacionDia = ProgramacionesDia::findOne($registro->IdProgramacionDia);
        
        if(count($produccion)==0){
            $produccion = new Producciones();
            $maquina = Maquinas::findOne($registro->IdMaquina)->Attributes;
            
            $data['Producciones']['IdCentroTrabajo'] = $maquina['IdCentroTrabajo'];
            $data['Producciones']['IdMaquina'] = $registro->IdMaquina;
            $data['Producciones']['IdEmpleado'] = $empleado;
            $data['Producciones']['IdProduccionEstatus'] = 1;
            $data['Producciones']['Fecha'] = $registro->Dia;
            $data['Producciones']['IdSubProceso'] = $registro->IdSubProceso;
            $data['Producciones']['IdArea'] = $this->areas->getCurrent();
            $produccion->load($data);
            $produccion->save();
            unset($data);
        }
        //var_dump($produccion);exit;
        //Generar detalle de produccion
        $data['ProduccionesDetalle']['IdProduccion'] = $produccion->IdProduccion;
        $data['ProduccionesDetalle']['IdProgramacion'] = $registro->IdProgramacion;
        $data['ProduccionesDetalle']['IdProductos'] = $registro->IdProducto;
        $data['ProduccionesDetalle']['Inicio'] = date('Y-m-d',strtotime($produccion->Attributes['Fecha']))." ".date('H:i:s');
        $data['ProduccionesDetalle']['Fin'] = date('Y-m-d',strtotime($produccion->Attributes['Fecha']))." ".date('H:i:s');
        $data['ProduccionesDetalle']['CiclosMolde'] = $registro->CiclosMolde == null ? 0 : $registro->CiclosMolde;
        $data['ProduccionesDetalle']['PiezasMolde'] = $registro->PiezasMolde == null ? 0 : $registro->PiezasMolde;
        $data['ProduccionesDetalle']['Programadas'] = $registro->programadasDia;
        
        //Identifica si es rechazo o piezas buenas
        switch(Yii::$app->request->get('grid')){
            case 'detalle':
                //$data['ProduccionesDetalle']['Hechas'] = 1 * $registro->PiezasMolde;
                $data['ProduccionesDetalle']['Hechas'] = 1 * 2;
                break;
            case 'rechazo':
                $data['ProduccionesDetalle']['Rechazadas'] = 1;
                break;
        }
        //var_dump($data);exit;

        $ProduccionesDetalle->load($data);
        $ProduccionesDetalle->save();
        
        //Actualizacion de totales hechos semanales y diarios
        $hechas = 0;
        $ProduccionesDetalle = ProduccionesDetalle::find()->with('idProduccion')->where("IdProgramacion = $registro->IdProgramacion")->asArray()->all();
        
        foreach($ProduccionesDetalle as $detalle){
            if($registro->Dia == date('Y-m-d',strtotime($detalle['idProduccion']['Fecha'])))
                $hechas += ($detalle['Hechas'] - $detalle['Rechazadas']);
        }

        $programacionDia->Hechas = $hechas;
        $programacionDia->save();
        
    }
    
    
    public function actionAddciclos($subProceso){
        $datos = json_decode(Yii::$app->request->get('data'));
        $grid = Yii::$app->request->get('grid');
        
        
        $ciclos = new CiclosVarel();
        
        switch ($datos->op){
            case 1: 
                $ciclos->IdProducto = $datos->IdProducto;
                $ciclos->ParteMolde = $datos->ParteMolde;
                $ciclos->Serie = $datos->Serie;
                $ciclos->Fecha = $datos->fecha;
                $ciclos->Comentarios = $datos->Coment;
                $ciclos->IdSubProceso = $subProceso;       
                $ciclos->IdTurno = $datos->IdTurno;  
                $ciclos->Cantidad = 1;  
                $ciclos->Tipo = 'B';
                break;
            case 2:
                $command = \Yii::$app->db;
                //$ciclos = CiclosVarel::find()->where("IdProducto = ".$datos->IdProducto." AND fecha '$datos->fecha' AND ParteMolde = '$datos->ParteMolde'")->delete();
                $command->createCommand()->delete('CiclosVarel', "IdProducto = ".$datos->IdProducto." AND fecha = '$datos->fecha' AND ParteMolde = '$datos->ParteMolde'")->execute();
                break;
            
        }
        
      
        $ciclos->save();
       // $ciclos = ProduccionesDetalle::find()->where("IdProgramacion = $registro->IdProgramacion")->asArray()->all();
        
        //print_r($datos);
       /* return $this->render('capturaM', [
            'title' => 'Captura de Produccion',
            'ciclos' =>$ciclos,
            'subProceso'=> $subProceso,
        ]);*/
        
       /* return $this->render('capturaM', [
            'title' => 'Captura de Produccion',
            'subProceso'=> $subProceso,
            'idArea'=> $this->areas->getCurrent(),
            'tiempoMuerto' => $tiempoMuerto,
            'detalle'=>$produccionDetalle,
            'IdProduccion'=>''
        ]);*/
    }


    public function actionSave(){
        $datos = json_decode(Yii::$app->request->get('data'));
        
        foreach($datos as $dat){
            $resumen = false;
            
            if(isset($dat->IdProduccion))
                $produccion = Producciones::findOne($dat->IdProduccion);
            
            switch(Yii::$app->request->get('grid')){
                case 'detalle':
                    $model = ProduccionesDetalle::findOne($dat->IdProduccionDetalle);
                    $programacionDia = VProgramacionesDia::find()->where("IdAreaProceso = $produccion->IdAreaProceso AND IdProgramacion = $dat->IdProgramacion AND Dia = '".date('Y-m-d',strtotime($produccion->Fecha))."'")->all();
                    $programacionDia = ProgramacionesDia::findOne($programacionDia[0]->IdProgramacionDia);
                    
                    if($model == null)
                        $model = new ProduccionesDetalle();
                    
                    //registro de la produccion
                    $data['IdProduccion'] = $dat->IdProduccion;
                    $data['IdProgramacion'] = $dat->IdProgramacion;
                    $data['IdProductos'] = $dat->IdProductos;
                    $data['Inicio'] = date('Y-m-d',strtotime($produccion->Attributes['Fecha']))." ".($dat->Inicio == '' ? "00:00" : $dat->Inicio);
                    $data['Fin'] = date('Y-m-d',strtotime($produccion->Attributes['Fecha']))." ".($dat->Fin == '' ? "00:00:00" : $dat->Fin);
                    $data['CiclosMolde'] = $dat->CiclosMolde;
                    $data['PiezasMolde'] = $dat->PiezasMolde;
                    $data['Programadas'] = $dat->Programadas;
                    $data['Hechas'] = $dat->Hechas == '' ? 0 : $dat->Hechas;
                    $data['Rechazadas'] = $dat->Rechazadas == '' ? 0 : $dat->Rechazadas;
                    $data2['ProduccionesDetalle'] = $data;

                    $resumen = true;
                    break;
                case 'material':
                    $model = MaterialesVaciado::findOne($dat->IdMaterialVaciado);
                    
                    if($model == null)
                        $model = new MaterialesVaciado();
                    
                    //registro de la produccion
                    $data['IdMaterialVaciado'] = $dat->IdMaterialVaciado;
                    $data['IdProduccion'] = $dat->IdProduccion;
                    $data['IdMaterial'] = $dat->IdMaterial;
                    $data['Cantidad'] = $dat->Cantidad;
                    $data2['MaterialesVaciado'] = $data;

                    break;
                case 'rechazo':
                    $model = ProduccionesDefecto::findOne($dat->IdProduccionDefecto);

                    if($model == null)
                        $model = new ProduccionesDefecto();

                    $data['IdProduccionDetalle'] = $dat->IdProduccionDetalle;
                    $data['IdDefecto'] = $dat->IdDefecto;
                    $data['Rechazadas'] = $dat->Rechazadas;

                    $data2['ProduccionesDefecto'] = $data;

                    break;
                case 'temperaturas':
                    $model = Temperaturas::findOne($dat->IdProduccion);

                    if($model == null)
                        $model = new Temperaturas();

                    $data['IdProduccion'] = $dat->IdProduccion;
                    $data['IdMaquina'] = $dat->IdMaquina;
                    $data['Fecha'] = $dat->Fecha;
                    $data['Temperatura'] = $dat->Temperatura;
                    $data['Temperatura2'] = $dat->Temperatura2;

                    $data2['Temperaturas'] = $data;

                    break;
                case 'tiempo_muerto':
                    $model = TiemposMuerto::findOne($dat->IdTiempoMuerto);

                    if($model == null)
                        $model = new TiemposMuerto();

                    $data['IdTiempoMuerto'] = $dat->IdTiempoMuerto;
                    $data['IdMaquina'] = $dat->IdMaquina;
                    $data['IdCausa'] = $dat->IdCausa;
                    $data['Inicio'] = date('Y-m-d',strtotime($dat->Fecha))." ".($dat->Inicio == '' ? "00:00" : $dat->Inicio);
                    $data['Fin'] = date('Y-m-d',strtotime($dat->Fecha))." ".($dat->Fin == '' ? "00:00:00" : $dat->Fin);
                    $data['Descripcion'] = $dat->Descripcion;

                    $data2['TiemposMuerto'] = $data;

                    
                    break;
                case 'lances':
                    $model = Vaciados::findOne($dat->IdProduccion);

                    if($model == null)
                        $model = new Vaciados();

                    $data['IdProduccion'] = $dat->IdProduccion;
                    $data['IdAleacion'] = $dat->IdAleacion;
                    $data['Colada'] = $dat->Colada;
                    $data['Lance'] = $dat->Lance;
                    $data['HornoConsecutivo'] = $dat->HornoConsecutivo;

                    $data2['Vaciados'] = $data;

                    break;
            }
            $model->load($data2);
            $model->save();
            
            if($resumen = true){
                //Actualizacion de totales hechos semanales y diarios
                $hechas = 0;
                $ProduccionesDetalle = ProduccionesDetalle::find()->where("IdProduccion = $produccion->IdProduccion AND IdProgramacion = $dat->IdProgramacion")->asArray()->all();
                foreach($ProduccionesDetalle as $detalle){
                    $hechas += $detalle['Hechas'];
                    echo $hechas."<br/>";
                }

                //var_dump($programacionDia);
                $programacionDia->Hechas = $hechas;
                $programacionDia->save();
            }
        }
    }
    
    public function actionDelete(){
        $datos = json_decode(Yii::$app->request->get('data'));
        
        switch(Yii::$app->request->get('grid')){
            case 'detalle':
                $produccion = Producciones::findOne($datos->IdProduccion);
                $model = ProduccionesDetalle::findOne($datos->IdProduccionDetalle)->delete();
                $programacionDia = VProgramacionesDia::find()->where("IdAreaProceso = $produccion->IdAreaProceso AND IdProgramacion = $datos->IdProgramacion AND Dia = '".date('Y-m-d',strtotime($produccion->Fecha))."'")->all();
                $programacionDia = ProgramacionesDia::findOne($programacionDia[0]->IdProgramacionDia);
                
                $totHechas = ProduccionesDetalle::find()->select('sum(Hechas) AS Hechas')->where("IdProduccion = $produccion->IdProduccion AND IdProgramacion = $datos->IdProgramacion")->all();
                $programacionDia->Hechas = $totHechas[0]['Hechas'];
                $programacionDia->save();
                break;
            case 'rechazo':
                $model = ProduccionesDefecto::findOne($datos->IdProduccionDefecto)->delete();
                break;
            case 'temperaturas':
                $model = Temperaturas::findOne($datos->IdTemperatura)->delete();
                break;
            case 'tiempo_muerto':
                $model = TiemposMuerto::findOne($datos->IdTiempoMuerto)->delete();
                break;
        }
    }
    
    public function actionCaptura($subProceso)
    { 
        $this->layout = 'captura';
        $produccion = new Producciones();
        $tiempoMuerto = new TiemposMuerto();
        $produccionDetalle = new ProduccionesDetalle();
        
        $empleado = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        $data = Yii::$app->request->post();
         
        if(count($data) != 0 ){
            if(isset($data['Cerrar'])){
                unset($data['Cerrar']);
                $produccion = $produccion->findOne($data['Producciones']['IdProduccion']);
                $data['Producciones']['IdProduccionEstatus'] = '2';
            }
            if(isset($data['Iniciar'])){
                unset($data['Iniciar']);
                $produccion = new Producciones();
                $maquina = Maquinas::findOne($data['Producciones']['IdMaquina']);
                $IdMaquina = $data['Producciones']['IdMaquina'];
                $data['Producciones']['IdProduccionEstatus'] = '1';
                $data['Producciones']['IdCentroTrabajo'] = $maquina['IdCentroTrabajo'];
                $data['Producciones']['IdEmpleado'] = $empleado;
                $data['Producciones']['IdSubProceso'] = $subProceso;
                $data['Producciones']['IdArea'] = $this->areas->getCurrent();
            }
            
            $produccion->load($data);
            $produccion->save();
            
        }
        //cargando modelos para la captura
        $dataProvider = $produccion->find()->where("IdProduccionEstatus = 1 AND IdArea = ". $this->areas->getCurrent() ." AND IdSubProceso = $subProceso AND IdEmpleado = $empleado")->asArray()->all();
        $produccion = count($dataProvider) > 0 ? $produccion->findOne($dataProvider[0]['IdProduccion']) : $produccion;
                
        if($produccion['IdProduccionEstatus'] == 1 && isset($data['Lances']['IdAleacion']) )
            $this->actionCalculolance ($produccion, $data['Lances']['IdAleacion']);
            
        $lances = $this->actionLances();
        $cons = $this->ConsMaquina($produccion['IdMaquina']);
        
        return $this->render('captura', [
            'title' => 'Captura de Produccion',
            'subProceso'=> $subProceso,
            'tiempoMuerto' => $tiempoMuerto,
            'produccion' => $produccion,
            'detalle'=>$produccionDetalle,
            'lances'=>$lances,
            'cons'=>$cons,
            
        ]);
    }
    
    public function actionAlmas($subProceso)
    {
        $this->layout = 'captura';
        $produccion = new Producciones();
        $tiempoMuerto = new TiemposMuerto();
        $produccionDetalle = new ProduccionesDetalle();
        
        $empleado = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];
        $data = Yii::$app->request->post();
        if(count($data) != 0 ){
            if(isset($data['Cerrar'])){
                unset($data['Cerrar']);
                $produccion = $produccion->findOne($data['Producciones']['IdProduccion']);
                $data['Producciones']['IdProduccionEstatus'] = '2';
            }
            if(isset($data['Iniciar'])){
                unset($data['Iniciar']);
                $produccion = new Producciones();
                $maquina = Maquinas::findOne($data['Producciones']['IdMaquina'])->Attributes;
                
                $data['Producciones']['IdProduccionEstatus'] = '1';
                $data['Producciones']['IdCentroTrabajo'] = $maquina['IdCentroTrabajo'];
                $data['Producciones']['IdEmpleado'] = $empleado;
                $data['Producciones']['IdSubProceso'] = $subProceso;
                $data['Producciones']['IdArea'] = Areas::getCurrent();
            }
            
            $produccion->load($data);
            $produccion->save();
        }
        
        //cargando modelos para la captura
        $dataProvider = $produccion->find()->where("IdProduccionEstatus = 1 AND IdProceso = $proceso AND IdEmpleado = $empleado")->asArray()->all();
        $produccion = count($dataProvider) > 0 ? $produccion->findOne($dataProvider[0]['IdProduccion']) : $produccion;
        
        $lances = $this->actionLances();
        //print_r($produccion);  
        //$cons = $this->actionHornos();
        return $this->render('captura', [
            'title' => 'Captura de Produccion',
            'proceso'=> $proceso,
            'tiempoMuerto' => $tiempoMuerto,
            'produccion' => $produccion,
            'detalle'=>$produccionDetalle,
            'lances'=>$lances,
           // 'cons'=>$cons
        ]);
        
    }
    
    public function actionCaptura2($subProceso)
    {
        $this->layout = 'captura';
        $produccion = new Producciones();
        $tiempoMuerto = new TiemposMuerto();
        $produccionDetalle = new ProduccionesDetalle();
        
        $empleado = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];

        return $this->render('captura2', [
            'title' => 'Captura de Produccion',
            'subProceso'=> $subProceso,
            'idArea'=> $this->areas->getCurrent(),
            'tiempoMuerto' => $tiempoMuerto,
            'detalle'=>$produccionDetalle,
            'IdProduccion'=>''
        ]);
    }
    
    public function actionCapturam($subProceso)
    {
        $this->layout = 'captura';
        $produccion = new Producciones();
        $tiempoMuerto = new TiemposMuerto();
        $produccionDetalle = new ProduccionesDetalle();
        
        $empleado = Yii::$app->user->getIdentity()->getAttributes()['IdEmpleado'];

        return $this->render('capturaM', [
            'title' => 'Captura de Produccion',
            'subProceso'=> $subProceso,
            'idArea'=> $this->areas->getCurrent(),
            'tiempoMuerto' => $tiempoMuerto,
            'detalle'=>$produccionDetalle,
             'ciclos' =>'',
            'IdProduccion'=>''
        ]);
    }
    
    public function actionDetalle(){
        if(isset($_GET['produccion'])){
            $produccion = $_GET['produccion'];
            
            $model = new ProduccionesDetalle();
            
            $dataProvider = $model->getDetalle($produccion);
          // print_r($dataProvider->allModels);exit();
        if(count($dataProvider)>0){
                return json_encode([
                    'total'=>count($dataProvider->allModels),
                    'rows'=>$dataProvider->allModels,
                ]);
            }
        }
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionTemperatura(){
        if(isset($_GET['produccion'])){
            $produccion = $_GET['produccion'];
            
            $model = new Temperaturas();
            
            $dataProvider = $model->getDetalle($produccion);
          // print_r($dataProvider->allModels);exit();
        if(count($dataProvider)>0){
                return json_encode([
                    'total'=>count($dataProvider->allModels),
                    'rows'=>$dataProvider->allModels,
                ]);
            }
        }
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionMaterial(){
        if(isset($_GET['produccion'])){
            $produccion = $_GET['produccion'];
            
            $model = new MaterialesVaciado();
            
            $dataProvider = $model->getDetalle($produccion);
            //var_dump($dataProvider->allModels);exit;
            
            if(count($dataProvider)>0){
                return json_encode([
                    'total'=>count($dataProvider->allModels),
                    'rows'=>$dataProvider->allModels,
                ]);
            }
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionDetalle2(){
            
        if(isset($_GET['IdSubProceso']) && isset($_GET['Dia'])){
            $IdSubProceso = $_GET['IdSubProceso'];
            $Dia = date('Y-m-d',strtotime($_GET['Dia']));
            
            $model = new VCapturaExceleada();
            
            $dataProvider = $model->getDetalle($IdSubProceso,$Dia);
           var_dump($dataProvider);exit;
            if(count($dataProvider)>0){
                return json_encode([
                    'total'=>count($dataProvider->allModels),
                    'rows'=>$dataProvider->allModels,
                ]);
            }
        }
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionRechazo(){
        if(isset($_POST['detalle'])){
            $model = new ProduccionesDefecto();
            $dataProvider = $model->getDefectos($_POST['detalle']);
        
            if(count($dataProvider)>0){
                return json_encode([
                    'total'=>count($dataProvider->allModels),
                    'rows'=>$dataProvider->allModels,
                ]);
            }
        }
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionData_rechazo(){
        $model = new VDefectos();
        $dataProvider = $model->find()->asArray()->all();

        if(count($dataProvider)>0){
            return json_encode($dataProvider);
        }
        return json_encode([
            'total'=>count($dataProvider),
            'rows'=>$dataProvider,
        ]);
    }
    
  
    
    public function actionData_tiempos_muertos(){
        $model = new TiemposMuerto();

        $dataProvider = $model->find()->where("IdMaquina = ".$_GET['IdMaquina']." AND CAST(Inicio AS date) = CAST('".(isset($_GET['Dia']) ? $_GET['Dia'] : date('Y-m-d'))."' AS date)")->with("idCausa")->asArray()->all();
        foreach($dataProvider as &$TiemposMuerto){
            $TiemposMuerto['Causa'] = $TiemposMuerto['idCausa']['Descripcion'];
            $TiemposMuerto['Fecha'] = date('Y-m-d',strtotime($TiemposMuerto['Inicio']));
            $TiemposMuerto['Fin'] = date('H:i:s',strtotime($TiemposMuerto['Fin']));
            $TiemposMuerto['Inicio'] = date('H:i:s',strtotime($TiemposMuerto['Inicio']));
        }
        //var_dump($dataProvider);
        if(count($dataProvider)>0){
            return json_encode($dataProvider);
        }
        return json_encode([
            'total'=>count($dataProvider),
            'rows'=>$dataProvider,
        ]);
    }
    
    public function actionData_causas(){
        $model = new Causas();
        $dataProvider = $model->find()->with('idCausaTipo')->where("IdSubProceso = ".$_GET['IdSubProceso'])->orderBy('IdCausaTipo')->asArray()->all();
        
        foreach($dataProvider as &$causas){
            $causas['Tipo'] = $causas['idCausaTipo']['Descripcion'];
        }
        
        //var_dump($dataProvider);
        if(count($dataProvider)>0){
            return json_encode($dataProvider);
        }
    }
    
    public function actionLances(){
        //$dataProvider = Lances::find()->asArray()->all();
        $lastId_La = Lances::find()->limit('1')->orderBy('IdLance desc')->one();
        return $lastId_La;
    }
    
    public function ConsMaquina($maquina){
        return Maquinas::findOne($maquina);
    }

    
    public function actionCalculolance($datos,$IdAleacion){
      
        $datos_lance = $this->getLastId('lances');
        $datos_prod = $this->getLastId('produccion');
      
        $colada; //Variable que se inicializa cada año en 0
        $time = date('Y-m-d');
        $time_colada = '01-02';
        $time_lance = date("H:i:s");
        
        //Calculo para la colada
        if($time_colada == substr($time, 5)){
            $colada = 1;
        }else{ $colada = $datos_lance['Colada'] + 1; }
        
        //Calculo para los Lances
        if($time == substr($datos_prod['Fecha'], 0,10) && isset($datos_lance['Colada']) ){        
            $lance = $datos_lance['Lance'] + 1;
        }else{
             $lance = 1;
        }
        
        $lances = new Lances();
        $dataProvider = $lances->find()->where("IdProduccion = '".$datos['IdProduccion']."' ")->asArray()->all();
         
        //var_dump($lances); exit;
        if($dataProvider == null){
            $cons = $this->updateMaquina($datos['IdMaquina']);
            $lances = new Lances(); 
            $lances->IdProduccion = $datos['IdProduccion']; 
            $lances->IdAleacion = $IdAleacion;
            $lances->Colada = $colada;
            $lances->Lance = $lance;
            $lances->HornoConsecutivo = $cons['Consecutivo']-1; 
            $lances->save();
           
        }
    }
    
    
    public function updateMaquina($IdMaquina){
        $maquina = Maquinas::findOne($IdMaquina);
        $maquina->Consecutivo = $maquina['Consecutivo'] + 1;
        $maquina->save();
        
        return $maquina;
    }

    public function actionAleaciones(){
        $aleaciones = Aleaciones::find()->asArray()->all();
                 
         return json_encode(
           $aleaciones
        );   
    }
    
    public function actionMaquinas(){
         $maquinas =Maquinas::find()->asArray()->all();
         
         return json_encode(
           $maquinas
        );   
    }
    
    
    public function actionHornos($maquina){
        $command = \Yii::$app->db;
        $cons = $command->createCommand("SELECT Consecutivo FROM Maquinas WHERE IdMaquina = $maquina ")->queryAll();
        
        foreach ($cons as $key) {
            $consecutivo = $key['Consecutivo'];
        }
        
        return $consecutivo;
    }

    
    public function getLastId($id){
        $command = \Yii::$app->db;
        $Datos = array();
        
         if($id == 'produccion')
            $last_id = $command->createCommand("SELECT TOP 2  Fecha FROM Producciones ORDER BY IdProduccion DESC")->queryAll();
                
        if($id == 'lances')
            $last_id = $command->createCommand("SELECT * FROM Lances WHERE IdLance = (SELECT MAX(IdLance) FROM Lances)")->queryAll();
                      
        foreach ($last_id as $key) {
            
            if ($id == 'produccion')
                $Datos['Fecha'] = $key['Fecha'];
            
            if($id=='lances'){                
               $Datos['Colada'] =  $key['Colada'];
               $Datos['Lance'] =  $key['Lance'];
               $Datos['HornoConsecutivo'] = $key['HornoConsecutivo'];
            }
        }
        
        return $Datos;
    }


    public function actionProductosSeries(){


    }

    
    
}

