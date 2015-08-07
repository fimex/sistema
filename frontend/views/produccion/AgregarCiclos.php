<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<div id="FormCiclos" >
  
    <?php
    echo $fecha;
    if (isset($ciclos)) {
    
    echo $f = $ciclos[0]['Inicio'];
    
    echo '<input id="dato" class="easyui-textbox" value="$f"  >';
            
    }
    ?>
    
    
    
    
</div>

