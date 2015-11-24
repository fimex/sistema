<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_Calidad".
 *
 * @property integer $IdCentroTrabajo
 * @property integer $Cantidad
 * @property integer $IdSubProceso
 * @property integer $IdEmpleado
 * @property string $Fecha
 * @property integer $IdTurno
 * @property integer $Id
 * @property integer $IdProducto
 * @property string $Descripcion
 * @property string $Identificacion
 */
class VCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Calidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCentroTrabajo', 'Cantidad', 'IdSubProceso', 'IdEmpleado', 'Fecha', 'Id', 'IdProducto'], 'required'],
            [['IdCentroTrabajo', 'Cantidad', 'IdSubProceso', 'IdEmpleado', 'IdTurno', 'Id', 'IdProducto'], 'integer'],
            [['Fecha'], 'safe'],
            [['Descripcion', 'Identificacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Cantidad' => 'Cantidad',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdEmpleado' => 'Id Empleado',
            'Fecha' => 'Fecha',
            'IdTurno' => 'Id Turno',
            'Id' => 'ID',
            'IdProducto' => 'Id Producto',
            'Descripcion' => 'Descripcion',
            'Identificacion' => 'Identificacion',
        ];
    }
}
