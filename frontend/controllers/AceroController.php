<?php

namespace frontend\controllers;

class AceroController extends ProduccionController
{
    public $IdArea = 2;
    
    function init(){
        $this->layout = "aceros";
    }
    
    function actionSaveDetalle() {
    }
    
    function actionSaveProduccion() {
        
    }
    
    public function actionSemanal(){
        return $this->Semanal(1,2);
    }
    
}
