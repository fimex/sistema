<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_AlmasRebabeo".
 *
 * @property integer $IdProgramacion
 * @property integer $IdArea
 * @property integer $IdProductoCasting
 * @property integer $IdAlma
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
 */
class VAlmasRebabeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_AlmasRebabeo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdArea', 'IdProductoCasting', 'IdAlma', 'IdProducto', 'IdAlmaTipo', 'IdAlmaReceta', 'IdAlmaMaterialCaja', 'Existencia', 'PiezasCaja', 'PiezasMolde'], 'integer'],
            [['IdArea', 'IdAlma', 'IdProducto', 'IdAlmaTipo', 'Alma', 'IdAlmaReceta', 'AlmaReceta', 'IdAlmaMaterialCaja', 'MaterialCaja'], 'required'],
            [['Producto', 'Alma', 'AlmaReceta', 'MaterialCaja'], 'string'],
            [['Peso', 'TiempoLlenado', 'TiempoFraguado', 'TiempoGaseoDirecto', 'TiempoGaseoIndirecto'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdArea' => 'Id Area',
            'IdProductoCasting' => 'Id Producto Casting',
            'IdAlma' => 'Id Alma',
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
        ];
    }
}
