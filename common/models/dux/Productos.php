<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "Productos".
 *
 * @property integer $IdProducto
 * @property integer $IdMarca
 * @property integer $IdPresentacion
 * @property integer $IdAleacion
 * @property integer $IdProductoCasting
 * @property string $Identificacion
 * @property string $Descripcion
 * @property integer $PiezasMolde
 * @property integer $CiclosMolde
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $MoldesHora
 * @property integer $CiclosHora
 * @property integer $IdProductosEstatus
 * @property integer $IdAreaAct
 * @property string $FactorTiempoDesmoldeo
 * @property string $Ensamble
 * @property string $LlevaSerie
 * @property integer $IdParteMolde
 * @property integer $FechaMoldeo
 *
 * @property Cajas[] $cajas
 * @property ConfiguracionSeries[] $configuracionSeries
 * @property CentrosTrabajoProductos[] $centrosTrabajoProductos
 * @property AlmasProduccionDetalle[] $almasProduccionDetalles
 * @property MaquinasProductos[] $maquinasProductos
 * @property Camisas[] $camisas
 * @property Programaciones[] $programaciones
 * @property Series[] $series
 * @property FechaMoldeo[] $fechaMoldeos
 * @property ProduccionesDetalle[] $produccionesDetalles
 * @property Filtros[] $filtros
 * @property Aleaciones $idAleacion
 * @property Marcas $idMarca
 * @property Presentaciones $idPresentacion
 * @property Productos $idProductoCasting
 * @property Productos[] $productos
 * @property ProductosEstatus $idProductosEstatus
 * @property AreaActual $idAreaAct
 * @property PartesMolde $idParteMolde
 * @property Almas[] $almas
 * @property ProductosEnsamble[] $productosEnsambles
 * @property Pedidos[] $pedidos
 * @property HistoriaExplosion[] $historiaExplosions
 * @property CiclosVarel[] $ciclosVarels
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMarca', 'IdPresentacion', 'IdAleacion', 'PiezasMolde', 'CiclosMolde', 'PesoCasting', 'PesoArania'], 'required'],
            [['IdMarca', 'IdPresentacion', 'IdAleacion', 'IdProductoCasting', 'PiezasMolde', 'CiclosMolde', 'MoldesHora', 'CiclosHora', 'IdProductosEstatus', 'IdAreaAct', 'IdParteMolde', 'FechaMoldeo'], 'integer'],
            [['Identificacion', 'Descripcion', 'Ensamble', 'LlevaSerie'], 'string'],
            [['PesoCasting', 'PesoArania', 'FactorTiempoDesmoldeo'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProducto' => 'Id Producto',
            'IdMarca' => 'Id Marca',
            'IdPresentacion' => 'Id Presentacion',
            'IdAleacion' => 'Id Aleacion',
            'IdProductoCasting' => 'Id Producto Casting',
            'Identificacion' => 'Identificacion',
            'Descripcion' => 'Descripcion',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'MoldesHora' => 'Moldes Hora',
            'CiclosHora' => 'Ciclos Hora',
            'IdProductosEstatus' => 'Id Productos Estatus',
            'IdAreaAct' => 'Id Area Act',
            'FactorTiempoDesmoldeo' => 'Factor Tiempo Desmoldeo',
            'Ensamble' => 'Ensamble',
            'LlevaSerie' => 'Lleva Serie',
            'IdParteMolde' => 'Id Parte Molde',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCajas()
    {
        return $this->hasMany(Cajas::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionSeries()
    {
        return $this->hasMany(ConfiguracionSeries::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosTrabajoProductos()
    {
        return $this->hasMany(CentrosTrabajoProductos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmasProduccionDetalles()
    {
        return $this->hasMany(AlmasProduccionDetalle::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaquinasProductos()
    {
        return $this->hasMany(MaquinasProductos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCamisas()
    {
        return $this->hasMany(Camisas::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasMany(Series::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFechaMoldeos()
    {
        return $this->hasMany(FechaMoldeo::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdProductos' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiltros()
    {
        return $this->hasMany(Filtros::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacion()
    {
        return $this->hasOne(Aleaciones::className(), ['IdAleacion' => 'IdAleacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMarca()
    {
        return $this->hasOne(Marcas::className(), ['IdMarca' => 'IdMarca']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPresentacion()
    {
        return $this->hasOne(Presentaciones::className(), ['IDPresentacion' => 'IdPresentacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductoCasting()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProductoCasting']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdProductoCasting' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductosEstatus()
    {
        return $this->hasOne(ProductosEstatus::className(), ['IdProductosEstatus' => 'IdProductosEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaAct()
    {
        return $this->hasOne(AreaActual::className(), ['IdAreaAct' => 'IdAreaAct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParteMolde()
    {
        return $this->hasOne(PartesMolde::className(), ['IdParteMolde' => 'IdParteMolde']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmas()
    {
        return $this->hasMany(Almas::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosEnsambles()
    {
        return $this->hasMany(ProductosEnsamble::className(), ['IdComponente' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedidos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoriaExplosions()
    {
        return $this->hasMany(HistoriaExplosion::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiclosVarels()
    {
        return $this->hasMany(CiclosVarel::className(), ['IdProducto' => 'IdProducto']);
    }


    public function getProductosSeries(){

        $command = \Yii::$app->db;
        $model =$command->createCommand("SELECT
                                            Productos.IdProducto,
                                            Productos.Identificacion,
                                            Productos.LlevaSerie
                                        FROM
                                            Productos
                                        LEFT JOIN ConfiguracionSeries ON Productos.IdProducto = ConfiguracionSeries.IdProducto 
                                        WHERE Productos.LlevaSerie = 'Si' ")->queryAll();

        return $model;
    }
}
