<?php

namespace frontend\models\produccion;

use Yii;
use common\models\catalogos\Defectos;

/**
 * This is the model class for table "AlmasProduccionDefecto".
 *
 * @property integer $IdAlmaProduccionDefecto
 * @property integer $IdAlmaProduccionDetalle
 * @property integer $IdDefectoTipo
 * @property integer $Rechazadas
 *
 * @property DefectosTipo $idDefectoTipo
 * @property AlmasProduccionDetalle $idAlmaProduccionDetalle
 */
class AlmasProduccionDefecto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmasProduccionDefecto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAlmaProduccionDetalle', 'IdDefectoTipo'], 'required'],
            [['IdAlmaProduccionDetalle', 'IdDefectoTipo', 'Rechazadas'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmaProduccionDefecto' => 'Id Alma Produccion Defecto',
            'IdAlmaProduccionDetalle' => 'Id Alma Produccion Detalle',
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
    public function getIdAlmaProduccionDetalle()
    {
        return $this->hasOne(AlmasProduccionDetalle::className(), ['IdAlmaProduccionDetalle' => 'IdAlmaProduccionDetalle']);
    }
}
