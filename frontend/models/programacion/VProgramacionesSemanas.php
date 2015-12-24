<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_programacionesSemanas".
 *
 * @property integer $IdProgramacion
 * @property integer $OE_Codigo
 * @property integer $OE_Numero
 * @property string $FechaEmbarque
 * @property integer $Cantidad
 * @property string $Color
 * @property string $SaldoCantidad
 * @property integer $IdEmpleado
 * @property string $Estatus
 * @property string $Producto
 * @property string $Descripcion
 * @property string $ProductoCasting
 * @property string $Marca
 * @property string $Presentacion
 * @property string $Aleacion
 * @property integer $PiezasMolde
 * @property string $PesoArania
 * @property string $PesoAraniaA
 * @property string $PesoCasting
 * @property integer $MoldesHora
 * @property integer $CiclosMolde
 * @property integer $IdProgramacionSemana
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $ProgramadasSemana
 * @property integer $Hechas
 * @property integer $Anio
 * @property integer $Semana
 */
class VProgramacionesSemana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionesSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'OE_Codigo', 'OE_Numero', 'SaldoCantidad', 'IdEmpleado', 'Estatus', 'Marca', 'PiezasMolde', 'PesoArania', 'PesoAraniaA', 'PesoCasting', 'CiclosMolde', 'IdProgramacionSemana', 'Prioridad', 'Programadas', 'ProgramadasSemana', 'Hechas', 'Anio', 'Semana'], 'required'],
            [['IdProgramacion', 'OE_Codigo', 'OE_Numero', 'Cantidad', 'IdEmpleado', 'PiezasMolde', 'MoldesHora', 'CiclosMolde', 'IdProgramacionSemana', 'Prioridad', 'Programadas', 'ProgramadasSemana', 'Hechas', 'Anio', 'Semana'], 'integer'],
            [['FechaEmbarque'], 'safe'],
            [['Color', 'Estatus', 'Producto', 'Descripcion', 'ProductoCasting', 'Marca', 'Presentacion', 'Aleacion'], 'string'],
            [['SaldoCantidad', 'PesoArania', 'PesoAraniaA', 'PesoCasting'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'OE_Codigo' => 'Oe  Codigo',
            'OE_Numero' => 'Oe  Numero',
            'FechaEmbarque' => 'Fecha Embarque',
            'Cantidad' => 'Cantidad',
            'Color' => 'Color',
            'SaldoCantidad' => 'Saldo Cantidad',
            'IdEmpleado' => 'Id Empleado',
            'Estatus' => 'Estatus',
            'Producto' => 'Producto',
            'Descripcion' => 'Descripcion',
            'ProductoCasting' => 'Producto Casting',
            'Marca' => 'Marca',
            'Presentacion' => 'Presentacion',
            'Aleacion' => 'Aleacion',
            'PiezasMolde' => 'Piezas Molde',
            'PesoArania' => 'Peso Arania',
            'PesoAraniaA' => 'Peso Arania A',
            'PesoCasting' => 'Peso Casting',
            'MoldesHora' => 'Moldes Hora',
            'CiclosMolde' => 'Ciclos Molde',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'ProgramadasSemana' => 'Programadas Semana',
            'Hechas' => 'Hechas',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
        ];
    }
}
