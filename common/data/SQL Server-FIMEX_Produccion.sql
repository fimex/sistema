CREATE TABLE [Programaciones] (
[IdProgramacion] int NOT NULL,
[IdPedido] int NOT NULL,
[IdArea] int NOT NULL,
[IdUsuario] int NOT NULL,
[IdProgramacionEstatus] int NOT NULL,
[IdProducto] int NOT NULL,
[Programadas] int NOT NULL,
[Hechas] int NOT NULL,
CONSTRAINT [PK_Programaciones] PRIMARY KEY ([IdProgramacion]) 
)
GO

CREATE TABLE [Marcas] (
[IdMarca] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_Marcas] PRIMARY KEY ([IdMarca]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Marcas', 
'COLUMN', N'Descripcion')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Collingnon 
Cooper 
Jabsco 
Rain Bird'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Marcas'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Collingnon 
Cooper 
Jabsco 
Rain Bird'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Marcas'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
GO

CREATE TABLE [Productos] (
[IdProducto] int NOT NULL,
[IdMarca] int NOT NULL,
[IdPresentacion] int NOT NULL,
[IdAleacion] int NOT NULL,
[IdProductoCasting] int NULL,
[Identificacion] varchar(20) NOT NULL,
[Descripcion] varchar(60) NOT NULL,
[PiezasMolde] int NOT NULL,
[CiclosMolde] int NOT NULL,
[PesoCasting] decimal(15,4) NOT NULL,
[PesoArania] decimal(15,4) NOT NULL,
CONSTRAINT [PK_Productos] PRIMARY KEY ([IdProducto]) 
)
GO

CREATE UNIQUE INDEX [IDX1_Productos] ON [Productos] ([Identificacion]  ASC)
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Productos', 
'COLUMN', N'PesoCasting')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'CampoUsuario1'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Productos'
, @level2type = 'COLUMN', @level2name = N'PesoCasting'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'CampoUsuario1'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Productos'
, @level2type = 'COLUMN', @level2name = N'PesoCasting'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Productos', 
'COLUMN', N'PesoArania')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'CampoUsuario2'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Productos'
, @level2type = 'COLUMN', @level2name = N'PesoArania'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'CampoUsuario2'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Productos'
, @level2type = 'COLUMN', @level2name = N'PesoArania'
GO

CREATE TABLE [Presentaciones] (
[IDPresentacion] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_Presentaciones] PRIMARY KEY ([IDPresentacion]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Presentaciones', 
'COLUMN', N'Descripcion')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Acero 
Bronce'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Presentaciones'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Acero 
Bronce'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Presentaciones'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
GO

CREATE TABLE [Aleaciones] (
[IdAleacion] int NOT NULL,
[IdAleacionTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_Aleaciones] PRIMARY KEY ([IdAleacion]) 
)
GO

CREATE TABLE [Pedidos] (
[IdPedido] int NOT NULL,
[IdAlmacen] int NOT NULL,
[IdProducto] int NOT NULL,
[Codigo] int NOT NULL,
[Numero] int NOT NULL,
[Fecha] date NOT NULL,
[Cliente] varchar(15) NOT NULL,
[OrdenCompra] varchar(20) NULL,
[Estatus] int NOT NULL,
[Cantidad] decimal(15,6) NOT NULL,
[SaldoCantidad] decimal(15,6) NOT NULL,
[FechaEmbarque] date NULL,
[NivelRiesgo] int NOT NULL DEFAULT ((0)),
[Observaciones] text NULL,
[TotalProgramado] decimal(15,6) NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Pedidos] PRIMARY KEY ([IdPedido]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'IdAlmacen')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Almacen de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'IdAlmacen'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Almacen de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'IdAlmacen'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Codigo')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Codigo de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Codigo'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Codigo de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Codigo'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Numero')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Numero de la partida de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Numero'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Numero de la partida de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Numero'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Fecha')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Fecha de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Fecha'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Fecha de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Fecha'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Cliente')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Cliente de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Cliente'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Cliente de la orden de entrega'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Cliente'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'OrdenCompra')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Orden de compra del cliente (OE_DOCUMENTO1)'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'OrdenCompra'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Orden de compra del cliente (OE_DOCUMENTO1)'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'OrdenCompra'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Estatus')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Estatus de la orden de entrega PO_STATUS'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Estatus'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Estatus de la orden de entrega PO_STATUS'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Estatus'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'FechaEmbarque')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'POE_DctoAdicionalFecha'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'FechaEmbarque'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'POE_DctoAdicionalFecha'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'FechaEmbarque'
GO
IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Pedidos', 
'COLUMN', N'Observaciones')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'POE_Observaciones'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Observaciones'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'POE_Observaciones'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Pedidos'
, @level2type = 'COLUMN', @level2name = N'Observaciones'
GO

CREATE TABLE [AlmacenesProducto] (
[IdAlmacenProducto] int NOT NULL,
[IdAlmacen] int NOT NULL,
[IdProducto] int NOT NULL,
[Existencia] decimal(15,4) NOT NULL,
[CostoPromedio] decimal(15,4) NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_AlmacenesProducto] PRIMARY KEY ([IdAlmacenProducto]) 
)
GO

CREATE UNIQUE INDEX [IDX1_AlmacenesProducto] ON [AlmacenesProducto] ([IdAlmacen]  ASC, [IdProducto]  ASC)
GO

CREATE TABLE [Almacenes] (
[IdAlmacen] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(50) NOT NULL,
CONSTRAINT [PK_Almacenes] PRIMARY KEY ([IdAlmacen]) 
)
GO

CREATE TABLE [Usuarios] (
[IdUsuarios] int NOT NULL,
[IdTurno] int NOT NULL,
[Usuario] varchar(20) NOT NULL,
[Contrasena] varchar(20) NOT NULL,
[Nombre] varchar(80) NOT NULL,
CONSTRAINT [PK_Usuarios] PRIMARY KEY ([IdUsuarios]) 
)
GO

CREATE TABLE [Areas] (
[IdArea] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_Areas] PRIMARY KEY ([IdArea]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Areas', 
'COLUMN', N'Descripcion')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Moldeo Permanente 
Bronce
 Acero'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Areas'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Moldeo Permanente 
Bronce
 Acero'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Areas'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
GO

