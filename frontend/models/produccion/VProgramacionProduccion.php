<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionProduccion".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacionDia
 * @property integer $IdPedido
 * @property integer $IdArea
 * @property integer $IdProgramacionEstatus
 * @property integer $IdProducto
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $IdProceso
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
 * @property integer $IdProduccion
 * @property integer $IdProduccionDetalle
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Inicio
 * @property string $Fin
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $hechasProduccion
 * @property integer $rechazadasProduccion
 */
class VProgramacionProduccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionProduccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdPedido', 'IdArea', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Hechas'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdPedido', 'IdArea', 'IdProgramacionEstatus', 'IdProducto', 'Anio', 'Semana', 'IdProceso', 'IdTurno', 'IdCentroTrabajo', 'IdMaquina', 'Programadas', 'Hechas', 'prioridadSemana', 'programadasSemana', 'hechasSemana', 'prioridadDia', 'programadasDia', 'hechasDia', 'IdProduccion', 'IdProduccionDetalle', 'IdEmpleado', 'IdProduccionEstatus', 'CiclosMolde', 'PiezasMolde', 'hechasProduccion', 'rechazadasProduccion'], 'integer'],
            [['Dia', 'Inicio', 'Fin'], 'safe']
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
            'IdProgramacionEstatus' => 'Id Programacion Estatus',
            'IdProducto' => 'Id Producto',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'IdProceso' => 'Id Proceso',
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
            'IdProduccion' => 'Id Produccion',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'hechasProduccion' => 'Hechas Produccion',
            'rechazadasProduccion' => 'Rechazadas Produccion',
        ];
    }
}
