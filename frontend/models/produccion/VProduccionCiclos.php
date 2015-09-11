<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProduccionCiclos".
 *
 * @property integer $IdProduccion
 * @property integer $IdProduccionDetalleMoldeo
 * @property integer $IdProgramacion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdTurno
 * @property integer $IdProducto
 * @property string $Eficiencia
 * @property integer $IdParteMolde
 * @property integer $IdEstatus
 * @property integer $Linea
 * @property integer $MoldesPorCiclo
 * @property string $Observaciones
 */
class VProduccionCiclos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProduccionCiclos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProduccionDetalleMoldeo', 'IdProgramacion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'IdArea', 'IdProducto', 'Eficiencia'], 'required'],
            [['IdProduccion', 'IdProduccionDetalleMoldeo', 'IdProgramacion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdArea', 'IdTurno', 'IdProducto', 'IdParteMolde', 'IdEstatus', 'Linea', 'MoldesPorCiclo'], 'integer'],
            [['Fecha'], 'safe'],
            [['Eficiencia'], 'number'],
            [['Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdProduccionDetalleMoldeo' => 'Id Produccion Detalle Moldeo',
            'IdProgramacion' => 'Id Programacion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdTurno' => 'Id Turno',
            'IdProducto' => 'Id Producto',
            'Eficiencia' => 'Eficiencia',
            'IdParteMolde' => 'Id Parte Molde',
            'IdEstatus' => 'Id Estatus',
            'Linea' => 'Linea',
            'MoldesPorCiclo' => 'Moldes Por Ciclo',
            'Observaciones' => 'Observaciones',
        ];
    }
}