CREATE TABLE [CentrosTrabajo] (
[IdCentroTrabajo] int NOT NULL,
[IdProceso] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(50) NOT NULL,
CONSTRAINT [PK_CentrosTrabajo] PRIMARY KEY ([IdCentroTrabajo]) 
)
GO

CREATE TABLE [Maquinas] (
[IdMaquina] int NOT NULL,
[IdCentroTrabajo] int NOT NULL,
[Identificador] varchar(6) NOT NULL,
[Descripcion] varchar(50) NOT NULL,
[Consecutivo] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Maquinas] PRIMARY KEY ([IdMaquina]) 
)
GO

CREATE TABLE [ProgramacionesSemana] (
[IdProgramacionSemana] int NOT NULL,
[IdProgramacion] int NOT NULL,
[Anio] int NOT NULL,
[Semana] int NOT NULL,
[Prioridad] int NOT NULL DEFAULT ((0)),
[Programadas] int NOT NULL,
[Hechas] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_ProgramacionesSemana] PRIMARY KEY ([IdProgramacionSemana]) 
)
GO

CREATE UNIQUE INDEX [IDX1_ProgramacionesSemana] ON [ProgramacionesSemana] ([IdProgramacion]  ASC, [Anio]  ASC, [Semana]  ASC)
GO

CREATE TABLE [ProgramacionesDia] (
[IdProgramacionDia] int NOT NULL,
[IdProgramacionSemana] int NOT NULL,
[IdProceso] int NOT NULL,
[Dia] date NOT NULL,
[Prioridad] int NOT NULL DEFAULT ((0)),
[Programadas] int NOT NULL,
[Hechas] int NOT NULL DEFAULT ((0)),
[IdTurno] int NOT NULL,
CONSTRAINT [PK_ProgramacionesDia] PRIMARY KEY ([IdProgramacionDia]) 
)
GO

CREATE UNIQUE INDEX [IDX1_ProgramacionesDia] ON [ProgramacionesDia] ([IdProgramacionSemana]  ASC, [Dia]  ASC, [IdTurno]  ASC, [IdProceso]  ASC)
GO

CREATE TABLE [Producciones] (
[IdProduccion] int NOT NULL,
[IdProceso] int NOT NULL,
[IdCentroTrabajo] int NOT NULL,
[IdMaquina] int NOT NULL,
[IdUsuario] int NOT NULL,
[IdProduccionEstatus] int NOT NULL,
[Fecha] date NOT NULL DEFAULT (getdate()),
CONSTRAINT [PK_Producciones] PRIMARY KEY ([IdProduccion]) 
)
GO

CREATE TABLE [ProduccionesDetalle] (
[IdProduccionDetalle] int NOT NULL,
[IdProduccion] int NOT NULL,
[IdProgramacion] int NOT NULL,
[IdProductos] int NOT NULL,
[Inicio] datetime2(7) NOT NULL DEFAULT '',
[Fin] datetime2(7) NOT NULL DEFAULT '',
[CiclosMolde] int NOT NULL DEFAULT ((0)),
[PiezasMolde] int NOT NULL DEFAULT ((0)),
[Programadas] int NOT NULL DEFAULT 0,
[Hechas] int NOT NULL DEFAULT 0,
[Rechazadas] int NOT NULL DEFAULT 0,
CONSTRAINT [PK_ProduccionesDetalle] PRIMARY KEY ([IdProduccionDetalle]) 
)
GO

CREATE TABLE [Turnos] (
[IdTurno] int NOT NULL,
[Identificador] char(1) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_Turnos] PRIMARY KEY ([IdTurno]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Turnos', 
'COLUMN', N'Descripcion')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Dia Noche'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Turnos'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Dia Noche'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Turnos'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
GO

CREATE TABLE [ProgramacionesEstatus] (
[IdProgramacionEstatus] int NOT NULL,
[Identificador] char(1) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_ProgramacionesEstatus] PRIMARY KEY ([IdProgramacionEstatus]) 
)
GO

CREATE TABLE [Procesos] (
[IdProceso] int NOT NULL,
[IdArea] int NOT NULL,
[Identificador] char(2) NOT NULL,
[Descripcion] varchar(50) NOT NULL,
[Secuencia] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Procesos] PRIMARY KEY ([IdProceso]) 
)
GO

IF ((SELECT COUNT(*) from fn_listextendedproperty('MS_Description', 
'SCHEMA', N'', 
'TABLE', N'Procesos', 
'COLUMN', N'Descripcion')) > 0) 
EXEC sp_updateextendedproperty @name = N'MS_Description', @value = N'Moldeado Vaciado'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Procesos'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
ELSE
EXEC sp_addextendedproperty @name = N'MS_Description', @value = N'Moldeado Vaciado'
, @level0type = 'SCHEMA', @level0name = N''
, @level1type = 'TABLE', @level1name = N'Procesos'
, @level2type = 'COLUMN', @level2name = N'Descripcion'
GO

CREATE TABLE [TiemposMuerto] (
[IdTiempoMuerto] int NOT NULL,
[IdProduccion] int NOT NULL,
[IdCausa] int NOT NULL,
[Inicio] datetime2(7) NOT NULL,
[Fin] datetime2(7) NOT NULL,
[Descripcion] varchar(80) NULL,
CONSTRAINT [PK_TiemposMuerto] PRIMARY KEY ([IdTiempoMuerto]) 
)
GO

CREATE TABLE [Causas] (
[IdCausa] int NOT NULL,
[IdProceso] int NOT NULL,
[IdCausaTipo] int NOT NULL,
[Indentificador] varchar(5) NOT NULL,
[Descripcion] varchar(60) NOT NULL,
CONSTRAINT [PK_Causas] PRIMARY KEY ([IdCausa]) 
)
GO

CREATE TABLE [CausasTipo] (
[IdCausaTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_CausasTipo] PRIMARY KEY ([IdCausaTipo]) 
)
GO

CREATE TABLE [ProduccionesEstatus] (
[IdProduccionEstatus] int NOT NULL,
[Identificador] char(1) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_ProduccionesEstatus] PRIMARY KEY ([IdProduccionEstatus]) 
)
GO

CREATE TABLE [Temperaturas] (
[IdTemperatura] int NOT NULL,
[IdProduccion] int NOT NULL,
[IdMaquina] int NOT NULL,
[Fecha] datetime2(7) NOT NULL,
[Temperatura] decimal(8,4) NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Temperaturas] PRIMARY KEY ([IdTemperatura]) 
)
GO

