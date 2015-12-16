<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "SeriesDetalleProdCiclosDetalle".
 *
 * @property integer $idSeriesDetalleProdCiclosDetalle
 * @property integer $idSeriesDetalle
 * @property integer $idprodCiclosDetalle
 *
 * @property ProduccionesCiclosDetalle $idprodCiclosDetalle0
 * @property SeriesDetalles $idSeriesDetalle0
 */
class SeriesDetalleProdCiclosDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SeriesDetalleProdCiclosDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSeriesDetalle', 'idprodCiclosDetalle'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idSeriesDetalleProdCiclosDetalle' => 'Id Series Detalle Prod Ciclos Detalle',
            'idSeriesDetalle' => 'Id Series Detalle',
            'idprodCiclosDetalle' => 'Idprod Ciclos Detalle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprodCiclosDetalle0()
    {
        return $this->hasOne(ProduccionesCiclosDetalle::className(), ['IdProduccionCiclosDetalle' => 'idprodCiclosDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSeriesDetalle0()
    {
        return $this->hasOne(SeriesDetalles::className(), ['IdSeriesDetalles' => 'idSeriesDetalle']);
    }
}
