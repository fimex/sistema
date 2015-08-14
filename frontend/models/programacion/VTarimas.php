<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_Tarimas".
 *
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $IdProgramacionDia
 * @property integer $Loop
 * @property integer $Tarima
 * @property string $Color
 */
class VTarimas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Tarimas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Anio', 'Semana', 'Dia', 'IdProgramacionDia', 'Loop', 'Tarima'], 'required'],
            [['Anio', 'Semana', 'IdProgramacionDia', 'Loop', 'Tarima'], 'integer'],
            [['Dia'], 'safe'],
            [['Color'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'Loop' => 'Loop',
            'Tarima' => 'Tarima',
            'Color' => 'Color',
        ];
    }
}
