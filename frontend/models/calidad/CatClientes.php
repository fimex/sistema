<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "cat_clientes".
 *
 * @property integer $id
 * @property string $cliente
 *
 * @property CatPartes[] $catPartes
 */
class CatClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_clientes';
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
            [['cliente'], 'required'],
            [['cliente'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente' => 'Cliente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatPartes()
    {
        return $this->hasMany(CatPartes::className(), ['cliente' => 'id'])->with('catDimensiones');
    }
}
