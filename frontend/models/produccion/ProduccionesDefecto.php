<?php

namespace frontend\models\produccion;

use Yii;


/**
 * This is the model class for table "ProduccionesDefecto".
 *
 * @property integer $IdProduccionDefecto
 * @property integer $IdProduccionDetalle
 * @property integer $IdDefectoTipo
 * @property integer $Rechazadas
 *
 * @property DefectosTipo $idDefectoTipo
 * @property ProduccionesDetalle $idProduccionDetalle
 */
class ProduccionesDefecto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesDefecto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionDetalle', 'IdDefectoTipo'], 'required'],
            [['IdProduccionDetalle', 'IdDefectoTipo', 'Rechazadas'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionDefecto' => 'Id Produccion Defecto',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdDefectoTipo' => 'Id Defecto Tipo',
            'Rechazadas' => 'Rechazadas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDefectoTipo()
    {
        return $this->hasOne(DefectosTipo::className(), ['IdDefectoTipo' => 'IdDefectoTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
}
