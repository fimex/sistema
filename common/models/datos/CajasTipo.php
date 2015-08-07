<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "CajasTipo".
 *
 * @property integer $IdTipoCaja
 * @property string $Tamano
 * @property integer $PiezasCaja
 *
 * @property Cajas[] $cajas
 */
class CajasTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CajasTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tamano', 'PiezaXCaja'], 'required'],
            [['IdTipoCaja', 'PiezasCaja'], 'integer'],
            [['Tamano'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoCaja' => 'Id Tipo Caja',
            'Tamano' => 'Tamano',
            'PiezasCaja' => 'Pieza Xcaja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCajas()
    {
        return $this->hasMany(Cajas::className(), ['IdTipoCaja' => 'IdTipoCaja']);
    }
    
      public function getCajasTipo()
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM CajasTipo")->queryAll();

        return $result;
    }
}
