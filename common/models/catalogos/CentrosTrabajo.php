<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "CentrosTrabajo".
 *
 * @property integer $IdCentroTrabajo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdSubProceso
 * @property integer $IdArea
 *
 * @property SubProcesos $idSubProceso
 * @property Areas $idArea
 * @property Maquinas[] $maquinas
 * @property ProgramacionesDia[] $programacionesDias
 * @property Producciones[] $producciones
 * @property ProgramacionesAlmaDia[] $programacionesAlmaDias
 */
class CentrosTrabajo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CentrosTrabajo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'string'],
            [['IdSubProceso'], 'required'],
            [['IdSubProceso', 'IdArea'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
        ];
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
    public function getMaquinas()
    {
        return $this->hasMany(Maquinas::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmaDias()
    {
        return $this->hasMany(ProgramacionesAlmaDia::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }
}
