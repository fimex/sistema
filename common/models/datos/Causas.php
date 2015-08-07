<?php

namespace common\models\datos;

use Yii;
use common\models\catalogos\CausasTipo;

/**
 * This is the model class for table "Causas".
 *
 * @property integer $IdCausa
 * @property integer $IdCausaTipo
 * @property string $Indentificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 *
 * @property TiemposMuerto[] $tiemposMuertos
 * @property SubProcesos $idSubProceso
 * @property Areas $idArea
 * @property CausasTipo $idCausaTipo
 */
class Causas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Causas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCausaTipo', 'Descripcion', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdCausaTipo', 'IdSubProceso', 'IdArea'], 'integer'],
            [['Indentificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCausa' => 'Id Causa',
            'IdCausaTipo' => 'Id Causa Tipo',
            'Indentificador' => 'Indentificador',
            'Descripcion' => 'Descripcion',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiemposMuertos()
    {
        return $this->hasMany(TiemposMuerto::className(), ['IdCausa' => 'IdCausa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Areas::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCausaTipo()
    {
        return $this->hasOne(CausasTipo::className(), ['IdCausaTipo' => 'IdCausaTipo']);
    }
}