CREATE TABLE [MaterialesVaciado] (
[IdMaterialVaciado] int NOT NULL,
[IdProduccion] int NOT NULL,
[IdMaterial] int NOT NULL,
[Cantidad] float(53) NOT NULL,
CONSTRAINT [PK_MaterialesVaciado] PRIMARY KEY ([IdMaterialVaciado]) 
)
GO

CREATE TABLE [Vaciados] (
[IdProduccion] int NOT NULL,
[IdAleacion] int NOT NULL,
[Colada] int NOT NULL,
[Lance] int NOT NULL,
[HornoConsecutivo] int NOT NULL
)
GO

CREATE TABLE [Materiales] (
[IdMaterial] int NOT NULL,
[IdProceso] int NOT NULL,
[Identificador] varchar(10) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_Materiales] PRIMARY KEY ([IdMaterial]) 
)
GO

CREATE TABLE [AlmasTipo] (
[IdAlmaTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descrfipcion] varchar(20) NOT NULL,
CONSTRAINT [PK_AlmasTipo] PRIMARY KEY ([IdAlmaTipo]) 
)
GO

CREATE TABLE [Almas] (
[IdAlma] int NOT NULL,
[IdProducto] int NOT NULL,
[IdAlmaTipo] int NOT NULL,
[IdAlmaMaterialCaja] int NOT NULL,
[IdAlmaReceta] int NOT NULL,
[Existencia] int NOT NULL DEFAULT ((0)),
[PiezasCaja] int NOT NULL,
[PiezasMolde] int NOT NULL,
[Peso] real NULL,
[TiempoLlenado] real NULL,
[TiempoFraguado] real NULL,
[TiempoGaseoDirectro] real NULL,
[TiempoGaseoIndirecto] real NULL,
CONSTRAINT [PK_Almas] PRIMARY KEY ([IdAlma]) 
)
GO

CREATE TABLE [AlmasRecetas] (
[IdAlmaReceta] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_AlmasRecetas] PRIMARY KEY ([IdAlmaReceta]) 
)
GO

CREATE TABLE [AlmasMaterialCaja] (
[IdAlmaMaterialCaja] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Dscripcion] varchar(20) NOT NULL,
CONSTRAINT [PK_AlmasMaterialCaja] PRIMARY KEY ([IdAlmaMaterialCaja]) 
)
GO

CREATE TABLE [FiltrosTipo] (
[IdFiltroTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(20) NOT NULL,
[CantidadPorPaquete] int NOT NULL DEFAULT ((0)),
[DUX_CodigoPesos] varchar(20) NULL,
[DUX_CodigoDolares] varchar(20) NULL,
CONSTRAINT [PK_FiltrosTipo] PRIMARY KEY ([IdFiltroTipo]) 
)
GO

CREATE TABLE [Filtros] (
[IdFiltro] int NOT NULL,
[IdProducto] int NOT NULL,
[IdFiltroTipo] int NOT NULL,
[Cantidad] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Filtros] PRIMARY KEY ([IdFiltro]) 
)
GO

CREATE TABLE [CamisasTipo] (
[IdCamisaTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
[CantidadPorPaquete] int NOT NULL DEFAULT ((0)),
[DUX_CodigoPesos] varchar(20) NULL,
[DUX_CodigoDolares] varchar(20) NULL,
CONSTRAINT [PK_CamisasTipo] PRIMARY KEY ([IdCamisaTipo]) 
)
GO

CREATE TABLE [Camisas] (
[IdCamisa] int NOT NULL,
[IdProducto] int NOT NULL,
[IdCamisaTipo] int NOT NULL,
[Cantidad] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_Camisas] PRIMARY KEY ([IdCamisa]) 
)
GO

CREATE TABLE [ProgramacionesAlma] (
[IdProgramacionAlma] int NOT NULL,
[IdProgramacion] int NOT NULL,
[IdUsuario] int NOT NULL,
[IdProgramacionEstatus] int NOT NULL,
[IdAlmas] int NOT NULL,
[Programadas] int NOT NULL,
[Hechas] int NOT NULL,
CONSTRAINT [PK_ProgramacionesAlma] PRIMARY KEY ([IdProgramacionAlma]) 
)
GO

CREATE TABLE [ProgramacionesAlmaSemana] (
[IdProgramacionAlmaSemana] int NOT NULL,
[IdProgramacionAlma] int NOT NULL,
[Anio] int NOT NULL,
[Semana] int NOT NULL,
[Prioridad] int NOT NULL DEFAULT ((0)),
[Programadas] int NOT NULL,
[Hechas] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_ProgramacionesAlmaSemana] PRIMARY KEY ([IdProgramacionAlmaSemana]) 
)
GO

CREATE TABLE [ProgramacionesAlmaDia] (
[IdProgramacionAlmaDia] int NOT NULL,
[IdProgramacionAlmaSemana] int NOT NULL,
[Dia] date NOT NULL,
[Prioridad] int NOT NULL DEFAULT ((0)),
[Programadas] int NOT NULL,
[Hechas] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_ProgramacionesAlmaDia] PRIMARY KEY ([IdProgramacionAlmaDia]) 
)
GO

