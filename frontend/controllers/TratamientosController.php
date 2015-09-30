<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\Producciones;
use frontend\models\tt\TratamientosTermicos;
use frontend\models\tt\TTTipoEnfriamientos;
use common\models\catalogos\VDefectos;
use common\models\catalogos\Turnos;
use common\models\catalogos\VEmpleados;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Areas;



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
		
		public function actionTratamientos($idprod){
			
			$model = TratamientosTermicos::find()
							->where([
							'IdProduccion' => $idprod
							])
							->asArray()
							->all();
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
			
			
			'numTT' => isset( $_GET['numTT'] )? $_GET['numTT'] : null  ,
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
		$produccion['IdProduccion']=$_GET['IdProduccion'];
		$produccion['IdArea']=$_GET['IdArea'] ;
		
        $model->load(['Producciones' => $produccion]);
        $model->Observaciones = $_GET['Observaciones'];
        $r = $update ? $model->update() : $model->save();
            var_dump($tratamientos);var_dump($model);exit;
       
		
        if(!$r){
        }
        

		$model2 = new TratamientosTermicos;
		$model2->load(['TratamientosTermicos' => $tratamientos]);
		$r2 = $update ? $model2->update() : $model2->save();

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
  
}
