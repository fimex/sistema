<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "Almacenes".
 *
 * @property integer $IdAlmacen
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property AlmacenesProducto[] $almacenesProductos
 * @property Pedidos[] $pedidos
 */
class Almacenes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Almacenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmacen' => 'Id Almacen',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmacenesProductos()
    {
        return $this->hasMany(AlmacenesProducto::className(), ['IdAlmacen' => 'IdAlmacen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedidos::className(), ['IdAlmacen' => 'IdAlmacen']);
    }
}
