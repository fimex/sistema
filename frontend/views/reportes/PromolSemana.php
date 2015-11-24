




<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

	$url = "http://devserver:8181/birt/frameset?__report=Promol_Semanal2.rptdesign&Semanaini=$Semanaini";
	//echo $url;
?>


Semana :
<select id="semana" class="easyui-combobox" name="area" style="width:200px;">
    
	<?php $i = 0;
	 for ($i = 1; $i <= 52; $i++) {
			echo "<option value=\" $i \"> $i</option>";
	 }
	?>
	
    
</select>


<?php
echo Html::a('Actualizar',"javascript:void(0)",[
        'class'=>"easyui-linkbutton",
        'data-options'=>"iconCls:'icon-reload',plain:true",
        'onclick'=>"recargaPagina()"
    ]);

	//echo $url ;
	?>

<br>
<embed id= "rep" width="80%" height="768" src="<?= $url ?>">

<script type="text/javascript">

		function recargaPagina(){
			
			
			var area = $('#semana').combobox('getValue');
			
			window.location.href = 'promol-semana' + "?Semanaini=" + area ;
			
		}

</script>
