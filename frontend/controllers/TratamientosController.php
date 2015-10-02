<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\Producciones;
use frontend\models\tt\TratamientosTermicos;
use frontend\models\tt\TTTipoEnfriamientos;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\programacion\VProgramacionesDia;
use common\models\catalogos\VDefectos;
use common\models\catalogos\Turnos;
use common\models\catalogos\VEmpleados;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Areas;
use frontend\models\produccion\TiemposMuerto;



class TratamientosController extends \yii\web\Controller
{
	
	protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
	
    public function actionNormalizado(){
        return $this->CapturaProduccion(19,2);
    }
	public function actionRevenido(){
        return $this->CapturaProduccion(20,2);
    }
	public function actionTemple(){
        return $this->CapturaProduccion(21,2);
    }
	public function actionSolubilizado(){
        return $this->CapturaProduccion(22,2);
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
	
	
	///----------------------------------------catalogos---------------------------------------------------
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
		
	    public function actionMaquinas($IdSubProceso = '',$IdArea = ''){
        if($IdSubProceso != '' && $IdArea != ''){
            $model = VMaquinas::find()->where([
                'IdSubProceso' => $IdSubProceso*1,
                'IdArea'=>$IdArea,
            ])->asArray()->all();

            return json_encode($model);
        }
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
		
		public function actionTratamientos($IdProduccion){
			
			$model = TratamientosTermicos::find()
							->where([
							'IdProduccion' => $IdProduccion
							])
							->asArray()
							->one();
			return json_encode( $model	);   
		
		}
		
		public function actionTtenfriamientos(){
			$model = TTTipoEnfriamientos::find()->asArray()->all();

        return json_encode($model);
		}
		
		 function actionFindProduccion(){
        $_GET['Fecha'] = date('Y-m-d',strtotime($_GET['Fecha']));
        return json_encode(Producciones::find()->where($_GET)->asArray()->one());
		}
		//----------------------------------------------------------------
		
		
	 public function actionSaveProduccion(){
        $update = false;
		//	var_dump($_GET);exit;
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
           
        }else{
            $model = new Producciones();
        }
        
		$tratamientos=[
			
			'Fecha' => isset( $_GET['Fecha']) ? $_GET['Fecha'] : null,
			'IdMaquina' => isset( $_GET['IdMaquina']) ? $_GET['IdMaquina'] : null,
			'IdEmpleado' => isset( $_GET['IdEmpleado']) ? $_GET['IdEmpleado'] : null,
			'IdTurno' => isset( $_GET['IdTurno'] )  ? $_GET['IdTurno'] : null,
			'IdSubProceso' => isset($_GET['IdSubProceso'])  ? $_GET['IdSubProceso'] : null,
			'IdAleacion' => isset($_GET['IdAleacion'])  ? $_GET['IdAleacion'] : null,
			
			
			'NoTT' => isset( $_GET['NoTT'] )? $_GET['NoTT'] : null  ,
			'HoraInicio' => isset( $_GET['HoraInicio'] )? $_GET['HoraInicio'] : null  ,
			'Horafin' => isset( $_GET['Horafin'] )? $_GET['Horafin'] : null  ,
			'KWFin' => isset( $_GET['KWFin'] )? $_GET['KWFin'] : null  ,
			'KWIni' => isset($_GET['KWIni'] ) ? $_GET['KWIni']: null ,
			'Temp1' => isset( $_GET['Temp1'] ) ? $_GET['Temp1'] : null ,
			'Temp2' => isset( $_GET['Temp2'] )? $_GET['Temp2'] : null ,
			'TempEntradaDeposito' => isset( $_GET['TempEntradaDeposito'] ) ? $_GET['TempEntradaDeposito'] : null   ,
			'TempSalidaDeposito' => isset( $_GET['TempSalidaDeposito'] ) ? $_GET['TempSalidaDeposito'] : null,
			'TempPzDepositoIn' => isset( $_GET['TempPzDepositoIn'] ) ? $_GET['TempPzDepositoIn'] : null ,
			'TempPzDepositoOut' => isset( $_GET['TempPzDepositoOut'] ) ? $_GET['TempPzDepositoOut'] : null,
			'IdTipoEnfriamiento' => isset( $_GET['IdTipoEnfriamiento'] ) ? $_GET['IdTipoEnfriamiento'] : null,
			'TiempoEnfriamiento' => isset( $_GET['TiempoEnfriamiento'] )  ? $_GET['TiempoEnfriamiento'] : null,
	 		'Ecofuel' => isset( $_GET['Ecofuel']) ? $_GET['Ecofuel'] : null,
			'TotalKG' => isset( $_GET['TotalKG'] ) ? $_GET['TotalKG'] : null ,
			'archivoGrafica' => isset( $_GET['archivoGrafica'] )  ? $_GET['archivoGrafica'] : null,
			'idOperador' => isset( $_GET['idOperador'] ) ? $_GET['idOperador'] : null,
			'idAprobo' => isset( $_GET['idAprobo'] ) ? $_GET['idAprobo'] : null ,
			'idSuperviso' => isset( $_GET['idSuperviso'] ) ? $_GET['idSuperviso'] : null,
			
		];
		
		$produccion['Fecha']=$tratamientos['Fecha'];
		$produccion['IdMaquina']=$tratamientos['IdMaquina'];
		$produccion['IdSubProceso']=$tratamientos['IdSubProceso'];
		$produccion['IdAleacion']=$tratamientos['IdAleacion'];
		$produccion['IdCentroTrabajo']=$_GET['IdCentroTrabajo'];
		$produccion['IdEmpleado']=$_GET['IdEmpleado'];
		$produccion['IdProduccion']=isset($_GET['IdProduccion'])? $_GET['IdProduccion']: null;
		$produccion['IdArea']=$_GET['IdArea'] ;
		$produccion['IdProduccionEstatus']= 1*1 ;
		
        $model->load(['Producciones' => $produccion]);
        $model->Observaciones = $_GET['Observaciones'];
        $r = $update ? $model->update() : $model->save();
       
		
        if(!$r){
            var_dump($model);
        }
        
		$tratamientos['IdProduccion'] = $model->IdProduccion;
		$model2 = new TratamientosTermicos;
		$model2->load(['TratamientosTermicos' => $tratamientos]);
		$r2 = $update ? $model2->update() : $model2->save();
		var_dump($model2);
		if(!$r){
            var_dump($model2);
        }
		
        $model = Producciones::find()->where(['IdProduccion'=>$model->IdProduccion])
            ->with('lances')
            ->with('idMaquina')
            ->with('idEmpleado')
            ->asArray()->one();
        
        $model['Fecha'] = date('Y-m-d',strtotime($model['Fecha']));
        
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
	
	public function actionProgramacion(){
        $_GET['Dia'] = date('Y-m-d',strtotime($_GET['Dia']));
        unset($_GET['IdSubProceso']);
        
        $model = VProgramacionesDia::find()->where($_GET)->asArray()->all();
       
        
        
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
  
}


