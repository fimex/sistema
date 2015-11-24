



<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;

$per = '%25';
$url = "http://devserver:8181/birt/frameset?__report=Promol_Dia.rptdesign&Turno=$Turno&Dia=$Dia";
$url = htmlentities($url);
$per = htmlentities($per);

// echo $url;
?>
Dia : 
<input id="ini" type="text" class="easyui-datebox" required="required" value="formatea_fecha($fecha)">

Area :
<select id="area" class="easyui-combobox" name="area" style="width:200px;">
    <option value="1">Mañana</option>
    <option value="2">Tarde</option>
    <option value="3">Noche</option>
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
<embed id= "rep" width="100%" height="768" src="<?= $url ?>">

<script type="text/javascript">

		function recargaPagina(){
			
			var ini = $('#ini').datebox('getValue');
			var area = $('#area').combobox('getValue');
			
			window.location.href = 'promol-dia' + "?Dia=" + formatea_fecha(ini) +  "&Turno=" + area ;
			
		}
		
		function formatea_fecha(fecha){
			var date =  new Date(fecha);
			
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			
			if (m< 10) var mes = '0'+m ; else mes = m;
			if (d< 10) var dia = '0'+d ; else dia = d;
			
			return y+''+mes+''+dia;
			
		}


</script>
