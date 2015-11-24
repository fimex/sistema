




<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

	$url = "http://devserver:8181/birt/frameset?__report=GraficaKloster.rptdesign";
	//echo $url;
?>




<embed id= "rep" width="1000" height="768" src="<?= $url ?>">


<script>
		function ReloadPage() {
			setTimeout(function(){
				location.reload();
			},900000);
		};
		
		</script>
		
		<script>ReloadPage();</script>