<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ResumenAcero".
 *
 * @property integer $IdArea
 * @property integer $Anio
 * @property integer $Semana
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
 */
class VResumenAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ResumenAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Anio', 'Semana'], 'required'],
            [['IdArea', 'Anio', 'Semana', 'CiclosK', 'CiclosV', 'CiclosE', 'MolPrgK', 'MolPrgV', 'MolPrgE'], 'integer'],
            [['TonPrgK', 'TonPrgV', 'TonPrgE', 'TonVacK', 'TonVacV', 'TonVacE'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
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
        ];
    }
}
