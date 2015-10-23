<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ProduccionesDetalle".
 *
 * @property integer $IdProduccionDetalle
 * @property integer $IdProduccion
 * @property integer $IdProgramacion
 * @property integer $IdProductos
 * @property string $Inicio
 * @property string $Fin
 * @property integer $CiclosMolde
 * @property integer $PiezasMolde
 * @property integer $Programadas
 * @property string $Hechas
 * @property string $Rechazadas
 * @property string $Eficiencia
 * @property integer $IdEstatus
 * @property string $FechaMoldeo
 *
 * @property ProduccionesDetalleMaterialVaciado[] $produccionesDetalleMaterialVaciados
 * @property SeriesDetalles[] $seriesDetalles
 * @property Evidencias[] $evidencias
 * @property Estatus $idEstatus
 * @property Producciones $idProduccion
 * @property Productos $idProductos
 * @property Programaciones $idProgramacion
 * @property FechaMoldeoDetalle[] $fechaMoldeoDetalles
 * @property ProduccionesDefecto[] $produccionesDefectos
 * @property ProduccionesCiclos[] $produccionesCiclos
 */
class ProduccionesDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProgramacion', 'IdProductos', 'Eficiencia'], 'required'],
            [['IdProduccion', 'IdProgramacion', 'IdProductos', 'CiclosMolde', 'PiezasMolde', 'Programadas', 'IdEstatus'], 'integer'],
            [['Inicio', 'Fin'], 'safe'],
            [['Hechas', 'Rechazadas', 'Eficiencia'], 'number'],
            [['FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdProduccion' => 'Id Produccion',
            'IdProgramacion' => 'Id Programacion',
            'IdProductos' => 'Id Productos',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'CiclosMolde' => 'Ciclos Molde',
            'PiezasMolde' => 'Piezas Molde',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'Eficiencia' => 'Eficiencia',
            'IdEstatus' => 'Id Estatus',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalleMaterialVaciados()
    {
        return $this->hasMany(ProduccionesDetalleMaterialVaciado::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesDetalles()
    {
        return $this->hasMany(SeriesDetalles::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidencias()
    {
        return $this->hasMany(Evidencias::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstatus()
    {
        return $this->hasOne(Estatus::className(), ['IdEstatus' => 'IdEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductos()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProductos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacion()
    {
        return $this->hasOne(Programaciones::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFechaMoldeoDetalles()
    {
        return $this->hasMany(FechaMoldeoDetalle::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDefectos()
    {
        return $this->hasMany(ProduccionesDefecto::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesCiclos()
    {
        return $this->hasMany(ProduccionesCiclos::className(), ['IdProduccionDetalle' => 'IdProduccionDetalle']);
    }
}
