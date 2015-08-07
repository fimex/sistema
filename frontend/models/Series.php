<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Series".
 *
 * @property integer $IdSerie
 * @property integer $IdProducto
 * @property integer $IdSubProceso
 * @property string $Serie
 * @property string $Estatus
 *
 * @property Productos $idProducto
 * @property SubProcesos $idSubProceso
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
            [['IdProducto', 'IdSubProceso'], 'required'],
            [['IdProducto', 'IdSubProceso'], 'integer'],
            [['Serie', 'Estatus'], 'string']
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
            'IdSubProceso' => 'Id Sub Proceso',
            'Serie' => 'Serie',
            'Estatus' => 'Estatus',
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
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
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
