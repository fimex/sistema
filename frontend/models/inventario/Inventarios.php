<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "Inventarios".
 *
 * @property integer $IdInventarios
 * @property string $Fecha
 * @property integer $IdEmpleado
 *
 * @property InventarioMovimientos[] $inventarioMovimientos
 */
class Inventarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Inventarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Fecha', 'IdEmpleado'], 'required'],
            [['Fecha'], 'safe'],
            [['IdEmpleado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventarios' => 'Id Inventarios',
            'Fecha' => 'Fecha',
            'IdEmpleado' => 'Id Empleado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimientos::className(), ['IdInventario' => 'IdInventarios']);
    }
}
