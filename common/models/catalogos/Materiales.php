<?php

namespace common\models\catalogos;

use Yii;
use common\models\catalogos\MaterialesTipo;

/**
 * This is the model class for table "Materiales".
 *
 * @property integer $IdMaterial
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property integer $IdMaterialTipo
 *
 * @property MaterialesTipo $idMaterialTipo
 * @property Areas $idArea
 * @property SubProcesos $idSubProceso
 * @property MaterialesVaciado[] $materialesVaciados
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
            [['Identificador', 'Descripcion'], 'string'],
            [['IdSubProceso', 'IdArea', 'IdMaterialTipo'], 'required'],
            [['IdSubProceso', 'IdArea', 'IdMaterialTipo'], 'integer']
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
            'IdMaterialTipo' => 'Id Material Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaterialTipo()
    {
        return $this->hasOne(MaterialesTipo::className(), ['IdMaterialTipo' => 'IdMaterialTipo']);
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
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialesVaciados()
    {
        return $this->hasMany(MaterialesVaciado::className(), ['IdMaterial' => 'IdMaterial']);
    }
}
