<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Charpy".
 *
 * @property integer $IdCharpy
 * @property integer $IdPruebaDestructiva
 * @property double $Espesor
 * @property double $Ancho
 * @property double $Largo
 * @property double $Profundo
 * @property integer $Angulo
 * @property double $ResultadoLBFT
 * @property double $Temperatura
 * @property string $Resultado
 *
 * @property PruebasDestructivas $idPruebaDestructiva
 */
class Charpy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Charpy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPruebaDestructiva'], 'required'],
            [['IdPruebaDestructiva', 'Angulo'], 'integer'],
            [['Espesor', 'Ancho', 'Largo', 'Profundo', 'ResultadoLBFT', 'Temperatura'], 'number'],
            [['Resultado'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCharpy' => 'Id Charpy',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'Espesor' => 'Espesor',
            'Ancho' => 'Ancho',
            'Largo' => 'Largo',
            'Profundo' => 'Profundo',
            'Angulo' => 'Angulo',
            'ResultadoLBFT' => 'Resultado Lbft',
            'Temperatura' => 'Temperatura',
            'Resultado' => 'Resultado',
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
