<?php

namespace frontend\controllers;

use Yii;
use frontend\models\programacion\ProgramacionAlmas;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\programacion\Pedidos;
use common\models\catalogos\PedProg;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Turnos;
use common\models\catalogos\SubProcesos;
use common\models\catalogos\AreaProcesos;
use frontend\models\programacion\ProgramacionesAlma;
use frontend\models\programacion\ProgramacionesAlmaSemana;
use frontend\models\programacion\ProgramacionesAlmaDia;
use common\models\datos\Almas;
use common\models\datos\Programaciones;
use common\models\datos\Areas;
use common\models\dux\Productos;
use common\models\dux\Aleaciones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\vistas\v_AlmasPorProgramarAC;


/**
 * ProgramacionesController implements the CRUD actions for programaciones model.
 */
class ProgramacionAlmasController extends Controller
{
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

    public function actionLoadSemana(){
        $val = $this->LoadSemana(!isset($_GET['semana1']) ? '' : $_GET['semana1']);
        return json_encode($val);
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
    
    public function actionDataSemanal()
    {
        $semanas = $this->LoadSemana(!isset($_GET['semana1']) ? '' : $_GET['semana1']);
        
        //var_dump($semanas);exit;
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $programacion = new ProgramacionAlmas();
        $dataProvider = $programacion->getProgramacionSemanal($semanas);

        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
            ]);
        }
        
        foreach ($dataProvider->allModels as &$data){
            $data['Requeridas1'] *= 1;
            $data['Requeridas2'] *= 1;
            $data['Requeridas3'] *= 1;
            $data['Requeridas4'] *= 1;
            $data['Existencia'] *= 1;
        }
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
        ]);
    }
            
    public function actionSemanal($semana1 = '',$fecha = '')
    {
        $this->layout = 'programacion';
		
		 $area = Yii::$app->session->get('area');
		 $area = $area['IdArea'];
		 
		 if ($area == 2 ) $title = 'Programación semanal almas ( ACEROS ) ';
		 else $title = 'Programación semanal almas ( Bronce ) F-PC-7.0-49/1';
        
        return $this->render('programacionSemanal',[
            'title'=>$title,
       ]);
    }
    
    public function actionDiaria($AreaProceso,$subProceso=2,$semana = '')
    {
        $this->layout = 'programacion';
        
		$area = Yii::$app->session->get('area');
		$area = $area['IdArea'];
		if ($area == 2 ) $title = 'Programación diaria almas ( ACEROS ) ';
		else $title = 'Programación diaria almas ( Bronce )  F-PC-7.0-50/1';
		
        $mes = date('m');
        if($semana == ''){
            $semana2 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana2 = explode('-W',$semana);
        }
        
        $semanas['semana1'] = ['año'=>$semana2[0],'semana'=>$semana2[1],'value'=>"$semana2[0]-W$semana2[1]"];
        
        $AreaProceso = AreaProcesos::findOne($AreaProceso);
        
        return $this->render('programacionDiaria',[
             'title'=>$title,
            'area'=>$AreaProceso->IdArea,
            'IdSubProceso'=>2,
            'semana'=>$semana,
            'AreaProceso'=>$AreaProceso->IdAreaProceso,
            'semanas'=>$semanas,
        ]);
    }
    
    public function actionLoadDias($semana = '')
    {
        $diasSemana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

        $year = $semana == '' ? date('Y') : date('Y',strtotime($semana));
        $week = $semana == '' ? date('W') : date('W',strtotime($semana));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        //echo $fecha;exit;
        
        for($x=0;$x<6;$x++){
            $dias[] = $diasSemana[$x]." ".date('d-m-Y',strtotime($fecha));
            $fecha = date('Y-m-d',strtotime("+1 Day",strtotime($fecha)));
        }
        
        return json_encode($dias);
    }

    public function actionDataDiaria($semana='',$subProceso = 6)
    {
        $turno = isset($_GET['turno']) ? $_GET['turno'] : 1;
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $semana = $semana == '' ? [date('Y'),date('W')] : [date('Y',strtotime($semana)),date('W',strtotime($semana))];
        
        
        
        $this->layout = 'JSON';

        $semana['semana1'] = ['year'=>$semana[0],'week'=>$semana[1],'value'=>"$semana[0]-W$semana[1]"];

        $programacion = new ProgramacionAlmas();
        $dataProvider = $programacion->getprogramacionDiaria($semana,$area,$subProceso,$turno);

        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
                'ResumenSem'=>[],
            ]);
        }
        return json_encode([
            'total'=>count($dataProvider->allModels),
            'rows'=>$dataProvider->allModels,
        ]);
    }
    
    /**
     * Creates a new programaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new programacion();
        //var_dump(Yii::$app->request->post()); exit;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->IdProgramacion]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing programaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSaveSemanal()
    {
        $model = new ProgramacionAlmas();

        $dat = $_GET;
		
		if (!isset($dat['Prioridad']) ) $dat['Prioridad'] = 0;
		
        $datosSemana1 = $dat['IdProgramacionAlma'].",".$dat['Anio'].",".$dat['Semana'].",".$dat['Prioridad'].",".$dat['Programadas'];
        $model->setProgramacionSemanal($datosSemana1);
        return var_dump($dat);
    }
    
    public function actionDatosDux()
    {
        $model = new Programacion();
        $model->setDatosDux();
    }
    
    public function actionActualizacion()
    {
        $model = new Programacion();
        return date('d-m-Y h:i',strtotime($model->getActualizacion()[0]['FechaInicio']));
    }
    
    public function actionSaveDiario()
    {
        $model = new ProgramacionAlmas();
        $maquinas = new VMaquinas();
        $dat = $_GET;

        if(isset($dat['Programadas'])){
            $maq = $maquinas->find()->where("IdMaquina = ".$dat['Maquina'])->asArray()->all();
            $centro = isset($dat['Centro']) ? $dat['Centro'] : $maq[0]['IdCentroTrabajo'];
            $datosSemana = $dat['IdProgramacionAlmaSemana'].",'".$dat['Dia']."',".$dat['Prioridad'].",".$dat['Programadas'].",".$dat['Maquina'].",$centro";
            $model->setProgramacionDiaria($datosSemana);
            return true;
        }
    }
    
    public function actionSavePedidos()
    {
        $model = new Programacion();
        $pedido = new Pedidos();
        
        $area = Yii::$app->session->get('area');
        $data = $_GET;

        foreach($data as $dat){   
            $pedidoDat = $pedido->findOne($dat);
            $producto = Productos::findOne($pedidoDat->IdProducto);
            
            $this->SetPedProgramacion($pedidoDat,$producto,$area['IdArea']);
        } 
        return true;
    }
    
    public function SetPedProgramacion($pedidoDat,$producto, $Area){
        $command = \Yii::$app->db;  
        $Acumulado = Programaciones::find()->where("IdProgramacionEstatus = 1 AND IdProducto = $pedidoDat->IdProducto")->asArray()->all();
        $area = Areas::findOne("$Area");
       
        if($area['AgruparPedidos'] == 1){
            //var_dump($Acumulado);       
            if(isset($Acumulado[0]['IdProgramacion'])){

                $programacion = Programaciones::findOne($Acumulado[0]['IdProgramacion']);
                $programacion->Cantidad = $Acumulado[0]['Cantidad'] + $pedidoDat->Cantidad ;
                $programacion->update();               
             
                $command->createCommand()->insert('PedProg', [
                    'IdPedido' => $pedidoDat->IdPedido,
                    'IdProgramacion' => $Acumulado[0]['IdProgramacion'],
                    'OrdenCompra' => $pedidoDat->OrdenCompra,
                    'FechaMovimiento' => date('Y-m-d H:i:s'),
                ])->execute();                 
            }else{
                $model = PedProg::findOne($pedidoDat->IdPedido);
                           
                if($model == null){  
                    $model = new Programaciones();
                    $model->IdPedido= $pedidoDat->IdPedido;
                    $model->IdArea = $area['IdArea'];
                    $model->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                    $model->IdProgramacionEstatus = 1;
                    $model->IdProducto = $pedidoDat->IdProducto;
                    $model->Programadas = 0;
                    $model->Hechas = 0;
                    $model->Cantidad = $pedidoDat->Cantidad;
                    $model->save();

                    $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                    $almas = Almas::find()->where("IdProducto = $casting")->asArray()->all();

                    if(count($almas)>0){
                        $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                        $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);
                        foreach($almas as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $programacion[0]['IdProgramacion'],
                                'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                                'IdProgramacionEstatus' => 1,
                                'IdAlmas' => $alma['IdAlma'],
                                'Programadas' => 0,
                                'Hechas' => 0,
                            ];
                            $almasProgramadas->load($almas_prog);
                            $almasProgramadas->save();
                        }
                    }

                    $lastId_La = Programaciones::find()->limit('1')->orderBy('IdProgramacion desc')->one();

                    $command->createCommand()->insert('PedProg', [
                        'IdPedido' => $pedidoDat->IdPedido,
                        'IdProgramacion' => $lastId_La['IdProgramacion'],
                        'OrdenCompra' => $pedidoDat->OrdenCompra,
                        'FechaMovimiento' => date('Y-m-d H:i:s'),
                    ])->execute();  
                }
            }
            }else{               
                $model = PedProg::findOne($pedidoDat->IdPedido);
                //print_r($model);
              
                if($model == null){
                    $model = new Programaciones();
                    $model->IdPedido= $pedidoDat->IdPedido;
                    $model->IdArea = $area['IdArea'];
                    $model->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                    $model->IdProgramacionEstatus = 1;
                    $model->IdProducto = $pedidoDat->IdProducto;
                    $model->Programadas = 0;
                    $model->Hechas = 0;
                    $model->Cantidad = $pedidoDat->Cantidad;
                    $model->save();

                    $casting = $producto->IdProductoCasting == 1 ? $producto->IdProducto : $producto->IdProductoCasting;
                    $almas = Almas::find()->where("IdProducto = $casting")->asArray()->all();

                    if(count($almas)>0){
                        $programacion = Programacion::find()->where("IdPedido = " . $model->IdPedido . "")->asArray()->all();
                        $producto = Productos::findOne(Productos::findOne($model->IdProducto)->IdProducto);

                        foreach($almas as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $programacion[0]['IdProgramacion'],
                                'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                                'IdProgramacionEstatus' => 1,
                                'IdAlmas' => $alma['IdAlma'],
                                'Programadas' => 0,
                                'Hechas' => 0,
                            ];
                            $almasProgramadas->load($almas_prog);
                            $almasProgramadas->save();
                        }
                    }

                    $lastId_La = Programaciones::find()->limit('1')->orderBy('IdProgramacion desc')->one();

                    $command->createCommand()->insert('PedProg', [
                        'IdPedido' => $pedidoDat->IdPedido,
                        'IdProgramacion' => $lastId_La['IdProgramacion'],
                        'OrdenCompra' => $pedidoDat->OrdenCompra,
                        'FechaMovimiento' => date('Y-m-d H:i:s'),
                    ])->execute();   
            }
        }  
    }

    /**
     * Deletes an existing programaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete_diario()
    {
        if(isset($_POST['IdProgramacionDia']))
            $this->findProgramacionDia($_POST['IdProgramacionDia'])->delete();
        return "true";
    }
    
        /**
     * Finds the programaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return programaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProgramacionDia($id)
    {
        if (($model = ProgramacionesDia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionRePrograma(){
		$sinAlma = v_AlmasPorProgramarAC::find()->asArray()->all();
		count($sinAlma);
		 // var_dump($sinAlma);
		
		if (count($sinAlma>0)){
			foreach($sinAlma as $alma){
					$Prog = (object)array('IdProgramacion' => $alma['IdProgramacion']);
					$Prod = Productos::findOne( ['IdProducto' => $alma['IdProducto'] ] );
					// $Prod = (object)array('IdProducto' => $alma['IdProducto']);
					// var_dump($Prod);
					 // if ($alma['IdProgramacion'] == 20315)
						 $this->ProgramarAlmas($Prog,$Prod);
			}
		}else{
				echo "fin"; 
		}
		
	}

	public function actionRePrograma2($idprogramacion,$idproducto){
		
					$Prog = (object)array('IdProgramacion' => $idprogramacion);
					$Prod = Productos::findOne( ['IdProducto' => $idproducto ] );
					
						$this->ProgramarAlmas($Prog,$Prod);
	}
	
	public function actionRe($idproducto){
	
					$Prod = Productos::findOne( ['IdProducto' => $idproducto ] );
					echo "count:" .count($Prod);
					echo "isnull:" .is_null($Prod);					
					
	}
	
	 public function ProgramarAlmas($Programacion,$producto){
        $almas = Almas::find()->where(['IdProducto' => $producto->IdProducto])->asArray()->all();
         // $almas = is_null($almas)  ? Almas::find()->where(['IdProducto' => $producto->IdProductoCasting])->asArray()->all() : $almas;

        if(count($almas)>0){
            foreach($almas as $alma){
                $almasProgramadas = ProgramacionesAlma::find()->where([
                    'IdProgramacion' => $Programacion->IdProgramacion,
                    'IdAlmas' => $alma['IdAlma'],

                ])->one();

                if(is_null($almasProgramadas)){
                    $almasProgramadas = new ProgramacionesAlma();
                    $almas_prog['ProgramacionesAlma'] = [
                        'IdProgramacion' => $Programacion->IdProgramacion,
                        'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                        'IdProgramacionEstatus' => 1,
                        'IdAlmas' => $alma['IdAlma'],
                        'Programadas' => 0,
                        'Hechas' => 0,
                    ];
                    $almasProgramadas->load($almas_prog);
                    $almasProgramadas->save();
					var_dump($almasProgramadas);
                }
            }
        }
    }
	
    
    
}