<?php

namespace frontend\models\programacion;

use Yii;
use yii\data\ArrayDataProvider;
use frontend\models\programacion\ProgramacionesSemana;

/**
 * This is the model class for table "Programaciones".
 *
 * @property integer $IdProgramacion
 * @property integer $IdPedido
 * @property integer $IdArea
 * @property integer $IdEmpleado
 * @property integer $IdProgramacionEstatus
 * @property integer $IdProducto
 * @property integer $Programadas
 * @property integer $Hechas
 *
 * @property ProgramacionesSemana[] $programacionesSemanas
 * @property Empleados $idEmpleado
 * @property Areas $idArea
 * @property Pedidos $idPedido
 * @property Productos $idProducto
 * @property ProgramacionesEstatus $idProgramacionEstatus
 * @property ProduccionesDetalle[] $produccionesDetalles
 * @property ProgramacionesAlma[] $programacionesAlmas
 */
class Programacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Programaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Hechas'], 'required'],
            [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Hechas'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdPedido' => 'Id Pedido',
            'IdArea' => 'Id Area',
            'IdEmpleado' => 'Id Empleado',
            'IdProgramacionEstatus' => 'Id Programacion Estatus',
            'IdProducto' => 'Id Producto',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesSemanas()
    {
        return $this->hasMany(ProgramacionesSemana::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
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
    public function getIdPedido()
    {
        return $this->hasOne(Pedidos::className(), ['IdPedido' => 'IdPedido']);
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
    public function getIdProgramacionEstatus()
    {
        return $this->hasOne(ProgramacionesEstatus::className(), ['IdProgramacionEstatus' => 'IdProgramacionEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdProgramacion' => 'IdProgramacion']);
    }
    
    public function getProgramacionSemanal($IdArea,$IdProceso,$data)
    {
        //obtengo datos desde un f_GetProgramaciones mediante un SELECT
        $command = \Yii::$app->db;
        
        if($IdArea == 2){
            $where = "";//"WHERE IdAreaAct IN(1,2,3)";
            $from = "f_GetProgramacionesAcero";
        }else{
            $where = "";//"WHERE IdAreaAct = 4";
            $from = "f_GetProgramacionesAcero";
            
            $sql = "UPDATE dbo.Programaciones SET
                dbo.Programaciones.IdProgramacionEstatus = 2003,
                dbo.Programaciones.FechaCerrado = CONVERT (date, GETDATE()),
                dbo.Programaciones.HoraCerrado = CONVERT (time, GETDATE()),
                dbo.Programaciones.CerradoPor = 'ServidorCont',
                dbo.Programaciones.CerradoPC = 'ServidorCont'

                FROM
                dbo.Pedidos
                INNER JOIN dbo.Programaciones ON dbo.Programaciones.IdPedido = dbo.Pedidos.IdPedido
                WHERE
                dbo.Pedidos.SaldoCantidad <= 0 AND
                dbo.Programaciones.IdProgramacionEstatus = 1 AND
                dbo.Programaciones.IdArea = 3";
            $result =$command->createCommand($sql)->execute();
        }

        
        foreach ($data as $dat){
            $arreglo[] = $dat['year'];
            $arreglo[] = $dat['week'];
        }
        
        $params = implode(",",$arreglo);
        
        $sql = "SELECT *, 
                IIF( PiezasMolde != 0, (Cantidad / PiezasMolde), 0 ) AS Moldes,
                CASE 
                    WHEN  IdArea = 3 THEN (PLB + CTB + PCC)
                    WHEN  IdArea = 2 THEN (PLA + CTA + CTA2 + PLA2)
                END AS Cast, 
                CASE 
                    WHEN  IdArea = 3 THEN (PMB + PTB + TRB) 
                    WHEN  IdArea = 2 THEN (PMA + PMA2 + PTA)
                END AS Maq
                FROM $from($IdArea,$IdProceso,$params) 
                $where ORDER BY Producto, Estatus, FechaEmbarque ASC";
        //echo $sql;
        $result =$command->createCommand($sql)->queryAll();
        if(count($result)!=0){
            return new ArrayDataProvider([
                'allModels' => $result,
                'key'=>['IdProgramacionSemana1','IdProgramacionSemana2','IdProgramacionSemana3','IdProgramacionSemana4'],
                'id'=>'IdProgramacion',
                'sort'=>array(
                    'attributes'=>array_keys($result[0]),
                ), 
                'pagination'=>false,
            ]);
        }
        return [];
    }
    
    public function getProgramacionDiaria($data,$IdArea,$IdProceso,$turno)
    {   
        //obtengo datos desde un f_GetProgramaciones mediante un SELECT
        $year = $data['semana1']['year'];
        $week = $data['semana1']['week'];
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        $params = implode(",",[
            $data['semana1']['year'],
            $data['semana1']['week'],
            "'$fecha'"
        ]);
        $command = \Yii::$app->db;
        //echo "SELECT * FROM f_GetProgramacionesDiaria($IdArea,$IdProceso,$params,$turno)";
        $result =$command->createCommand("SELECT * FROM f_GetProgramacionesDiaria($IdArea,$IdProceso,$params,$turno) Order By Posicion ASC, Producto ASC")->queryAll();

        
        if(count($result)!=0){
            return new ArrayDataProvider([
                'allModels' => $result,
                'key'=>['IdProgramacionSemana'],
                'id'=>'IdProgramacion',
                'sort'=>array(
                    'attributes'=>array_keys($result[0]),
                ),
                'pagination'=>false,
            ]);
        }
        return [];
    }
    
    public function setProgramacionDiaria($data)
    {
        $command = \Yii::$app->db;
        //echo "EXECUTE p_SetProgramacionDia $data,NULL";
        $result =$command->createCommand("EXECUTE p_SetProgramacionDia $data,NULL")->execute();
    }
    
    public function setProgramacionTarima($data)
    {
        $command = \Yii::$app->db;
        //echo "EXECUTE p_SetProgramacionDia $data,NULL";
        $result =$command->createCommand("EXECUTE p_SetProgramacionTarima $data,NULL")->execute();
    }
    
    public function setProgramacionSemanal($data)
    {
        $command = \Yii::$app->db;
        return $command->createCommand("EXECUTE p_SetProgramacionSemana $data,NULL")->execute();
    }
    
    public function setDatosDux()
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("EXECUTE p_SetAlmacenFromDUX")->execute();
    }
    
    public function getActualizacion()
    {
        $command = \Yii::$app->db;
        return $command->createCommand("
            SELECT TOP 1 dbo.Bitacora.FechaInicio
            FROM dbo.Bitacora
            ORDER BY dbo.Bitacora.FechaInicio DESC
        ")->queryAll();
    }
    
    public function formAttribsProgramacionSemanal()
    {
        return [
            'IdProgramacion'=>['type'=>TabularForm::INPUT_STATIC],
            'OE_Codigo'=>['type'=>TabularForm::INPUT_STATIC],
            'OE_Nuemero'=>['type'=>TabularForm::INPUT_STATIC],
            'Usuario'=>['type'=>TabularForm::INPUT_STATIC],
            'Estatus'=>['type'=>TabularForm::INPUT_STATIC],
            'Producto'=>['type'=>TabularForm::INPUT_STATIC],
            'Descripcion'=>['type'=>TabularForm::INPUT_STATIC],
            'ProductoCasting'=>['type'=>TabularForm::INPUT_STATIC],
            'Marca'=>['type'=>TabularForm::INPUT_STATIC],
            'Presentacion'=>['type'=>TabularForm::INPUT_STATIC],
            'Aleacion'=>['type'=>TabularForm::INPUT_STATIC],
            'PLB'=>['type'=>TabularForm::INPUT_STATIC],
            'PMB'=>['type'=>TabularForm::INPUT_STATIC],
            'PTB'=>['type'=>TabularForm::INPUT_STATIC],
            'TRB'=>['type'=>TabularForm::INPUT_STATIC],
            'PCC'=>['type'=>TabularForm::INPUT_STATIC],
            'CTB'=>['type'=>TabularForm::INPUT_STATIC],

/*          'FechaEmbarque' => [
                'type'=> TabularForm::INPUT_WIDGET, 
                'widgetClass'=>\kartik\widgets\DatePicker::classname(), 
                'options' => [ 
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true, 
                        'autoclose'=>true
                    ]
                ],
                'columnOptions'=>['width'=>'170px'],
            ],
            'NivelRiesgo' => ['type' => TabularForm::INPUT_TEXT,'options'=>['class'=>'form-control long'],],
            'Observaciones' => ['type' => TabularForm::INPUT_TEXT,'options'=>['class'=>'form-control long'],],
            'TotalProgramado' => ['type' => TabularForm::INPUT_TEXT,'options'=>['class'=>'form-control long'],],
*/            
        ];
    }
}
