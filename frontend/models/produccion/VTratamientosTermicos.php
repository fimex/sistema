<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "V_TratamientosTermicos".
 *
 * @property string $Identificacion
 * @property string $Descripcion
 * @property integer $Hechas
 * @property integer $Cantidad
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property string $Fecha
 * @property string $FechaMoldeo
 * @property integer $IdArea
 * @property integer $IdSubProceso
 * @property integer $IdProduccion
 * @property integer $IdProgramacion
 * @property integer $IdCentroTrabajoDestino
 */
class VTratamientosTermicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_TratamientosTermicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificacion', 'Descripcion', 'FechaMoldeo'], 'string'],
            [['Hechas', 'Cantidad', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'Fecha', 'IdArea', 'IdSubProceso', 'IdProduccion', 'IdProgramacion'], 'required'],
            [['Hechas', 'Cantidad', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdArea', 'IdSubProceso', 'IdProduccion', 'IdProgramacion', 'IdCentroTrabajoDestino'], 'integer'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Identificacion' => 'Identificacion',
            'Descripcion' => 'Descripcion',
            'Hechas' => 'Hechas',
            'Cantidad' => 'Cantidad',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'Fecha' => 'Fecha',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdArea' => 'Id Area',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProduccion' => 'Id Produccion',
            'IdProgramacion' => 'Id Programacion',
            'IdCentroTrabajoDestino' => 'Id Centro Trabajo Destino',
        ];
    }
}
