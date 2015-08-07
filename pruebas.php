<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$c = new PDO("sqlsrv:Server=192.168.0.18;Database=FIMEX_Produccion", "avilla", "1234@") or die('no se conecto');
$c->query("EXECUTE p_SetProductoFromDUX") or die('no se ejecuto***');
