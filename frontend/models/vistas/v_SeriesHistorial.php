<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_SeriesHistorial".
 *
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdSubProceso
 * @property string $Proceso
 * @property integer $IdArea
 * @property string $Fecha
 * @property integer $Programadas
 * @property string $Hechas
 * @property integer $IdProducto
 * @property string $Identificacion
 * @property integer $IdProduccionDetalle
 * @property integer $IdSerie
 * @property string $Estatus
 * @property string $Serie
 * @property integer $IdEmpleado
 */
class v_SeriesHistorial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_SeriesHistorial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdSubProceso', 'Proceso', 'IdArea', 'Fecha', 'Programadas', 'IdProducto', 'IdProduccionDetalle', 'IdEmpleado'], 'required'],
            [['IdProduccion', 'IdCentroTrabajo', 'IdMaquina', 'IdSubProceso', 'IdArea', 'Programadas', 'IdProducto', 'IdProduccionDetalle', 'IdSerie', 'IdEmpleado'], 'integer'],
            [['Proceso', 'Identificacion', 'Estatus', 'Serie'], 'string'],
            [['Fecha'], 'safe'],
            [['Hechas'], 'number']
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
            'IdSubProceso' => 'Id Sub Proceso',
            'Proceso' => 'Proceso',
            'IdArea' => 'Id Area',
            'Fecha' => 'Fecha',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'IdProducto' => 'Id Producto',
            'Identificacion' => 'Identificacion',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdSerie' => 'Id Serie',
            'Estatus' => 'Estatus',
            'Serie' => 'Serie',
            'IdEmpleado' => 'Id Empleado',
        ];
    }
}
