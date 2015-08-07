<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "AleacionesTipoFactor".
 *
 * @property integer $IdAleacionTipoFactor
 * @property integer $IdAleacionTipo
 * @property string $Fecha
 * @property string $Factor
 *
 * @property AleacionesTipo $idAleacionTipo
 */
class AleacionesTipoFactor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AleacionesTipoFactor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAleacionTipo', 'Fecha'], 'required'],
            [['IdAleacionTipoFactor', 'IdAleacionTipo'], 'integer'],
            [['Fecha'], 'safe'],
            [['Factor'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAleacionTipoFactor' => 'Id Aleacion Tipo Factor',
            'IdAleacionTipo' => 'Id Aleacion Tipo',
            'Fecha' => 'Fecha',
            'Factor' => 'Factor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacionTipo()
    {
        return $this->hasOne(AleacionesTipo::className(), ['IdAleacionTipo' => 'IdAleacionTipo']);
    }
}
