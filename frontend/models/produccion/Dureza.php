<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Dureza".
 *
 * @property integer $IdDureza
 * @property integer $IdPruebaDestructiva
 * @property integer $DurezaBrinelHB
 * @property integer $DurezaRockwellHRC
 * @property double $DiametroHuella
 *
 * @property PruebasDestructivas $idPruebaDestructiva
 */
class Dureza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Dureza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPruebaDestructiva', 'DurezaBrinelHB', 'DurezaRockwellHRC'], 'integer'],
            [['DiametroHuella'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDureza' => 'Id Dureza',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'DurezaBrinelHB' => 'Dureza Brinel Hb',
            'DurezaRockwellHRC' => 'Dureza Rockwell Hrc',
            'DiametroHuella' => 'Diametro Huella',
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
