<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionesAlmaDia".
 *
 * @property integer $IdProducto
 * @property string $Producto
 * @property integer $IdAlmaTipo
 * @property string $Alma
 * @property integer $IdAlmaReceta
 * @property string $AlmaReceta
 * @property integer $IdAlmaMaterialCaja
 * @property string $MaterialCaja
 * @property integer $Existencia
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property double $Peso
 * @property double $TiempoLlenado
 * @property double $TiempoFraguado
 * @property double $TiempoGaseoDirecto
 * @property double $TiempoGaseoIndirecto
 * @property integer $IdProgramacionAlma
 * @property integer $IdProgramacionAlmaSemana
 * @property integer $IdProgramacionAlmaDia
 * @property string $Dia
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 */
class VProgramacionesAlmaDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionesAlmaDia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdAlmaTipo', 'Alma', 'IdAlmaReceta', 'AlmaReceta', 'IdAlmaMaterialCaja', 'MaterialCaja', 'IdProgramacionAlma', 'IdProgramacionAlmaSemana', 'IdProgramacionAlmaDia', 'Dia', 'Prioridad', 'Programadas', 'Hechas', 'IdCentroTrabajo', 'IdMaquina'], 'required'],
            [['IdProducto', 'IdAlmaTipo', 'IdAlmaReceta', 'IdAlmaMaterialCaja', 'Existencia', 'PiezasCaja', 'PiezasMolde', 'IdProgramacionAlma', 'IdProgramacionAlmaSemana', 'IdProgramacionAlmaDia', 'Prioridad', 'Programadas', 'Hechas', 'IdCentroTrabajo', 'IdMaquina'], 'integer'],
            [['Producto', 'Alma', 'AlmaReceta', 'MaterialCaja'], 'string'],
            [['Peso', 'TiempoLlenado', 'TiempoFraguado', 'TiempoGaseoDirecto', 'TiempoGaseoIndirecto'], 'number'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'Alma' => 'Alma',
            'IdAlmaReceta' => 'Id Alma Receta',
            'AlmaReceta' => 'Alma Receta',
            'IdAlmaMaterialCaja' => 'Id Alma Material Caja',
            'MaterialCaja' => 'Material Caja',
            'Existencia' => 'Existencia',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'Peso' => 'Peso',
            'TiempoLlenado' => 'Tiempo Llenado',
            'TiempoFraguado' => 'Tiempo Fraguado',
            'TiempoGaseoDirecto' => 'Tiempo Gaseo Directo',
            'TiempoGaseoIndirecto' => 'Tiempo Gaseo Indirecto',
            'IdProgramacionAlma' => 'Id Programacion Alma',
            'IdProgramacionAlmaSemana' => 'Id Programacion Alma Semana',
            'IdProgramacionAlmaDia' => 'Id Programacion Alma Dia',
            'Dia' => 'Dia',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
        ];
    }
}
