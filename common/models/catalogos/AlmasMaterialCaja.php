<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "AlmasMaterialCaja".
 *
 * @property integer $IdAlmaMaterialCaja
 * @property string $Identificador
 * @property string $Dscripcion
 *
 * @property Almas[] $almas
 */
class AlmasMaterialCaja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmasMaterialCaja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Dscripcion'], 'required'],
            [['Identificador', 'Dscripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmaMaterialCaja' => 'Id Alma Material Caja',
            'Identificador' => 'Identificador',
            'Dscripcion' => 'Dscripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmas()
    {
        return $this->hasMany(Almas::className(), ['IdAlmaMaterialCaja' => 'IdAlmaMaterialCaja']);
    }
    
    public function getAlmasMaterialCaja()
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM AlmasMaterialCaja")->queryAll();

        return $result;
    }
}
