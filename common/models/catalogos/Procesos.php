<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "Procesos".
 *
 * @property integer $IdProceso
 * @property integer $IdArea
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $Secuencia
 *
 * @property CentrosTrabajo[] $centrosTrabajos
 * @property ProgramacionesDia[] $programacionesDias
 * @property Producciones[] $producciones
 * @property Causas[] $causas
 * @property Areas $idArea
 * @property Defectos[] $defectos
 */
class Procesos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Procesos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Identificador', 'Descripcion'], 'required'],
            [['IdArea', 'Secuencia'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProceso' => 'Id Proceso',
            'IdArea' => 'Id Area',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Moldeado Vaciado',
            'Secuencia' => 'Secuencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajos()
    {
        return $this->hasMany(CentrosTrabajo::className(), ['IdProceso' => 'IdProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdProceso' => 'IdProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdProceso' => 'IdProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCausas()
    {
        return $this->hasMany(Causas::className(), ['IdProceso' => 'IdProceso']);
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
    public function getDefectos()
    {
        return $this->hasMany(Defectos::className(), ['IdProceso' => 'IdProceso']);
    }
}
