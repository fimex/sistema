<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "ProductosEnsamble".
 *
 * @property integer $IdProductoEnsamble
 * @property integer $IdProducto
 * @property integer $IdComponente
 * @property integer $Cantidad
 * @property integer $SeCompra
 *
 * @property Productos $idProducto
 * @property Productos $idComponente
 */
class ProductosEnsamble extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProductosEnsamble';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'Cantidad'], 'required'],
            [['IdProducto', 'IdComponente', 'Cantidad', 'SeCompra'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProductoEnsamble' => 'Id Producto Ensamble',
            'IdProducto' => 'Id Producto',
            'IdComponente' => 'Id Componente',
            'Cantidad' => 'Cantidad',
            'SeCompra' => 'Se Compra',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComponente()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdComponente']);
    }
}
