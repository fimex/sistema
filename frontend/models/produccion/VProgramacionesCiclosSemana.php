<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionesCiclosSemana".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdArea
 * @property integer $IdAreaAct
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $IdProducto
 * @property string $Producto
 * @property string $Aleacion
 * @property integer $PiezasMolde
 * @property string $CiclosMolde
 * @property string $CiclosMoldeA
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $FechaMoldeo
 * @property string $LlevaSerie
 * @property integer $SerieInicio
 * @property integer $IdConfiguracionSerie
 * @property integer $IdParteMolde
 * @property integer $OkComponentesMoldeo
 * @property integer $RecComponentesMoldeo
 * @property integer $RepComponentesMoldeo
 * @property integer $RecComponentesCerrado
 * @property integer $OkMoldesCerrados
 * @property string $BaseDivicion
 */
class VProgramacionesCiclosSemana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionesCiclosSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdProgramacionSemana', 'IdArea', 'IdAreaAct', 'Anio', 'Semana', 'IdProducto', 'CiclosMolde', 'CiclosMoldeA', 'BaseDivicion'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdArea', 'IdAreaAct', 'Anio', 'Semana', 'IdProducto', 'PiezasMolde', 'Prioridad', 'Programadas', 'FechaMoldeo', 'SerieInicio', 'IdConfiguracionSerie', 'IdParteMolde', 'OkComponentesMoldeo', 'RecComponentesMoldeo', 'RepComponentesMoldeo', 'RecComponentesCerrado', 'OkMoldesCerrados'], 'integer'],
            [['Producto', 'Aleacion', 'LlevaSerie'], 'string'],
            [['CiclosMolde', 'CiclosMoldeA', 'PesoCasting', 'PesoArania', 'BaseDivicion'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdArea' => 'Id Area',
            'IdAreaAct' => 'Id Area Act',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'Aleacion' => 'Aleacion',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'CiclosMoldeA' => 'Ciclos Molde A',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'FechaMoldeo' => 'Fecha Moldeo',
            'LlevaSerie' => 'Lleva Serie',
            'SerieInicio' => 'Serie Inicio',
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
            'IdParteMolde' => 'Id Parte Molde',
            'OkComponentesMoldeo' => 'Ok Componentes Moldeo',
            'RecComponentesMoldeo' => 'Rec Componentes Moldeo',
            'RepComponentesMoldeo' => 'Rep Componentes Moldeo',
            'RecComponentesCerrado' => 'Rec Componentes Cerrado',
            'OkMoldesCerrados' => 'Ok Moldes Cerrados',
            'BaseDivicion' => 'Base Divicion',
        ];
    }
}
