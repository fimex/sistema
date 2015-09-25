<?php

namespace frontend\controllers;

class CalidadController extends \yii\web\Controller
{
    public function actionCatalogos(){
        return $this->render('catalogos');
    }
    
    public function actionMediciones(){
        return $this->render('mediciones');
    }
}
