<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "mediciones_dimenciones".
 *
 * @property integer $parMedicion
 * @property integer $dimension
 * @property integer $pieza
 * @property string $medida
 * @property string $serie
 *
 * @property Parmediciones $parMedicion0
 * @property CatDimensiones $dimension0
 */
class MedicionesDimenciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mediciones_dimenciones';
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
            [['parMedicion', 'dimension', 'pieza', 'medida'], 'required'],
            [['parMedicion', 'dimension', 'pieza'], 'integer'],
            [['medida'], 'number'],
            [['serie'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parMedicion' => 'Par Medicion',
            'dimension' => 'Dimension',
            'pieza' => 'Pieza',
            'medida' => 'Medida',
            'serie' => 'Serie',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParMedicion0()
    {
        return $this->hasOne(Parmediciones::className(), ['id' => 'parMedicion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDimension0()
    {
        return $this->hasOne(CatDimensiones::className(), ['id' => 'dimension']);
    }
}
