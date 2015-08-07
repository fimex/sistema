<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "v_almas".
 *
 * @property integer $IdAlma
 * @property integer $IdProducto
 * @property integer $IdAlmaTipo
 * @property integer $IdAlmaMaterialCaja
 * @property integer $IdAlmaReceta
 * @property integer $Existencia
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property double $Peso
 * @property double $TiempoLlenado
 * @property double $TiempoFraguado
 * @property double $TiempoGaseoDirectro
 * @property double $TiempoGaseoIndirecto
 * @property string $Tipo
 * @property string $Receta
 * @property string $caja
 */
class VAlmas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_almas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAlma', 'IdProducto', 'IdAlmaTipo', 'IdAlmaMaterialCaja', 'IdAlmaReceta', 'Existencia', 'PiezasCaja', 'PiezasMolde', 'Tipo', 'Receta', 'caja'], 'required'],
            [['IdAlma', 'IdProducto', 'IdAlmaTipo', 'IdAlmaMaterialCaja', 'IdAlmaReceta', 'Existencia', 'PiezasCaja', 'PiezasMolde'], 'integer'],
            [['Peso', 'TiempoLlenado', 'TiempoFraguado', 'TiempoGaseoDirectro', 'TiempoGaseoIndirecto'], 'number'],
            [['Tipo', 'Receta', 'caja'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlma' => 'Id Alma',
            'IdProducto' => 'Id Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'IdAlmaMaterialCaja' => 'Id Alma Material Caja',
            'IdAlmaReceta' => 'Id Alma Receta',
            'Existencia' => 'Existencia',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'Peso' => 'Peso',
            'TiempoLlenado' => 'Tiempo Llenado',
            'TiempoFraguado' => 'Tiempo Fraguado',
            'TiempoGaseoDirectro' => 'Tiempo Gaseo Directro',
            'TiempoGaseoIndirecto' => 'Tiempo Gaseo Indirecto',
            'Tipo' => 'Tipo',
            'Receta' => 'Receta',
            'caja' => 'Caja',
        ];
    }
}
