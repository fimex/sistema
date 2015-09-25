<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "cat_inspeccion".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo_formato
 *
 * @property Parmediciones[] $parmediciones
 */
class CatInspeccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_inspeccion';
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
            [['nombre', 'codigo_formato'], 'required'],
            [['nombre', 'codigo_formato'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'codigo_formato' => 'Codigo Formato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParmediciones()
    {
        return $this->hasMany(Parmediciones::className(), ['inspeccion' => 'id']);
    }
}