CREATE TABLE [DefectosTipo] (
[IdDefectoTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
CONSTRAINT [PK_DefectosTipo] PRIMARY KEY ([IdDefectoTipo]) 
)
GO

CREATE TABLE [Defectos] (
[IdDefecto] int NOT NULL,
[IdProceso] int NOT NULL,
[IdDefectoTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(60) NOT NULL,
CONSTRAINT [PK_Defectos] PRIMARY KEY ([IdDefecto]) 
)
GO

CREATE TABLE [ProduccionesDefecto] (
[IdProduccionDefecto] int NOT NULL,
[IdProduccionDetalle] int NOT NULL,
[IdDefecto] int NOT NULL,
[Rechazadas] int NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_ProduccionesDefecto] PRIMARY KEY ([IdProduccionDefecto]) 
)
GO

CREATE TABLE [AlmasProduccionDetalle] (
[IdAlmaProduccion] int NOT NULL,
[IdProduccion] int NOT NULL,
[IdProgramacionAlma] int NOT NULL,
[IdAlma] int NOT NULL,
[Inicio] datetime2(7) NOT NULL,
[Fin] datetime2(7) NOT NULL,
[Programadas] int NOT NULL,
[Hechas] int NOT NULL,
[Rechazadas] int NOT NULL,
CONSTRAINT [PK_AlmasProduccionDetalle] PRIMARY KEY ([IdAlmaProduccion]) 
)
GO

CREATE TABLE [AlmasProduccionDefecto] (
[IdAlmaProduccionDefecto] int NOT NULL,
[IdAlmaProduccionDetalle] int NOT NULL,
[IdDefecto] int NOT NULL,
[Rechazada] int NULL DEFAULT ((0)),
CONSTRAINT [PK_AlmasProduccionDefecto] PRIMARY KEY ([IdAlmaProduccionDefecto]) 
)
GO

CREATE TABLE [AleacionesTipo] (
[IdAleacionTipo] int NOT NULL,
[Identificador] varchar(5) NOT NULL,
[Descripcion] varchar(30) NOT NULL,
[Factor] money NOT NULL,
[DUX_Codigo] varchar(20) NOT NULL,
[DUX_CuentaContable] varchar(20) NOT NULL,
CONSTRAINT [PK_AleacionesTipo] PRIMARY KEY ([IdAleacionTipo]) 
)
GO

CREATE TABLE [AleacionesTipoFactor] (
[IdAleacionTipoFactor] int NOT NULL,
[IdAleacionTipo] int NOT NULL,
[Fecha] date NOT NULL,
[Factor] money NOT NULL DEFAULT ((0)),
CONSTRAINT [PK_AleacionesTipoFactor] PRIMARY KEY ([IdAleacionTipoFactor]) 
)
GO

CREATE TABLE [DUX_ALMACEN] (
[IDENTIFICACION] char(20) COLLATE Modern_Spanish_CI_AS NOT NULL,
[DESCRIPCION] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[FECHAMODIFICACION] date NULL,
CONSTRAINT [PK__DUX_ALMA__6F9F6A3B38607BE7] PRIMARY KEY ([IDENTIFICACION]) 
)
GO

CREATE TABLE [DUX_ALMPROD] (
[PRODUCTO] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[ALMACEN] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLEVENTA] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLECOMPRA] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLECOSTOVENTAS] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[EXISTENCIA] numeric(15,6) NULL,
[COSTO] numeric(15,6) NULL,
[ULTIMOCOSTO] numeric(15,6) NULL,
[COSTOPROMEDIO] numeric(15,6) NULL,
[MAXIMO] numeric(15,6) NULL,
[MINIMO] numeric(15,6) NULL,
[PUNTOREORDEN] numeric(15,6) NULL,
[UBICACION] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[FECHAMODIFICACION] date NULL,
[CUENTACONTABLEORDEN] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[CANTIDADRESERVADA] numeric(19,6) NULL,
[CUENTACONTABLEESPECIAL] char(19) COLLATE Modern_Spanish_CI_AS NULL
)
GO

CREATE TABLE [DUX_CLIENTES] (
[CODIGO] char(15) COLLATE Modern_Spanish_CI_AS NULL,
[NOMBRE] char(100) COLLATE Modern_Spanish_CI_AS NULL,
[CONTACTO] char(45) COLLATE Modern_Spanish_CI_AS NULL,
[RFC] char(15) COLLATE Modern_Spanish_CI_AS NULL,
[DOMICILIO] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[COLONIA] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CIUDAD] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[ESTADO] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[CP] char(5) COLLATE Modern_Spanish_CI_AS NULL,
[PAIS] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[TELEFONO1] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[TELEFONO2] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[TELEFONO3] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[FAX] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[CLASIFICACION] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[ZONA] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[IVADESGLOSADO] int NULL,
[AGENTE] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[DESCUENTO] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[DIASCREDITO] int NULL,
[LIMITECREDITO] numeric(11,2) NULL,
[FECHAINICIORELACIONES] date NULL,
[FECHAULTIMOMOVIMIENTO] date NULL,
[CONCEPTO] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLE] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[BLOQUEADO] int NULL,
[MOTIVOBLOQUEO] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[FECHAALTA] date NULL,
[PUBLICOGENERAL] int NULL,
[GOLDMINE] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[EMAIL] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[PAGINAWEB] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CODIGOADICIONAL] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[ALMACEN] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[SUBALMACEN] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[INTERCOMPANIA] int NULL,
[CUENTACONTABLECOSTOVENTAS] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLEVENTAS] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[AUTORIZADOPOR] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[FECHAAUTORIZACION] date NULL,
[NIVELRIESGO] char(5) COLLATE Modern_Spanish_CI_AS NULL,
[COMENTARIOSCREDITO] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO1] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO2] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO3] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO4] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO5] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLEORDEN] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[AGENTECOBRANZA] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[COBRARIVA] int NULL,
[CURP] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[RLUNES] int NULL,
[RMARTES] int NULL,
[RMIERCOLES] int NULL,
[RJUEVES] int NULL,
[RVIERNES] int NULL,
[RSABADO] int NULL,
[RDOMINGO] int NULL,
[PLUNES] int NULL,
[PMARTES] int NULL,
[PMIERCOLES] int NULL,
[PJUEVES] int NULL,
[PVIERNES] int NULL,
[PSABADO] int NULL,
[PDOMINGO] int NULL,
[NOMBRECOMERCIAL] char(80) COLLATE Modern_Spanish_CI_AS NULL,
[ENTRECALLE1] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[ENTRECALLE2] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[HORARIO] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[DELEGACION] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[ESPECIFICACIONFECHAREVISION] char(70) COLLATE Modern_Spanish_CI_AS NULL,
[ESPECIFICACIONFECHAPAGO] char(70) COLLATE Modern_Spanish_CI_AS NULL,
[HORAINICIOREVISION] time(7) NULL,
[HORAFINALREVISION] time(7) NULL,
[HORAINICIOPAGO] time(7) NULL,
[HORAFINALPAGO] time(7) NULL,
[NUMEROEXTERIOR] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[NUMEROINTERIOR] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[COORDENADASDOMICILIO] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[GEOCERCA] char(6) COLLATE Modern_Spanish_CI_AS NULL,
[DISTANCIAMASDEUNAHORA] int NULL,
[NIVELACCESO] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[NIVELRIESGOACCESO] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[ESTACIONAMIENTO] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[COORDENADASESTACIONAMIENTO] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[ELUNES] int NULL,
[EMARTES] int NULL,
[EMIERCOLES] int NULL,
[EJUEVES] int NULL,
[EVIERNES] int NULL,
[ESABADO] int NULL,
[EDOMINGO] int NULL,
[HORAINICIOENTREGALUNES] time(7) NULL,
[HORAFINALENTREGALUNES] time(7) NULL,
[HORAINICIOENTREGAMARTES] time(7) NULL,
[HORAFINALENTREGAMARTES] time(7) NULL,
[HORAINICIOENTREGAMIERCOLES] time(7) NULL,
[HORAFINALENTREGAMIERCOLES] time(7) NULL,
[HORAINICIOENTREGAJUEVES] time(7) NULL,
[HORAFINALENTREGAJUEVES] time(7) NULL,
[HORAINICIOENTREGAVIERNES] time(7) NULL,
[HORAFINALENTREGAVIERNES] time(7) NULL,
[HORAINICIOENTREGASABADO] time(7) NULL,
[HORAFINALENTREGASABADO] time(7) NULL,
[HORAINICIOENTREGADOMINGO] time(7) NULL,
[HORAFINALENTREGADOMINGO] time(7) NULL,
[GEOCERCAESTACIONAMIENTO] char(6) COLLATE Modern_Spanish_CI_AS NULL,
[METODOPAGO] int NULL,
[DATOSCUENTAPAGO] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[OBSERVACIONES] text COLLATE Modern_Spanish_CI_AS NULL
)
GO

