<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "SubProcesos".
 *
 * @property integer $IdSubProceso
 * @property integer $IdProceso
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Procesos $idProceso
 * @property CentrosTrabajo[] $centrosTrabajos
 * @property Producciones[] $producciones
 * @property Causas[] $causas
 * @property Materiales[] $materiales
 * @property Defectos[] $defectos
 */
class SubProcesos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SubProcesos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProceso', 'Identificador', 'Descripcion'], 'required'],
            [['IdProceso'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProceso' => 'Id Proceso',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
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
    public function getCentrosTrabajos()
    {
        return $this->hasMany(CentrosTrabajo::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCausas()
    {
        return $this->hasMany(Causas::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateriales()
    {
        return $this->hasMany(Materiales::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefectos()
    {
        return $this->hasMany(Defectos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }
}
