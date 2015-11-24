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
 *
 * @property ProduccionesCiclosDetalle[] $produccionesCiclosDetalles
 * @property CiclosTipo $idEstatus
 * @property ProduccionesDetalle $idProduccionDetalle
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesCiclosDetalles()
    {
        return $this->hasMany(ProduccionesCiclosDetalle::className(), ['IdProduccionCiclos' => 'IdProduccionCiclos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionDetalle()
    {
        return $this->hasOne(ProduccionesDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstatus()
    {
        return $this->hasOne(CiclosTipo::className(), ['IdCicloTipo' => 'IdEstatus']);
    }
}