CREATE TABLE [DUX_OENTREGA] (
[CODIGO] int NULL,
[TIPO] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[NUMERO] int NULL,
[SERIE] char(3) COLLATE Modern_Spanish_CI_AS NULL,
[FECHA] date NULL,
[CLIENTE] char(15) COLLATE Modern_Spanish_CI_AS NULL,
[SALDO] numeric(11,2) NULL,
[AGENTE] char(40) COLLATE Modern_Spanish_CI_AS NULL,
[DIASCREDITO] int NULL,
[FECHAEMBARQUE] date NULL,
[DOMICILIOEMBARQUE] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[FLETEPOR] int NULL,
[CLIENTERETIRA] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[DESCUENTOGLOBAL] numeric(9,4) NULL,
[IVADESGLOSADO] int NULL,
[DOCUMENTO1] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[DOCUMENTO2] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[DOCUMENTO3] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[ALMACEN] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[STATUS] int NULL,
[USUARIO] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[TOTAL] numeric(11,2) NULL,
[DESCUENTO] numeric(11,2) NULL,
[IVA] numeric(11,2) NULL,
[MES] int NULL,
[FECHAVENCIMIENTO] date NULL,
[COSTOFINANCIERO] numeric(11,2) NULL,
[CONDICIONES] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[MODIFICARCONDICIONES] int NULL,
[AUTORIZO] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[MONEDA] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[COTIZACION] numeric(7,4) NULL,
[NOAFECTAPRODUCCION] int NULL,
[RETENCIONIVA] numeric(11,2) NULL,
[RETENCIONISR] numeric(11,2) NULL,
[RETENCIONIE] numeric(11,2) NULL,
[HORAEMBARQUE] time(7) NULL,
[OBSERVACIONES] text COLLATE Modern_Spanish_CI_AS NULL
)
GO

CREATE TABLE [DUX_PAROEN] (
[CODIGO] int NULL,
[NUMERO] int NULL,
[SERIE] char(3) COLLATE Modern_Spanish_CI_AS NULL,
[CANTIDAD] numeric(15,6) NULL,
[PRODUCTO] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[PRECIOUNITARIO] numeric(15,6) NULL,
[DESCUENTO] numeric(9,4) NULL,
[IVA] numeric(9,4) NULL,
[TOTALPARTIDA] numeric(11,2) NULL,
[SALDOCANTIDAD] numeric(15,6) NULL,
[SALDOIMPORTE] numeric(15,2) NULL,
[CODIGOPEDIDO] int NULL,
[PARTIDAPEDIDO] int NULL,
[SALDOCANTIDADFACTURAR] numeric(15,6) NULL,
[SALDOCANCELADO] numeric(15,6) NULL,
[DOCUMENTO1] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[DOCUMENTO2] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[DOCUMENTO3] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONIVA] int NULL,
[RETENCIONISR] int NULL,
[RETENCIONIE] int NULL,
[PORCENTAJERETENCIONIVA] numeric(7,4) NULL,
[PORCENTAJERETENCIONISR] numeric(7,4) NULL,
[PORCENTAJERETENCIONIE] numeric(7,4) NULL,
[NOAFECTAPRODUCCION] int NULL,
[DOCTOADICIONALFECHA] date NULL,
[OBSERVACIONES] text COLLATE Modern_Spanish_CI_AS NULL
)
GO

CREATE TABLE [DUX_PRODUCTO] (
[IDENTIFICACION] char(20) COLLATE Modern_Spanish_CI_AS NOT NULL,
[DESCRIPCION] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[CLASIFICACION] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[UNIDAD] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[PROVEEDOR] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[TASA] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[EXISTENCIA] numeric(15,4) NULL,
[SEVENDE] int NULL,
[SECOMPRA] int NULL,
[ESMANUFACTURABLE] int NULL,
[TIPO] char(1) COLLATE Modern_Spanish_CI_AS NULL,
[CLASE] char(3) COLLATE Modern_Spanish_CI_AS NULL,
[ORDEN] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[FAMILIA] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[LINEA] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[PRESENTACION] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[SUBPRESENTACION] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[TASACOMPRAS] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[USAPEDIMENTO] int NULL,
[FECHAMODIFICACION] date NULL,
[UMVENTA] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[UMCOMPRA] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[METODOIDENTIFICACION] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[TIEMPOSURTIDO] int NULL,
[PROVEEDOR2] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[PROVEEDOR3] char(60) COLLATE Modern_Spanish_CI_AS NULL,
[CUENTACONTABLE] char(19) COLLATE Modern_Spanish_CI_AS NULL,
[COSTOESTANDAR] numeric(19,6) NULL,
[COLOR] char(20) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO1] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO2] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO3] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO4] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[CAMPOUSUARIO5] char(50) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONIVA] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONISR] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONIE] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONIVACLIENTES] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONISRCLIENTES] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[RETENCIONIECLIENTES] char(30) COLLATE Modern_Spanish_CI_AS NULL,
[KIT] int NULL,
[PORCENTAJECOMISION] numeric(5,2) NULL,
[NODEDUCIBLEIETU] int NULL,
[ANCHO] numeric(9,2) NULL,
[LARGO] numeric(9,2) NULL,
[PROFUNDIDAD] numeric(9,2) NULL,
[OBSERVACIONES] text COLLATE Modern_Spanish_CI_AS NULL,
CONSTRAINT [PK__DUX_PROD__6F9F6A3B7B21A57F] PRIMARY KEY ([IDENTIFICACION]) 
)
GO

