<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "SeriesDetalles".
 *
 * @property integer $IdSeriesDetalles
 * @property integer $IdProduccionDetalle
 * @property integer $IdSerie
 * @property string $Comentarios
 *
 * @property ProduccionesDetalle $idProduccionDetalle
 * @property Series $idSerie
 */
class SeriesDetalles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SeriesDetalles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionDetalle', 'IdSerie'], 'required'],
            [['IdProduccionDetalle', 'IdSerie'], 'integer'],
            [['Comentarios', 'Estatus'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSeriesDetalles' => 'Id Series Detalles',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdSerie' => 'Id Serie',
            'Comentarios' => 'Comentarios',
            'Estatus' => 'Estatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalleMoldeo::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSerie()
    {
        return $this->hasOne(Series::className(), ['IdSerie' => 'IdSerie']);
    }

}
