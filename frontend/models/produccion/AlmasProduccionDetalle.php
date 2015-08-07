<?php

namespace frontend\models\produccion;

use Yii;

use common\models\catalogos\AlmasTipo; 
use common\models\dux\Productos;

/**
 * This is the model class for table "AlmasProduccionDetalle".
 *
 * @property integer $IdAlmaProduccionDetalle
 * @property integer $IdProduccion
 * @property integer $IdProgramacionAlma
 * @property integer $IdProducto
 * @property integer $IdAlmaTipo
 * @property string $Inicio
 * @property string $Fin
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $Rechazadas
 * @property integer $PiezasCaja
 * @property integer $PiezasMolde
 * @property integer $PiezasHora
 *
 * @property AlmasTipo $idAlmaTipo
 * @property Producciones $idProduccion
 * @property ProgramacionesAlma $idProgramacionAlma
 * @property Productos $idProducto
 * @property AlmasProduccionDefecto[] $almasProduccionDefectos
 */
class AlmasProduccionDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmasProduccionDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdProgramacionAlma', 'IdProducto', 'IdAlmaTipo', 'Programadas', 'Rechazadas', 'PiezasCaja', 'PiezasMolde'], 'required'],
            [['IdProduccion', 'IdProgramacionAlma', 'IdProducto', 'IdAlmaTipo', 'Programadas', 'Hechas', 'Rechazadas', 'PiezasCaja', 'PiezasMolde', 'PiezasHora'], 'integer'],
            [['Inicio', 'Fin'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAlmaProduccionDetalle' => 'Id Alma Produccion Detalle',
            'IdProduccion' => 'Id Produccion',
            'IdProgramacionAlma' => 'Id Programacion Alma',
            'IdProducto' => 'Id Producto',
            'IdAlmaTipo' => 'Id Alma Tipo',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
            'PiezasCaja' => 'Piezas Caja',
            'PiezasMolde' => 'Piezas Molde',
            'PiezasHora' => 'Piezas Hora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlmaTipo()
    {
        return $this->hasOne(AlmasTipo::className(), ['IdAlmaTipo' => 'IdAlmaTipo']);
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
    public function getIdProgramacionAlma()
    {
        return $this->hasOne(ProgramacionesAlma::className(), ['IdProgramacionAlma' => 'IdProgramacionAlma']);
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
    public function getAlmasProduccionDefectos()
    {
        return $this->hasMany(AlmasProduccionDefecto::className(), ['IdAlmaProduccionDetalle' => 'IdAlmaProduccionDetalle']);
    }
}
