<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "DurezaTipo".
 *
 * @property integer $IdDurezaTipo
 * @property string $DiametroHuella
 * @property integer $Dureza
 * @property integer $HRC
 */
class DurezaTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DurezaTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DiametroHuella'], 'number'],
            [['Dureza', 'HRC'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDurezaTipo' => 'Id Dureza Tipo',
            'DiametroHuella' => 'Diametro Huella',
            'Dureza' => 'Dureza',
            'HRC' => 'Hrc',
        ];
    }
}
