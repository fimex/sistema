<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "SeriesDetalles".
 *
 * @property integer $IdSeriesDetalles
 * @property integer $IdProduccionDetalle
 * @property integer $IdSerie
 * @property integer $IdCicloTipo
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
            [['IdProduccionDetalle', 'IdSerie', 'IdCicloTipo'], 'integer'],
            [['Comentarios'], 'string']
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
            'IdCicloTipo' => 'Id Ciclo Tipo',
            'Comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSerie()
    {
        return $this->hasOne(Series::className(), ['IdSerie' => 'IdSerie']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiclosTipo()
    {
        return $this->hasMany(CiclosTipo::className(), ['IdCicloTipo' => 'IdCicloTipo']);
    }
}
