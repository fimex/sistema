<?php

namespace frontend\controllers;

use Yii;

class BronceController extends ProduccionController
{
    public $IdArea = 3;
    
    function init(){
        $this->layout = "bronces";
    }
    
    function actionSaveDetalle() {
    }
    
    function actionSaveProduccion() {
    }
    
    public function actionSemanal(){
        return $this->Semanal(1,2);
    }
}
