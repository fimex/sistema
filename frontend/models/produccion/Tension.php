<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Tension".
 *
 * @property integer $IdTension
 * @property integer $IdPruebaDestructiva
 * @property integer $PsiTensileStrength
 * @property integer $PsiYieldStrength
 * @property integer $Elongacin
 * @property integer $ReduccionArea
 *
 * @property PruebasDestructivas $idPruebaDestructiva
 */
class Tension extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tension';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPruebaDestructiva'], 'required'],
            [['IdPruebaDestructiva', 'PsiTensileStrength', 'PsiYieldStrength', 'Elongacin', 'ReduccionArea'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTension' => 'Id Tension',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'PsiTensileStrength' => 'Psi Tensile Strength',
            'PsiYieldStrength' => 'Psi Yield Strength',
            'Elongacin' => 'Elongacin',
            'ReduccionArea' => 'Reduccion Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPruebaDestructiva()
    {
        return $this->hasOne(PruebasDestructivas::className(), ['IdPruebaDestructiva' => 'IdPruebaDestructiva']);
    }
}
