<?php

namespace frontend\controllers;

use Yii;
use common\models\dux\VProductos;
use common\models\dux\Productos;
use common\models\dux\VMarcas;
use common\models\datos\Almas;
use common\models\catalogos\AlmasMaterialCaja;
use common\models\catalogos\AlmasRecetas;
use common\models\catalogos\AlmasTipo;
use common\models\datos\Filtros;
use common\models\catalogos\FiltrosTipo;
use common\models\catalogos\Series;
use common\models\catalogos\PartesMolde;
use common\models\datos\Camisas;
use common\models\catalogos\CamisasTipo;
use common\models\datos\Cajas;
use common\models\datos\CajasTipo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class ProductosController extends Controller
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

    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex($area)
    {
        $model = new VMarcas();
        $dataProvider = $model->getMarcas($area);
        //print_r($dataProvider); exit;
        return $this->render('index', [
            'title' => 'Productos',
            'model' => $model,
            'marcas' => $dataProvider,
            'area' => $area,
        ]);
    }
    
    public function actionData_productos()
    {
        $this->layout = 'JSON';

        $model = new VProductos();
        //$marca = isset($_POST['marca']) ? $_POST['marca'] : "2";
        $area = isset($_POST['area']) ? $_POST['area'] : "1" ;     
        $dataProvider = $model->getProductos($area);
        
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
    
    public function actionSaveProducto(){
        $model = Productos::findOne($_REQUEST['IdProducto']);
        $model->load(['Productos' => $_REQUEST]);
        $model->save();
        
        $producto = VProductos::find()->where(['IdProducto' => $_REQUEST['IdProducto']])->asArray()->one();
        return json_encode($producto);
    }
    
    public function actionSaveAlmas(){
        if(isset($_REQUEST['IdAlma'])){
            $model = Almas::findOne($_REQUEST['IdAlma']);
        }else{
            $model = new Almas();
        }
        
        $model->load(['Almas' => $_REQUEST]);
        if($model->save()){
            return json_encode($model->attributes);
        }
        
        return 0;
    }
    
    public function actionSaveCamisas(){
        if(isset($_REQUEST['IdCamisa'])){
            $model = Camisas::findOne($_REQUEST['IdCamisa']);
        }else{
            $model = new Camisas();
        }
        
        $model->load(['Camisas' => $_REQUEST]);
        if($model->save()){
            return json_encode($model->attributes);
        }
        
        return 0;
    }
    
    public function actionSaveFiltros(){
        if(isset($_REQUEST['IdFiltro'])){
            $model = Filtros::findOne($_REQUEST['IdFiltro']);
        }else{
            $model = new Filtros();
        }
        
        $model->load(['Filtros' => $_REQUEST]);
        if($model->save()){
            return json_encode($model->attributes);
        }
        
        return 0;
    }
    
    public function actionSaveCajas(){
        if(isset($_REQUEST['IdCaja'])){
            $model = Cajas::findOne($_REQUEST['IdCaja']);
        }else{
            $model = new Cajas();
        }
        
        $model->load(['Cajas' => $_REQUEST]);
        if($model->save()){
            return json_encode($model->attributes);
        }
        return 0;
    }

    public function actionPartesMolde(){
        $model = PartesMolde::find()->asArray()->all();
        $i = 1;
        $IdAreaAct = isset($_REQUEST['IdAreaAct']) == false ? 1 : $_REQUEST['IdAreaAct'];  
        foreach ($model as &$key ) {
            if (($IdAreaAct == 1 || $IdAreaAct == 3) && $i <= 2) {
                $key['Num'] = $i;
                $key['Ciclos'] = 2;
            }elseif ($IdAreaAct == 2 && $i <= $_REQUEST['CiclosVarel']) {
                $key['Num'] = $i;
                $key['Ciclos'] = $_REQUEST['CiclosVarel'];
            }
            $i++;
        }
        return json_encode($model);
    }
    
    public function actionDataProductos()
    {
        $model = VProductos::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }
    
    public function actionAlmasTipo()
    {
        $model = AlmasTipo::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCamisasTipo()
    {
        $model = CamisasTipo::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionFiltrosTipo()
    {
        $model = FiltrosTipo::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCajasTipo()
    {
        $model = CajasTipo::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionAlmasMaterialCaja()
    {
        $model = AlmasMaterialCaja::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionAlmasRecetas()
    {
        $model = AlmasRecetas::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDataAlmas()
    {
        $model = Almas::find()->where($_REQUEST)
            ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDataCajas()
    {
        $model = Cajas::find()->where($_REQUEST)
            ->asArray()->all();
        return json_encode($model);
    }

    public function actionDataFiltros()
    {
        $model = Filtros::find()->where($_REQUEST)
            ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDataCamisas()
    {
        $model = Camisas::find()->where($_REQUEST)
            ->asArray()->all();
        return json_encode($model);
    }

    /**
     * Displays a single Productos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Productos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->IdProducto]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Productos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMoldeo($id,$area)
    {
   
        if (($model = Productos::findOne($id)) == null) {
            return false;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->renderPartial('update', [
                'model' => $model,
                'form' => '_formMoldeo',
                'area' => $area,
            ]);
        }
    }


    public function actionSeries($id,$area)
    {
   
        if (($model = Productos::find()->where('IdProducto = '.$id)->one()) == null) {
            return false;
        }

       if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->renderPartial('update', [
                'model' => $model,
                'form' => '_formSeries',
                'area' => $area,
            ]);
        }

    }

    
    public function actionAlmas()
    {
        $this->layout = 'JSON';
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $dataProvider = $this->findAlmas($id);   
             
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
        return json_encode([
                'total'=>count($dataProvider),
                'rows'=>$dataProvider,
        ]);
    }
    
        
    public function actionFiltros()
    {
        $this->layout = 'JSON';
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $model = new Filtros();
        $dataProvider = $model->getFiltros($id);
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
                
        return json_encode([
                'total'=>count($dataProvider),
                'rows'=>$dataProvider,
        ]); 
    }
    
            
    public function actionCamisas()
    {
        $this->layout = 'JSON';
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $model = new Camisas();
        $dataProvider = $model->getCamisas($id);
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
                
        return json_encode([
                'total'=>count($dataProvider),
                'rows'=>$dataProvider,
        ]); 
    }
    
              
    public function actionCajas()
    {
        $this->layout = 'JSON';
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $model = new Cajas();
        $dataProvider = $model->getCajas($id);
        
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
                
        return json_encode([
                'total'=>count($dataProvider),
                'rows'=>$dataProvider,
        ]); 
    }
    
    public function actionData_tipos($id) {
        $this->layout = 'JSON';
        
        switch ($id) {
            case 'almas':
                $model = new AlmasTipo();
                $dataProvider = $model->getAlmasTipo();
                break;
            case 'materialcaja':
                $model = new AlmasMaterialCaja();
                $dataProvider = $model->getAlmasMaterialCaja();
                break;
            case 'receta':
                $model = new AlmasRecetas();
                $dataProvider = $model->getAlmasRecetas();
                break;
            case 'filtro':
                $model = new FiltrosTipo();
                $dataProvider = $model->getFiltrosTipo();
                break;
            case 'camisa':
                $model = new CamisasTipo();
                $dataProvider = $model->getCamisasTipo();
                break;
            case 'cajas':
                $model = new CajasTipo();
                $dataProvider = $model->getCajasTipo();
                break;
        }      

        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
            ]);
        }
  //print_r($dataProvider);
    //                exit();
         /* return $dataProvider;*/
        return json_encode(
           $dataProvider
        );     
       
        
    }
    
    public function actionSave(){
        $datos = json_decode(Yii::$app->request->get('data'));
        $m = "";
       // print_r($datos);        exit();
        foreach($datos as $dat){
            if (isset($dat->IdProducto)) {
                switch (Yii::$app->request->get('grid')) {
                    case 'Almas':
                        
                        if (isset($dat->IdAlma)) {
                            $model = Almas::findOne($dat->IdAlma);
                        }  else {
                            $model = null;
                        }
                        
                        if ($model == null) {
                            $model = new Almas();
                        }  else {
                            $data['IdAlma'] = $dat->IdAlma;
                        }
                        
                        $data['IdProducto'] = $dat->IdProducto;
                        $data['IdAlmaTipo'] = $dat->IdAlmaTipo;
                        $data['IdAlmaMaterialCaja'] = $dat->IdAlmaMaterialCaja;
                        $data['IdAlmaReceta'] = $dat->IdAlmaReceta;
                        $data['Existencia'] = $dat->Existencia;
                        $data['PiezasCaja'] = $dat->PiezasCaja;
                        $data['PiezasMolde'] = $dat->PiezasMolde;
                        $data['Peso'] = $dat->Peso;
                        $data['TiempoLlenado'] = $dat->TiempoLlenado;
                        $data['TiempoFraguado'] = $dat->TiempoFraguado;
                        $data['TiempoGaseoDirecto'] = $dat->TiempoGaseoDirecto;
                        $data['TiempoGaseoIndirecto'] = $dat->TiempoGaseoIndirecto;
                        $data2['Almas'] = $data;

                        $model->load($data2);

                        break;
                    case 'Filtros':
                        
                        if(isset($dat->IdFiltro)){
                            $model = Filtros::findOne($dat->IdFiltro);
                        }  else {
                            $model = null;
                        }
                       
                        if($model == null){
                            $model = new Filtros();
                        }
                        
                        $data['IdProducto']  = $dat->IdProducto;
                        $data['IdFiltroTipo'] = $dat->IdFiltroTipo;
                        $data['Cantidad'] = $dat->Cantidad;

                        $data2['Filtros'] = $data;
                        $model->load($data2);

                        break;
                    case 'Camisas':          
                         if(isset($dat->IdCamisa)){
                            $model = Camisas::findOne($dat->IdCamisa);
                        }  else {
                            $model = null;
                        }
                       
                        if($model == null){
                            $model = new Camisas();
                        }

                        $data['IdProducto']  = $dat->IdProducto;
                        $data['IdCamisaTipo'] = $dat->IdCamisaTipo;
                        $data['Cantidad'] = $dat->Cantidad;

                        $data2['Camisas'] = $data;
                        $model->load($data2);

                         break; 
                         
                    case 'Cajas':          
                         if(isset($dat->IdCaja)){
                            $model = Cajas::findOne($dat->IdCaja);
                        }  else {
                            $model = null;
                        }
                        
                        $m = Cajas::find()->where("IdProducto = $dat->IdProducto")->asArray()->all();
                        
                        if($model == null){
                            $model = new Cajas();
                        }
                        
                        $data['IdProducto']  = $dat->IdProducto;
                        $data['IdTipoCaja'] = $dat->IdTipoCaja;
                        $data['PiezasXCaja'] = $dat->PiezasXCaja;

                        $data2['Cajas'] = $data;
                        $model->load($data2);

                        break; 
                }
            }
            //if(!$m){
                $model->save();
            //}
            
        }
    }
    
    public function actionDeleteproductos(){
        $datos = json_decode(Yii::$app->request->get('data'));
        
        switch(Yii::$app->request->get('grid')){
            case 'Almas':
                $model = Almas::findOne($datos->IdAlma)->delete();
                break;
            case 'Filtros':
                $model = Filtros::findOne($datos->IdFiltro)->delete();
                break;
            case 'Camisas':
                $model = Camisas::findOne($datos->IdCamisa)->delete();
                break;
            case 'Cajas':
                $model = Cajas::findOne($datos->IdCaja)->delete();
                break;
        }
    }

    public function actionData_almas()
    {
        $this->layout = 'JSON';
        $semana1 = $semana1 == '' ? array(date('Y'),date('W')) : explode('-W',$semana1);
        $semanas['semana1'] = ['año'=>$semana1[0],'semana'=>$semana1[1],'value'=>"$semana1[0]-W$semana1[1]"];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        
        $programacion = new Programacion();
        $dataProvider = $programacion->getProgramacionSemanal($semanas);
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
        ]);
    }
    
    /**
     * Deletes an existing Productos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Productos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findAlmas($id){
       
        $model = new Almas();
        $dataProvider = $model->getAlmas($id);

       // print_r($dataProvider); exit();
       return $dataProvider;
    }
}
