<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ResumenDiariaAcero".
 *
 * @property integer $IdArea
 * @property string $TonPrgK
 * @property string $TonPrgV
 * @property string $TonPrgE
 * @property string $TonVacK
 * @property string $TonVacV
 * @property string $TonVacE
 * @property integer $CiclosK
 * @property integer $CiclosV
 * @property integer $CiclosE
 * @property integer $MolPrgK
 * @property integer $MolPrgV
 * @property integer $MolPrgE
 * @property string $Dia
 * @property integer $Anio
 * @property integer $Semana
 */
class VResumenDiariaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ResumenDiariaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Dia', 'Anio', 'Semana'], 'required'],
            [['IdArea', 'CiclosK', 'CiclosV', 'CiclosE', 'MolPrgK', 'MolPrgV', 'MolPrgE', 'Anio', 'Semana'], 'integer'],
            [['TonPrgK', 'TonPrgV', 'TonPrgE', 'TonVacK', 'TonVacV', 'TonVacE'], 'number'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'TonPrgK' => 'Ton Prg K',
            'TonPrgV' => 'Ton Prg V',
            'TonPrgE' => 'Ton Prg E',
            'TonVacK' => 'Ton Vac K',
            'TonVacV' => 'Ton Vac V',
            'TonVacE' => 'Ton Vac E',
            'CiclosK' => 'Ciclos K',
            'CiclosV' => 'Ciclos V',
            'CiclosE' => 'Ciclos E',
            'MolPrgK' => 'Mol Prg K',
            'MolPrgV' => 'Mol Prg V',
            'MolPrgE' => 'Mol Prg E',
            'Dia' => 'Dia',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
        ];
    }
}
