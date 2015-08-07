<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "AlmasTipo".
 *
 * @property integer $IdAlmaTipo
 * @property string $Identificador
 * @property string $Descrfipcion
 *
 * @property Almas[] $almas
 */
class AlmasTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmasTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descrfipcion'], 'required'],
            [['Identificador', 'Descrfipcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmaTipo' => 'Id Alma Tipo',
            'Identificador' => 'Identificador',
            'Descrfipcion' => 'Descrfipcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getAlmas()
    {
        return $this->hasMany(Almas::className(), ['IdAlmaTipo' => 'IdAlmaTipo']);
    }*/
    
     public function getAlmasTipo()
     {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM AlmasTipo")->queryAll();

        return $result;
    }
}
