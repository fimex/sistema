<?php

namespace frontend\Models\calidad;
use Yii;
use yii\base\Model;
//use frontend\Models\calidad\MaquinadoCTA2;

Class ProduccionCalidad extends Model {
    
    public function GetCantidad($IdProduccion, $IdSubProceso, $IdCentroTrabajo) {
        $command = \Yii::$app->db;
        $sql = "SELECT
            Existencias.IdCentroTrabajo,
            Existencias.Cantidad,
            Existencias.Id,
            Existencias.IdProducto,
            CentrosTrabajo.IdSubProceso,
            Programaciones.IdProgramacionEstatus,
            Programaciones.IdProgramacion,
            Programaciones.IdArea,
            CentroTrabajoBuffer.IdCentroTrabajoDestino,
            Productos.LlevaSerie,
            Productos.Descripcion,
            Productos.Identificacion,
            Productos.FechaMoldeo,
            Aceptadas.Hechas AS Aceptadas,
            Reparaciones.Hechas AS Reparaciones,
            Scrap.Hechas AS Scrap

            FROM
            Existencias
            INNER JOIN CentrosTrabajo ON CentrosTrabajo.IdCentroTrabajo = Existencias.IdCentroTrabajo
            INNER JOIN Programaciones ON Existencias.IdProducto = Programaciones.IdProducto
            INNER JOIN CentroTrabajoBuffer ON CentroTrabajoBuffer.IdCentroTrabajoOrigen = CentrosTrabajo.IdCentroTrabajo
            INNER JOIN Productos ON Existencias.IdProducto = Productos.IdProducto
            LEFT JOIN ProduccionesDetalle AS Aceptadas ON Productos.IdProducto = Aceptadas.IdProductos AND Aceptadas.IdEstatus = 1 AND Aceptadas.IdProduccion = ".$IdProduccion."
            LEFT JOIN ProduccionesDetalle AS Reparaciones ON Productos.IdProducto = Reparaciones.IdProductos AND Reparaciones.IdEstatus = 2 AND Reparaciones.IdProduccion = ".$IdProduccion."
            LEFT JOIN ProduccionesDetalle AS Scrap ON Productos.IdProducto = Scrap.IdProductos AND Scrap.IdEstatus = 3 AND Scrap.IdProduccion = ".$IdProduccion."
            WHERE
            Programaciones.IdProgramacionEstatus = 1 AND
            Programaciones.IdArea = 2 AND
            CentrosTrabajo.IdSubProceso = ".$IdSubProceso." AND
            Existencias.IdCentroTrabajo = ".$IdCentroTrabajo;
        //echo $sql;
        //exit();
        $result =$command->createCommand($sql)->queryAll();
                                                           // )->getRawSql();
                                                           // print_r($result);exit;

        return $result;
    }
}