<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_tarimas".
 *
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $IdProgramacionDia
 * @property integer $Loop
 * @property integer $Tarima
 * @property string $Color
 * @property string $Producto
 * @property string $visible
 * @property integer $IdAreaProceso
 * @property integer $IdCentroTrabajo
 * @property integer $Maquina
 * @property integer $IdTurno
 * @property integer $Programadas
 * @property integer $IdProgramacionSemana
 * @property integer $Prioridad
 * @property integer $ProgramadasSemana
 * @property string $CiclosMolde
 * @property string $Aleacion
 * @property string $PesoAraniaA
 * @property string $PesoArania
 * @property integer $TotalProgramado
 * @property integer $IdTarima
 * @property string $Dia
 * @property integer $Posicion
 * @property string $CiclosMoldeA
 */
class VTarimas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_tarimas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Anio', 'Semana', 'IdProgramacionDia', 'Loop', 'Tarima', 'visible', 'IdCentroTrabajo', 'Maquina', 'IdTurno', 'Programadas', 'IdProgramacionSemana', 'PesoAraniaA', 'PesoArania', 'IdTarima', 'Dia'], 'required'],
            [['Anio', 'Semana', 'IdProgramacionDia', 'Loop', 'Tarima', 'IdAreaProceso', 'IdCentroTrabajo', 'Maquina', 'IdTurno', 'Programadas', 'IdProgramacionSemana', 'Prioridad', 'ProgramadasSemana', 'TotalProgramado', 'IdTarima', 'Posicion'], 'integer'],
            [['Color', 'Producto', 'visible', 'Aleacion'], 'string'],
            [['CiclosMolde', 'PesoAraniaA', 'PesoArania', 'CiclosMoldeA'], 'number'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'Loop' => 'Loop',
            'Tarima' => 'Tarima',
            'Color' => 'Color',
            'Producto' => 'Producto',
            'visible' => 'Visible',
            'IdAreaProceso' => 'Id Area Proceso',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Maquina' => 'Maquina',
            'IdTurno' => 'Id Turno',
            'Programadas' => 'Programadas',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'Prioridad' => 'Prioridad',
            'ProgramadasSemana' => 'Programadas Semana',
            'CiclosMolde' => 'Ciclos Molde',
            'Aleacion' => 'Aleacion',
            'PesoAraniaA' => 'Peso Arania A',
            'PesoArania' => 'Peso Arania',
            'TotalProgramado' => 'Total Programado',
            'IdTarima' => 'Id Tarima',
            'Dia' => 'Dia',
            'Posicion' => 'Posicion',
            'CiclosMoldeA' => 'Ciclos Molde A',
        ];
    }
}
