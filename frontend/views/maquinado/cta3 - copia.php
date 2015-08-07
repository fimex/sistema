
<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;
use common\models\Grid;
	$id2 = 'maquinasop';
	$id3 = 'maquinasop2';

?>

<table id="<?php echo $id2 ?>" class="easyui-datagrid " style="width:100%;height:auto;"

        data-options="
			url:'cta3d?fecha=<?=$semana?>',
			method:'post',
		    singleSelect: true,
			showFooter: true,
		    onClickRow:onClickRow2 ,
			toolbar:tb2,
			queryParams: {
				semana: '<?=$semana?>'
							}
		"
   >
   
   <div id="tb2" style="height:auto">
						<!--
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Accept</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>
						-->
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="deshacerfila2()">Deshacer fila</a>
						
					</div>
   
    <thead>
		<tr>
			<th rowspan='2' data-options="field:'maquina',width:100">maquina</th>
			<th colspan="3">Turnos</th>
			<th colspan="3">Tiempo a Maquinar</th>
			<th colspan="4">Tiempo  Operador</th>
		</tr>
	
        <tr>
 
		
			
			
			<th data-options="field:'Matutino',width:60,
										
											
				editor:{
					type:'combobox',
					options:{
					valueField:'operador',
					textField:'operador',
					url:'cta2',
					method:'get',
						}
				}
			">matutino</th>
			
			<th data-options="field:'Vespertino',width:60,
										
											
				editor:{
					type:'combobox',
					options:{
					valueField:'operador',
					textField:'operador',
					url:'cta2',
					method:'get',
						}
				}
			">vespertino</th>
			
			<th data-options="field:'Nocturno',width:60,
										
											
				editor:{
					type:'combobox',
					options:{
					valueField:'operador',
					textField:'operador',
					url:'cta2',
					method:'get',
						}
				}
			">nocturno</th>
			
			<th data-options="field:'minutos_m',width:60">Min</th>
			<th data-options="field:'horas_m',width:60">Hrs</th>
			<th data-options="field:'t8_m',width:60">T8</th>
			<th data-options="field:'t9_m',width:60">T9</th>
			
			<th data-options="field:'minutos_o',width:60">Min</th>
			<th data-options="field:'horas_o',width:60">Hrs</th>
			<th data-options="field:'t8_o',width:60">T8</th>

			
            
        </tr>
    </thead>
</table>

<table id="<?php echo $id3 ?>" class="easyui-datagrid " style="width:100%;height:auto;"
		
        data-options="
			url:'cta4d?fecha=<?=$semana?>',
			method:'post',
		    singleSelect: true,
			showFooter: true,
		    
			queryParams: {
				semana: '<?=$semana?>'
							}
		"
   >
   
   
   
    <thead>
			
        <tr>
 
			<th data-options="field:'turno',width:60">Codigo</th>
			<th data-options="field:'nombre',width:300">Operador</th>		
			<th data-options="field:'maquina',width:100">Maquina</th>
			<th data-options="field:'minutos',width:60">Minutos</th>
			
			
            
        </tr>
    </thead>
