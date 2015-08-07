<?php

namespace frontend\controllers;

use Yii;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Turnos;
use frontend\models\programacion\ProgramacionesAlma;
use frontend\models\programacion\ProgramacionesAlmaSemana;
use frontend\models\programacion\ProgramacionesAlmaDia;
use common\models\datos\Almas;
use common\models\dux\Productos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgramacionesController implements the CRUD actions for programaciones model.
 */
class AlmasController extends Controller
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

    public function actionSemanal($semana1 = '',$fecha = '')
    {
        $mes = date('m');
        if($semana1 == ''){
            $semana1 = $mes == 12 && date('W') == 1 ? array(date('Y')+1,date('W')) : array(date('Y'),date('W'));
        }else{
            $semana1 = explode('-W',$semana1);
        }
        
        $semanas['semana1'] = ['año'=>$semana1[0],'semana'=>$semana1[1],'value'=>"$semana1[0]-W".(strlen($semana1[1]) == 1 ? "0" : "").$semana1[1]];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);

        $programacion = new ProgramacionesAlma();
        $dataProvider = $programacion->getprogramacionSemanal($semanas,Yii::$app->session->get('area'));
        
        return $this->render('programacion',[
            'title'=>'Programacion diaria Almas',
            'semanas'=>$semanas,
            //'programacion'=>$programacion,
            //'data'=>json_encode($dataProvider->allModels),
        ]);
    }
    
    public function actionData_semanal()
    {
        $this->layout = 'JSON';
        $semana1 = isset($_POST['semana1']) ? explode('-W',$_POST['semana1']) : array(date('Y'),date('W'));
        $semanas['semana1'] = ['año'=>$semana1[0],'semana'=>$semana1[1],'value'=>"$semana1[0]-W$semana1[1]"];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        
        $programacion = new ProgramacionesAlma();
        $dataProvider = $programacion->getProgramacionSemanal($semanas);
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
        ]);
    }
    
    public function actionData_maquina($subProceso)
    {
        $this->layout = 'JSON';
                
        $maquinas = new VMaquinas();
        $dataProvider = $maquinas->find("IdSubProceso = ".$subProceso)->asArray()->all();
        
        return json_encode($dataProvider);
    }
    
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

    public function actionSave_semanal()
    {
        $model = new Programacion();
        $data = json_decode($_POST['Data']);
        
        foreach($data as $dat){
            
        }
        return var_dump($data);
        
    }
    
    public function actionDelete_diario()
    {
        if(isset($_POST['IdProgramacionDia']))
            $this->findProgramacionDia($_POST['IdProgramacionDia'])->delete();
        return "true";
    }

    public function checarSemana($semana){
        $ultimaSemana = date('W',strtotime($semana['año'].'-12-31'));
        if($semana['semana'] == $ultimaSemana || $ultimaSemana == '01'){
            $semana['semana'] = 1;
            $semana['año']++;
        }
        else
            $semana['semana']++;
        $semana['value'] = $semana['año']."-W".(strlen($semana['semana']) ==1 ? "0" : "").$semana['semana'] ;

        return $semana;
    }
    
}