CREATE TABLE [user] (
[id] int NOT NULL,
[username] varchar(255) COLLATE Modern_Spanish_CI_AS NOT NULL,
[auth_key] varchar(32) COLLATE Modern_Spanish_CI_AS NOT NULL,
[password_hash] varchar(255) COLLATE Modern_Spanish_CI_AS NOT NULL,
[password_reset_token] varchar(255) COLLATE Modern_Spanish_CI_AS NULL,
[email] varchar(255) COLLATE Modern_Spanish_CI_AS NOT NULL,
[role] smallint NOT NULL DEFAULT ((10)),
[IdEmpleado] int NULL,
[status] smallint NOT NULL DEFAULT ((10)),
[created_at] int NOT NULL,
[updated_at] int NOT NULL,
CONSTRAINT [PK__user__3213E83FAD0830C1] PRIMARY KEY ([id]) 
)
GO

CREATE TABLE [Empleados] (
[IdEmpleado] int NOT NULL,
[CODIGO] varchar(15) NULL DEFAULT NULL,
[CODIGOANTERIOR] int NOT NULL,
[GOLDMINE] varchar(20) NULL DEFAULT NULL,
[APELLIDOPATERNO] varchar(30) NULL DEFAULT NULL,
[APELLIDOMATERNO] varchar(30) NULL DEFAULT NULL,
[NOMBRES] varchar(30) NULL DEFAULT NULL,
[NOMBRECOMPLETO] varchar(90) NULL DEFAULT NULL,
[ESTATUS] varchar(25) NULL DEFAULT NULL,
[RFC] varchar(15) NULL DEFAULT NULL,
[IMSS] varchar(15) NULL DEFAULT NULL,
[FECHAINICIO] datetime NULL DEFAULT NULL,
[DEPARTAMENTO] varchar(25) NULL DEFAULT NULL,
[PUESTO] varchar(50) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[FECHAINICIOPUESTO] datetime NULL DEFAULT NULL,
[TURNO] varchar(40) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[SIGUIENTENOMINA] datetime NULL DEFAULT NULL,
[FECHAULTIMANOMINA] datetime NULL DEFAULT NULL,
[SALARIODIARIO] decimal(9,2) NULL DEFAULT NULL,
[SALARIODIARIOINTEGRADO] decimal(9,2) NULL DEFAULT NULL,
[TIPOSALARIO] tinyint NULL DEFAULT NULL,
[PORCENTAJEPRIMAVACACIONAL] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT 'Prima Vacacional',
[DIASAGUINALDO] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[FORMAPAGO] varchar(1) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[REFERENCIAPAGO] varchar(40) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[PERIODICIDAD] varchar(25) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[CAUSABAJA] varchar(50) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[FECHABAJA] datetime NULL DEFAULT NULL,
[SEXO] varchar(1) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[CURP] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[SAR] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[DOMICILIO] varchar(100) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[CALLE] varchar(40) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[NUMEROEXTERIOR] varchar(10) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[NUMEROINTERIOR] varchar(10) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[COLONIA] varchar(40) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[MUNICIPIO] varchar(40) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[ESTADO] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[CP] varchar(6) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[TELEFONO1] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[TELEFONO2] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[FECHANACIMIENTO] datetime NULL DEFAULT NULL,
[LUGARNACIMIENTO] varchar(50) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[ESTADOCIVIL] varchar(1) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[NOMBREPADRE] varchar(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '\'\'',
[NOMBREMADRE] varchar(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '\'\'',
[VACACIONES] tinyint NULL DEFAULT NULL,
[CUENTACONTABLE] varchar(19) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[EXISTEPRESTAMO] tinyint NULL DEFAULT NULL,
[REFERENCIAPRESTAMO] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[MONTOPRESTAMO] decimal(11,2) NULL DEFAULT NULL,
[SALDOPRESTAMO] decimal(11,2) NULL DEFAULT NULL,
[PORCENTAJERETENCION] tinyint NULL DEFAULT NULL,
[SINIMPRIMIRNOTIFICACION] tinyint NULL DEFAULT NULL,
[TABLAVACACIONES] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[PORCENTAJEFIJOINFONAVIT] decimal(7,2) NULL DEFAULT NULL,
[FACTORADICIONALINTEGRADO] decimal(7,4) NULL DEFAULT NULL,
[NOMBRESIMPLE] varchar(30) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[EMAIL] varchar(60) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[TIPO] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[CALCULARENBASEASMGVDF] tinyint NULL DEFAULT NULL,
[IMPORTEARETENER] decimal(13,4) NULL DEFAULT NULL,
[CENTRODECOSTOS] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[USARELOJCHECADOR] tinyint NULL DEFAULT NULL,
[CALCULAENVECESALSALARIOMINIMO] tinyint NULL DEFAULT NULL,
[CALCULARENBASEASMGVZ] tinyint NULL DEFAULT NULL,
[BANCO] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[REGIMENCONTRATACION] tinyint NULL DEFAULT NULL,
[CATALOGOBANCOS] varchar(4) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[RIESGOPUESTO] bigint NULL DEFAULT NULL,
[TIPOCONTRATO] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL,
[TIPOJORNADA] varchar(20) COLLATE latin1_swedish_ci NULL DEFAULT NULL
)
GO


ALTER TABLE [Productos] ADD CONSTRAINT [fk_Productos_Marcas_1] FOREIGN KEY ([IdMarca]) REFERENCES [Marcas] ([IdMarca])
GO
ALTER TABLE [Productos] ADD CONSTRAINT [fk_Productos_Presentacion_1] FOREIGN KEY ([IdPresentacion]) REFERENCES [Presentaciones] ([IDPresentacion])
GO
ALTER TABLE [Productos] ADD CONSTRAINT [fk_Productos_Productos_1] FOREIGN KEY ([IdProductoCasting]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Productos] ADD CONSTRAINT [fk_Productos_Aleaciones_1] FOREIGN KEY ([IdAleacion]) REFERENCES [Aleaciones] ([IdAleacion])
GO
ALTER TABLE [Pedidos] ADD CONSTRAINT [fk_Pedidos_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [ProgramacionesSemana] ADD CONSTRAINT [fk_ProgramacionesSemana_Programaciones_1] FOREIGN KEY ([IdProgramacion]) REFERENCES [Programaciones] ([IdProgramacion])
GO
ALTER TABLE [AlmacenesProducto] ADD CONSTRAINT [fk_AlmacenesProducto_Almacenes_1] FOREIGN KEY ([IdAlmacen]) REFERENCES [Almacenes] ([IdAlmacen])
GO
ALTER TABLE [AlmacenesProducto] ADD CONSTRAINT [fk_AlmacenesProducto_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Producciones] ADD CONSTRAINT [fk_Seguimientos_Maquinas_1] FOREIGN KEY ([IdMaquina]) REFERENCES [Maquinas] ([IdMaquina])
GO
ALTER TABLE [Producciones] ADD CONSTRAINT [fk_Seguimientos_Usuarios_1] FOREIGN KEY ([IdUsuario]) REFERENCES [Usuarios] ([IdUsuarios])
GO
ALTER TABLE [ProduccionesDetalle] ADD CONSTRAINT [fk_SeguimientosDetalle_Programaciones_1] FOREIGN KEY ([IdProgramacion]) REFERENCES [Programaciones] ([IdProgramacion])
GO
ALTER TABLE [Programaciones] ADD CONSTRAINT [fk_Programaciones_Usuarios_1] FOREIGN KEY ([IdUsuario]) REFERENCES [Usuarios] ([IdUsuarios])
GO
ALTER TABLE [Usuarios] ADD CONSTRAINT [fk_Usuarios_Turnos_1] FOREIGN KEY ([IdTurno]) REFERENCES [Turnos] ([IdTurno])
GO
ALTER TABLE [Programaciones] ADD CONSTRAINT [fk_Programaciones_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Programaciones] ADD CONSTRAINT [fk_Programaciones_ProgramacionesEstatus_1] FOREIGN KEY ([IdProgramacionEstatus]) REFERENCES [ProgramacionesEstatus] ([IdProgramacionEstatus])
GO
ALTER TABLE [ProduccionesDetalle] ADD CONSTRAINT [fk_SeguimientosDetalle_Productos_1] FOREIGN KEY ([IdProductos]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Causas] ADD CONSTRAINT [fk_Causas_CausasTipo_1] FOREIGN KEY ([IdCausaTipo]) REFERENCES [CausasTipo] ([IdCausaTipo])
GO
ALTER TABLE [TiemposMuerto] ADD CONSTRAINT [fk_TiemposMuerto_Causas_1] FOREIGN KEY ([IdCausa]) REFERENCES [Causas] ([IdCausa])
GO
ALTER TABLE [MaterialesVaciado] ADD CONSTRAINT [fk_MaterialesVaciado_Materiales_1] FOREIGN KEY ([IdMaterial]) REFERENCES [Materiales] ([IdMaterial])
GO
ALTER TABLE [Vaciados] ADD CONSTRAINT [fk_Vaciados_Aleaciones_1] FOREIGN KEY ([IdAleacion]) REFERENCES [Aleaciones] ([IdAleacion])
GO
ALTER TABLE [Programaciones] ADD CONSTRAINT [fk_Programaciones_Pedidos_1] FOREIGN KEY ([IdPedido]) REFERENCES [Pedidos] ([IdPedido])
GO
ALTER TABLE [Almas] ADD CONSTRAINT [fk_Almas_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Almas] ADD CONSTRAINT [fk_Almas_AlmasTipo_1] FOREIGN KEY ([IdAlmaTipo]) REFERENCES [AlmasTipo] ([IdAlmaTipo])
GO
ALTER TABLE [Almas] ADD CONSTRAINT [fk_Almas_AlmasRecetas_1] FOREIGN KEY ([IdAlmaReceta]) REFERENCES [AlmasRecetas] ([IdAlmaReceta])
GO
ALTER TABLE [Almas] ADD CONSTRAINT [fk_Almas_AlmasMaterialCaja_1] FOREIGN KEY ([IdAlmaMaterialCaja]) REFERENCES [AlmasMaterialCaja] ([IdAlmaMaterialCaja])
GO
ALTER TABLE [Filtros] ADD CONSTRAINT [fk_Filtros_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Filtros] ADD CONSTRAINT [fk_Filtros_FiltrosTipo_1] FOREIGN KEY ([IdFiltroTipo]) REFERENCES [FiltrosTipo] ([IdFiltroTipo])
GO
ALTER TABLE [Camisas] ADD CONSTRAINT [fk_Camisas_CamisasTipo_1] FOREIGN KEY ([IdCamisaTipo]) REFERENCES [CamisasTipo] ([IdCamisaTipo])
GO
ALTER TABLE [Camisas] ADD CONSTRAINT [fk_Camisas_Productos_1] FOREIGN KEY ([IdProducto]) REFERENCES [Productos] ([IdProducto])
GO
ALTER TABLE [Temperaturas] ADD CONSTRAINT [fk_Temperaturas_Maquinas_1] FOREIGN KEY ([IdMaquina]) REFERENCES [Maquinas] ([IdMaquina])
GO
ALTER TABLE [Maquinas] ADD CONSTRAINT [fk_Maquinas_CentrosTrabajo_1] FOREIGN KEY ([IdCentroTrabajo]) REFERENCES [CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [ProgramacionesAlma] ADD CONSTRAINT [fk_ProgramacionesAlma_Programaciones_1] FOREIGN KEY ([IdProgramacion]) REFERENCES [Programaciones] ([IdProgramacion])
GO
ALTER TABLE [ProgramacionesAlmaDia] ADD CONSTRAINT [fk_ProgramacionesAlmaDia_ProgramacionesAlmaSemana_1] FOREIGN KEY ([IdProgramacionAlmaSemana]) REFERENCES [ProgramacionesAlmaSemana] ([IdProgramacionAlmaSemana])
GO
ALTER TABLE [ProgramacionesAlmaSemana] ADD CONSTRAINT [fk_ProgramacionesAlmaSemana_ProgramacionesAlma_1] FOREIGN KEY ([IdProgramacionAlma]) REFERENCES [ProgramacionesAlma] ([IdProgramacionAlma])
GO
ALTER TABLE [ProgramacionesAlma] ADD CONSTRAINT [fk_ProgramacionesAlma_ProgramacionesEstatus_1] FOREIGN KEY ([IdProgramacionEstatus]) REFERENCES [ProgramacionesEstatus] ([IdProgramacionEstatus])
GO
ALTER TABLE [ProgramacionesAlma] ADD CONSTRAINT [fk_ProgramacionesAlma_Almas_1] FOREIGN KEY ([IdAlmas]) REFERENCES [Almas] ([IdAlma])
GO
ALTER TABLE [ProgramacionesAlma] ADD CONSTRAINT [fk_ProgramacionesAlma_Usuarios_1] FOREIGN KEY ([IdUsuario]) REFERENCES [Usuarios] ([IdUsuarios])
GO
ALTER TABLE [TiemposMuerto] ADD CONSTRAINT [fk_TiemposMuerto_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [Temperaturas] ADD CONSTRAINT [fk_Temperaturas_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [MaterialesVaciado] ADD CONSTRAINT [fk_MaterialesVaciado_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [Vaciados] ADD CONSTRAINT [fk_Vaciados_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [ProduccionesDetalle] ADD CONSTRAINT [fk_ProduccionesDetalle_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [Defectos] ADD CONSTRAINT [fk_Defectos_DefectosTipo_1] FOREIGN KEY ([IdDefectoTipo]) REFERENCES [DefectosTipo] ([IdDefectoTipo])
GO
ALTER TABLE [Producciones] ADD CONSTRAINT [fk_Producciones_ProduccionesEstatus_1] FOREIGN KEY ([IdProduccionEstatus]) REFERENCES [ProduccionesEstatus] ([IdProduccionEstatus])
GO
ALTER TABLE [ProduccionesDefecto] ADD CONSTRAINT [fk_ProduccionesDefecto_ProduccionesDetalle_1] FOREIGN KEY ([IdProduccionDetalle]) REFERENCES [ProduccionesDetalle] ([IdProduccionDetalle])
GO
ALTER TABLE [ProduccionesDefecto] ADD CONSTRAINT [fk_ProduccionesDefecto_Defectos_1] FOREIGN KEY ([IdDefecto]) REFERENCES [Defectos] ([IdDefecto])
GO
ALTER TABLE [Producciones] ADD CONSTRAINT [fk_Producciones_CentrosTrabajo_1] FOREIGN KEY ([IdCentroTrabajo]) REFERENCES [CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [AlmasProduccionDetalle] ADD CONSTRAINT [fk_AlmasProduccionDetalle_Producciones_1] FOREIGN KEY ([IdProduccion]) REFERENCES [Producciones] ([IdProduccion])
GO
ALTER TABLE [AlmasProduccionDefecto] ADD CONSTRAINT [fk_AlmasProduccionDefecto_AlmasProduccionDetalle_1] FOREIGN KEY ([IdAlmaProduccionDetalle]) REFERENCES [AlmasProduccionDetalle] ([IdAlmaProduccion])
GO
ALTER TABLE [AlmasProduccionDefecto] ADD CONSTRAINT [fk_AlmasProduccionDefecto_Defectos_1] FOREIGN KEY ([IdDefecto]) REFERENCES [Defectos] ([IdDefecto])
GO
ALTER TABLE [AlmasProduccionDetalle] ADD CONSTRAINT [fk_AlmasProduccionDetalle_Almas_1] FOREIGN KEY ([IdAlma]) REFERENCES [Almas] ([IdAlma])
GO
ALTER TABLE [AlmasProduccionDetalle] ADD CONSTRAINT [fk_AlmasProduccionDetalle_ProgramacionesAlma_1] FOREIGN KEY ([IdProgramacionAlma]) REFERENCES [ProgramacionesAlma] ([IdProgramacionAlma])
GO
ALTER TABLE [ProgramacionesDia] ADD CONSTRAINT [fk_ProgramacionesDia_ProgramacionesSemana_1] FOREIGN KEY ([IdProgramacionSemana]) REFERENCES [ProgramacionesSemana] ([IdProgramacionSemana])
GO
ALTER TABLE [Pedidos] ADD CONSTRAINT [fk_Pedidos_Almacenes_1] FOREIGN KEY ([IdAlmacen]) REFERENCES [Almacenes] ([IdAlmacen])
GO
ALTER TABLE [Procesos] ADD CONSTRAINT [fk_Procesos_Areas_1] FOREIGN KEY ([IdArea]) REFERENCES [Areas] ([IdArea])
GO
ALTER TABLE [CentrosTrabajo] ADD CONSTRAINT [fk_CentrosTrabajo_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [Producciones] ADD CONSTRAINT [fk_Producciones_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [Causas] ADD CONSTRAINT [fk_Causas_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [Defectos] ADD CONSTRAINT [fk_Defectos_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [Aleaciones] ADD CONSTRAINT [fk_Aleaciones_AleacionesTipo_1] FOREIGN KEY ([IdAleacionTipo]) REFERENCES [AleacionesTipo] ([IdAleacionTipo])
GO
ALTER TABLE [AleacionesTipoFactor] ADD CONSTRAINT [fk_AleacionesTipoFactor_AleacionesTipo_1] FOREIGN KEY ([IdAleacionTipo]) REFERENCES [AleacionesTipo] ([IdAleacionTipo])
GO
ALTER TABLE [Programaciones] ADD CONSTRAINT [fk_Programaciones_Areas_1] FOREIGN KEY ([IdArea]) REFERENCES [Areas] ([IdArea])
GO
ALTER TABLE [ProgramacionesDia] ADD CONSTRAINT [fk_ProgramacionesDia_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [Materiales] ADD CONSTRAINT [fk_Materiales_Procesos_1] FOREIGN KEY ([IdProceso]) REFERENCES [Procesos] ([IdProceso])
GO
ALTER TABLE [ProgramacionesDia] ADD CONSTRAINT [fk_ProgramacionesDia_Turnos_1] FOREIGN KEY ([IdTurno]) REFERENCES [Turnos] ([IdTurno])
GO
ALTER TABLE [user] ADD CONSTRAINT [fk_user_Usuarios_1] FOREIGN KEY ([IdEmpleado]) REFERENCES [Usuarios] ([IdUsuarios])
GO
ALTER TABLE [user] ADD CONSTRAINT [fk_user_empleados_1] FOREIGN KEY ([IdEmpleado]) REFERENCES [Empleados] ([IdEmpleado])
GO

