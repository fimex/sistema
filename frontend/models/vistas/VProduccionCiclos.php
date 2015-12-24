<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_ProduccionCiclos".
 *
 * @property integer $IdProduccion
 * @property integer $IdProduccionCiclos
 * @property integer $IdProduccionDetalle
 * @property integer $IdProgramacion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property string $Area
 * @property integer $IdArea
 * @property integer $IdTurno
 * @property integer $IdProductos
 * @property string $Producto
 * @property string $Eficiencia
 * @property integer $IdEstatus
 * @property string $Observaciones
 * @property string $Hechas
 * @property string $Rechazadas
 * @property string $Tipo
 * @property string $FechaCreacion
 * @property integer $Linea
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
            [['IdProduccion', 'IdProduccionDetalle', 'IdProgramacion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'Fecha', 'IdSubProceso', 'Area', 'IdArea', 'IdProductos', 'Eficiencia'], 'required'],
            [['IdProduccion', 'IdProduccionCiclos', 'IdProduccionDetalle', 'IdProgramacion', 'IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdArea', 'IdTurno', 'IdProductos', 'IdEstatus', 'Linea'], 'integer'],
            [['Fecha', 'FechaCreacion'], 'safe'],
            [['Area', 'Producto', 'Observaciones', 'Tipo'], 'string'],
            [['Eficiencia', 'Hechas', 'Rechazadas'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdProduccionCiclos' => 'Id Produccion Ciclos',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdProgramacion' => 'Id Programacion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'Area' => 'Area',
            'IdArea' => 'Id Area',
            'IdTurno' => 'Id Turno',
            'IdProductos' => 'Id Productos',
            'Producto' => 'Producto',
            'Eficiencia' => 'Eficiencia',
            'IdEstatus' => 'Id Estatus',
            'Observaciones' => 'Observaciones',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'Tipo' => 'Tipo',
            'FechaCreacion' => 'Fecha Creacion',
            'Linea' => 'Linea',
        ];
    }
}
