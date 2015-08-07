<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_lances".
 *
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdLance
 * @property integer $IdAleacion
 * @property integer $Colada
 * @property integer $Lance
 * @property integer $HornoConsecutivo
 */
class VLances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_lances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'IdArea', 'IdLance', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo'], 'required'],
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdArea', 'IdLance', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo'], 'integer'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'IdLance' => 'Id Lance',
            'IdAleacion' => 'Id Aleacion',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'HornoConsecutivo' => 'Horno Consecutivo',
        ];
    }
}
