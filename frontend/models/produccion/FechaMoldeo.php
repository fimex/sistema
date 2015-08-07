<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "FechaMoldeo".
 *
 * @property integer $IdFechaMoldeo
 * @property integer $IdProducto
 * @property string $FechaMoldeo
 *
 * @property Productos $idProducto
 * @property FechaMoldeoDetalle[] $fechaMoldeoDetalles
 * @property ResumenFechaMoldeo[] $resumenFechaMoldeos
 */
class FechaMoldeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FechaMoldeo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto'], 'integer'],
            [['FechaMoldeo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdFechaMoldeo' => 'Id Fecha Moldeo',
            'IdProducto' => 'Id Producto',
            'FechaMoldeo' => 'Fecha Moldeo',
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
    public function getFechaMoldeoDetalles()
    {
        return $this->hasMany(FechaMoldeoDetalle::className(), ['IdFechaMoldeo' => 'IdFechaMoldeo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumenFechaMoldeos()
    {
        return $this->hasMany(ResumenFechaMoldeo::className(), ['IdFechaMoldeo' => 'IdFechaMoldeo']);
    }
}
