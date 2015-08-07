<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "AlmacenesProducto".
 *
 * @property integer $IdAlmacenProducto
 * @property integer $IdAlmacen
 * @property integer $IdProducto
 * @property string $Existencia
 * @property string $CostoPromedio
 *
 * @property Almacenes $idAlmacen
 * @property Productos $idProducto
 */
class AlmacenesProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmacenesProducto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAlmacen', 'IdProducto', 'Existencia'], 'required'],
            [['IdAlmacen', 'IdProducto'], 'integer'],
            [['Existencia', 'CostoPromedio'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmacenProducto' => 'Id Almacen Producto',
            'IdAlmacen' => 'Id Almacen',
            'IdProducto' => 'Id Producto',
            'Existencia' => 'Existencia',
            'CostoPromedio' => 'Costo Promedio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmacen()
    {
        return $this->hasOne(Almacenes::className(), ['IdAlmacen' => 'IdAlmacen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
