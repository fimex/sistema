<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_Resumen".
 *
 * @property integer $IdArea
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $PrgMol
 * @property string $PrgTon
 * @property string $PrgTonP
 * @property integer $PrgHrs
 * @property integer $HecMol
 * @property string $HecTon
 * @property string $HecTonP
 * @property integer $HecHrs
 */
class VResumen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Resumen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Anio', 'Semana'], 'required'],
            [['IdArea', 'Anio', 'Semana', 'PrgMol', 'PrgHrs', 'HecMol', 'HecHrs'], 'integer'],
            [['PrgTon', 'PrgTonP', 'HecTon', 'HecTonP'], 'number']
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
            'PrgMol' => 'Prg Mol',
            'PrgTon' => 'Prg Ton',
            'PrgTonP' => 'Prg Ton P',
            'PrgHrs' => 'Prg Hrs',
            'HecMol' => 'Hec Mol',
            'HecTon' => 'Hec Ton',
            'HecTonP' => 'Hec Ton P',
            'HecHrs' => 'Hec Hrs',
        ];
    }
}