</table>

	<script type="text/javascript">
		
		var editIndex2 = undefined;
		
		function endEditing2(){
				
				var mat = null;
				var ves = null;
				var noc = null;
				var semana = null ;
			if (editIndex2 == undefined){return true}
			if ($('#<?php echo $id2 ?>').datagrid('validateRow', editIndex2)){
				
				var ed_mat = $('#<?php echo $id2 ?>').datagrid('getEditor', {index:editIndex2,field:'Matutino'});
				var ed_ves = $('#<?php echo $id2 ?>').datagrid('getEditor', {index:editIndex2,field:'Vespertino'});
				var ed_noc = $('#<?php echo $id2 ?>').datagrid('getEditor', {index:editIndex2,field:'Nocturno'});
				 
				  if (ed_mat == null || ed_ves == null || ed_noc == null  )
				  {return true;editIndex2 = undefined;}
				 
				 mat = $(ed_mat.target).combobox('getText');
				 ves = $(ed_ves.target).combobox('getText');
				 noc = $(ed_noc.target).combobox('getText');
				semana = $('#semana1').val();
				 $('#<?php echo $id2 ?>').datagrid('getRows')[editIndex2]['Matutino'] = mat;
				 $('#<?php echo $id2 ?>').datagrid('getRows')[editIndex2]['Vespertino'] = ves;
				 $('#<?php echo $id2 ?>').datagrid('getRows')[editIndex2]['Nocturno'] = noc;
				 $('#<?php echo $id2 ?>').datagrid('getRows')[editIndex2]['semana'] = semana;
				 
				$('#<?php echo $id2 ?>').datagrid('refreshRow',editIndex2);
				
				var grid = '#<?php echo $id2 ?>';
				var data = $('#<?php echo $id2 ?>').datagrid('getRows')[editIndex2];
					//$.post('".URL::to('/Fimex/programacion/save_semanal')."',
					$.post('ctap2',
						{Data: JSON.stringify(data)},
						function(data,status){
							if(status == 'success' ){
								$(grid).datagrid('load');
								console.log(data);
								$var = $(grid).datagrid('getChanges');
							}else{
								reject('#$id');
								alert('Error al guardar los datos');
							}
						}
					);
				
				editIndex2 = undefined;
				$('#<?php echo $id2 ?>').datagrid('endEdit', editIndex2);
				deshacerfila2();
				return true;
			} else {
				return false;
			}
		}
		
		
		function deshacerfila2(){
					var sel = $('#<?php echo $id2 ?>').datagrid('getSelected');
					var row=  $('#<?php echo $id2 ?>').datagrid('getRowIndex',sel);
					$('#<?php echo $id2 ?>').datagrid('cancelEdit',row);
					editIndex2 = undefined;
					$('#<?php echo $id2 ?>').datagrid('clearSelections');
					
		}
		function onDblClickRow2(){
						
		}
		
		function onClickRow2(inx,row){
		
		var maquina = row.maquina;
		var mat  = $('#<?php echo $id2 ?>').datagrid('getColumnOption','Matutino');
		    mat.editor.options.url = 'cta3p2operador?maquina='+maquina;
		
		var ves  = $('#<?php echo $id2 ?>').datagrid('getColumnOption','Vespertino');
		    ves.editor.options.url = 'cta3p2operador?maquina='+maquina;
			
		var noc  = $('#<?php echo $id2 ?>').datagrid('getColumnOption','Nocturno');
			noc.editor.options.url = 'cta3p2operador?maquina='+maquina;
		
		var ed = null
			if (editIndex != inx){
				if (endEditing2()){
					$('#<?php echo $id2 ?>').datagrid('selectRow', inx)
							.datagrid('beginEdit', inx);
							
					editIndex2 = inx;
				} else {
					$('#<?php echo $id2 ?>').datagrid('selectRow', editIndex2);
				}
			}
		}
		
		
		
		function accept(){
		  var grid = '#<?php echo $id2 ?>';
			if (endEditing()){
				//$(grid).datagrid('acceptChanges');
				
					var data = $(grid).datagrid('getChanges');
					//$.post('".URL::to('/Fimex/programacion/save_semanal')."',
					$.post('ctap1',
						{Data: JSON.stringify(data)},
						function(data,status){
							if(status == 'success' ){
								$(grid).datagrid('load');
								console.log(data);
								$var = $(grid).datagrid('getChanges');
							}else{
								reject('#$id');
								alert('Error al guardar los datos');
							}
						}
					);
				
				
			}
		}
		function reject2(){
		alert("reject!!");
			$('#<?php echo $id2 ?>').datagrid('rejectChanges');
			editIndex = undefined;
		}
		function getChanges(){
			var rows = $('#<?php echo $id2 ?>').datagrid('getChanges');
			alert(rows.length+' rows are changed!');
		}
		
	</script>
