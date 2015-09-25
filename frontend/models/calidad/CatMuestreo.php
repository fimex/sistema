<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "cat_muestreo".
 *
 * @property integer $id
 * @property string $AQL
 *
 * @property Parmuestreo[] $parmuestreos
 */
class CatMuestreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_muestreo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mysql_calidad');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AQL'], 'required'],
            [['AQL'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'AQL' => 'Aql',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParmuestreos()
    {
        return $this->hasMany(Parmuestreo::className(), ['idMuestreo' => 'id']);
    }
}
