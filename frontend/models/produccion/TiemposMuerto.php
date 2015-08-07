<?php

namespace frontend\models\produccion;

use Yii;
use common\models\datos\Causas;
use common\models\datos\Maquinas;

/**
 * This is the model class for table "TiemposMuerto".
 *
 * @property integer $IdTiempoMuerto
 * @property integer $IdMaquina
 * @property integer $IdCausa
 * @property string $Inicio
 * @property string $Fin
 * @property string $Descripcion
 * @property string $Fecha
 *
 * @property Causas $idCausa
 * @property Maquinas $idMaquina
 */
class TiemposMuerto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TiemposMuerto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMaquina', 'IdCausa', 'Inicio', 'Fin'], 'required'],
            [['IdMaquina', 'IdCausa'], 'integer'],
            [['Inicio', 'Fin', 'Fecha'], 'safe'],
            [['Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTiempoMuerto' => 'Id Tiempo Muerto',
            'IdMaquina' => 'Id Maquina',
            'IdCausa' => 'Id Causa',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'Descripcion' => 'Descripcion',
            'Fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCausa()
    {
        return $this->hasOne(Causas::className(), ['IdCausa' => 'IdCausa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }
}
