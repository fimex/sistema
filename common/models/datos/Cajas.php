<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Cajas".
 *
 * @property integer $IdCaja
 * @property integer $IdProducto
 * @property integer $IdTipoCaja
 * @property integer $PiezasXCaja
 *
 * @property CajasTipo $idTipoCaja
 * @property Productos $idProducto
 */
class Cajas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Cajas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdTipoCaja', 'PiezasXCaja'], 'required'],
            [['IdCaja', 'IdProducto', 'IdTipoCaja', 'PiezasXCaja'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCaja' => 'Id Caja',
            'IdProducto' => 'Id Producto',
            'IdTipoCaja' => 'Id Tipo Caja',
            'PiezasXCaja' => 'PiezasXCaja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCaja()
    {
        return $this->hasOne(CajasTipo::className(), ['IdTipoCaja' => 'IdTipoCaja']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
    
    public function getCajas($id)
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT c.*, ct.Tamano FROM  Cajas c left join CajasTipo ct on c.IdTipoCaja = ct.IdTipoCaja Where idProducto = $id ")->queryAll();

        return $result;
    }
    
    public function getDetalleCajas($semana_ini,$anio1,$semana_fin,$anio2)
    {
        /*if($ini == 0){
            $where  = "";
        }else{
            $where = "AND ps.Semana = $semana ";
        }*/
        $command = \Yii::$app->db;
        $result = $command->createCommand("SELECT  
                                                pe.Fecha,
                                                ps.Semana,
                                                p.IdProgramacion,
                                                pr.Identificacion,
                                                p.IdProducto, 
                                                ps.Programadas, 
                                                (ps.Programadas/c.PiezasXCaja) AS Requiere, 
                                                c.IdCaja,
                                                c.IdTipoCaja, 
                                                c.PiezasXCaja, 
                                                t.Tamano, 
                                                t.CodigoDlls, 
                                                t.CodigoPesos, 
                                                CodP.EXISTENCIA AS CodPesos,
                                                CodD.EXISTENCIA AS CodDlls
                                            FROM dbo.Programaciones p
                                            INNER JOIN dbo.ProgramacionesSemana ps ON p.IdProgramacion=ps.IdProgramacion
                                            LEFT JOIN dbo.Pedidos pe ON p.IdPedido=pe.IdPedido
                                            INNER JOIN dbo.Cajas c ON p.IdProducto=c.IdProducto  
                                            LEFT JOIN dbo.CajasTipo t ON c.IdTipoCaja=t.IdTipoCaja 
                                            LEFT JOIN Duxsinc.dbo.ALMPROD CodP ON t.CodigoPesos=CodP.PRODUCTO
                                            LEFT JOIN Duxsinc.dbo.ALMPROD CodD ON t.CodigoDlls=CodD.PRODUCTO
                                            LEFT JOIN dbo.Productos pr ON p.IdProducto=pr.IdProducto WHERE ps.Semana BETWEEN $semana_ini AND $semana_fin AND ps.Anio = $anio1 ORDER BY t.Tamano ")->queryAll();
        return $result;
        /*$result =$command->createCommand("
         * SELECT    
		ps.Semana,
    ps.Anio,
		p.IdProducto, 
		pr.Identificacion,
		ps.Programadas, 
		(ps.Programadas/c.PiezasXCaja) AS Requiere, 
		c.IdCaja,
		c.IdTipoCaja, 
		c.PiezasXCaja, 
		t.Tamano, 
		CodP.EXISTENCIA AS CodPesos,
    CodD.EXISTENCIA AS CodDlls,
		t.CodigoDlls, 
		t.CodigoPesos
FROM dbo.Productos pr
INNER JOIN dbo.Cajas c ON pr.IdProducto=c.IdProducto  
INNER JOIN dbo.CajasTipo t ON c.IdTipoCaja=t.IdTipoCaja 
INNER JOIN dux.DUX_ALMPROD CodP ON t.CodigoPesos=CodP.PRODUCTO
INNER JOIN dux.DUX_ALMPROD CodD ON t.CodigoDlls=CodD.PRODUCTO
INNER JOIN dbo.Programaciones p  ON pr.IdProducto=p.IdProducto
INNER JOIN dbo.ProgramacionesSemana ps ON p.IdProgramacion=ps.IdProgramacion                   
                                        SELECT    
                                            pe.Fecha, 
                                            pr.Identificacion,
                                            p.IdProducto, 
                                            ps.Programadas, 
                                            (ps.Programadas/c.PiezasXCaja) AS Requiere, 
                                            c.IdCaja,
                                            c.IdTipoCaja, 
                                            c.PiezasXCaja, 
                                            t.Tamano, 
                                            t.CodigoDlls, 
                                            t.CodigoPesos, 
                                            CodP.EXISTENCIA AS CodPesos,
                                            CodD.EXISTENCIA AS CodDlls
                                        FROM dbo.ProgramacionesSemana ps 
                                        LEFT JOIN dbo.Programaciones p ON ps.IdProgramacion=p.IdProgramacion
                                        LEFT JOIN dbo.Pedidos pe ON p.IdPedido=pe.IdPedido
                                        INNER JOIN dbo.Cajas c ON p.IdProducto=c.IdProducto  
                                        LEFT JOIN dbo.CajasTipo t ON c.IdTipoCaja=t.IdTipoCaja 
                                        LEFT JOIN dux.DUX_ALMPROD CodP ON t.CodigoPesos=CodP.PRODUCTO
                                        LEFT JOIN dux.DUX_ALMPROD CodD ON t.CodigoDlls=CodD.PRODUCTO
                                        LEFT JOIN dbo.Productos pr ON p.IdProducto=pr.IdProducto $where ORDER BY t.Tamano ")->queryAll();

         $result = $command->createCommand(" SELECT    
                                                pe.Fecha, 
                                                pr.Identificacion,
                                                p.IdProducto, 
                                                ap.IdAlmacen,
                                                ps.Programadas, 
                                                (ps.Programadas/c.PiezasXCaja) AS Requiere, 
                                                c.IdCaja,
                                                c.IdTipoCaja, 
                                                c.PiezasXCaja, 
                                                t.Tamano, 
                                                CASE WHEN ap.IdAlmacen = 3 THEN ap.Existencia  END AS CodPesos,
                                                CASE WHEN ap.IdAlmacen = 2 THEN ap.Existencia END AS CodDlls,
                                                t.CodigoDlls, 
                                                t.CodigoPesos
                                            FROM dbo.ProgramacionesSemana ps 
                                            LEFT JOIN dbo.Programaciones p ON ps.IdProgramacion=p.IdProgramacion
                                            LEFT JOIN dbo.Pedidos pe ON p.IdPedido=pe.IdPedido
                                            INNER JOIN dbo.Cajas c ON p.IdProducto=c.IdProducto  
                                            LEFT JOIN dbo.CajasTipo t ON c.IdTipoCaja=t.IdTipoCaja 
                                            LEFT JOIN dbo.Productos pr ON p.IdProducto=pr.IdProducto
                                            LEFT JOIN dbo.AlmacenesProducto ap ON p.IdProducto=ap.IdProducto
                                            WHERE ap.IdAlmacen IN (2,3) AND ps.Semana = $semana AND ps.Anio = $anio ORDER BY t.Tamano ")->queryAll(); 
         
         *          */

        
    }
    
}
