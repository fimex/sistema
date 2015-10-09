<?php

namespace frontend\models\produccion;

use Yii;


/**
 * This is the model class for table "PruebasDestructivas".
 *
 * @property integer $IdPruebaDestructiva
 * @property integer $IdProduccion
 * @property string $SpecimenStandard
 * @property integer $IdProbeta
 *
 * @property Producciones $idProduccion
 * @property Probetas $idProbeta
 * @property Charpy[] $charpies
 * @property Tension[] $tensions
 * @property Dureza[] $durezas
 */
class PruebasDestructivas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PruebasDestructivas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProbeta'], 'integer'],
            [['SpecimenStandard'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'IdProduccion' => 'Id Produccion',
            'SpecimenStandard' => 'Specimen Standard',
            'IdProbeta' => 'Id Probeta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProbeta()
    {
        return $this->hasOne(Probetas::className(), ['IdProbetas' => 'IdProbeta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharpies()
    {
        return $this->hasMany(Charpy::className(), ['IdPruebaDestructiva' => 'IdPruebaDestructiva']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTensions()
    {
        return $this->hasMany(Tension::className(), ['IdPruebaDestructiva' => 'IdPruebaDestructiva']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDurezas()
    {
        return $this->hasMany(Dureza::className(), ['IdPruebaDestructiva' => 'IdPruebaDestructiva']);
    }
}