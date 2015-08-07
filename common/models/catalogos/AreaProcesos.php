<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "AreaProcesos".
 *
 * @property integer $IdAreaProceso
 * @property integer $IdArea
 * @property integer $IdProceso
 *
 * @property Areas $idArea
 * @property Procesos $idProceso
 * @property ProgramacionesDia[] $programacionesDias
 */
class AreaProcesos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AreaProcesos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'IdProceso'], 'required'],
            [['IdArea', 'IdProceso'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAreaProceso' => 'Id Area Proceso',
            'IdArea' => 'Id Area',
            'IdProceso' => 'Id Proceso',
        ];
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
    public function getIdProceso()
    {
        return $this->hasOne(Procesos::className(), ['IdProceso' => 'IdProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdAreaProceso' => 'IdAreaProceso']);
    }
}
