<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Maquinas".
 *
 * @property integer $IdMaquina
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $Consecutivo
 * @property string $Eficiencia
 *
 * @property MaquinasProductos[] $maquinasProductos
 * @property Producciones[] $producciones
 * @property CentrosTrabajoMaquinas[] $centrosTrabajoMaquinas
 * @property ProgramacionesAlmaDia[] $programacionesAlmaDias
 * @property ProgramacionesDia[] $programacionesDias
 * @property Temperaturas[] $temperaturas
 * @property TiemposMuerto[] $tiemposMuertos
 * @property MantenimientoHornos[] $mantenimientoHornos
 */
class Maquinas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Maquinas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'string'],
            [['Consecutivo'], 'integer'],
            [['Eficiencia'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaquina' => 'Id Maquina',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'Consecutivo' => 'Consecutivo',
            'Eficiencia' => 'Eficiencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaquinasProductos()
    {
        return $this->hasMany(MaquinasProductos::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajoMaquinas()
    {
        return $this->hasMany(CentrosTrabajoMaquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmaDias()
    {
        return $this->hasMany(ProgramacionesAlmaDia::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemperaturas()
    {
        return $this->hasMany(Temperaturas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiemposMuertos()
    {
        return $this->hasMany(TiemposMuerto::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientoHornos()
    {
        return $this->hasMany(MantenimientoHornos::className(), ['IdMaquina' => 'IdMaquina']);
    }
}
