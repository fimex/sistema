<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "ProduccionesCiclos".
 *
 * @property integer $IdProduccionCiclos
 * @property integer $IdProduccionDetalle
 * @property integer $IdEstatus
 * @property string $Tipo
 * @property string $FechaCreacion
 * @property integer $Linea
 */
class ProduccionesCiclos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesCiclos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccionDetalle'], 'required'],
            [['IdProduccionDetalle', 'IdEstatus', 'Linea'], 'integer'],
            [['Tipo'], 'string'],
            [['FechaCreacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionCiclos' => 'Id Produccion Ciclos',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdEstatus' => 'Id Estatus',
            'Tipo' => 'Tipo',
            'FechaCreacion' => 'Fecha Creacion',
            'Linea' => 'Linea',
        ];
    }
}
