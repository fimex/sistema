<?php

namespace frontend\models\produccion;

use Yii;


/**
 * This is the model class for table "TiempoAnalisis".
 *
 * @property integer $IdTiempoAnalisis
 * @property integer $IdProduccion
 * @property string $Tiempo
 * @property string $Tipo
 *
 * @property Producciones $idProduccion
 */
class TiempoAnalisis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TiempoAnalisis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'Tiempo', 'Tipo'], 'required'],
            [['IdProduccion'], 'integer'],
            [['Tiempo'], 'safe'],
            [['Tipo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTiempoAnalisis' => 'Id Tiempo Analisis',
            'IdProduccion' => 'Id Produccion',
            'Tiempo' => 'Tiempo',
            'Tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
}
