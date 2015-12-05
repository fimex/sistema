<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "EstatusMonitoreo".
 *
 * @property integer $IdEstatuMonitoreo
 * @property integer $IdProducto
 * @property integer $IdProgramacionSemana
 * @property integer $IdTipoEstatusUbic
 * @property integer $IdTipoMonitoreo
 * @property string $Fecha
 * @property string $Comentarios
 *
 * @property ProgramacionesSemana $idProgramacionSemana
 * @property Productos $idProducto
 * @property TipoEstatusUbic $idTipoEstatusUbic
 * @property TipoMonitoreo $idTipoMonitoreo
 */
class EstatusMonitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EstatusMonitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdProgramacionSemana', 'IdTipoEstatusUbic', 'IdTipoMonitoreo'], 'integer'],
            [['IdTipoEstatusUbic', 'Fecha'], 'required'],
            [['Fecha'], 'safe'],
            [['Comentarios'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEstatuMonitoreo' => 'Id Estatu Monitoreo',
            'IdProducto' => 'Id Producto',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdTipoEstatusUbic' => 'Id Tipo Estatus Ubic',
            'IdTipoMonitoreo' => 'Id Tipo Monitoreo',
            'Fecha' => 'Fecha',
            'Comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionSemana()
    {
        return $this->hasOne(ProgramacionesSemana::className(), ['IdProgramacionSemana' => 'IdProgramacionSemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEstatusUbic()
    {
        return $this->hasOne(TipoEstatusUbic::className(), ['IdTipoEstatusUbic' => 'IdTipoEstatusUbic']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoMonitoreo()
    {
        return $this->hasOne(TipoMonitoreo::className(), ['IdTipoMonitoreo' => 'IdTipoMonitoreo']);
    }
}
