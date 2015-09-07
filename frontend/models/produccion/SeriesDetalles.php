<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "SeriesDetalles".
 *
 * @property integer $IdSeriesDetalles
 * @property integer $IdProduccionDetalleMoldeo
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
            [['IdProduccionDetalleMoldeo', 'IdSerie'], 'required'],
            [['IdProduccionDetalleMoldeo', 'IdSerie', 'IdCicloTipo'], 'integer'],
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
            'IdProduccionDetalleMoldeo' => 'Id Produccion Detalle',
            'IdSerie' => 'Id Serie',
            'IdCicloTipo' => 'Id Ciclo Tipo',
            'Comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalleMoldeo()
    {
        return $this->hasOne(ProduccionesDetalleMoldeo::className(), ['IdProduccionDetalleMoldeo' => 'IdProduccionDetalleMoldeo']);
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
