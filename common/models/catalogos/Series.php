<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "Series".
 *
 * @property integer $IdSerie
 * @property integer $IdProducto
 * @property integer $IdAlmacen
 * @property string $ParteMolde
 *
 * @property SeriesDetalles[] $seriesDetalles
 * @property SeriesPartidas[] $seriesPartidas
 */
class Series extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Series';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdAlmacen', 'ParteMolde'], 'required'],
            [['IdProducto', 'IdAlmacen'], 'integer'],
            [['ParteMolde'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSerie' => 'Id Serie',
            'IdProducto' => 'Id Producto',
            'IdAlmacen' => 'Id Almacen',
            'ParteMolde' => 'Parte Molde',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesDetalles()
    {
        return $this->hasMany(SeriesDetalles::className(), ['IdSerie' => 'IdSerie']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesPartidas()
    {
        return $this->hasMany(SeriesPartidas::className(), ['IdSerie' => 'IdSerie']);
    }
}
