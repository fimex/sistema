<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "Materiales".
 *
 * @property integer $IdMaterial
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 *
 * @property MaterialesVaciado[] $materialesVaciados
 * @property SubProcesos $idSubProceso
 * @property Areas $idArea
 */
class Materiales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Materiales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'IdSubProceso', 'IdArea'], 'required'],
            [['Identificador', 'Descripcion'], 'string'],
            [['IdSubProceso', 'IdArea'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterial' => 'Id Material',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialesVaciados()
    {
        return $this->hasMany(MaterialesVaciado::className(), ['IdMaterial' => 'IdMaterial']);
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
}
