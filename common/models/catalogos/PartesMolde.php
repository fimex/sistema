<?php

namespace common\models\catalogos;


use Yii;

/**
 * This is the model class for table "PartesMolde".
 *
 * @property integer $IdParteMolde
 * @property string $Identificador
 */
class PartesMolde extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PartesMolde';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador'], 'required'],
            [['Identificador'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdParteMolde' => 'Id Parte Molde',
            'Identificador' => 'Identificador',
        ];
    }
}
