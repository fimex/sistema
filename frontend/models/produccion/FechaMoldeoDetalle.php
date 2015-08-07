<?php

namespace frontend\models\produccion;


use Yii;

/**
 * This is the model class for table "FechaMoldeoDetalle".
 *
 * @property integer $IdFechaMoldeoDetalle
 * @property integer $IdProduccionDetalle
 * @property integer $IdFechaMoldeo
 *
 * @property FechaMoldeo $idFechaMoldeo
 * @property ProduccionesDetalle $idProduccionDetalle
 */
class FechaMoldeoDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FechaMoldeoDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdFechaMoldeo', 'IdProduccionDetalle'], 'required'],
            [['IdFechaMoldeo', 'IdProduccionDetalle'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdFechaMoldeoDetalle' => 'Id Fecha Moldeo Detalle',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdFechaMoldeo' => 'Id Fecha Moldeo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFechaMoldeo()
    {
        return $this->hasOne(FechaMoldeo::className(), ['IdFechaMoldeo' => 'IdFechaMoldeo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
}
