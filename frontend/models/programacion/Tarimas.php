<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "Tarimas".
 *
 * @property integer $IdTarima
 * @property integer $IdProgramacionDia
 * @property integer $Loop
 * @property integer $Tarima
 * @property string $Dia
 *
 * @property ProgramacionesDia $idProgramacionDia
 */
class Tarimas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tarimas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacionDia', 'Loop', 'Tarima'], 'required'],
            [['IdProgramacionDia', 'Loop', 'Tarima'], 'integer'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTarima' => 'Id Tarima',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'Loop' => 'Loop',
            'Tarima' => 'Tarima',
            'Dia' => 'Dia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionDia()
    {
        return $this->hasOne(ProgramacionesDia::className(), ['IdProgramacionDia' => 'IdProgramacionDia']);
    }
}
