<?php

namespace frontend\controllers;

use Yii;
use frontend\models\produccion\Producciones;
use common\models\catalogos\VDefectos;
use common\models\catalogos\Turnos;
use common\models\catalogos\VEmpleados;
use common\models\catalogos\VMaquinas;


class TratamientosController extends \yii\web\Controller
{
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
		
		//----------------------------------------------------------------
		
		
  
}
