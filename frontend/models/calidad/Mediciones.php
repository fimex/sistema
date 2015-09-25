<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "mediciones".
 *
 * @property integer $folio
 * @property integer $no_parte
 * @property string $fecha
 * @property string $maquina
 * @property string $orden_fabricacion
 *
 * @property CatPartes $noParte
 * @property Parmediciones[] $parmediciones
 */
class Mediciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mediciones';
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
            [['no_parte', 'fecha', 'maquina', 'orden_fabricacion'], 'required'],
            [['no_parte'], 'integer'],
            [['fecha'], 'safe'],
            [['maquina', 'orden_fabricacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'folio' => 'Folio',
            'no_parte' => 'No Parte',
            'fecha' => 'Fecha',
            'maquina' => 'Maquina',
            'orden_fabricacion' => 'Orden Fabricacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoParte()
    {
        return $this->hasOne(CatPartes::className(), ['id' => 'no_parte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParmediciones()
    {
        return $this->hasMany(Parmediciones::className(), ['idFolio' => 'folio']);
    }
}
