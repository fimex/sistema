<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Probetas".
 *
 * @property integer $IdProbeta
 * @property integer $IdLance
 * @property string $Tipo
 * @property integer $Cantidad
 *
 * @property Lances $idLance
 * @property PruebasDestructivas[] $pruebasDestructivas
 */
class Probetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Probetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdLance'], 'required'],
            [['IdLance', 'Cantidad'], 'integer'],
            [['Tipo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProbeta' => 'Id Probeta',
            'IdLance' => 'Id Lance',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLance()
    {
        return $this->hasOne(Lances::className(), ['IdLance' => 'IdLance']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPruebasDestructivas()
    {
        return $this->hasMany(PruebasDestructivas::className(), ['IdProbeta' => 'IdProbeta']);
    }
}
