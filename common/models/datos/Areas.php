<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Areas".
 *
 * @property integer $IdArea
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $AgruparPedidos
 *
 * @property CentrosTrabajo[] $centrosTrabajos
 * @property AreaProcesos[] $areaProcesos
 * @property Programaciones[] $programaciones
 * @property Producciones[] $producciones
 * @property Causas[] $causas
 * @property Materiales[] $materiales
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea'], 'required'],
            [['IdArea', 'AgruparPedidos'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'AgruparPedidos' => 'Agrupar Pedidos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajos()
    {
        return $this->hasMany(CentrosTrabajo::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaProcesos()
    {
        return $this->hasMany(AreaProcesos::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCausas()
    {
        return $this->hasMany(Causas::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateriales()
    {
        return $this->hasMany(Materiales::className(), ['IdArea' => 'IdArea']);
    }
}
