<?php

namespace frontend\models\produccion;
use frontend\models\produccion\Maquinas;


use Yii;

/**
 * This is the model class for table "MantenimientoHornos".
 *
 * @property integer $IdMantenimientoHorno
 * @property integer $IdMaquina
 * @property string $Fecha
 * @property integer $Consecutivo
 * @property string $Observaciones
 * @property string $Refractario
 *
 * @property Maquinas $idMaquina
 */
class MantenimientoHornos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MantenimientoHornos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMaquina', 'Consecutivo'], 'integer'],
            [['Fecha'], 'safe'],
            [['Observaciones', 'Refractario'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMantenimientoHorno' => 'Id Mantenimiento Horno',
            'IdMaquina' => 'Id Maquina',
            'Fecha' => 'Fecha',
            'Consecutivo' => 'Consecutivo',
            'Observaciones' => 'Observaciones',
            'Refractario' => 'Refractario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }
}
