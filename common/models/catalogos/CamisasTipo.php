<?php

namespace common\models\catalogos;

use Yii;
use common\models\datos\Camisas;

/**
 * This is the model class for table "CamisasTipo".
 *
 * @property integer $IdCamisaTipo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $CantidadPorPaquete
 * @property string $DUX_CodigoPesos
 * @property string $DUX_CodigoDolares
 *
 * @property Camisas[] $camisas
 */
class CamisasTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CamisasTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'required'],
            [['Identificador', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string'],
            [['CantidadPorPaquete'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCamisaTipo' => 'Id Camisa Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'CantidadPorPaquete' => 'Cantidad Por Paquete',
            'DUX_CodigoPesos' => 'Dux  Codigo Pesos',
            'DUX_CodigoDolares' => 'Dux  Codigo Dolares',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCamisas()
    {
        return $this->hasMany(Camisas::className(), ['IdCamisaTipo' => 'IdCamisaTipo']);
    }
    
    public function getCamisasTipo()
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT IdCamisaTipo, Identificador, Descripcion, CantidadPorPaquete, DUX_CodigoPesos, DUX_CodigoDolares FROM CamisasTipo")->queryAll();

        return $result;
    }
}
