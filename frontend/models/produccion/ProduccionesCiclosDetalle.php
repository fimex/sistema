<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "ProduccionesCiclosDetalle".
 *
 * @property integer $IdProduccionCiclosDetalle
 * @property integer $IdProduccionCiclos
 * @property integer $IdParteMolde
 *
 * @property PartesMolde $idParteMolde
 * @property ProduccionesCiclos $idProduccionCiclos
 */
class ProduccionesCiclosDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesCiclosDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionCiclos'], 'required'],
            [['IdProduccionCiclos', 'IdParteMolde'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionCiclosDetalle' => 'Id Produccion Ciclos Detalle',
            'IdProduccionCiclos' => 'Id Produccion Ciclos',
            'IdParteMolde' => 'Id Parte Molde',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParteMolde()
    {
        return $this->hasOne(PartesMolde::className(), ['IdParteMolde' => 'IdParteMolde']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionCiclos()
    {
        return $this->hasOne(ProduccionesCiclos::className(), ['IdProduccionCiclos' => 'IdProduccionCiclos']);
    }
}
