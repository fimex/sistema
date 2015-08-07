<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Vaciados".
 *
 * @property integer $IdProduccion
 * @property integer $IdAleacion
 * @property integer $Colada
 * @property integer $Lance
 * @property integer $HornoConsecutivo
 * @property integer $IdVaciados
 *
 * @property Aleaciones $idAleacion
 * @property Producciones $idProduccion
 */
class Lances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Lances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo', 'IdLance'], 'required'],
            [['IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo', 'IdLance'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdAleacion' => 'Id Aleacion',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'HornoConsecutivo' => 'Horno Consecutivo',
            'IdLance' => 'Id Lance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacion()
    {
        return $this->hasOne(Aleaciones::className(), ['IdAleacion' => 'IdAleacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
    
    public function getLastID(){
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT MAX(IdMaquina) AS ultimoId FROM Maquinas")->queryAll();
        return $result;
    }
            
    
}
