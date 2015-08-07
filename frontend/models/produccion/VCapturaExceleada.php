<?php

namespace frontend\models\produccion;

use Yii;
use yii\data\ArrayDataProvider;
use common\models\dux\Productos;

/**
 * This is the model class for table "v_CapturaExceleada".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacionDia
 * @property integer $IdPedido
 * @property integer $IdArea
 * @property integer $IdProducto
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $IdSubProceso
 * @property integer $IdTurno
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $prioridadSemana
 * @property integer $programadasSemana
 * @property integer $hechasSemana
 * @property integer $prioridadDia
 * @property integer $programadasDia
 * @property integer $hechasDia
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $IdAreaProceso
 * @property integer $hechasProduccion
 * @property integer $rechazadasProduccion
 */
class VCapturaExceleada extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CapturaExceleada';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdPedido', 'IdArea', 'IdProducto', 'Programadas', 'Hechas'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdPedido', 'IdArea', 'IdProducto', 'Anio', 'Semana', 'IdSubProceso', 'IdTurno', 'IdCentroTrabajo', 'IdMaquina', 'Programadas', 'Hechas', 'prioridadSemana', 'programadasSemana', 'hechasSemana', 'prioridadDia', 'programadasDia', 'hechasDia', 'CiclosMolde', 'PiezasMolde', 'IdAreaProceso', 'hechasProduccion', 'rechazadasProduccion'], 'integer'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'IdPedido' => 'Id Pedido',
            'IdArea' => 'Id Area',
            'IdProducto' => 'Id Producto',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdTurno' => 'Id Turno',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'prioridadSemana' => 'Prioridad Semana',
            'programadasSemana' => 'Programadas Semana',
            'hechasSemana' => 'Hechas Semana',
            'prioridadDia' => 'Prioridad Dia',
            'programadasDia' => 'Programadas Dia',
            'hechasDia' => 'Hechas Dia',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'IdAreaProceso' => 'Id Area Proceso',
            'hechasProduccion' => 'Hechas Produccion',
            'rechazadasProduccion' => 'Rechazadas Produccion',
        ];
    }
    
    public function getDetalle($subProceso,$dia){
        $result = $this->find()->where("IdSubProceso = $subProceso AND Dia= '$dia'")->asArray()->all();
        foreach ($result as &$res){
            $productos = Productos::findOne($res['IdProducto'])->Attributes;
            $res['Producto'] = $productos['Identificacion'];
            
            $okCic = CiclosVarel::find()->select('SUM(Cantidad) AS okCic')->where("IdProducto = ".$res['IdProducto']." AND Fecha = '$dia' AND Tipo = 'B' ")->asArray()->all();
            $res['OkCic'] =  $okCic[0]['okCic'];
        }
        
        if(count($result)!=0){
            return new ArrayDataProvider([
                'allModels' => $result,
                'id'=>'IdPedido',
                'sort'=>array(
                    'attributes'=> $result[0],
                ),
                'pagination'=>false,
            ]);
        }
        return [];
    }
}
