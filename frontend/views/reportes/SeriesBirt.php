
<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

$per = '%25';
$url = "http://devserver:8181/birt/frameset?__report=serieshistorial.rptdesign";
$url = htmlentities($url);


// echo $url;
?>




<embed id= "rep" width="100%" height="768" src="<?= $url ?>">

