USE [FIMEX_Produccion]
GO
/****** Object:  Table [dbo].[Aleaciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Aleaciones](
	[IdAleacion] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NULL,
	[Descripcion] [varchar](30) NULL,
	[IdAleacionTipo] [int] NOT NULL,
	[Color] [varchar](7) NULL,
 CONSTRAINT [PK_Aleaciones] PRIMARY KEY CLUSTERED 
(
	[IdAleacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AleacionesTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AleacionesTipo](
	[IdAleacionTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](30) NOT NULL,
	[Factor] [money] NOT NULL,
	[DUX_Codigo] [varchar](20) NOT NULL,
	[DUX_CuentaContable] [varchar](20) NOT NULL,
 CONSTRAINT [PK_AleacionesTipo] PRIMARY KEY CLUSTERED 
(
	[IdAleacionTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AleacionesTipoFactor]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AleacionesTipoFactor](
	[IdAleacionTipoFactor] [int] IDENTITY(1,1) NOT NULL,
	[IdAleacionTipo] [int] NOT NULL,
	[Fecha] [date] NOT NULL,
	[Factor] [money] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAleacionTipoFactor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Almacenes]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Almacenes](
	[IdAlmacen] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NULL,
	[Descripcion] [varchar](50) NULL,
 CONSTRAINT [PK_Almacenes] PRIMARY KEY CLUSTERED 
(
	[IdAlmacen] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AlmacenesProducto]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AlmacenesProducto](
	[IdAlmacenProducto] [int] IDENTITY(1,1) NOT NULL,
	[IdAlmacen] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[Existencia] [decimal](15, 4) NOT NULL,
	[CostoPromedio] [decimal](15, 4) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAlmacenProducto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Almas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Almas](
	[IdAlma] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdAlmaTipo] [int] NOT NULL,
	[IdAlmaMaterialCaja] [int] NOT NULL,
	[IdAlmaReceta] [int] NOT NULL,
	[Existencia] [int] NULL,
	[PiezasCaja] [int] NULL,
	[PiezasMolde] [int] NULL,
	[Peso] [real] NULL,
	[TiempoLlenado] [real] NULL,
	[TiempoFraguado] [real] NULL,
	[TiempoGaseoDirecto] [real] NULL,
	[TiempoGaseoIndirecto] [real] NULL,
 CONSTRAINT [PK_Almas] PRIMARY KEY CLUSTERED 
(
	[IdAlma] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[AlmasMaterialCaja]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AlmasMaterialCaja](
	[IdAlmaMaterialCaja] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_AlmasMaterialCaja] PRIMARY KEY CLUSTERED 
(
	[IdAlmaMaterialCaja] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AlmasProduccionDefecto]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AlmasProduccionDefecto](
	[IdAlmaProduccionDefecto] [int] IDENTITY(1,1) NOT NULL,
	[IdAlmaProduccionDetalle] [int] NOT NULL,
	[IdDefectoTipo] [int] NOT NULL,
	[Rechazadas] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAlmaProduccionDefecto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[AlmasProduccionDetalle]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AlmasProduccionDetalle](
	[IdAlmaProduccionDetalle] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NOT NULL,
	[IdProgramacionAlma] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdAlmaTipo] [int] NOT NULL,
	[Inicio] [datetime2](7) NULL,
	[Fin] [datetime2](7) NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NULL,
	[Rechazadas] [int] NOT NULL,
	[PiezasCaja] [int] NOT NULL,
	[PiezasMolde] [int] NOT NULL,
	[PiezasHora] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAlmaProduccionDetalle] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[AlmasRecetas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AlmasRecetas](
	[IdAlmaReceta] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_AlmasRecetas] PRIMARY KEY CLUSTERED 
(
	[IdAlmaReceta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AlmasTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AlmasTipo](
	[IdAlmaTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_AlmasTipo] PRIMARY KEY CLUSTERED 
(
	[IdAlmaTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AreaActual]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AreaActual](
	[IdAreaAct] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](10) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAreaAct] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AreaProcesos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AreaProcesos](
	[IdAreaProceso] [int] IDENTITY(1,1) NOT NULL,
	[IdArea] [int] NOT NULL,
	[IdProceso] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdAreaProceso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Areas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Areas](
	[IdArea] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NULL,
	[Descripcion] [varchar](30) NULL,
	[AgruparPedidos] [bit] NULL,
 CONSTRAINT [PK__Areas__2FC141AAA9F76290] PRIMARY KEY CLUSTERED 
(
	[IdArea] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[auth_assignment]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[auth_assignment](
	[item_name] [varchar](64) NOT NULL,
	[user_id] [varchar](64) NOT NULL,
	[created_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[item_name] ASC,
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[auth_item]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[auth_item](
	[name] [varchar](64) NOT NULL,
	[type] [int] NOT NULL,
	[description] [text] NULL,
	[rule_name] [varchar](64) NULL,
	[data] [text] NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[auth_item_child]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[auth_item_child](
	[parent] [varchar](64) NOT NULL,
	[child] [varchar](64) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[parent] ASC,
	[child] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[auth_rule]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[auth_rule](
	[name] [varchar](64) NOT NULL,
	[data] [text] NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Bitacora]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Bitacora](
	[IdBitacora] [int] IDENTITY(1,1) NOT NULL,
	[FechaInicio] [datetime2](7) NULL,
 CONSTRAINT [PK__Bitacora__ED3A1B13C6B9F02F] PRIMARY KEY CLUSTERED 
(
	[IdBitacora] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Cajas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Cajas](
	[IdCaja] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdTipoCaja] [int] NOT NULL,
	[PiezasXCaja] [int] NOT NULL,
 CONSTRAINT [PK__Cajas__3B7BF2C510916BC8] PRIMARY KEY CLUSTERED 
(
	[IdCaja] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CajasTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CajasTipo](
	[IdTipoCaja] [int] IDENTITY(1,1) NOT NULL,
	[Tamano] [varchar](50) NOT NULL,
	[CodigoDlls] [char](20) NULL,
	[CodigoPesos] [char](20) NULL,
 CONSTRAINT [PK__CajasTip__F1B8240CE1E56773] PRIMARY KEY CLUSTERED 
(
	[IdTipoCaja] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Camisas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Camisas](
	[IdCamisa] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdCamisaTipo] [int] NOT NULL,
	[Cantidad] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdCamisa] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CamisasTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CamisasTipo](
	[IdCamisaTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](30) NOT NULL,
	[CantidadPorPaquete] [int] NOT NULL,
	[DUX_CodigoPesos] [varchar](20) NULL,
	[DUX_CodigoDolares] [varchar](20) NULL,
	[Tamano] [varchar](20) NULL,
	[TiempoDesmoldeo] [decimal](18, 0) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdCamisaTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Causas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Causas](
	[IdCausa] [int] IDENTITY(1,1) NOT NULL,
	[IdCausaTipo] [int] NOT NULL,
	[Indentificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](60) NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
 CONSTRAINT [PK_Causas] PRIMARY KEY CLUSTERED 
(
	[IdCausa] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[CausasTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CausasTipo](
	[IdCausaTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_CausasTipo] PRIMARY KEY CLUSTERED 
(
	[IdCausaTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[CentrosTrabajo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CentrosTrabajo](
	[IdCentroTrabajo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](50) NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
	[Habilitado] [bigint] NULL,
 CONSTRAINT [PK_CentrosTrabajo] PRIMARY KEY CLUSTERED 
(
	[IdCentroTrabajo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[CentrosTrabajoMaquinas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CentrosTrabajoMaquinas](
	[IdCentroTrabajoMaquina] [int] IDENTITY(1,1) NOT NULL,
	[IdCentroTrabajo] [int] NOT NULL,
	[IdMaquina] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdCentroTrabajoMaquina] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CentrosTrabajoProductos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CentrosTrabajoProductos](
	[IdCentroTrabajoProducto] [int] IDENTITY(0,1) NOT NULL,
	[IdCentroTrabajo] [int] NULL,
	[IdProducto] [int] NULL,
	[PiezasPorHora] [decimal](18, 0) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdCentroTrabajoProducto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CiclosTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CiclosTipo](
	[IdCicloTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NULL,
	[Descripcion] [varchar](15) NULL,
 CONSTRAINT [PK_RechazosTipo] PRIMARY KEY CLUSTERED 
(
	[IdCicloTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[CiclosVarel]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CiclosVarel](
	[IdCiclos] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdTurno] [int] NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[Serie] [varchar](30) NULL,
	[Comentarios] [varchar](255) NULL,
	[Fecha] [date] NULL,
	[Cantidad] [int] NULL,
	[Tipo] [varchar](2) NULL,
	[IdParteMolde] [int] NULL,
 CONSTRAINT [PK__Ciclos__EA25B64BF38F060A] PRIMARY KEY CLUSTERED 
(
	[IdCiclos] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ConfiguracionSeries]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ConfiguracionSeries](
	[IdConfiguracionSerie] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NULL,
	[SerieInicio] [int] NULL,
 CONSTRAINT [PK_ConfiguracionSeries] PRIMARY KEY CLUSTERED 
(
	[IdConfiguracionSerie] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[ConfiguracionSeries] SET (LOCK_ESCALATION = AUTO)
GO
/****** Object:  Table [dbo].[Defectos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Defectos](
	[IdDefecto] [int] IDENTITY(1,1) NOT NULL,
	[IdDefectoTipo] [int] NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
 CONSTRAINT [PK_Defectos] PRIMARY KEY CLUSTERED 
(
	[IdDefecto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[DefectosTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[DefectosTipo](
	[IdDefectoTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](110) NULL,
 CONSTRAINT [PK_DefectosTipo] PRIMARY KEY CLUSTERED 
(
	[IdDefectoTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Departamentos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Departamentos](
	[IdDepartamento] [int] IDENTITY(1,1) NOT NULL,
	[IDENTIFICACION] [varchar](20) NOT NULL,
	[DESCRIPCION] [varchar](50) NULL,
	[NOMBRERESPONSABLE] [varchar](90) NULL,
	[CUENTACONTABLE] [varchar](19) NULL,
	[OBSERVACIONES] [varchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdDepartamento] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Empleados]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Empleados](
	[IdEmpleado] [int] IDENTITY(1,1) NOT NULL,
	[Nomina] [int] NOT NULL,
	[ApellidoPaterno] [varchar](30) NULL,
	[ApellidoMaterno] [varchar](30) NULL,
	[Nombre] [varchar](90) NULL,
	[IdEmpleadoEstatus] [int] NULL,
	[RFC] [varchar](15) NULL,
	[IMSS] [varchar](15) NULL,
	[IdDepartamento] [int] NULL,
	[IdTurno] [int] NULL,
	[IdPuesto] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdEmpleado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[EmpleadosEstatus]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[EmpleadosEstatus](
	[IdEmpleadoEstatus] [int] IDENTITY(1,1) NOT NULL,
	[Descripcion] [varchar](25) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdEmpleadoEstatus] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Existencias]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Existencias](
	[IdExistencias] [int] IDENTITY(1,1) NOT NULL,
	[IdSubproceso] [int] NOT NULL,
	[IdProgramacion] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[Cantidad] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdExistencias] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[FechaMoldeo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FechaMoldeo](
	[IdFechaMoldeo] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NULL,
	[FechaMoldeo] [date] NULL,
 CONSTRAINT [PK_FechaMoldeo] PRIMARY KEY CLUSTERED 
(
	[IdFechaMoldeo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[FechaMoldeoDetalle]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FechaMoldeoDetalle](
	[IdFechaMoldeoDetalle] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccionDetalle] [int] NOT NULL,
	[IdFechaMoldeo] [int] NOT NULL,
 CONSTRAINT [PK_FechaMoldeoDetalle1] PRIMARY KEY CLUSTERED 
(
	[IdFechaMoldeoDetalle] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Filtros]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Filtros](
	[IdFiltro] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdFiltroTipo] [int] NOT NULL,
	[Cantidad] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdFiltro] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[FiltrosTipo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[FiltrosTipo](
	[IdFiltroTipo] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](50) NULL,
	[CantidadPorPaquete] [int] NOT NULL,
	[DUX_CodigoPesos] [varchar](20) NULL,
	[DUX_CodigoDolares] [varchar](20) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdFiltroTipo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[HistoriaExplosion]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[HistoriaExplosion](
	[IdHistorialExplo] [int] NOT NULL,
	[IdProductosEnsamble] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[Componente] [char](30) NOT NULL,
	[Cantidad] [int] IDENTITY(1,1) NOT NULL,
 CONSTRAINT [PK_HistoriaExplosion] PRIMARY KEY CLUSTERED 
(
	[IdHistorialExplo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
ALTER TABLE [dbo].[HistoriaExplosion] SET (LOCK_ESCALATION = AUTO)
GO
/****** Object:  Table [dbo].[Lances]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Lances](
	[IdLance] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NOT NULL,
	[IdAleacion] [int] NOT NULL,
	[Colada] [int] NOT NULL,
	[Lance] [int] NOT NULL,
	[HornoConsecutivo] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdLance] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[MantenimientoHornos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[MantenimientoHornos](
	[IdMantenimientoHorno] [int] IDENTITY(1,1) NOT NULL,
	[IdMaquina] [int] NULL,
	[Fecha] [datetime] NULL,
	[Consecutivo] [int] NULL,
	[Observaciones] [text] NULL,
	[Refractario] [text] NULL,
 CONSTRAINT [PK__Mantenim__6A31DA05252226A2] PRIMARY KEY CLUSTERED 
(
	[IdMantenimientoHorno] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Maquinas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Maquinas](
	[IdMaquina] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](9) NULL,
	[Descripcion] [varchar](70) NULL,
	[Consecutivo] [int] NOT NULL,
	[Eficiencia] [decimal](18, 2) NULL,
 CONSTRAINT [PK_Maquinas] PRIMARY KEY CLUSTERED 
(
	[IdMaquina] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MaquinasProductos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[MaquinasProductos](
	[IdMaquinaProducto] [int] NULL,
	[IdMaquina] [int] NULL,
	[IdProducto] [int] NULL,
	[PiezasPorHora] [decimal](18, 0) NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Marcas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Marcas](
	[IdMarca] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NOT NULL,
	[Descripcion] [varchar](30) NOT NULL,
 CONSTRAINT [PK_Marcas] PRIMARY KEY CLUSTERED 
(
	[IdMarca] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Materiales]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Materiales](
	[IdMaterial] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](10) NOT NULL,
	[Descripcion] [varchar](50) NULL,
	[IdSubProceso] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
 CONSTRAINT [PK_Materiales] PRIMARY KEY CLUSTERED 
(
	[IdMaterial] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MaterialesVaciado]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[MaterialesVaciado](
	[IdMaterialVaciado] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NOT NULL,
	[IdMaterial] [int] NOT NULL,
	[Cantidad] [float] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdMaterialVaciado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[PartesMolde]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PartesMolde](
	[IdParteMolde] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](15) NOT NULL,
 CONSTRAINT [PK_PartesMolde] PRIMARY KEY CLUSTERED 
(
	[IdParteMolde] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Partran]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Partran](
	[IdPartran] [int] IDENTITY(1,1) NOT NULL,
	[IdTransaccion] [int] NOT NULL,
	[IdAlmacen] [int] NOT NULL,
	[Tipo] [varchar](1) NOT NULL,
	[Cantidad] [int] NULL,
	[Exixtencia] [int] NULL,
 CONSTRAINT [PK__Partran__654BC1ECEC35A133] PRIMARY KEY CLUSTERED 
(
	[IdPartran] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Pedidos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Pedidos](
	[IdPedido] [int] IDENTITY(1,1) NOT NULL,
	[IdAlmacen] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[Codigo] [int] NOT NULL,
	[Numero] [int] NOT NULL,
	[Fecha] [date] NOT NULL,
	[Cliente] [varchar](15) NULL,
	[OrdenCompra] [varchar](20) NULL,
	[Estatus] [int] NOT NULL,
	[Cantidad] [decimal](15, 6) NOT NULL,
	[SaldoCantidad] [decimal](15, 6) NOT NULL,
	[FechaEmbarque] [date] NULL,
	[NivelRiesgo] [int] NOT NULL,
	[Observaciones] [text] NULL,
	[TotalProgramado] [decimal](15, 6) NOT NULL,
	[SaldoExistenciaPT] [int] NULL,
	[SaldoExistenciaProceso] [int] NULL,
	[EstatusEnsamble] [int] NULL,
	[FechaEnvio] [date] NULL,
 CONSTRAINT [PK_Pedidos] PRIMARY KEY CLUSTERED 
(
	[IdPedido] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[PedProg]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PedProg](
	[IdPedProg] [int] IDENTITY(1,1) NOT NULL,
	[IdPedido] [int] NOT NULL,
	[IdProgramacion] [int] NOT NULL,
	[OrdenCompra] [varchar](50) NOT NULL,
	[FechaMovimiento] [datetime2](7) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdPedProg] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Pintura_control]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Pintura_control](
	[id_pintura] [int] IDENTITY(1,1) NOT NULL,
	[fecha] [datetime] NOT NULL,
	[turno] [varchar](10) NOT NULL,
	[Motivo] [varchar](20) NOT NULL,
	[pintura] [varchar](30) NOT NULL,
	[den_ini] [float] NOT NULL,
	[den_fin] [float] NOT NULL,
	[serie] [varchar](20) NULL,
	[pin_nueva] [float] NULL,
	[pin_recicl] [float] NULL,
	[comentarios] [varchar](max) NULL,
	[nomina] [varchar](10) NOT NULL,
	[alcohol] [float] NULL,
	[area] [varchar](20) NOT NULL,
	[base] [varchar](20) NULL,
	[base_cant] [float] NULL,
	[timestamp] [datetime] NOT NULL,
 CONSTRAINT [PK_Pintura_Control] PRIMARY KEY CLUSTERED 
(
	[id_pintura] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Presentaciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Presentaciones](
	[IDPresentacion] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [varchar](5) NULL,
	[Descripcion] [varchar](30) NULL,
 CONSTRAINT [PK_Presentaciones] PRIMARY KEY CLUSTERED 
(
	[IDPresentacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Procesos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Procesos](
	[IdProceso] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [char](2) NOT NULL,
	[Descripcion] [varchar](50) NOT NULL,
 CONSTRAINT [PK_Procesos] PRIMARY KEY CLUSTERED 
(
	[IdProceso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Producciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Producciones](
	[IdProduccion] [int] IDENTITY(1,1) NOT NULL,
	[IdCentroTrabajo] [int] NOT NULL,
	[IdMaquina] [int] NOT NULL,
	[IdEmpleado] [int] NOT NULL,
	[IdProduccionEstatus] [int] NOT NULL,
	[Fecha] [datetime2](7) NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
	[Observaciones] [varchar](255) NULL,
	[IdTurno] [int] NULL,
 CONSTRAINT [PK_Producciones] PRIMARY KEY CLUSTERED 
(
	[IdProduccion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ProduccionesDefecto]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProduccionesDefecto](
	[IdProduccionDefecto] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccionDetalle] [int] NOT NULL,
	[IdDefectoTipo] [int] NULL,
	[Rechazadas] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProduccionDefecto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ProduccionesDetalle]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ProduccionesDetalle](
	[IdProduccionDetalle] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NOT NULL,
	[IdProgramacion] [int] NOT NULL,
	[IdProductos] [int] NOT NULL,
	[Inicio] [datetime2](7) NULL,
	[Fin] [datetime2](7) NULL,
	[CiclosMolde] [int] NOT NULL,
	[PiezasMolde] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
	[Rechazadas] [int] NOT NULL,
	[Eficiencia] [decimal](18, 2) NOT NULL,
	[Enviado] [bit] NULL,
	[Seleccionado] [bit] NULL,
	[IdParteMolde] [int] NULL,
	[CantidadCiclos] [int] NULL,
	[EstatusCiclos] [varchar](7) NULL,
 CONSTRAINT [PK_ProduccionesDetalle] PRIMARY KEY CLUSTERED 
(
	[IdProduccionDetalle] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ProduccionesEstatus]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ProduccionesEstatus](
	[IdProduccionEstatus] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [char](1) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_ProduccionesEstatus] PRIMARY KEY CLUSTERED 
(
	[IdProduccionEstatus] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Productos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Productos](
	[IdProducto] [int] IDENTITY(1,1) NOT NULL,
	[IdMarca] [int] NOT NULL,
	[IdPresentacion] [int] NOT NULL,
	[IdAleacion] [int] NOT NULL,
	[IdProductoCasting] [int] NULL,
	[Identificacion] [varchar](20) NULL,
	[Descripcion] [varchar](60) NULL,
	[PiezasMolde] [int] NOT NULL,
	[CiclosMolde] [int] NOT NULL,
	[PesoCasting] [decimal](15, 4) NOT NULL,
	[PesoArania] [decimal](15, 4) NOT NULL,
	[MoldesHora] [int] NULL,
	[CiclosHora] [int] NULL,
	[IdProductosEstatus] [int] NULL,
	[IdAreaAct] [int] NULL,
	[FactorTiempoDesmoldeo] [decimal](15, 2) NULL,
	[Ensamble] [char](1) NULL,
	[LlevaSerie] [varchar](2) NULL,
	[IdParteMolde] [int] NULL,
	[FechaMoldeo] [bit] NULL,
 CONSTRAINT [PK_Productos] PRIMARY KEY CLUSTERED 
(
	[IdProducto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [UNQ_identificacion] UNIQUE NONCLUSTERED 
(
	[Identificacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ProductosEnsamble]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProductosEnsamble](
	[IdProductoEnsamble] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdComponente] [int] NULL,
	[Cantidad] [int] NOT NULL,
	[SeCompra] [bit] NULL,
 CONSTRAINT [PK_ProductosEnsamble] PRIMARY KEY CLUSTERED 
(
	[IdProductoEnsamble] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[ProductosEnsamble] SET (LOCK_ESCALATION = AUTO)
GO
/****** Object:  Table [dbo].[ProductosEstatus]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ProductosEstatus](
	[IdProductosEstatus] [int] IDENTITY(1,1) NOT NULL,
	[Descripcion] [varchar](20) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProductosEstatus] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Programaciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Programaciones](
	[IdProgramacion] [int] IDENTITY(1,1) NOT NULL,
	[IdPedido] [int] NOT NULL,
	[IdArea] [int] NOT NULL,
	[IdEmpleado] [int] NOT NULL,
	[IdProgramacionEstatus] [int] NOT NULL,
	[IdProducto] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NULL,
	[Cantidad] [int] NULL,
	[Llenadas] [int] NULL,
	[Cerradas] [int] NULL,
	[Vaciadas] [int] NULL,
	[FechaCerrado] [date] NULL,
	[HoraCerrado] [time](7) NULL,
	[CerradoPor] [varchar](20) NULL,
	[CerradoPC] [varchar](20) NULL,
 CONSTRAINT [PK_Programaciones] PRIMARY KEY CLUSTERED 
(
	[IdProgramacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ProgramacionesAlma]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProgramacionesAlma](
	[IdProgramacionAlma] [int] IDENTITY(1,1) NOT NULL,
	[IdProgramacion] [int] NOT NULL,
	[IdEmpleado] [int] NOT NULL,
	[IdProgramacionEstatus] [int] NOT NULL,
	[IdAlmas] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
	[Usadas] [int] NULL,
 CONSTRAINT [PK_ProgramacionesAlma] PRIMARY KEY CLUSTERED 
(
	[IdProgramacionAlma] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ProgramacionesAlmaDia]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProgramacionesAlmaDia](
	[IdProgramacionAlmaDia] [int] IDENTITY(1,1) NOT NULL,
	[IdProgramacionAlmaSemana] [int] NOT NULL,
	[Dia] [date] NOT NULL,
	[Prioridad] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
	[IdCentroTrabajo] [int] NOT NULL,
	[IdMaquina] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProgramacionAlmaDia] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ProgramacionesAlmaSemana]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProgramacionesAlmaSemana](
	[IdProgramacionAlmaSemana] [int] IDENTITY(1,1) NOT NULL,
	[IdProgramacionAlma] [int] NOT NULL,
	[Anio] [int] NOT NULL,
	[Semana] [int] NOT NULL,
	[Prioridad] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProgramacionAlmaSemana] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ProgramacionesDia]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProgramacionesDia](
	[IdProgramacionDia] [int] IDENTITY(1,1) NOT NULL,
	[IdProgramacionSemana] [int] NOT NULL,
	[Dia] [date] NOT NULL,
	[Prioridad] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
	[IdAreaProceso] [int] NOT NULL,
	[IdTurno] [int] NOT NULL,
	[IdCentroTrabajo] [int] NOT NULL,
	[IdMaquina] [int] NOT NULL,
	[Llenadas] [int] NULL,
	[Cerradas] [int] NULL,
	[Vaciadas] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProgramacionDia] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ProgramacionesEstatus]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ProgramacionesEstatus](
	[IdProgramacionEstatus] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [char](1) NOT NULL,
	[Descripcion] [varchar](20) NOT NULL,
 CONSTRAINT [PK_ProgramacionesEstatus] PRIMARY KEY CLUSTERED 
(
	[IdProgramacionEstatus] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ProgramacionesSemana]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProgramacionesSemana](
	[IdProgramacionSemana] [int] IDENTITY(1,1) NOT NULL,
	[IdProgramacion] [int] NOT NULL,
	[Anio] [int] NOT NULL,
	[Semana] [int] NOT NULL,
	[Prioridad] [int] NOT NULL,
	[Programadas] [int] NOT NULL,
	[Hechas] [int] NOT NULL,
	[Llenadas] [int] NULL,
	[Cerradas] [int] NULL,
	[Vaciadas] [int] NULL,
	[IdAreaProceso] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdProgramacionSemana] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ResumenFechaMoldeo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ResumenFechaMoldeo](
	[IdResumenFechaMoldeo] [int] IDENTITY(1,1) NOT NULL,
	[IdFechaMoldeo] [int] NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[Existencia] [int] NOT NULL,
 CONSTRAINT [PK_ResumenFechaMoldeo] PRIMARY KEY CLUSTERED 
(
	[IdResumenFechaMoldeo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Series]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Series](
	[IdSerie] [int] IDENTITY(1,1) NOT NULL,
	[IdProducto] [int] NOT NULL,
	[IdSubProceso] [int] NOT NULL,
	[Serie] [varchar](7) NULL,
	[Estatus] [varchar](1) NULL,
	[FechaHora] [datetime2](7) NULL,
 CONSTRAINT [PK__Series__13B9BEAD41652AAD] PRIMARY KEY CLUSTERED 
(
	[IdSerie] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [UNQ_Producto_Serie] UNIQUE NONCLUSTERED 
(
	[IdProducto] ASC,
	[Serie] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[SeriesDetalles]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[SeriesDetalles](
	[IdSeriesDetalles] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccionDetalle] [int] NOT NULL,
	[IdSerie] [int] NOT NULL,
	[Estatus] [varchar](7) NULL,
	[Comentarios] [text] NULL,
 CONSTRAINT [PK__SeriesDe__3F4837D205B17D7E] PRIMARY KEY CLUSTERED 
(
	[IdSeriesDetalles] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[SeriesPartidas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SeriesPartidas](
	[IdSeriesPartidas] [int] IDENTITY(1,1) NOT NULL,
	[IdPartran] [int] NOT NULL,
	[IdSerie] [int] NOT NULL,
 CONSTRAINT [PK__SeriesPa__05272AEDCD3EED9F] PRIMARY KEY CLUSTERED 
(
	[IdSeriesPartidas] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[SubProcesos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[SubProcesos](
	[IdSubProceso] [int] IDENTITY(1,1) NOT NULL,
	[IdProceso] [int] NOT NULL,
	[Identificador] [char](2) NOT NULL,
	[Descripcion] [varchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdSubProceso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tarimas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tarimas](
	[IdTarima] [int] IDENTITY(0,1) NOT NULL,
	[IdProgramacionDia] [int] NOT NULL,
	[Loop] [int] NOT NULL,
	[Tarima] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[IdTarima] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Temperaturas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Temperaturas](
	[IdTemperatura] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NOT NULL,
	[IdMaquina] [int] NOT NULL,
	[Fecha] [datetime2](7) NOT NULL,
	[Temperatura] [decimal](8, 4) NOT NULL,
	[Temperatura2] [decimal](8, 4) NULL,
	[IdEmpleado] [int] NOT NULL,
	[Moldes] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdTemperatura] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[TiemposMuerto]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[TiemposMuerto](
	[IdTiempoMuerto] [int] IDENTITY(1,1) NOT NULL,
	[IdMaquina] [int] NOT NULL,
	[IdCausa] [int] NOT NULL,
	[Inicio] [datetime2](7) NULL,
	[Fin] [datetime2](7) NULL,
	[Descripcion] [varchar](150) NULL,
	[Fecha] [date] NOT NULL,
	[IdTurno] [int] NULL,
	[IdEmpleado] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[IdTiempoMuerto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Transacciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Transacciones](
	[IdTransaccion] [int] IDENTITY(1,1) NOT NULL,
	[IdProduccion] [int] NULL,
 CONSTRAINT [PK__Transacc__334B1F77F5B17237] PRIMARY KEY CLUSTERED 
(
	[IdTransaccion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Turnos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Turnos](
	[IdTurno] [int] IDENTITY(1,1) NOT NULL,
	[Identificador] [char](1) NULL,
	[Descripcion] [varchar](20) NULL,
PRIMARY KEY CLUSTERED 
(
	[IdTurno] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](255) NOT NULL,
	[auth_key] [varchar](32) NOT NULL,
	[password_hash] [varchar](255) NOT NULL,
	[password_reset_token] [varchar](255) NULL,
	[email] [varchar](255) NOT NULL,
	[role] [smallint] NOT NULL,
	[status] [smallint] NOT NULL,
	[created_at] [int] NOT NULL,
	[updated_at] [int] NOT NULL,
	[IdEmpleado] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  View [dbo].[v_Productos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Productos] AS 
SELECT
dbo.Productos.IdProducto,
dbo.Productos.IdAreaAct,
dbo.AreaActual.Identificador AS AreaAct,
dbo.Productos.IdMarca,
dbo.Productos.IdPresentacion,
dbo.Productos.IdAleacion,
dbo.Productos.IdProductoCasting,
dbo.Productos.Identificacion,
dbo.Productos.Descripcion,
ProductosCast.Identificacion AS ProductoCasting,
dbo.Marcas.Identificador AS Marca,
dbo.Presentaciones.Descripcion AS Presentacion,
dbo.Aleaciones.Descripcion AS Aleacion,
ProductosCast.PiezasMolde,
ProductosCast.CiclosMolde,
dbo.Productos.PesoCasting,
ProductosCast.PesoArania,
ProductosCast.MoldesHora,
dbo.Productos.PiezasMolde AS PiezasMoldeA,
dbo.Productos.CiclosMolde AS CiclosMoldeA,
dbo.Productos.PesoArania AS PesoAraniaA,
dbo.Productos.MoldesHora AS MoldesHoraA,
dbo.Productos.Ensamble,
dbo.Aleaciones.Color

FROM            dbo.Productos INNER JOIN
                         dbo.Marcas ON dbo.Productos.IdMarca = dbo.Marcas.IdMarca INNER JOIN
                         dbo.Presentaciones ON dbo.Productos.IdPresentacion = dbo.Presentaciones.IDPresentacion INNER JOIN
                         dbo.Aleaciones ON dbo.Productos.IdAleacion = dbo.Aleaciones.IdAleacion INNER JOIN
                         dbo.Productos AS ProductosCast ON dbo.Productos.IdProductoCasting = ProductosCast.IdProducto LEFT JOIN
												 dbo.AreaActual ON dbo.Productos.IdAreaAct = dbo.AreaActual.IdAreaAct

GO
/****** Object:  View [dbo].[v_Programaciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Programaciones] AS 
SELECT
dbo.Programaciones.IdProgramacion,
dbo.Programaciones.IdPedido,
dbo.Programaciones.IdArea,
dbo.Programaciones.IdEmpleado,
dbo.Programaciones.IdProgramacionEstatus,
dbo.Programaciones.IdProducto,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.Color,
dbo.Pedidos.OrdenCompra,
dbo.v_Productos.IdAreaAct,
dbo.v_Productos.AreaAct,
dbo.Programaciones.Programadas,
dbo.Programaciones.Hechas,
dbo.Areas.Descripcion AS Area,
dbo.Pedidos.Codigo AS OE_Codigo,
dbo.Pedidos.Numero AS OE_Numero,
dbo.Pedidos.FechaEmbarque,
dbo.Programaciones.Cantidad,
dbo.Pedidos.SaldoCantidad,
dbo.Pedidos.TotalProgramado,
dbo.ProgramacionesEstatus.Descripcion AS Estatus,
dbo.v_Productos.Identificacion AS Producto,
dbo.v_Productos.Descripcion,
dbo.v_Productos.ProductoCasting,
dbo.v_Productos.Marca,
dbo.v_Productos.Presentacion,
dbo.v_Productos.Aleacion,
dbo.v_Productos.IdAleacion,
dbo.v_Productos.PiezasMolde,
dbo.v_Productos.CiclosMolde,
dbo.v_Productos.PesoCasting,
dbo.v_Productos.PesoArania,
dbo.v_Productos.MoldesHora,
dbo.v_Productos.Ensamble,
dbo.Pedidos.FechaEnvio

FROM            dbo.Programaciones INNER JOIN
												 --dbo.Programaciones ON dbo.PedProg.IdProgramacion = dbo.Programaciones.IdProgramacion INNER JOIN
                         dbo.Pedidos ON dbo.Programaciones.IdPedido = dbo.Pedidos.IdPedido INNER JOIN
                         dbo.Empleados ON dbo.Programaciones.IdEmpleado = dbo.Empleados.IdEmpleado INNER JOIN
                         dbo.ProgramacionesEstatus ON dbo.Programaciones.IdProgramacionEstatus = dbo.ProgramacionesEstatus.IdProgramacionEstatus INNER JOIN
                         dbo.v_Productos ON dbo.Programaciones.IdProducto = dbo.v_Productos.IdProducto INNER JOIN
                         dbo.Areas ON dbo.Programaciones.IdArea = dbo.Areas.IdArea
WHERE
dbo.Programaciones.Cantidad <> 0
GO
/****** Object:  View [dbo].[v_ResumenAcero]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ResumenAcero] AS 
SELECT
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.v_Programaciones.Aleacion,
Sum(CASE WHEN dbo.v_Programaciones.IdAreaAct IS NULL THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonPrgK,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 2 THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonPrgV,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 3 THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonPrgE,

SUM(CASE WHEN  dbo.v_Programaciones.IdAreaAct IS NULL THEN dbo.ProgramacionesSemana.Hechas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonVacK,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 2 THEN dbo.ProgramacionesSemana.Hechas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonVacV,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 3 THEN dbo.ProgramacionesSemana.Hechas * dbo.v_Programaciones.PesoArania ELSE 0 END) AS TonVacE,

SUM(CASE WHEN dbo.v_Programaciones.IdAreaAct IS NULL THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.CiclosMolde ELSE 0 END) AS CiclosK,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 2 THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.CiclosMolde ELSE 0 END) AS CiclosV,
SUM(CASE dbo.v_Programaciones.IdAreaAct WHEN 3 THEN dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.CiclosMolde ELSE 0 END) AS CiclosE,

SUM(CASE WHEN dbo.v_Programaciones.IdAreaAct IS NULL THEN dbo.ProgramacionesSemana.Programadas ELSE 0 END) AS MolPrgK,
Sum(CASE dbo.v_Programaciones.IdAreaAct WHEN 2 THEN dbo.ProgramacionesSemana.Programadas ELSE 0 END) AS MolPrgV,
Sum(CASE dbo.v_Programaciones.IdAreaAct WHEN 3 THEN dbo.ProgramacionesSemana.Programadas ELSE 0 END) AS MolPrgE

FROM
dbo.v_Programaciones
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
WHERE
dbo.ProgramacionesSemana.Programadas > 0 AND
dbo.v_Programaciones.SaldoCantidad > 0 AND
dbo.v_Programaciones.IdArea = 2
GROUP BY 
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.v_Programaciones.Aleacion

GO
/****** Object:  View [dbo].[v_Pedidos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Pedidos] AS 
SELECT
dbo.Pedidos.IdPedido,
dbo.Pedidos.IdAlmacen,
dbo.Pedidos.IdProducto,
dbo.Pedidos.Codigo,
dbo.Pedidos.Numero,
dbo.Productos.Identificacion AS Producto,
dbo.Almacenes.Identificador AS Almacen,
dbo.Pedidos.Fecha,
dbo.Pedidos.Cliente,
dbo.Pedidos.OrdenCompra,
dbo.Pedidos.Estatus,
dbo.Pedidos.Cantidad,
dbo.Pedidos.SaldoCantidad,
dbo.Pedidos.FechaEmbarque,
dbo.Pedidos.FechaEnvio,
dbo.Pedidos.NivelRiesgo,
dbo.Pedidos.TotalProgramado,
dbo.Pedidos.Observaciones,
dbo.Productos.PiezasMolde,
dbo.Productos.CiclosMolde,
dbo.Productos.PesoCasting,
dbo.Productos.PesoArania,
dbo.Productos.IdPresentacion,
dbo.Productos.IdParteMolde,
dbo.Productos.LlevaSerie,
dbo.Productos.FechaMoldeo,
dbo.Productos.IdAreaAct,
dbo.Programaciones.IdProgramacionEstatus,
dbo.Programaciones.FechaCerrado,
dbo.Programaciones.HoraCerrado,
dbo.Programaciones.CerradoPor,
dbo.Programaciones.CerradoPC

FROM
dbo.Pedidos
LEFT JOIN dbo.Almacenes ON dbo.Pedidos.IdAlmacen = dbo.Almacenes.IdAlmacen
LEFT JOIN dbo.Productos ON dbo.Pedidos.IdProducto = dbo.Productos.IdProducto
LEFT JOIN dbo.Programaciones ON dbo.Programaciones.IdPedido = dbo.Pedidos.IdPedido AND dbo.Programaciones.IdProducto = dbo.Pedidos.IdProducto

GO
/****** Object:  View [dbo].[v_DetalleProduccion]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_DetalleProduccion] AS 
SELECT
dbo.Programaciones.IdProgramacion,
dbo.ProgramacionesDia.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
ProduccionDetalle.IdProducto,
--ProduccionDetalle.IdProduccion,
ProduccionDetalle.Cant AS CiclosOk,
ProduccionDetalle.CantC AS CiclosOkC,
(ProduccionDetalle.Cant/dbo.v_Pedidos.CiclosMolde) AS MoldesOK,
(dbo.v_Pedidos.CiclosMolde*dbo.ProgramacionesDia.Programadas) AS ProgramadasCic,
ProduccionDetalle.RechazadasC,
ProduccionDetalle.RechazadasM,
ProduccionDetalle.RechazadasR,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.Programaciones.Programadas AS Pedido,
dbo.Programaciones.Hechas AS pedido_hecho,
dbo.ProgramacionesSemana.Programadas AS programadas_semana,
dbo.ProgramacionesSemana.Hechas AS hechas_semana,
dbo.ProgramacionesSemana.Prioridad AS prioridad_semana,
dbo.ProgramacionesDia.Prioridad,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesDia.Hechas,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.v_Pedidos.IdPedido,
dbo.v_Pedidos.IdAlmacen,
dbo.v_Pedidos.Codigo,
dbo.v_Pedidos.Numero,
dbo.v_Pedidos.Producto,
dbo.v_Pedidos.Almacen,
dbo.v_Pedidos.Fecha,
dbo.v_Pedidos.Cliente,
dbo.v_Pedidos.OrdenCompra,
dbo.v_Pedidos.Estatus,
dbo.v_Pedidos.Cantidad,
dbo.v_Pedidos.SaldoCantidad,
dbo.v_Pedidos.FechaEmbarque,
dbo.v_Pedidos.NivelRiesgo,
dbo.v_Pedidos.TotalProgramado,
dbo.v_Pedidos.Observaciones,
dbo.v_Pedidos.PiezasMolde,
dbo.v_Pedidos.CiclosMolde,
dbo.v_Pedidos.PesoCasting,
dbo.v_Pedidos.PesoArania,
dbo.v_Pedidos.IdParteMolde,
dbo.v_Pedidos.LlevaSerie,
dbo.v_Pedidos.FechaMoldeo,
dbo.v_Pedidos.IdAreaAct,
dbo.ProgramacionesDia.IdTurno,
dbo.Turnos.Descripcion AS Turno,
dbo.v_Pedidos.IdPresentacion,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina,
dbo.AreaProcesos.IdArea,
dbo.AreaProcesos.IdProceso,
dbo.SubProcesos.IdSubProceso,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.ProductoCasting,
dbo.v_Productos.Aleacion,
dbo.ProgramacionesDia.Llenadas,
dbo.ProgramacionesDia.Cerradas,
dbo.ProgramacionesDia.Vaciadas

FROM
dbo.ProgramacionesDia
LEFT JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
LEFT JOIN dbo.Programaciones ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
RIGHT JOIN (SELECT dbo.Programaciones.IdProducto, dbo.ProduccionesDetalle.IdProgramacion,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'B' THEN dbo.ProduccionesDetalle.CantidadCiclos ELSE 0 END ) AS Cant,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'CB' THEN dbo.ProduccionesDetalle.CantidadCiclos ELSE 0 END ) AS CantC,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'R' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasR,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'RM' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasM,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'RC' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasC
	FROM dbo.ProduccionesDetalle
		RIGHT JOIN dbo.Programaciones ON dbo.ProduccionesDetalle.IdProductos = dbo.Programaciones.IdProducto
		--INNER JOIN dbo.ProgramacionesSemana ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
		--INNER JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
		LEFT JOIN dbo.Producciones ON dbo.ProduccionesDetalle.IdProduccion = dbo.Producciones.IdProduccion
		WHERE dbo.Programaciones.IdArea = 2 
		GROUP BY dbo.Programaciones.IdProducto, dbo.ProduccionesDetalle.IdProgramacion) AS ProduccionDetalle ON dbo.Programaciones.IdProducto = ProduccionDetalle.IdProducto 
LEFT JOIN dbo.v_Pedidos ON dbo.Programaciones.IdPedido = dbo.v_Pedidos.IdPedido
LEFT JOIN dbo.Turnos ON dbo.ProgramacionesDia.IdTurno = dbo.Turnos.IdTurno
LEFT JOIN dbo.AreaProcesos ON dbo.AreaProcesos.IdAreaProceso = dbo.ProgramacionesDia.IdAreaProceso
LEFT JOIN dbo.SubProcesos ON dbo.SubProcesos.IdProceso = dbo.AreaProcesos.IdProceso
LEFT JOIN dbo.v_Productos ON dbo.v_Productos.IdProducto = dbo.v_Pedidos.IdProducto
WHERE dbo.AreaProcesos.IdArea = 2 AND dbo.SubProcesos.IdSubProceso = 6 --and ProduccionDetalle.IdProgramacion IS NULL
GO
/****** Object:  View [dbo].[v_ProgramacionSemanal]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionSemanal] AS 
SELECT
dbo.v_Programaciones.IdProgramacion,
dbo.v_Programaciones.IdPedido,
dbo.v_Programaciones.IdArea,
dbo.v_Programaciones.IdEmpleado,
dbo.v_Programaciones.IdProgramacionEstatus,
dbo.v_Programaciones.IdProducto,
dbo.v_Programaciones.IdProductoCasting,
dbo.v_Programaciones.OrdenCompra,
dbo.v_Programaciones.Area,
dbo.v_Programaciones.OE_Codigo,
dbo.v_Programaciones.OE_Numero,
dbo.v_Programaciones.FechaEmbarque,
dbo.v_Programaciones.Cantidad,
dbo.v_Programaciones.SaldoCantidad,
dbo.v_Programaciones.TotalProgramado,
dbo.v_Programaciones.Estatus,
dbo.v_Programaciones.Producto,
dbo.v_Programaciones.Descripcion,
dbo.v_Programaciones.ProductoCasting,
dbo.v_Programaciones.Marca,
dbo.v_Programaciones.Presentacion,
dbo.v_Programaciones.Aleacion,
dbo.v_Programaciones.IdAleacion,
dbo.v_Programaciones.PiezasMolde,
dbo.v_Programaciones.CiclosMolde,
dbo.v_Programaciones.PesoCasting,
dbo.v_Programaciones.PesoArania,
dbo.v_Programaciones.MoldesHora,
dbo.v_Programaciones.Ensamble,
dbo.v_Programaciones.FechaEnvio,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesSemana.Prioridad,
dbo.ProgramacionesSemana.Programadas,
dbo.ProgramacionesSemana.Llenadas,
dbo.ProgramacionesSemana.Vaciadas

FROM
dbo.v_Programaciones
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion

GO
/****** Object:  View [dbo].[v_PedidosDux]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_PedidosDux] AS 
SELECT OE.ALMACEN, POE.PRODUCTO, POE.CODIGO, POE.NUMERO, OE.FECHA, OE.CLIENTE, 
	OE.DOCUMENTO1, OE.STATUS, POE.CANTIDAD, POE.SALDOCANTIDAD, POE.DOCTOADICIONALFECHA, POE.DOCTOADICIONALFECHA AS Envio, 
	C.NIVELRIESGO, POE.OBSERVACIONES
	FROM DuxSinc.dbo.PAROEN POE
	INNER JOIN DuxSinc.dbo.OENTREGA OE ON POE.CODIGO = OE.CODIGO 
	INNER JOIN DuxSinc.dbo.CLIENTES C ON OE.CLIENTE = C.CODIGO
GO
/****** Object:  View [dbo].[v_PedidosDux2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_PedidosDux2] AS 
SELECT
dbo.Productos.IdProducto,
dbo.v_PedidosDux.CODIGO,
dbo.v_PedidosDux.NUMERO,
dbo.v_PedidosDux.FECHA,
dbo.v_PedidosDux.CLIENTE,
dbo.v_PedidosDux.DOCUMENTO1,
dbo.v_PedidosDux.STATUS,
dbo.v_PedidosDux.CANTIDAD,
dbo.v_PedidosDux.SALDOCANTIDAD,
dbo.v_PedidosDux.DOCTOADICIONALFECHA,
dbo.v_PedidosDux.Envio,
dbo.v_PedidosDux.NIVELRIESGO,
dbo.v_PedidosDux.OBSERVACIONES

FROM
dbo.v_PedidosDux
INNER JOIN dbo.Productos ON dbo.Productos.Identificacion = dbo.v_PedidosDux.PRODUCTO

GO
/****** Object:  View [dbo].[v_ProgramacionDiaAcero]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionDiaAcero] AS 
SELECT
dbo.Programaciones.IdProgramacion,
dbo.ProgramacionesDia.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.Programaciones.Programadas AS Pedido,
dbo.Programaciones.Hechas AS pedido_hecho,
dbo.ProgramacionesSemana.Programadas AS programadas_semana,
dbo.ProgramacionesSemana.Hechas AS hechas_semana,
dbo.ProgramacionesSemana.Prioridad AS prioridad_semana,
dbo.ProgramacionesDia.Prioridad,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesDia.Hechas,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.v_Pedidos.IdPedido,
dbo.v_Pedidos.IdAlmacen,
dbo.v_Pedidos.IdProducto,
dbo.v_Pedidos.Codigo,
dbo.v_Pedidos.Numero,
dbo.v_Pedidos.Producto,
dbo.v_Pedidos.Almacen,
dbo.v_Pedidos.Fecha,
dbo.v_Pedidos.Cliente,
dbo.v_Pedidos.OrdenCompra,
dbo.v_Pedidos.Estatus,
dbo.v_Pedidos.Cantidad,
dbo.v_Pedidos.SaldoCantidad,
dbo.v_Pedidos.FechaEmbarque,
dbo.v_Pedidos.NivelRiesgo,
dbo.v_Pedidos.TotalProgramado,
dbo.v_Pedidos.Observaciones,
dbo.v_Pedidos.PiezasMolde,
dbo.v_Pedidos.CiclosMolde,
dbo.v_Pedidos.PesoCasting,
dbo.v_Pedidos.PesoArania,
dbo.ProgramacionesDia.IdTurno,
dbo.Turnos.Descripcion AS Turno,
dbo.v_Pedidos.IdPresentacion,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina,
dbo.AreaProcesos.IdArea,
dbo.AreaProcesos.IdProceso,
dbo.SubProcesos.IdSubProceso,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.ProductoCasting,
dbo.ProgramacionesDia.Llenadas,
dbo.ProgramacionesDia.Cerradas,
dbo.ProgramacionesDia.Vaciadas,
dbo.v_Pedidos.IdParteMolde,
dbo.v_Pedidos.LlevaSerie,
dbo.v_Pedidos.FechaMoldeo,
dbo.v_Pedidos.IdAreaAct,
dbo.v_Productos.Aleacion

FROM
dbo.ProgramacionesDia
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
INNER JOIN dbo.Programaciones ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
INNER JOIN dbo.v_Pedidos ON dbo.Programaciones.IdPedido = dbo.v_Pedidos.IdPedido
INNER JOIN dbo.Turnos ON dbo.ProgramacionesDia.IdTurno = dbo.Turnos.IdTurno
INNER JOIN dbo.AreaProcesos ON dbo.AreaProcesos.IdAreaProceso = dbo.ProgramacionesDia.IdAreaProceso
INNER JOIN dbo.SubProcesos ON dbo.SubProcesos.IdProceso = dbo.AreaProcesos.IdProceso
INNER JOIN dbo.v_Productos ON dbo.Programaciones.IdProducto = dbo.v_Productos.IdProducto
WHERE
dbo.ProgramacionesDia.Programadas > 0
AND dbo.SubProcesos.IdSubProceso = 6 AND dbo.AreaProcesos.IdArea = 2
GO
/****** Object:  View [dbo].[v_PedidosPorAgregar]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_PedidosPorAgregar] AS 
SELECT
dbo.Almacenes.IdAlmacen,
dbo.Productos.IdProducto,
dbo.v_PedidosDux.CODIGO,
dbo.v_PedidosDux.NUMERO,
dbo.v_PedidosDux.FECHA,
dbo.v_PedidosDux.CLIENTE,
dbo.v_PedidosDux.DOCUMENTO1,
dbo.v_PedidosDux.STATUS,
dbo.v_PedidosDux.CANTIDAD,
dbo.v_PedidosDux.SALDOCANTIDAD,
dbo.v_PedidosDux.DOCTOADICIONALFECHA,
dbo.v_PedidosDux.Envio,
dbo.v_PedidosDux.NIVELRIESGO,
dbo.v_PedidosDux.OBSERVACIONES

FROM
dbo.v_PedidosDux
LEFT JOIN dbo.Pedidos ON dbo.Pedidos.Codigo = dbo.v_PedidosDux.CODIGO AND dbo.Pedidos.Numero = dbo.v_PedidosDux.NUMERO
INNER JOIN dbo.Almacenes ON dbo.Almacenes.Identificador = dbo.v_PedidosDux.ALMACEN
INNER JOIN dbo.Productos ON dbo.Productos.Identificacion = dbo.v_PedidosDux.PRODUCTO
WHERE
dbo.Pedidos.IdPedido IS NULL AND
dbo.v_PedidosDux.SALDOCANTIDAD > 0
GO
/****** Object:  View [dbo].[v_Tarimas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Tarimas] AS 
SELECT
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.Tarimas.IdProgramacionDia,
dbo.Tarimas.Loop,
dbo.Tarimas.Tarima,
dbo.v_Productos.Color,
dbo.v_Productos.Identificacion AS Producto,
'true' AS visible,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina AS Maquina,
dbo.ProgramacionesDia.IdTurno,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesSemana.IdProgramacionSemana,
dbo.ProgramacionesSemana.Prioridad,
dbo.v_Productos.CiclosMolde,
dbo.v_Productos.Aleacion,
dbo.v_Productos.PesoArania

FROM
dbo.Programaciones AS Producto
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = Producto.IdProgramacion
INNER JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesDia.IdProgramacionSemana = dbo.ProgramacionesSemana.IdProgramacionSemana
INNER JOIN dbo.Tarimas ON dbo.Tarimas.IdProgramacionDia = dbo.ProgramacionesDia.IdProgramacionDia
INNER JOIN dbo.v_Productos ON dbo.v_Productos.IdProducto = Producto.IdProducto

GO
/****** Object:  View [dbo].[v_Almas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Almas] AS 
SELECT
dbo.Almas.IdAlma,
dbo.Almas.IdProducto,
dbo.Productos.Identificacion AS Producto,
dbo.Almas.IdAlmaTipo,
dbo.AlmasTipo.Descripcion AS Alma,
dbo.Almas.IdAlmaReceta,
dbo.AlmasRecetas.Descripcion AS AlmaReceta,
dbo.Almas.IdAlmaMaterialCaja,
dbo.AlmasMaterialCaja.Descripcion AS MaterialCaja,
dbo.Almas.Existencia,
dbo.Almas.PiezasCaja,
dbo.Almas.PiezasMolde,
dbo.Almas.Peso,
dbo.Almas.TiempoLlenado,
dbo.Almas.TiempoFraguado,
dbo.Almas.TiempoGaseoDirecto,
dbo.Almas.TiempoGaseoIndirecto,
dbo.Productos.IdPresentacion

FROM
dbo.Almas
INNER JOIN dbo.AlmasTipo ON dbo.Almas.IdAlmaTipo = dbo.AlmasTipo.IdAlmaTipo
INNER JOIN dbo.Productos ON dbo.Almas.IdProducto = dbo.Productos.IdProducto
INNER JOIN dbo.AlmasRecetas ON dbo.Almas.IdAlmaReceta = dbo.AlmasRecetas.IdAlmaReceta
INNER JOIN dbo.AlmasMaterialCaja ON dbo.Almas.IdAlmaMaterialCaja = dbo.AlmasMaterialCaja.IdAlmaMaterialCaja

GO
/****** Object:  View [dbo].[v_ProgramacionesAlmaDia]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionesAlmaDia] AS 
SELECT
dbo.v_Almas.IdProducto,
dbo.v_Almas.Producto,
dbo.v_Almas.IdAlmaTipo,
dbo.v_Almas.Alma,
dbo.v_Almas.IdAlmaReceta,
dbo.v_Almas.AlmaReceta,
dbo.v_Almas.IdAlmaMaterialCaja,
dbo.v_Almas.MaterialCaja,
dbo.v_Almas.Existencia,
dbo.v_Almas.PiezasCaja,
dbo.v_Almas.PiezasMolde,
dbo.v_Almas.Peso,
dbo.v_Almas.TiempoLlenado AS PiezasHora,
dbo.v_Almas.TiempoFraguado,
dbo.v_Almas.TiempoGaseoDirecto,
dbo.v_Almas.TiempoGaseoIndirecto,
dbo.ProgramacionesAlmaSemana.IdProgramacionAlma,
dbo.ProgramacionesAlmaSemana.IdProgramacionAlmaSemana,
dbo.ProgramacionesAlmaDia.IdProgramacionAlmaDia,
dbo.ProgramacionesAlmaDia.Dia,
dbo.ProgramacionesAlmaDia.Prioridad,
dbo.ProgramacionesAlmaDia.Programadas,
dbo.ProgramacionesAlmaDia.Hechas,
dbo.ProgramacionesAlmaDia.IdCentroTrabajo,
dbo.ProgramacionesAlmaDia.IdMaquina,
dbo.Maquinas.Identificador,
dbo.Maquinas.Descripcion,
dbo.Maquinas.Consecutivo,
dbo.Maquinas.Eficiencia,
dbo.v_Almas.IdPresentacion AS IdArea

FROM
dbo.ProgramacionesAlma
INNER JOIN dbo.ProgramacionesAlmaSemana ON dbo.ProgramacionesAlmaSemana.IdProgramacionAlma = dbo.ProgramacionesAlma.IdProgramacionAlma
INNER JOIN dbo.v_Almas ON dbo.v_Almas.IdAlma = dbo.ProgramacionesAlma.IdAlmas
INNER JOIN dbo.ProgramacionesAlmaDia ON dbo.ProgramacionesAlmaDia.IdProgramacionAlmaSemana = dbo.ProgramacionesAlmaSemana.IdProgramacionAlmaSemana
INNER JOIN dbo.Maquinas ON dbo.Maquinas.IdMaquina = dbo.ProgramacionesAlmaDia.IdMaquina
GO
/****** Object:  View [dbo].[v_AlmasDuplicadas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmasDuplicadas] AS 
SELECT
dbo.ProgramacionesAlma.IdAlmas,
dbo.ProgramacionesAlma.IdProgramacion,
Count(dbo.ProgramacionesAlma.IdProgramacion) Cantidad

FROM
dbo.ProgramacionesAlma
GROUP BY
dbo.ProgramacionesAlma.IdAlmas,
dbo.ProgramacionesAlma.IdProgramacion
HAVING
Count(dbo.ProgramacionesAlma.IdProgramacion) > 1
GO
/****** Object:  View [dbo].[v_AlmasDuplicadas2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmasDuplicadas2] AS 
SELECT
dbo.ProgramacionesAlma.IdProgramacionAlma,
dbo.ProgramacionesAlma.IdProgramacion,
dbo.ProgramacionesAlma.IdAlmas,
dbo.ProgramacionesAlma.IdEmpleado,
dbo.ProgramacionesAlma.IdProgramacionEstatus,
dbo.ProgramacionesAlma.Programadas,
dbo.ProgramacionesAlma.Hechas,
dbo.ProgramacionesAlma.Usadas

FROM
dbo.ProgramacionesAlma
INNER JOIN dbo.v_AlmasDuplicadas ON dbo.v_AlmasDuplicadas.IdAlmas = dbo.ProgramacionesAlma.IdAlmas AND dbo.v_AlmasDuplicadas.IdProgramacion = dbo.ProgramacionesAlma.IdProgramacion
GO
/****** Object:  View [dbo].[v_AlmasProgranadas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmasProgranadas] AS 
SELECT
dbo.v_Programaciones.IdProgramacion,
dbo.v_Programaciones.IdEmpleado,
dbo.v_Programaciones.IdProgramacionEstatus,
dbo.v_Almas.IdAlma,
0 AS Programadas

FROM
dbo.v_Programaciones
INNER JOIN dbo.v_Almas ON dbo.v_Almas.IdProducto = dbo.v_Programaciones.IdProductoCasting
WHERE
dbo.v_Programaciones.IdProgramacionEstatus = 1 AND
dbo.v_Programaciones.Programadas > 0
GO
/****** Object:  View [dbo].[v_AlmacenesProducto]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmacenesProducto] AS 
SELECT
dbo.AlmacenesProducto.IdAlmacenProducto,
dbo.AlmacenesProducto.IdAlmacen,
dbo.AlmacenesProducto.IdProducto,
dbo.v_Productos.Identificacion AS Producto,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.ProductoCasting,
dbo.Almacenes.Identificador AS Almacen,
dbo.AlmacenesProducto.Existencia,
dbo.AlmacenesProducto.CostoPromedio

FROM
dbo.AlmacenesProducto
INNER JOIN dbo.Almacenes ON dbo.AlmacenesProducto.IdAlmacen = dbo.Almacenes.IdAlmacen
INNER JOIN dbo.v_Productos ON dbo.AlmacenesProducto.IdProducto = dbo.v_Productos.IdProducto
WHERE
(dbo.AlmacenesProducto.Existencia > 0)

GO
/****** Object:  View [dbo].[v_Produccion2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Produccion2] AS 
SELECT
dbo.Producciones.IdProduccion,
dbo.ProduccionesDetalle.IdProduccionDetalle,
dbo.Producciones.IdCentroTrabajo,
dbo.Producciones.IdMaquina,
dbo.Producciones.IdEmpleado,
dbo.Producciones.IdProduccionEstatus,
dbo.Producciones.Fecha,
dbo.Producciones.IdSubProceso,
dbo.ProduccionesDetalle.IdProgramacion,
dbo.ProduccionesDetalle.IdProductos,
dbo.ProduccionesDetalle.Inicio,
dbo.ProduccionesDetalle.Fin,
dbo.ProduccionesDetalle.CiclosMolde,
dbo.ProduccionesDetalle.PiezasMolde,
dbo.ProduccionesDetalle.Programadas,
dbo.ProduccionesDetalle.Hechas,
dbo.ProduccionesDetalle.Rechazadas,
dbo.Producciones.IdArea

FROM
dbo.Producciones
INNER JOIN dbo.ProduccionesDetalle ON dbo.Producciones.IdProduccion = dbo.ProduccionesDetalle.IdProduccion

GO
/****** Object:  View [dbo].[v_Programacion]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Programacion] AS 
SELECT
dbo.Programaciones.IdProgramacion,
dbo.ProgramacionesSemana.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
dbo.Programaciones.IdPedido,
dbo.Programaciones.IdArea,
dbo.Programaciones.IdEmpleado,
dbo.Programaciones.IdProgramacionEstatus,
dbo.Programaciones.IdProducto,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.ProgramacionesDia.IdTurno,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina,
dbo.Programaciones.Programadas,
dbo.Programaciones.Hechas,
dbo.ProgramacionesSemana.Prioridad AS prioridadSemana,
dbo.ProgramacionesSemana.Programadas AS programadasSemana,
dbo.ProgramacionesSemana.Hechas AS hechasSemana,
dbo.ProgramacionesDia.Prioridad AS prioridadDia,
dbo.ProgramacionesDia.Programadas AS programadasDia,
dbo.ProgramacionesDia.Hechas AS hechasDia,
dbo.SubProcesos.IdSubProceso,
dbo.SubProcesos.Identificador,
dbo.SubProcesos.Descripcion

FROM
dbo.Programaciones
LEFT JOIN dbo.ProgramacionesSemana ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
LEFT JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
LEFT JOIN dbo.AreaProcesos ON dbo.ProgramacionesDia.IdAreaProceso = dbo.AreaProcesos.IdAreaProceso
INNER JOIN dbo.SubProcesos ON dbo.SubProcesos.IdProceso = dbo.AreaProcesos.IdProceso

GO
/****** Object:  View [dbo].[v_ProgramacionProduccion]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionProduccion] AS 
SELECT
dbo.v_Programacion.IdProgramacion,
dbo.v_Programacion.IdProgramacionSemana,
dbo.v_Programacion.IdProgramacionDia,
dbo.v_Programacion.IdPedido,
dbo.v_Programacion.IdArea,
dbo.v_Programacion.IdProgramacionEstatus,
dbo.v_Programacion.IdProducto,
dbo.v_Productos.Aleacion,
dbo.v_Programacion.Anio,
dbo.v_Programacion.Semana,
dbo.v_Programacion.Dia,
dbo.v_Programacion.IdAreaProceso,
dbo.v_Programacion.IdTurno,
dbo.v_Programacion.IdCentroTrabajo,
dbo.v_Programacion.IdMaquina,
dbo.v_Programacion.Programadas,
dbo.v_Programacion.Hechas,
dbo.v_Programacion.prioridadSemana,
dbo.v_Programacion.programadasSemana,
dbo.v_Programacion.hechasSemana,
dbo.v_Programacion.prioridadDia,
dbo.v_Programacion.programadasDia,
dbo.v_Programacion.hechasDia,
dbo.v_Produccion2.IdProduccion,
dbo.v_Produccion2.IdProduccionDetalle,
dbo.v_Produccion2.IdEmpleado,
dbo.v_Produccion2.IdProduccionEstatus,
dbo.v_Produccion2.Inicio,
dbo.v_Produccion2.Fin,
dbo.v_Produccion2.CiclosMolde,
dbo.v_Produccion2.PiezasMolde,
dbo.v_Produccion2.Hechas AS hechasProduccion,
dbo.v_Produccion2.Rechazadas AS rechazadasProduccion,
dbo.v_Programacion.IdSubProceso

FROM
dbo.v_Programacion
LEFT JOIN dbo.v_Productos ON dbo.v_Programacion.IdProducto = dbo.v_Productos.IdProducto
LEFT JOIN dbo.v_Produccion2 ON dbo.v_Programacion.IdProducto = dbo.v_Produccion2.IdProductos AND dbo.v_Programacion.Dia = dbo.v_Produccion2.Fecha AND dbo.v_Programacion.IdProgramacion = dbo.v_Produccion2.IdProgramacion AND dbo.v_Programacion.IdArea = dbo.v_Produccion2.IdArea

GO
/****** Object:  View [dbo].[v_CapturaExceleada]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_CapturaExceleada] AS 
SELECT
dbo.v_ProgramacionProduccion.IdProgramacion,
dbo.v_ProgramacionProduccion.IdProgramacionSemana,
dbo.v_ProgramacionProduccion.IdProgramacionDia,
dbo.v_ProgramacionProduccion.IdPedido,
dbo.v_ProgramacionProduccion.IdArea,
dbo.v_ProgramacionProduccion.IdProducto,
dbo.v_ProgramacionProduccion.Aleacion,
dbo.v_ProgramacionProduccion.Anio,
dbo.v_ProgramacionProduccion.Semana,
dbo.v_ProgramacionProduccion.Dia,
dbo.v_ProgramacionProduccion.IdSubProceso,
dbo.v_ProgramacionProduccion.IdTurno,
dbo.v_ProgramacionProduccion.IdCentroTrabajo,
dbo.v_ProgramacionProduccion.IdMaquina,
dbo.v_ProgramacionProduccion.Programadas,
dbo.v_ProgramacionProduccion.Hechas,
dbo.v_ProgramacionProduccion.prioridadSemana,
dbo.v_ProgramacionProduccion.programadasSemana,
dbo.v_ProgramacionProduccion.hechasSemana,
dbo.v_ProgramacionProduccion.prioridadDia,
dbo.v_ProgramacionProduccion.programadasDia,
dbo.v_ProgramacionProduccion.hechasDia,
dbo.v_ProgramacionProduccion.CiclosMolde,
dbo.v_ProgramacionProduccion.PiezasMolde,
dbo.v_ProgramacionProduccion.IdAreaProceso,
Sum(dbo.v_ProgramacionProduccion.hechasProduccion) AS hechasProduccion,
Sum(dbo.v_ProgramacionProduccion.rechazadasProduccion) AS rechazadasProduccion

FROM
dbo.v_ProgramacionProduccion
GROUP BY
dbo.v_ProgramacionProduccion.IdProgramacion,
dbo.v_ProgramacionProduccion.IdProgramacionSemana,
dbo.v_ProgramacionProduccion.IdProgramacionDia,
dbo.v_ProgramacionProduccion.IdPedido,
dbo.v_ProgramacionProduccion.IdArea,
dbo.v_ProgramacionProduccion.IdProducto,
dbo.v_ProgramacionProduccion.Aleacion,
dbo.v_ProgramacionProduccion.Anio,
dbo.v_ProgramacionProduccion.Semana,
dbo.v_ProgramacionProduccion.Dia,
dbo.v_ProgramacionProduccion.IdSubProceso,
dbo.v_ProgramacionProduccion.IdTurno,
dbo.v_ProgramacionProduccion.IdCentroTrabajo,
dbo.v_ProgramacionProduccion.IdMaquina,
dbo.v_ProgramacionProduccion.Programadas,
dbo.v_ProgramacionProduccion.Hechas,
dbo.v_ProgramacionProduccion.prioridadSemana,
dbo.v_ProgramacionProduccion.programadasSemana,
dbo.v_ProgramacionProduccion.hechasSemana,
dbo.v_ProgramacionProduccion.prioridadDia,
dbo.v_ProgramacionProduccion.programadasDia,
dbo.v_ProgramacionProduccion.hechasDia,
dbo.v_ProgramacionProduccion.CiclosMolde,
dbo.v_ProgramacionProduccion.PiezasMolde,
dbo.v_ProgramacionProduccion.IdAreaProceso

GO
/****** Object:  View [dbo].[v_Resumen]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Resumen] AS 
SELECT
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
sum(dbo.ProgramacionesSemana.Programadas) AS PrgMol,
ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoCasting)/1000,2)  AS PrgTonP,
ROUND(sum(dbo.ProgramacionesSemana.Programadas * dbo.v_Programaciones.PesoArania)/1000,2)  AS PrgTon,
ROUND(sum(CAST(dbo.ProgramacionesSemana.Programadas AS FLOAT) / CAST(ISNULL(dbo.v_Programaciones.MoldesHora,65) as FLOAT)),1) AS PrgHrs,
sum(dbo.ProgramacionesSemana.Llenadas) AS HecMol,
ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesSemana.Llenadas * dbo.v_Programaciones.PesoCasting)/1000,2)  AS HecTonP,
ROUND(sum(dbo.ProgramacionesSemana.Llenadas * dbo.v_Programaciones.PesoArania)/1000,2)  AS HecTon,
ROUND(sum(
	CASE WHEN dbo.ProgramacionesSemana.Llenadas = 0 THEN
		0
	ELSE CAST(dbo.ProgramacionesSemana.Llenadas as FLOAT) / CAST(dbo.v_Programaciones.MoldesHora  as FLOAT)
	END
),1) AS HecHrs

FROM
dbo.v_Programaciones
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
WHERE
dbo.ProgramacionesSemana.Programadas > 0 AND
dbo.v_Programaciones.SaldoCantidad > 0
GROUP BY 
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana
GO
/****** Object:  View [dbo].[v_Marcas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Marcas] AS 
SELECT DISTINCT
dbo.v_Productos.IdMarca,
dbo.v_Productos.Marca,
dbo.v_Productos.IdPresentacion

FROM
dbo.v_Productos
WHERE
dbo.v_Productos.Marca IS NOT NULL AND
dbo.v_Productos.Marca <> ''

GO
/****** Object:  View [dbo].[v_Cajas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Cajas] AS 
SELECT
dbo.Productos.Identificacion,
dbo.CajasTipo.Tamano,
dbo.CajasTipo.CodigoDlls,
dbo.CajasTipo.CodigoPesos,
dbo.Cajas.PiezasXCaja,
Sum(ExistenciaPesos.Existencia) AS ExistenciaPesos,
Sum(ExistenciaDolares.Existencia) AS ExistenciaDolares

FROM
dbo.Cajas
INNER JOIN dbo.CajasTipo ON dbo.Cajas.IdTipoCaja = dbo.CajasTipo.IdTipoCaja
INNER JOIN dbo.Productos ON dbo.Productos.IdProducto = dbo.Cajas.IdProducto
LEFT JOIN dbo.v_AlmacenesProducto AS ExistenciaPesos ON ExistenciaPesos.Producto = dbo.CajasTipo.CodigoPesos
LEFT JOIN dbo.v_AlmacenesProducto AS ExistenciaDolares ON ExistenciaDolares.Producto = dbo.CajasTipo.CodigoDlls
GROUP BY
dbo.Productos.Identificacion,
dbo.CajasTipo.Tamano,
dbo.CajasTipo.CodigoDlls,
dbo.CajasTipo.CodigoPesos,
dbo.Cajas.PiezasXCaja,
ExistenciaPesos.Almacen,
ExistenciaDolares.Almacen
GO
/****** Object:  View [dbo].[v_PedidosPorProgramar]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_PedidosPorProgramar] AS 
SELECT
dbo.Pedidos.IdPedido,
dbo.PedProg.IdProgramacion,
dbo.v_Productos.Descripcion AS Producto,
dbo.Pedidos.Codigo,
dbo.Pedidos.Numero,
dbo.Pedidos.Fecha,
dbo.Pedidos.Cliente,
dbo.Pedidos.OrdenCompra,
dbo.Pedidos.Estatus,
dbo.Pedidos.Cantidad,
dbo.Pedidos.SaldoCantidad,
dbo.Pedidos.FechaEmbarque,
dbo.Pedidos.NivelRiesgo,
dbo.Pedidos.Observaciones,
dbo.Pedidos.TotalProgramado,
dbo.Pedidos.SaldoExistenciaPT,
dbo.Pedidos.SaldoExistenciaProceso,
dbo.Pedidos.EstatusEnsamble,
dbo.Almacenes.Identificador,
dbo.Almacenes.Descripcion,
dbo.v_Productos.Identificacion,
dbo.v_Productos.ProductoCasting,
dbo.v_Productos.Marca,
dbo.v_Productos.Presentacion,
dbo.v_Productos.IdPresentacion,
dbo.v_Productos.IdProducto,
dbo.v_Productos.Aleacion,
dbo.v_Productos.Ensamble

FROM
dbo.Pedidos
INNER JOIN dbo.v_Productos ON dbo.Pedidos.IdProducto = dbo.v_Productos.IdProducto
LEFT JOIN dbo.PedProg ON dbo.Pedidos.IdPedido = dbo.PedProg.IdPedido
INNER JOIN dbo.Almacenes ON dbo.Pedidos.IdAlmacen = dbo.Almacenes.IdAlmacen
WHERE
dbo.PedProg.IdProgramacion IS NULL AND
dbo.Pedidos.Cantidad > 0 AND
dbo.Pedidos.SaldoCantidad > 0
GO
/****** Object:  View [dbo].[v_CamisasAcero]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_CamisasAcero] AS 
SELECT (ps.Programadas*c.Cantidad) AS Cant_Camisas,  (ps.Hechas*c.Cantidad) AS Cam_hechas, c.IdCamisa, c.IdProducto, c.IdCamisaTipo, ct.[Tamaño], ct.Descripcion ,
		c.Cantidad, ps.Programadas, ct.CantidadPorPaquete, ct.DUX_CodigoPesos, ct.DUX_CodigoDolares, ps.Hechas,  ps.Semana
			FROM Camisas AS c LEFT JOIN
					 CamisasTipo AS ct ON c.IdCamisaTipo = ct.IdCamisaTipo LEFT JOIN 
							Programaciones AS p ON c.IdProducto = p.IdProducto LEFT JOIN
							ProgramacionesSemana AS ps ON ps.IdProgramacion = p.IdProgramacion

GO
/****** Object:  View [dbo].[v_PivotTamano]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_PivotTamano] AS 
SELECT * FROM (SELECT Cant_Camisas, Semana, Tamaño FROM FIMEX_Produccion.dbo.v_CamisasAcero ) P
PIVOT ( SUM(Cant_Camisas) FOR Semana IN ([16],[17],[18]) ) AS Cas

GO
/****** Object:  View [dbo].[v_Produccion]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Produccion] AS 
SELECT
dbo.ProgramacionesSemana.IdProgramacion,
dbo.ProgramacionesSemana.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.ProgramacionesDia.Prioridad,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.ProgramacionesDia.IdTurno,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina,
dbo.v_Productos.IdProducto,
dbo.v_Productos.IdMarca,
dbo.v_Productos.IdPresentacion,
dbo.v_Productos.IdAleacion,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.Identificacion,
dbo.v_Productos.Descripcion,
dbo.v_Productos.ProductoCasting,
dbo.v_Productos.Marca,
dbo.v_Productos.Presentacion,
dbo.v_Productos.Aleacion,
dbo.v_Productos.PiezasMolde,
dbo.v_Productos.CiclosMolde,
dbo.v_Productos.PesoCasting,
dbo.v_Productos.PesoArania

FROM
dbo.Programaciones
INNER JOIN dbo.ProgramacionesSemana ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
INNER JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
INNER JOIN dbo.v_Productos ON dbo.v_Productos.IdProducto = dbo.Programaciones.IdProducto

GO
/****** Object:  View [dbo].[v_ProgramacionDiaria]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionDiaria] AS 
SELECT
dbo.Pedidos.IdPedido,
dbo.v_Productos.Descripcion AS Producto,
dbo.Pedidos.Codigo,
dbo.Pedidos.Numero,
dbo.Pedidos.Fecha,
dbo.Pedidos.Cliente,
dbo.Pedidos.OrdenCompra,
dbo.Pedidos.Estatus,
dbo.Pedidos.Cantidad,
dbo.Pedidos.SaldoCantidad,
dbo.Pedidos.FechaEmbarque,
dbo.Pedidos.NivelRiesgo,
dbo.Pedidos.Observaciones,
dbo.Pedidos.TotalProgramado,
dbo.Almacenes.Identificador,
dbo.Almacenes.Descripcion,
dbo.v_Productos.Identificacion,
dbo.v_Productos.ProductoCasting,
dbo.v_Productos.Marca,
dbo.v_Productos.Presentacion,
dbo.v_Productos.IdPresentacion,
dbo.Programaciones.IdProgramacion

FROM
dbo.Pedidos
INNER JOIN dbo.v_Productos ON dbo.Pedidos.IdProducto = dbo.v_Productos.IdProducto
INNER JOIN dbo.Programaciones ON dbo.Pedidos.IdPedido = dbo.Programaciones.IdPedido
INNER JOIN dbo.Almacenes ON dbo.Pedidos.IdAlmacen = dbo.Almacenes.IdAlmacen

GO
/****** Object:  View [dbo].[v_Programaciones2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Programaciones2] AS 
SELECT
dbo.ProgramacionesSemana.IdProgramacion,
dbo.ProgramacionesSemana.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.ProgramacionesDia.Prioridad,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesDia.IdTurno,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina

FROM
dbo.Programaciones
LEFT JOIN dbo.ProgramacionesSemana ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
LEFT JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
INNER JOIN dbo.v_Productos ON dbo.Programaciones.IdProducto = dbo.v_Productos.IdProducto

GO
/****** Object:  View [dbo].[v_ProgramacionesAlma]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionesAlma] AS 
SELECT
dbo.ProgramacionesAlma.IdProgramacionAlma,
dbo.v_Programaciones.IdProgramacion,
dbo.v_Programaciones.IdArea,
dbo.v_Programaciones.IdEmpleado,
dbo.v_Programaciones.IdProductoCasting,
dbo.v_Almas.IdAlma,
dbo.v_Almas.IdProducto,
dbo.v_Almas.Producto,
dbo.v_Almas.IdAlmaTipo,
dbo.v_Almas.Alma,
dbo.v_Almas.IdAlmaReceta,
dbo.v_Almas.AlmaReceta,
dbo.v_Almas.IdAlmaMaterialCaja,
dbo.v_Almas.MaterialCaja,
dbo.v_Almas.Existencia,
dbo.v_Almas.PiezasCaja,
dbo.v_Almas.PiezasMolde,
dbo.v_Almas.Peso,
dbo.v_Almas.TiempoLlenado,
dbo.v_Almas.TiempoFraguado,
dbo.v_Almas.TiempoGaseoDirecto,
dbo.v_Almas.TiempoGaseoIndirecto,
dbo.v_Programaciones.Cantidad / dbo.v_Programaciones.PiezasMolde AS Moldes,
dbo.ProgramacionesAlma.Programadas AS AlmasRequeridas

FROM
dbo.v_Programaciones
INNER JOIN dbo.ProgramacionesAlma ON dbo.ProgramacionesAlma.IdProgramacion = dbo.v_Programaciones.IdProgramacion
INNER JOIN dbo.v_Almas ON dbo.v_Almas.IdAlma = dbo.ProgramacionesAlma.IdAlmas
WHERE
dbo.v_Programaciones.Estatus = 'ABIERTO'

GO
/****** Object:  View [dbo].[v_ProgramacionesDia]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionesDia] AS 
SELECT
dbo.Programaciones.IdProgramacion,
dbo.ProgramacionesDia.IdProgramacionSemana,
dbo.ProgramacionesDia.IdProgramacionDia,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
dbo.Programaciones.Programadas AS Pedido,
dbo.Programaciones.Hechas AS pedido_hecho,
dbo.ProgramacionesSemana.Programadas AS programadas_semana,
dbo.ProgramacionesSemana.Hechas AS hechas_semana,
dbo.ProgramacionesSemana.Prioridad AS prioridad_semana,
dbo.ProgramacionesDia.Prioridad,
dbo.ProgramacionesDia.Programadas,
dbo.ProgramacionesDia.Hechas,
dbo.ProgramacionesDia.IdAreaProceso,
dbo.v_Pedidos.IdPedido,
dbo.v_Pedidos.IdAlmacen,
dbo.v_Pedidos.IdProducto,
dbo.v_Pedidos.Codigo,
dbo.v_Pedidos.Numero,
dbo.v_Pedidos.Producto,
dbo.v_Pedidos.Almacen,
dbo.v_Pedidos.Fecha,
dbo.v_Pedidos.Cliente,
dbo.v_Pedidos.OrdenCompra,
dbo.v_Pedidos.Estatus,
dbo.v_Pedidos.Cantidad,
dbo.v_Pedidos.SaldoCantidad,
dbo.v_Pedidos.FechaEmbarque,
dbo.v_Pedidos.NivelRiesgo,
dbo.v_Pedidos.TotalProgramado,
dbo.v_Pedidos.Observaciones,
dbo.v_Pedidos.PiezasMolde,
dbo.v_Pedidos.CiclosMolde,
dbo.v_Pedidos.PesoCasting,
dbo.v_Pedidos.PesoArania,
dbo.ProgramacionesDia.IdTurno,
dbo.Turnos.Descripcion AS Turno,
dbo.v_Pedidos.IdPresentacion,
dbo.ProgramacionesDia.IdCentroTrabajo,
dbo.ProgramacionesDia.IdMaquina,
dbo.AreaProcesos.IdArea,
dbo.AreaProcesos.IdProceso,
dbo.SubProcesos.IdSubProceso,
dbo.v_Productos.IdProductoCasting,
dbo.v_Productos.ProductoCasting,
dbo.ProgramacionesDia.Llenadas,
dbo.ProgramacionesDia.Cerradas,
dbo.ProgramacionesDia.Vaciadas

FROM
dbo.ProgramacionesDia
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacionSemana = dbo.ProgramacionesDia.IdProgramacionSemana
LEFT JOIN dbo.Programaciones ON dbo.Programaciones.IdProgramacion = dbo.ProgramacionesSemana.IdProgramacion
LEFT JOIN dbo.v_Pedidos ON dbo.Programaciones.IdPedido = dbo.v_Pedidos.IdPedido
LEFT JOIN dbo.Turnos ON dbo.ProgramacionesDia.IdTurno = dbo.Turnos.IdTurno
LEFT JOIN dbo.AreaProcesos ON dbo.AreaProcesos.IdAreaProceso = dbo.ProgramacionesDia.IdAreaProceso
LEFT JOIN dbo.SubProcesos ON dbo.SubProcesos.IdProceso = dbo.AreaProcesos.IdProceso
LEFT JOIN dbo.v_Productos ON dbo.Programaciones.IdProducto = dbo.v_Productos.IdProducto
WHERE
dbo.ProgramacionesDia.Programadas > 0 AND
dbo.ProgramacionesSemana.Programadas > 0
GO
/****** Object:  View [dbo].[v_ProgramacionesAlma_copy]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionesAlma_copy] AS 
SELECT
dbo.v_Programaciones.IdProgramacion,
dbo.v_Programaciones.IdArea,
dbo.v_Programaciones.IdEmpleado,
dbo.v_Programaciones.IdProductoCasting,
dbo.v_Almas.IdAlma,
dbo.v_Almas.IdProducto,
dbo.v_Almas.Producto,
dbo.v_Almas.IdAlmaTipo,
dbo.v_Almas.Alma,
dbo.v_Almas.IdAlmaReceta,
dbo.v_Almas.AlmaReceta,
dbo.v_Almas.IdAlmaMaterialCaja,
dbo.v_Almas.MaterialCaja,
dbo.v_Almas.Existencia,
dbo.v_Almas.PiezasCaja,
dbo.v_Almas.PiezasMolde,
dbo.v_Almas.Peso,
dbo.v_Almas.TiempoLlenado,
dbo.v_Almas.TiempoFraguado,
dbo.v_Almas.TiempoGaseoDirecto,
dbo.v_Almas.TiempoGaseoIndirecto,
dbo.v_Programaciones.Cantidad / dbo.v_Programaciones.PiezasMolde AS Moldes

FROM
dbo.v_Programaciones
INNER JOIN dbo.v_Almas ON dbo.v_Programaciones.IdProductoCasting = dbo.v_Almas.IdProducto
WHERE
dbo.v_Programaciones.Estatus = 'ABIERTO'

GO
/****** Object:  View [dbo].[v_ResumenDiario]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ResumenDiario] AS 
SELECT
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia,
Sum(dbo.ProgramacionesDia.Programadas) AS PrgMol,
sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesDia.Programadas)  AS PrgPzas,
ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesDia.Programadas * dbo.v_Programaciones.PesoCasting)/1000,2) AS PrgTonP,
ROUND(sum(dbo.ProgramacionesDia.Programadas * dbo.v_Programaciones.PesoArania)/1000,2) AS PrgTon,
Sum(CAST(dbo.ProgramacionesDia.Programadas AS FLOAT) / CAST(dbo.v_Programaciones.MoldesHora AS FLOAT)) AS PrgHrs,
Sum(dbo.ProgramacionesDia.Llenadas) AS HecMol,
sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesDia.Llenadas)  AS HecPzas,
ROUND(sum(dbo.v_Programaciones.PiezasMolde * dbo.ProgramacionesDia.Llenadas * dbo.v_Programaciones.PesoCasting)/1000,2) AS HecTonP,
ROUND(sum(dbo.ProgramacionesDia.Llenadas * dbo.v_Programaciones.PesoArania)/1000,2) AS HecTon,
Sum(CAST(dbo.ProgramacionesDia.Llenadas AS FLOAT) / CAST(dbo.v_Programaciones.MoldesHora AS FLOAT)) AS HecHrs

FROM
dbo.v_Programaciones
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
INNER JOIN dbo.ProgramacionesDia ON dbo.ProgramacionesDia.IdProgramacionSemana = dbo.ProgramacionesSemana.IdProgramacionSemana
WHERE
dbo.ProgramacionesSemana.Programadas > 0 AND
dbo.ProgramacionesDia.Programadas > 0
GROUP BY
dbo.v_Programaciones.IdArea,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesDia.Dia
GO
/****** Object:  View [dbo].[v_TiemposMuertos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_TiemposMuertos] AS 
SELECT
dbo.TiemposMuerto.IdTiempoMuerto,
dbo.Maquinas.IdMaquina,
dbo.Maquinas.Identificador,
dbo.Maquinas.Descripcion,
dbo.TiemposMuerto.Fecha,
dbo.TiemposMuerto.Inicio,
dbo.TiemposMuerto.Fin,
DATEDIFF(minute, dbo.TiemposMuerto.Inicio, dbo.TiemposMuerto.Fin) AS Minutos,
dbo.TiemposMuerto.Descripcion AS Observaciones,
dbo.Causas.IdCausa,
dbo.Causas.Descripcion AS Causa,
dbo.CausasTipo.IdCausaTipo,
dbo.CausasTipo.Identificador AS ClaveTipo,
dbo.CausasTipo.Descripcion AS Tipo,
dbo.Causas.IdSubProceso,
dbo.Causas.IdArea

FROM
dbo.Causas
INNER JOIN dbo.CausasTipo ON dbo.Causas.IdCausaTipo = dbo.CausasTipo.IdCausaTipo
INNER JOIN dbo.TiemposMuerto ON dbo.TiemposMuerto.IdCausa = dbo.Causas.IdCausa
INNER JOIN dbo.Maquinas ON dbo.TiemposMuerto.IdMaquina = dbo.Maquinas.IdMaquina
GO
/****** Object:  View [dbo].[v_TMEliazar]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_TMEliazar] AS 
SELECT
dbo.v_TiemposMuertos.Identificador AS Maquina,
dbo.v_TiemposMuertos.Inicio AS Tinicio,
dbo.v_TiemposMuertos.Fin AS Tfinal,
dbo.v_TiemposMuertos.IdCausa AS IdTipodeProblema,
dbo.v_TiemposMuertos.Tipo AS Clasificacion,
dbo.v_TiemposMuertos.Causa AS TipodeProblema,
dbo.v_TiemposMuertos.Observaciones Obs,
dbo.v_TiemposMuertos.Fecha,
dbo.v_TiemposMuertos.Inicio AS Tinicio_INI,
dbo.v_TiemposMuertos.Fin AS Tfinal_fin


FROM
dbo.v_TiemposMuertos
WHERE
dbo.v_TiemposMuertos.IdArea = 3

GO
/****** Object:  View [dbo].[v_AlmasRebabeo]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmasRebabeo] AS 
SELECT
dbo.v_ProgramacionesAlma.IdProgramacionAlma,
Min(dbo.v_ProgramacionesAlma.IdProgramacion) AS IdProgramacion,
dbo.v_ProgramacionesAlma.IdArea,
dbo.v_ProgramacionesAlma.IdProductoCasting,
dbo.v_ProgramacionesAlma.IdAlma,
dbo.v_ProgramacionesAlma.IdProducto,
dbo.v_ProgramacionesAlma.Producto,
dbo.v_ProgramacionesAlma.IdAlmaTipo,
dbo.v_ProgramacionesAlma.Alma,
dbo.v_ProgramacionesAlma.IdAlmaReceta,
dbo.v_ProgramacionesAlma.AlmaReceta,
dbo.v_ProgramacionesAlma.IdAlmaMaterialCaja,
dbo.v_ProgramacionesAlma.MaterialCaja,
dbo.v_ProgramacionesAlma.Existencia,
dbo.v_ProgramacionesAlma.PiezasCaja,
dbo.v_ProgramacionesAlma.PiezasMolde,
dbo.v_ProgramacionesAlma.Peso,
dbo.v_ProgramacionesAlma.TiempoLlenado,
dbo.v_ProgramacionesAlma.TiempoFraguado,
dbo.v_ProgramacionesAlma.TiempoGaseoDirecto,
dbo.v_ProgramacionesAlma.TiempoGaseoIndirecto,
dbo.v_ProgramacionesAlma.AlmasRequeridas AS Programadas

FROM
dbo.v_ProgramacionesAlma
INNER JOIN dbo.v_Programaciones ON dbo.v_Programaciones.IdProgramacion = dbo.v_ProgramacionesAlma.IdProgramacion
WHERE
dbo.v_Programaciones.SaldoCantidad > 0 AND
dbo.v_Programaciones.Estatus = 'Abierto'
GROUP BY
dbo.v_ProgramacionesAlma.IdProgramacionAlma,
dbo.v_ProgramacionesAlma.IdArea,
dbo.v_ProgramacionesAlma.IdProductoCasting,
dbo.v_ProgramacionesAlma.IdAlma,
dbo.v_ProgramacionesAlma.IdProducto,
dbo.v_ProgramacionesAlma.Producto,
dbo.v_ProgramacionesAlma.IdAlmaTipo,
dbo.v_ProgramacionesAlma.Alma,
dbo.v_ProgramacionesAlma.IdAlmaReceta,
dbo.v_ProgramacionesAlma.AlmaReceta,
dbo.v_ProgramacionesAlma.IdAlmaMaterialCaja,
dbo.v_ProgramacionesAlma.MaterialCaja,
dbo.v_ProgramacionesAlma.Existencia,
dbo.v_ProgramacionesAlma.PiezasCaja,
dbo.v_ProgramacionesAlma.PiezasMolde,
dbo.v_ProgramacionesAlma.Peso,
dbo.v_ProgramacionesAlma.TiempoLlenado,
dbo.v_ProgramacionesAlma.TiempoFraguado,
dbo.v_ProgramacionesAlma.TiempoGaseoDirecto,
dbo.v_ProgramacionesAlma.TiempoGaseoIndirecto,
dbo.v_ProgramacionesAlma.AlmasRequeridas
GO
/****** Object:  View [dbo].[v_Filtros]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Filtros] AS 
SELECT
dbo.v_Programaciones.IdProductoCasting,
dbo.v_Programaciones.IdArea,
dbo.v_Programaciones.ProductoCasting,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesSemana.Programadas,
dbo.ProgramacionesSemana.Llenadas,
dbo.FiltrosTipo.Descripcion,
dbo.FiltrosTipo.CantidadPorPaquete,
dbo.FiltrosTipo.DUX_CodigoPesos,
dbo.FiltrosTipo.DUX_CodigoDolares,
dbo.Filtros.Cantidad,
Pesos.Existencia AS ExistenciaPesos,
Dolares.Existencia AS ExistenciaDolares,
dbo.FiltrosTipo.IdFiltroTipo,
dbo.Filtros.Cantidad * dbo.ProgramacionesSemana.Programadas AS Requeridas

FROM
dbo.v_Programaciones
INNER JOIN dbo.Filtros ON dbo.v_Programaciones.IdProductoCasting = dbo.Filtros.IdProducto
INNER JOIN dbo.FiltrosTipo ON dbo.FiltrosTipo.IdFiltroTipo = dbo.Filtros.IdFiltroTipo
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
LEFT JOIN dbo.v_AlmacenesProducto AS Pesos ON Pesos.Producto = dbo.FiltrosTipo.DUX_CodigoPesos
LEFT JOIN dbo.v_AlmacenesProducto AS Dolares ON Dolares.Producto = dbo.FiltrosTipo.DUX_CodigoDolares
GO
/****** Object:  View [dbo].[v_Camisas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Camisas] AS 
SELECT
dbo.v_Programaciones.IdProductoCasting,
dbo.v_Programaciones.ProductoCasting,
dbo.ProgramacionesSemana.Anio,
dbo.ProgramacionesSemana.Semana,
dbo.ProgramacionesSemana.Programadas,
dbo.ProgramacionesSemana.Llenadas,
dbo.CamisasTipo.Descripcion,
dbo.CamisasTipo.CantidadPorPaquete,
dbo.CamisasTipo.DUX_CodigoPesos,
dbo.CamisasTipo.DUX_CodigoDolares,
dbo.Camisas.Cantidad,
Pesos.Existencia AS ExistenciaPesos,
Dolares.Existencia AS ExistenciaDolares,
dbo.CamisasTipo.IdCamisaTipo,
dbo.CamisasTipo.Tamano,
dbo.CamisasTipo.TiempoDesmoldeo,
dbo.Camisas.Cantidad * dbo.ProgramacionesSemana.Programadas AS Requeridas

FROM
dbo.v_Programaciones
INNER JOIN dbo.Camisas ON dbo.v_Programaciones.IdProductoCasting = dbo.Camisas.IdProducto
INNER JOIN dbo.CamisasTipo ON dbo.CamisasTipo.IdCamisaTipo = dbo.Camisas.IdCamisaTipo
INNER JOIN dbo.ProgramacionesSemana ON dbo.ProgramacionesSemana.IdProgramacion = dbo.v_Programaciones.IdProgramacion
LEFT JOIN dbo.v_AlmacenesProducto AS Pesos ON Pesos.Producto = dbo.CamisasTipo.DUX_CodigoPesos
LEFT JOIN dbo.v_AlmacenesProducto AS Dolares ON Dolares.Producto = dbo.CamisasTipo.DUX_CodigoDolares
GO
/****** Object:  View [dbo].[v_Aleaciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Aleaciones] AS 
SELECT DISTINCT
dbo.Aleaciones.IdAleacion,
dbo.Aleaciones.Identificador,
dbo.Aleaciones.Descripcion,
dbo.Aleaciones.IdAleacionTipo,
dbo.Productos.IdPresentacion,
dbo.Aleaciones.Color

FROM
dbo.Aleaciones
INNER JOIN dbo.Productos ON dbo.Aleaciones.IdAleacion = dbo.Productos.IdAleacion
WHERE
dbo.Aleaciones.Identificador <> ''

GO
/****** Object:  View [dbo].[v_AlmacenesProductos2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmacenesProductos2] AS 
SELECT
dbo.AlmacenesProducto.IdAlmacenProducto,
dbo.AlmacenesProducto.IdAlmacen,
dbo.Almacenes.Identificador AS Almacen,
dbo.AlmacenesProducto.IdProducto,
dbo.Productos.Identificacion AS Producto,
dbo.AlmacenesProducto.Existencia,
dbo.AlmacenesProducto.CostoPromedio

FROM
dbo.AlmacenesProducto
INNER JOIN dbo.Almacenes ON dbo.Almacenes.IdAlmacen = dbo.AlmacenesProducto.IdAlmacen
INNER JOIN dbo.Productos ON dbo.Productos.IdProducto = dbo.AlmacenesProducto.IdProducto
GO
/****** Object:  View [dbo].[v_AlmproDux]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_AlmproDux] AS 
SELECT
dbo.Almacenes.IdAlmacen,
dbo.Productos.IdProducto,
DuxSinc.dbo.ALMPROD.EXISTENCIA,
DuxSinc.dbo.ALMPROD.COSTOPROMEDIO

FROM
DuxSinc.dbo.ALMPROD
INNER JOIN dbo.Productos ON dbo.Productos.Identificacion = DuxSinc.dbo.ALMPROD.PRODUCTO
INNER JOIN dbo.Almacenes ON dbo.Almacenes.Identificador = DuxSinc.dbo.ALMPROD.ALMACEN
GO
/****** Object:  View [dbo].[v_Costos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Costos] AS 
SELECT
dbo.Producciones.Fecha,
dbo.Productos.Identificacion AS Producto,
dbo.ProduccionesDetalle.Hechas AS Moldes,
dbo.ProduccionesDetalle.PiezasMolde * dbo.ProduccionesDetalle.Hechas AS Pzas,
dbo.AleacionesTipo.Factor * dbo.Productos.PesoArania AS Costo

FROM
dbo.Producciones
INNER JOIN dbo.ProduccionesDetalle ON dbo.ProduccionesDetalle.IdProduccion = dbo.Producciones.IdProduccion
INNER JOIN dbo.Productos ON dbo.Productos.IdProducto = dbo.ProduccionesDetalle.IdProductos
INNER JOIN dbo.Aleaciones ON dbo.Aleaciones.IdAleacion = dbo.Productos.IdAleacion
INNER JOIN dbo.AleacionesTipo ON dbo.AleacionesTipo.IdAleacionTipo = dbo.Aleaciones.IdAleacionTipo

GO
/****** Object:  View [dbo].[v_Defectos]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Defectos] AS 
SELECT
dbo.Defectos.IdDefecto,
dbo.Defectos.IdDefectoTipo,
dbo.Defectos.IdSubProceso,
dbo.Defectos.IdArea,
dbo.DefectosTipo.Identificador AS Tipo,
dbo.DefectosTipo.Descripcion AS NombreTipo

FROM
dbo.Defectos
INNER JOIN dbo.DefectosTipo ON dbo.Defectos.IdDefectoTipo = dbo.DefectosTipo.IdDefectoTipo

GO
/****** Object:  View [dbo].[v_Empleados]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Empleados] AS 
SELECT
dbo.Empleados.IdEmpleado,
dbo.Empleados.Nomina,
concat(RTRIM(dbo.Empleados.ApellidoPaterno),SPACE(1),RTRIM(dbo.Empleados.ApellidoMaterno),SPACE(1),RTRIM(dbo.Empleados.Nombre)) as NombreCompleto,
dbo.Empleados.IdEmpleadoEstatus,
dbo.Empleados.RFC,
dbo.Empleados.IMSS,
dbo.Departamentos.IdDepartamento,
dbo.Departamentos.IDENTIFICACION,
dbo.Departamentos.DESCRIPCION,
dbo.Empleados.IdTurno,
dbo.Empleados.IdPuesto

FROM
dbo.Empleados
INNER JOIN dbo.Departamentos ON dbo.Empleados.IdDepartamento = dbo.Departamentos.IdDepartamento
WHERE
dbo.Empleados.IdEmpleadoEstatus <> 2

GO
/****** Object:  View [dbo].[v_EmpleadosDux]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_EmpleadosDux] AS 
SELECT
CAST(DuxSinc.dbo.empleado.CODIGO AS DECIMAL) AS CODIGO,
CAST(DuxSinc.dbo.empleado.CODIGOANTERIOR AS DECIMAL) AS CODIGOANTERIOR,
DuxSinc.dbo.empleado.GOLDMINE,
LTRIM(DuxSinc.dbo.empleado.APELLIDOPATERNO) AS APELLIDOPATERNO,
LTRIM(DuxSinc.dbo.empleado.APELLIDOMATERNO) AS APELLIDOMATERNO,
LTRIM(DuxSinc.dbo.empleado.NOMBRES) AS NOMBRES,
DuxSinc.dbo.empleado.NOMBRECOMPLETO,
DuxSinc.dbo.empleado.ESTATUS,
DuxSinc.dbo.empleado.RFC,
DuxSinc.dbo.empleado.IMSS,
DuxSinc.dbo.empleado.FECHAINICIO,
DuxSinc.dbo.empleado.DEPARTAMENTO,
DuxSinc.dbo.empleado.PUESTO,
DuxSinc.dbo.empleado.FECHAINICIOPUESTO,
DuxSinc.dbo.empleado.TURNO,
DuxSinc.dbo.empleado.SIGUIENTENOMINA,
DuxSinc.dbo.empleado.FECHAULTIMANOMINA,
DuxSinc.dbo.empleado.SALARIODIARIO,
DuxSinc.dbo.empleado.SALARIODIARIOINTEGRADO,
DuxSinc.dbo.empleado.TIPOSALARIO,
DuxSinc.dbo.empleado.PORCENTAJEPRIMAVACACIONAL,
DuxSinc.dbo.empleado.DIASAGUINALDO,
DuxSinc.dbo.empleado.FORMAPAGO,
DuxSinc.dbo.empleado.REFERENCIAPAGO,
DuxSinc.dbo.empleado.PERIODICIDAD,
DuxSinc.dbo.empleado.CAUSABAJA,
DuxSinc.dbo.empleado.FECHABAJA,
DuxSinc.dbo.empleado.SEXO,
DuxSinc.dbo.empleado.CURP,
DuxSinc.dbo.empleado.SAR,
DuxSinc.dbo.empleado.DOMICILIO,
DuxSinc.dbo.empleado.CALLE,
DuxSinc.dbo.empleado.NUMEROEXTERIOR,
DuxSinc.dbo.empleado.NUMEROINTERIOR,
DuxSinc.dbo.empleado.COLONIA,
DuxSinc.dbo.empleado.MUNICIPIO,
DuxSinc.dbo.empleado.ESTADO,
DuxSinc.dbo.empleado.CP,
DuxSinc.dbo.empleado.TELEFONO1,
DuxSinc.dbo.empleado.TELEFONO2,
DuxSinc.dbo.empleado.FECHANACIMIENTO,
DuxSinc.dbo.empleado.LUGARNACIMIENTO,
DuxSinc.dbo.empleado.ESTADOCIVIL,
DuxSinc.dbo.empleado.NOMBREPADRE,
DuxSinc.dbo.empleado.NOMBREMADRE,
DuxSinc.dbo.empleado.VACACIONES,
DuxSinc.dbo.empleado.CUENTACONTABLE,
DuxSinc.dbo.empleado.EXISTEPRESTAMO,
DuxSinc.dbo.empleado.REFERENCIAPRESTAMO,
DuxSinc.dbo.empleado.MONTOPRESTAMO,
DuxSinc.dbo.empleado.SALDOPRESTAMO,
DuxSinc.dbo.empleado.PORCENTAJERETENCION,
DuxSinc.dbo.empleado.SINIMPRIMIRNOTIFICACION,
DuxSinc.dbo.empleado.TABLAVACACIONES,
DuxSinc.dbo.empleado.PORCENTAJEFIJOINFONAVIT,
DuxSinc.dbo.empleado.FACTORADICIONALINTEGRADO,
DuxSinc.dbo.empleado.NOMBRESIMPLE,
DuxSinc.dbo.empleado.EMAIL,
DuxSinc.dbo.empleado.TIPO,
DuxSinc.dbo.empleado.CALCULARENBASEASMGVDF,
DuxSinc.dbo.empleado.IMPORTEARETENER,
DuxSinc.dbo.empleado.CENTRODECOSTOS,
DuxSinc.dbo.empleado.USARELOJCHECADOR,
DuxSinc.dbo.empleado.CALCULAENVECESALSALARIOMINIMO,
DuxSinc.dbo.empleado.CALCULARENBASEASMGVZ,
DuxSinc.dbo.empleado.BANCO,
DuxSinc.dbo.empleado.REGIMENCONTRATACION,
DuxSinc.dbo.empleado.CATALOGOBANCOS,
DuxSinc.dbo.empleado.RIESGOPUESTO,
DuxSinc.dbo.empleado.TIPOCONTRATO,
DuxSinc.dbo.empleado.TIPOJORNADA

FROM
DuxSinc.dbo.empleado
GO
/****** Object:  View [dbo].[v_Existencias]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Existencias] AS 
SELECT
dbo.AlmacenesProducto.IdAlmacen,
dbo.Almacenes.Identificador AS Almacen,
dbo.AlmacenesProducto.IdProducto,
dbo.Productos.Identificacion AS Producto,
dbo.AlmacenesProducto.Existencia,
dbo.AlmacenesProducto.CostoPromedio

FROM
dbo.AlmacenesProducto
INNER JOIN dbo.Almacenes ON dbo.AlmacenesProducto.IdAlmacen = dbo.Almacenes.IdAlmacen
INNER JOIN dbo.Productos ON dbo.Productos.IdProducto = dbo.AlmacenesProducto.IdProducto
WHERE
dbo.AlmacenesProducto.Existencia > 0

GO
/****** Object:  View [dbo].[v_Lances]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Lances] AS 
SELECT
dbo.Producciones.IdProduccion,
dbo.Producciones.IdCentroTrabajo,
dbo.Producciones.IdMaquina,
dbo.Producciones.IdEmpleado,
dbo.Producciones.IdProduccionEstatus,
dbo.Producciones.Fecha,
dbo.Producciones.IdSubProceso,
dbo.Producciones.IdArea,
dbo.Lances.IdLance,
dbo.Lances.IdAleacion,
dbo.Lances.Colada,
dbo.Lances.Lance,
dbo.Lances.HornoConsecutivo

FROM
dbo.Producciones
INNER JOIN dbo.Lances ON dbo.Lances.IdProduccion = dbo.Producciones.IdProduccion
GO
/****** Object:  View [dbo].[v_Maquinas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Maquinas] AS 
SELECT
dbo.CentrosTrabajo.IdCentroTrabajo,
dbo.CentrosTrabajo.Identificador,
dbo.CentrosTrabajo.Descripcion,
dbo.CentrosTrabajo.IdSubProceso,
dbo.CentrosTrabajo.IdArea,
dbo.CentrosTrabajo.Habilitado,
dbo.Maquinas.IdMaquina,
dbo.Maquinas.Identificador AS ClaveMaquina,
dbo.Maquinas.Descripcion AS Maquina,
dbo.Maquinas.Consecutivo,
dbo.Maquinas.Eficiencia

FROM
dbo.CentrosTrabajo
LEFT JOIN dbo.CentrosTrabajoMaquinas ON dbo.CentrosTrabajo.IdCentroTrabajo = dbo.CentrosTrabajoMaquinas.IdCentroTrabajo
LEFT JOIN dbo.Maquinas ON dbo.CentrosTrabajoMaquinas.IdMaquina = dbo.Maquinas.IdMaquina
GO
/****** Object:  View [dbo].[v_MaterialArania]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_MaterialArania] AS 
SELECT
a.Identificador AS Aleacion,
pr.IdArea,
ps.Semana,
ps.Anio,
ps.Programadas * p.PesoArania AS TonTotales,
ps.Programadas * p.PiezasMolde * p.PesoCasting AS TonTotalesCasting
FROM            dbo.ProgramacionesSemana AS ps LEFT OUTER JOIN
                         dbo.Programaciones AS pr ON ps.IdProgramacion = pr.IdProgramacion LEFT OUTER JOIN
                         dbo.Productos AS p ON pr.IdProducto = p.IdProducto LEFT OUTER JOIN
                         dbo.Aleaciones AS a ON p.IdAleacion = a.IdAleacion
GO
/****** Object:  View [dbo].[v_Materiales]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Materiales] AS 
SELECT
dbo.MaterialesVaciado.IdMaterialVaciado,
dbo.MaterialesVaciado.IdProduccion,
dbo.Materiales.IdMaterial,
dbo.Materiales.Identificador,
dbo.Materiales.Descripcion,
dbo.Materiales.IdSubProceso,
dbo.MaterialesVaciado.Cantidad

FROM
dbo.MaterialesVaciado
RIGHT JOIN dbo.Materiales ON dbo.MaterialesVaciado.IdMaterial = dbo.Materiales.IdMaterial

GO
/****** Object:  View [dbo].[v_Pedidos2]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Pedidos2] AS 
SELECT
dbo.Pedidos.IdPedido,
dbo.Pedidos.IdAlmacen,
dbo.Pedidos.IdProducto,
dbo.Pedidos.Codigo,
dbo.Pedidos.Numero,
dbo.Productos.Identificacion AS Producto,
dbo.Almacenes.Identificador AS Almacen,
dbo.Pedidos.Fecha,
dbo.Pedidos.Cliente,
dbo.Pedidos.OrdenCompra,
dbo.Pedidos.Estatus,
dbo.Pedidos.Cantidad,
dbo.Pedidos.SaldoCantidad,
dbo.Pedidos.FechaEmbarque,
dbo.Pedidos.FechaEnvio,
dbo.Pedidos.NivelRiesgo,
dbo.Pedidos.TotalProgramado,
dbo.Pedidos.Observaciones,
dbo.Productos.PiezasMolde,
dbo.Productos.CiclosMolde,
dbo.Productos.PesoCasting,
dbo.Productos.PesoArania,
dbo.Productos.IdPresentacion,
dbo.Productos.IdParteMolde,
dbo.Productos.LlevaSerie,
dbo.Productos.FechaMoldeo,
dbo.Productos.IdAreaAct,
dbo.Programaciones.IdProgramacionEstatus

FROM
dbo.Pedidos
INNER JOIN dbo.Almacenes ON dbo.Pedidos.IdAlmacen = dbo.Almacenes.IdAlmacen
INNER JOIN dbo.Productos ON dbo.Pedidos.IdProducto = dbo.Productos.IdProducto
INNER JOIN dbo.Programaciones ON dbo.Programaciones.IdPedido = dbo.Pedidos.IdPedido AND dbo.Programaciones.IdProducto = dbo.Pedidos.IdProducto
WHERE
dbo.Programaciones.IdProgramacionEstatus = 1 AND
dbo.Productos.IdPresentacion = 3

GO
/****** Object:  View [dbo].[v_Producciones]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_Producciones] AS 
SELECT
dbo.Producciones.IdProduccion,
dbo.Producciones.IdCentroTrabajo,
dbo.Producciones.IdMaquina,
dbo.Producciones.IdEmpleado,
dbo.Producciones.IdProduccionEstatus,
dbo.Producciones.Fecha,
dbo.Producciones.IdSubProceso,
dbo.Producciones.IdArea,
dbo.ProduccionesDetalle.IdProduccionDetalle,
dbo.ProduccionesDetalle.IdProgramacion,
dbo.ProduccionesDetalle.IdProductos,
dbo.ProduccionesDetalle.Inicio,
dbo.ProduccionesDetalle.Fin,
dbo.ProduccionesDetalle.CiclosMolde,
dbo.ProduccionesDetalle.PiezasMolde,
dbo.ProduccionesDetalle.Programadas,
dbo.ProduccionesDetalle.Hechas,
dbo.ProduccionesDetalle.Rechazadas,
dbo.ProduccionesDetalle.Eficiencia

FROM
dbo.Producciones
INNER JOIN dbo.ProduccionesDetalle ON dbo.Producciones.IdProduccion = dbo.ProduccionesDetalle.IdProduccion

GO
/****** Object:  View [dbo].[v_ProductoExistencias]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProductoExistencias] AS 
SELECT        IdProducto, 
ISNULL(CAST([48] AS int),0) AS PLB, 
ISNULL(CAST([57] AS int),0) AS PMB, 
ISNULL(CAST([61] AS int),0) AS PTB, 
ISNULL(CAST([81] AS int),0) AS TRB, 
ISNULL(CAST([41] AS int),0) AS PCC, 
ISNULL(CAST([14] AS int),0) AS CTB,
ISNULL(CAST([13] AS int),0) AS CTA,
ISNULL(CAST([84] AS int),0) AS CTA2,
ISNULL(CAST([35] AS int),0) AS LAP,
ISNULL(CAST([39] AS int),0) AS PAI,
ISNULL(CAST([46] AS int),0) AS PLA,
ISNULL(CAST([47] AS int),0) AS PLA2,
ISNULL(CAST([55] AS int),0) AS PMA,
ISNULL(CAST([56] AS int),0) AS PMA2,
ISNULL(CAST([60] AS int),0) AS PTA,
ISNULL(CAST([67] AS int),0) AS RFA,
ISNULL(CAST([72] AS int),0) AS RLA,
ISNULL(CAST([75] AS int),0) AS RMA,
ISNULL(CAST([80] AS int),0) AS TRA,
ISNULL(CAST([15] AS int),0) AS GCRR,
ISNULL(CAST([16] AS int),0) AS GPC,
ISNULL(CAST([17] AS int),0) AS GPCB,
ISNULL(CAST([18] AS int),0) AS GPCK,
ISNULL(CAST([19] AS int),0) AS GPCR,
ISNULL(CAST([20] AS int),0) AS GPL,
ISNULL(CAST([21] AS int),0) AS GPLK,
ISNULL(CAST([22] AS int),0) AS GPLR,
ISNULL(CAST([23] AS int),0) AS GPM,
ISNULL(CAST([24] AS int),0) AS GPMK,
ISNULL(CAST([25] AS int),0) AS GPMR,
ISNULL(CAST([26] AS int),0) AS GPP,
ISNULL(CAST([27] AS int),0) AS GPPK,
ISNULL(CAST([28] AS int),0) AS GPPR,
ISNULL(CAST([29] AS int),0) AS GPT,
ISNULL(CAST([30] AS int),0) AS GPT1,
ISNULL(CAST([31] AS int),0) AS GPTA
FROM            (SELECT        IdProducto, IdAlmacen, Existencia
                          FROM            AlmacenesProducto) ps PIVOT (SUM(Existencia) FOR IdAlmacen IN ([48], [57], [61], [81], [41], [14],[13],[84],[35], [39], [46], [47], [55], [56], [60], [67], [72], [75], [80], [15], [16], [17], [18], [19], [20], [21], [22], [23], [24], [25], [26], [27], [28], [29], [30], [31])) AS pvt
GO
/****** Object:  View [dbo].[v_ProductosDux]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProductosDux] AS 
SELECT
DuxSinc.dbo.PRODUCTO.IDENTIFICACION,
CASE DuxSinc.dbo.PRODUCTO.PRESENTACION
  WHEN 'ACE' THEN 2 
  WHEN 'BRO' THEN 3
  ELSE 1
END AS IdPresentacion,
dbo.Aleaciones.IdAleacion,
DuxSinc.dbo.PRODUCTO.DESCRIPCION,
DuxSinc.dbo.PRODUCTO.TIEMPOSURTIDO AS PiezasMolde,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int)
END AS CiclosMolde,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO1 AS FLOAT) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO1 AS FLOAT)
END AS PesoCasting,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO2 AS FLOAT) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO2 AS FLOAT)
END AS PesoArania,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int)
END AS MoldesHora

FROM
DuxSinc.dbo.PRODUCTO
INNER JOIN dbo.Aleaciones ON DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO3 = dbo.Aleaciones.Descripcion
GO
/****** Object:  View [dbo].[v_ProductosNoAgregados]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProductosNoAgregados] AS 
SELECT
Min(dbo.Marcas.IdMarca) AS IdMarca,
CASE DuxSinc.dbo.PRODUCTO.PRESENTACION
  WHEN 'ACE' THEN 2 
  WHEN 'BRO' THEN 3
  ELSE 1
END AS IdPresentacion,
dbo.Aleaciones.IdAleacion,
1 AS IdProductoCasting,
DuxSinc.dbo.PRODUCTO.IDENTIFICACION,
DuxSinc.dbo.PRODUCTO.DESCRIPCION,
DuxSinc.dbo.PRODUCTO.TIEMPOSURTIDO AS PiezasMolde,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int)
END AS CiclosMolde,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO1 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO1 AS int)
END AS PesoCasting,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO2 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO2 AS int)
END AS PesoArania,
CASE
  WHEN TRY_CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int) Is NULL THEN -1
  ELSE CAST(DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4 AS int)
END AS MoldesHora,
1 AS IdProductosEstatus

FROM
DuxSinc.dbo.PRODUCTO
INNER JOIN dbo.Marcas ON dbo.Marcas.Descripcion = DuxSinc.dbo.PRODUCTO.ORDEN
LEFT JOIN dbo.Productos ON dbo.Productos.Identificacion = DuxSinc.dbo.PRODUCTO.IDENTIFICACION
INNER JOIN dbo.Aleaciones ON DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO3 = dbo.Aleaciones.Descripcion
WHERE
dbo.Productos.Identificacion IS NULL
GROUP BY
dbo.Aleaciones.IdAleacion,
IdProductoCasting,
DuxSinc.dbo.PRODUCTO.IDENTIFICACION,
DuxSinc.dbo.PRODUCTO.DESCRIPCION,
DuxSinc.dbo.PRODUCTO.PRESENTACION,
DuxSinc.dbo.PRODUCTO.TIEMPOSURTIDO,
DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO4,
DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO1,
DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO2,
DuxSinc.dbo.PRODUCTO.CAMPOUSUARIO3
GO
/****** Object:  View [dbo].[v_ProgramacionCiclosAcero]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ProgramacionCiclosAcero] AS 
SELECT dbo.ProduccionesDetalle.IdProductos, dbo.Programaciones.IdProgramacion, dbo.Producciones.IdProduccion,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'B' THEN dbo.ProduccionesDetalle.CantidadCiclos ELSE 0 END ) AS Cant,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'CB' THEN dbo.ProduccionesDetalle.CantidadCiclos ELSE 0 END ) AS CantC,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'R' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasR,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'RM' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasM,
		SUM(CASE dbo.ProduccionesDetalle.EstatusCiclos WHEN 'RC' THEN dbo.ProduccionesDetalle.Rechazadas ELSE 0 END ) AS RechazadasC
FROM dbo.ProduccionesDetalle
		INNER JOIN dbo.Programaciones ON dbo.ProduccionesDetalle.IdProductos = dbo.Programaciones.IdProducto
		LEFT JOIN dbo.Producciones ON dbo.ProduccionesDetalle.IdProduccion = dbo.Producciones.IdProduccion
		WHERE dbo.Programaciones.IdArea = 2 
		GROUP BY dbo.ProduccionesDetalle.IdProductos, dbo.Programaciones.IdProgramacion, dbo.Producciones.IdProduccion
GO
/****** Object:  View [dbo].[v_ResumenMateriales]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_ResumenMateriales] AS 
SELECT
dbo.Producciones.Fecha,
dbo.Materiales.IdMaterial,
dbo.Materiales.Identificador,
dbo.Materiales.Descripcion,
Sum(dbo.MaterialesVaciado.Cantidad) AS Cantidad

FROM
dbo.Producciones
INNER JOIN dbo.MaterialesVaciado ON dbo.MaterialesVaciado.IdProduccion = dbo.Producciones.IdProduccion
INNER JOIN dbo.Materiales ON dbo.Materiales.IdMaterial = dbo.MaterialesVaciado.IdMaterial
GROUP BY
dbo.Producciones.Fecha,
dbo.Materiales.IdMaterial,
dbo.Materiales.Identificador,
dbo.Materiales.Descripcion
GO
/****** Object:  View [dbo].[v_TotalesSemana]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_TotalesSemana] AS 
SELECT
dbo.ProgramacionesDia.IdProgramacionSemana,
Sum(dbo.ProgramacionesDia.Hechas) AS Hechas,
Sum(dbo.ProgramacionesDia.Llenadas) AS Llenadas,
Sum(dbo.ProgramacionesDia.Cerradas) AS Cerradas,
Sum(dbo.ProgramacionesDia.Vaciadas) AS Vaciadas

FROM
dbo.ProgramacionesDia
GROUP BY
dbo.ProgramacionesDia.IdProgramacionSemana

GO
/****** Object:  View [dbo].[v_TotalHechas]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_TotalHechas] AS 
SELECT
dbo.ProduccionesDetalle.IdProgramacion,
dbo.Producciones.Fecha,
dbo.Producciones.IdSubProceso,
dbo.Producciones.IdArea,
Sum(dbo.ProduccionesDetalle.Hechas) AS TotalHechas,
Sum(dbo.ProduccionesDetalle.Rechazadas) AS TotalRechazadas

FROM
dbo.Producciones
INNER JOIN dbo.ProduccionesDetalle ON dbo.Producciones.IdProduccion = dbo.ProduccionesDetalle.IdProduccion
GROUP BY
dbo.ProduccionesDetalle.IdProgramacion,
dbo.Producciones.Fecha,
dbo.Producciones.IdSubProceso,
dbo.Producciones.IdArea

GO
/****** Object:  View [dbo].[v_TotalPedido]    Script Date: 19/08/2015 10:14:54 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_TotalPedido] AS 
SELECT
dbo.ProgramacionesSemana.IdProgramacion,
Sum(dbo.ProgramacionesSemana.Hechas) AS Hechas,
Sum(dbo.ProgramacionesSemana.Llenadas) AS Llenadas,
Sum(dbo.ProgramacionesSemana.Cerradas) AS Cerradas,
Sum(dbo.ProgramacionesSemana.Vaciadas) AS Vaciadas

FROM
dbo.ProgramacionesSemana
GROUP BY
dbo.ProgramacionesSemana.IdProgramacion

GO
ALTER TABLE [dbo].[AleacionesTipoFactor] ADD  DEFAULT ((0)) FOR [Factor]
GO
ALTER TABLE [dbo].[AlmacenesProducto] ADD  DEFAULT ((0)) FOR [CostoPromedio]
GO
ALTER TABLE [dbo].[Almas] ADD  DEFAULT ((1)) FOR [IdAlmaMaterialCaja]
GO
ALTER TABLE [dbo].[Almas] ADD  DEFAULT ((1)) FOR [IdAlmaReceta]
GO
ALTER TABLE [dbo].[Almas] ADD  DEFAULT ((0)) FOR [Existencia]
GO
ALTER TABLE [dbo].[AlmasProduccionDefecto] ADD  DEFAULT ((0)) FOR [Rechazadas]
GO
ALTER TABLE [dbo].[AlmasRecetas] ADD  DEFAULT ('NI') FOR [Identificador]
GO
ALTER TABLE [dbo].[Camisas] ADD  DEFAULT ((0)) FOR [Cantidad]
GO
ALTER TABLE [dbo].[CamisasTipo] ADD  DEFAULT ((0)) FOR [CantidadPorPaquete]
GO
ALTER TABLE [dbo].[Causas] ADD  DEFAULT ('NI') FOR [Indentificador]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [ApellidoPaterno]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [ApellidoMaterno]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [Nombre]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [IdEmpleadoEstatus]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [RFC]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [IMSS]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [IdDepartamento]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [IdTurno]
GO
ALTER TABLE [dbo].[Empleados] ADD  DEFAULT (NULL) FOR [IdPuesto]
GO
ALTER TABLE [dbo].[Filtros] ADD  DEFAULT ((0)) FOR [Cantidad]
GO
ALTER TABLE [dbo].[FiltrosTipo] ADD  DEFAULT ((0)) FOR [CantidadPorPaquete]
GO
ALTER TABLE [dbo].[Maquinas] ADD  DEFAULT ((0)) FOR [Consecutivo]
GO
ALTER TABLE [dbo].[Maquinas] ADD  DEFAULT ((1)) FOR [Eficiencia]
GO
ALTER TABLE [dbo].[Pedidos] ADD  CONSTRAINT [DF__Pedidos__NivelRi__43A1090D]  DEFAULT ((0)) FOR [NivelRiesgo]
GO
ALTER TABLE [dbo].[Pedidos] ADD  CONSTRAINT [DF__Pedidos__TotalPr__44952D46]  DEFAULT ((0)) FOR [TotalProgramado]
GO
ALTER TABLE [dbo].[Producciones] ADD  DEFAULT (getdate()) FOR [Fecha]
GO
ALTER TABLE [dbo].[ProduccionesDefecto] ADD  DEFAULT ((0)) FOR [Rechazadas]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ('') FOR [Inicio]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ('') FOR [Fin]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ((0)) FOR [CiclosMolde]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ((0)) FOR [PiezasMolde]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ((0)) FOR [Programadas]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ((0)) FOR [Hechas]
GO
ALTER TABLE [dbo].[ProduccionesDetalle] ADD  DEFAULT ((0)) FOR [Rechazadas]
GO
ALTER TABLE [dbo].[Productos] ADD  DEFAULT ('No') FOR [LlevaSerie]
GO
ALTER TABLE [dbo].[Programaciones] ADD  DEFAULT ((0)) FOR [Llenadas]
GO
ALTER TABLE [dbo].[Programaciones] ADD  DEFAULT ((0)) FOR [Cerradas]
GO
ALTER TABLE [dbo].[Programaciones] ADD  DEFAULT ((0)) FOR [Vaciadas]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia] ADD  DEFAULT ((0)) FOR [Prioridad]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia] ADD  DEFAULT ((0)) FOR [Hechas]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaSemana] ADD  DEFAULT ((0)) FOR [Prioridad]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaSemana] ADD  DEFAULT ((0)) FOR [Hechas]
GO
ALTER TABLE [dbo].[ProgramacionesDia] ADD  DEFAULT ((0)) FOR [Prioridad]
GO
ALTER TABLE [dbo].[ProgramacionesDia] ADD  DEFAULT ((0)) FOR [Hechas]
GO
ALTER TABLE [dbo].[ProgramacionesDia] ADD  DEFAULT ((0)) FOR [Llenadas]
GO
ALTER TABLE [dbo].[ProgramacionesDia] ADD  DEFAULT ((0)) FOR [Cerradas]
GO
ALTER TABLE [dbo].[ProgramacionesDia] ADD  DEFAULT ((0)) FOR [Vaciadas]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Prioridad]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Programadas]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Hechas]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Llenadas]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Cerradas]
GO
ALTER TABLE [dbo].[ProgramacionesSemana] ADD  DEFAULT ((0)) FOR [Vaciadas]
GO
ALTER TABLE [dbo].[Temperaturas] ADD  DEFAULT ((0)) FOR [Temperatura]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT ((10)) FOR [role]
GO
ALTER TABLE [dbo].[user] ADD  DEFAULT ((10)) FOR [status]
GO
ALTER TABLE [dbo].[Aleaciones]  WITH CHECK ADD  CONSTRAINT [fk_Aleaciones_AleacionesTipo_1] FOREIGN KEY([IdAleacionTipo])
REFERENCES [dbo].[AleacionesTipo] ([IdAleacionTipo])
GO
ALTER TABLE [dbo].[Aleaciones] CHECK CONSTRAINT [fk_Aleaciones_AleacionesTipo_1]
GO
ALTER TABLE [dbo].[AleacionesTipoFactor]  WITH CHECK ADD  CONSTRAINT [FK__AleacionesTipoFactor__AleacionesTipo__IdAleacionTipo] FOREIGN KEY([IdAleacionTipo])
REFERENCES [dbo].[AleacionesTipo] ([IdAleacionTipo])
GO
ALTER TABLE [dbo].[AleacionesTipoFactor] CHECK CONSTRAINT [FK__AleacionesTipoFactor__AleacionesTipo__IdAleacionTipo]
GO
ALTER TABLE [dbo].[AlmacenesProducto]  WITH CHECK ADD  CONSTRAINT [FK__AlmacenesProducto__Almacenes__IdAlmacen] FOREIGN KEY([IdAlmacen])
REFERENCES [dbo].[Almacenes] ([IdAlmacen])
GO
ALTER TABLE [dbo].[AlmacenesProducto] CHECK CONSTRAINT [FK__AlmacenesProducto__Almacenes__IdAlmacen]
GO
ALTER TABLE [dbo].[Almas]  WITH CHECK ADD  CONSTRAINT [fk_Almas_AlmasMaterialCaja_IdAlmaMaterialCaja] FOREIGN KEY([IdAlmaMaterialCaja])
REFERENCES [dbo].[AlmasMaterialCaja] ([IdAlmaMaterialCaja])
GO
ALTER TABLE [dbo].[Almas] CHECK CONSTRAINT [fk_Almas_AlmasMaterialCaja_IdAlmaMaterialCaja]
GO
ALTER TABLE [dbo].[Almas]  WITH CHECK ADD  CONSTRAINT [fk_Almas_AlmasRecetas_IdAlmaReceta] FOREIGN KEY([IdAlmaReceta])
REFERENCES [dbo].[AlmasRecetas] ([IdAlmaReceta])
GO
ALTER TABLE [dbo].[Almas] CHECK CONSTRAINT [fk_Almas_AlmasRecetas_IdAlmaReceta]
GO
ALTER TABLE [dbo].[Almas]  WITH CHECK ADD  CONSTRAINT [fk_Almas_AlmasTipo_IdAlmaTipo] FOREIGN KEY([IdAlmaTipo])
REFERENCES [dbo].[AlmasTipo] ([IdAlmaTipo])
GO
ALTER TABLE [dbo].[Almas] CHECK CONSTRAINT [fk_Almas_AlmasTipo_IdAlmaTipo]
GO
ALTER TABLE [dbo].[Almas]  WITH CHECK ADD  CONSTRAINT [fk_Almas_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Almas] CHECK CONSTRAINT [fk_Almas_Productos_IdProducto]
GO
ALTER TABLE [dbo].[AlmasProduccionDefecto]  WITH CHECK ADD  CONSTRAINT [FK__AlmasProduccioDefecto__Defectos__IdDefectoTipo] FOREIGN KEY([IdDefectoTipo])
REFERENCES [dbo].[DefectosTipo] ([IdDefectoTipo])
GO
ALTER TABLE [dbo].[AlmasProduccionDefecto] CHECK CONSTRAINT [FK__AlmasProduccioDefecto__Defectos__IdDefectoTipo]
GO
ALTER TABLE [dbo].[AlmasProduccionDefecto]  WITH CHECK ADD  CONSTRAINT [FK__AlmasProduccioDefecto_AlmasProduccionDetalle_IdAlmaProduccionDetalle] FOREIGN KEY([IdAlmaProduccionDetalle])
REFERENCES [dbo].[AlmasProduccionDetalle] ([IdAlmaProduccionDetalle])
GO
ALTER TABLE [dbo].[AlmasProduccionDefecto] CHECK CONSTRAINT [FK__AlmasProduccioDefecto_AlmasProduccionDetalle_IdAlmaProduccionDetalle]
GO
ALTER TABLE [dbo].[AlmasProduccionDetalle]  WITH CHECK ADD FOREIGN KEY([IdAlmaTipo])
REFERENCES [dbo].[AlmasTipo] ([IdAlmaTipo])
GO
ALTER TABLE [dbo].[AlmasProduccionDetalle]  WITH CHECK ADD FOREIGN KEY([IdProduccion])
REFERENCES [dbo].[Producciones] ([IdProduccion])
GO
ALTER TABLE [dbo].[AlmasProduccionDetalle]  WITH CHECK ADD FOREIGN KEY([IdProgramacionAlma])
REFERENCES [dbo].[ProgramacionesAlma] ([IdProgramacionAlma])
GO
ALTER TABLE [dbo].[AlmasProduccionDetalle]  WITH CHECK ADD  CONSTRAINT [FK__AlmasProd__Productos__IdProductos] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[AlmasProduccionDetalle] CHECK CONSTRAINT [FK__AlmasProd__Productos__IdProductos]
GO
ALTER TABLE [dbo].[AreaProcesos]  WITH CHECK ADD  CONSTRAINT [fk_AreaProcesos_Areas_1] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[AreaProcesos] CHECK CONSTRAINT [fk_AreaProcesos_Areas_1]
GO
ALTER TABLE [dbo].[AreaProcesos]  WITH CHECK ADD  CONSTRAINT [fk_AreaProcesos_Procesos_1] FOREIGN KEY([IdProceso])
REFERENCES [dbo].[Procesos] ([IdProceso])
GO
ALTER TABLE [dbo].[AreaProcesos] CHECK CONSTRAINT [fk_AreaProcesos_Procesos_1]
GO
ALTER TABLE [dbo].[auth_assignment]  WITH CHECK ADD FOREIGN KEY([item_name])
REFERENCES [dbo].[auth_item] ([name])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[auth_item]  WITH CHECK ADD FOREIGN KEY([rule_name])
REFERENCES [dbo].[auth_rule] ([name])
ON UPDATE CASCADE
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[auth_item_child]  WITH CHECK ADD FOREIGN KEY([child])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[auth_item_child]  WITH CHECK ADD FOREIGN KEY([parent])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[Cajas]  WITH CHECK ADD  CONSTRAINT [fk_Cajas_CajasTipo_IdTipoCaja] FOREIGN KEY([IdTipoCaja])
REFERENCES [dbo].[CajasTipo] ([IdTipoCaja])
GO
ALTER TABLE [dbo].[Cajas] CHECK CONSTRAINT [fk_Cajas_CajasTipo_IdTipoCaja]
GO
ALTER TABLE [dbo].[Cajas]  WITH CHECK ADD  CONSTRAINT [fk_Cajas_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Cajas] CHECK CONSTRAINT [fk_Cajas_Productos_IdProducto]
GO
ALTER TABLE [dbo].[Camisas]  WITH CHECK ADD  CONSTRAINT [FK__Camisas__CamisasTipo__IdCamisaTipo] FOREIGN KEY([IdCamisaTipo])
REFERENCES [dbo].[CamisasTipo] ([IdCamisaTipo])
GO
ALTER TABLE [dbo].[Camisas] CHECK CONSTRAINT [FK__Camisas__CamisasTipo__IdCamisaTipo]
GO
ALTER TABLE [dbo].[Camisas]  WITH CHECK ADD  CONSTRAINT [FK__Camisas__Productos__IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Camisas] CHECK CONSTRAINT [FK__Camisas__Productos__IdProducto]
GO
ALTER TABLE [dbo].[Causas]  WITH CHECK ADD  CONSTRAINT [fk_Causas_Area_1] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[Causas] CHECK CONSTRAINT [fk_Causas_Area_1]
GO
ALTER TABLE [dbo].[Causas]  WITH CHECK ADD  CONSTRAINT [fk_Causas_CausasTipo_1] FOREIGN KEY([IdCausaTipo])
REFERENCES [dbo].[CausasTipo] ([IdCausaTipo])
GO
ALTER TABLE [dbo].[Causas] CHECK CONSTRAINT [fk_Causas_CausasTipo_1]
GO
ALTER TABLE [dbo].[Causas]  WITH CHECK ADD  CONSTRAINT [fk_Causas_Procesos_1] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[Causas] CHECK CONSTRAINT [fk_Causas_Procesos_1]
GO
ALTER TABLE [dbo].[CentrosTrabajo]  WITH CHECK ADD  CONSTRAINT [fk_CentrosTrabajo_Areas_1] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[CentrosTrabajo] CHECK CONSTRAINT [fk_CentrosTrabajo_Areas_1]
GO
ALTER TABLE [dbo].[CentrosTrabajo]  WITH CHECK ADD  CONSTRAINT [fk_CentrosTrabajo_Procesos_1] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[CentrosTrabajo] CHECK CONSTRAINT [fk_CentrosTrabajo_Procesos_1]
GO
ALTER TABLE [dbo].[CentrosTrabajoMaquinas]  WITH CHECK ADD  CONSTRAINT [FK_CentrosTrabajoMaquinas_CentrosTrabajo_IdCentroTrabajo] FOREIGN KEY([IdCentroTrabajo])
REFERENCES [dbo].[CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [dbo].[CentrosTrabajoMaquinas] CHECK CONSTRAINT [FK_CentrosTrabajoMaquinas_CentrosTrabajo_IdCentroTrabajo]
GO
ALTER TABLE [dbo].[CentrosTrabajoMaquinas]  WITH CHECK ADD  CONSTRAINT [FK_CentrosTrabajoMaquinas_Maquinas_IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[CentrosTrabajoMaquinas] CHECK CONSTRAINT [FK_CentrosTrabajoMaquinas_Maquinas_IdMaquina]
GO
ALTER TABLE [dbo].[CentrosTrabajoProductos]  WITH CHECK ADD FOREIGN KEY([IdCentroTrabajo])
REFERENCES [dbo].[CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [dbo].[CentrosTrabajoProductos]  WITH CHECK ADD FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[CiclosVarel]  WITH CHECK ADD  CONSTRAINT [fk_Ciclos_PartesMolde_IdParteMolde] FOREIGN KEY([IdParteMolde])
REFERENCES [dbo].[PartesMolde] ([IdParteMolde])
GO
ALTER TABLE [dbo].[CiclosVarel] CHECK CONSTRAINT [fk_Ciclos_PartesMolde_IdParteMolde]
GO
ALTER TABLE [dbo].[CiclosVarel]  WITH CHECK ADD  CONSTRAINT [fk_Ciclos_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[CiclosVarel] CHECK CONSTRAINT [fk_Ciclos_Productos_IdProducto]
GO
ALTER TABLE [dbo].[CiclosVarel]  WITH CHECK ADD  CONSTRAINT [fk_Ciclos_SubProcesos_IdSubProceso] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[CiclosVarel] CHECK CONSTRAINT [fk_Ciclos_SubProcesos_IdSubProceso]
GO
ALTER TABLE [dbo].[CiclosVarel]  WITH CHECK ADD  CONSTRAINT [fk_Ciclos_Turnos_IdTurno] FOREIGN KEY([IdTurno])
REFERENCES [dbo].[Turnos] ([IdTurno])
GO
ALTER TABLE [dbo].[CiclosVarel] CHECK CONSTRAINT [fk_Ciclos_Turnos_IdTurno]
GO
ALTER TABLE [dbo].[ConfiguracionSeries]  WITH CHECK ADD  CONSTRAINT [PK_ConfiguracionSeries_Productos] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[ConfiguracionSeries] CHECK CONSTRAINT [PK_ConfiguracionSeries_Productos]
GO
ALTER TABLE [dbo].[Defectos]  WITH CHECK ADD  CONSTRAINT [fk_Defectos_DefectosTipo_1] FOREIGN KEY([IdDefectoTipo])
REFERENCES [dbo].[DefectosTipo] ([IdDefectoTipo])
GO
ALTER TABLE [dbo].[Defectos] CHECK CONSTRAINT [fk_Defectos_DefectosTipo_1]
GO
ALTER TABLE [dbo].[Defectos]  WITH CHECK ADD  CONSTRAINT [fk_Defectos_Procesos_1] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[Defectos] CHECK CONSTRAINT [fk_Defectos_Procesos_1]
GO
ALTER TABLE [dbo].[Empleados]  WITH CHECK ADD  CONSTRAINT [FK__Empleados__Departamentos__IdDepartamento] FOREIGN KEY([IdDepartamento])
REFERENCES [dbo].[Departamentos] ([IdDepartamento])
GO
ALTER TABLE [dbo].[Empleados] CHECK CONSTRAINT [FK__Empleados__Departamentos__IdDepartamento]
GO
ALTER TABLE [dbo].[Empleados]  WITH CHECK ADD  CONSTRAINT [FK__Empleados__EmpleadosEstatus__IdEmpleadoEstatus] FOREIGN KEY([IdEmpleadoEstatus])
REFERENCES [dbo].[EmpleadosEstatus] ([IdEmpleadoEstatus])
GO
ALTER TABLE [dbo].[Empleados] CHECK CONSTRAINT [FK__Empleados__EmpleadosEstatus__IdEmpleadoEstatus]
GO
ALTER TABLE [dbo].[FechaMoldeo]  WITH CHECK ADD  CONSTRAINT [FK_FechaMoldeo_Productos] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[FechaMoldeo] CHECK CONSTRAINT [FK_FechaMoldeo_Productos]
GO
ALTER TABLE [dbo].[FechaMoldeoDetalle]  WITH CHECK ADD  CONSTRAINT [FK_FechaMoldeoDetalle_FechaMoldeo] FOREIGN KEY([IdFechaMoldeo])
REFERENCES [dbo].[FechaMoldeo] ([IdFechaMoldeo])
GO
ALTER TABLE [dbo].[FechaMoldeoDetalle] CHECK CONSTRAINT [FK_FechaMoldeoDetalle_FechaMoldeo]
GO
ALTER TABLE [dbo].[FechaMoldeoDetalle]  WITH CHECK ADD  CONSTRAINT [FK_FechaMoldeoDetalle_ProduccionesDetalle] FOREIGN KEY([IdProduccionDetalle])
REFERENCES [dbo].[ProduccionesDetalle] ([IdProduccionDetalle])
GO
ALTER TABLE [dbo].[FechaMoldeoDetalle] CHECK CONSTRAINT [FK_FechaMoldeoDetalle_ProduccionesDetalle]
GO
ALTER TABLE [dbo].[Filtros]  WITH CHECK ADD  CONSTRAINT [FK__Filtros__FiltrosTipo__IdFiltroTipo] FOREIGN KEY([IdFiltroTipo])
REFERENCES [dbo].[FiltrosTipo] ([IdFiltroTipo])
GO
ALTER TABLE [dbo].[Filtros] CHECK CONSTRAINT [FK__Filtros__FiltrosTipo__IdFiltroTipo]
GO
ALTER TABLE [dbo].[Filtros]  WITH CHECK ADD  CONSTRAINT [FK__Filtros__Productos__IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Filtros] CHECK CONSTRAINT [FK__Filtros__Productos__IdProducto]
GO
ALTER TABLE [dbo].[HistoriaExplosion]  WITH CHECK ADD  CONSTRAINT [FK_HistoriaExplosion_Productos] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[HistoriaExplosion] CHECK CONSTRAINT [FK_HistoriaExplosion_Productos]
GO
ALTER TABLE [dbo].[HistoriaExplosion]  WITH CHECK ADD  CONSTRAINT [FK_HistoriaExplosion_ProductosEnsamble] FOREIGN KEY([IdProductosEnsamble])
REFERENCES [dbo].[ProductosEnsamble] ([IdProductoEnsamble])
GO
ALTER TABLE [dbo].[HistoriaExplosion] CHECK CONSTRAINT [FK_HistoriaExplosion_ProductosEnsamble]
GO
ALTER TABLE [dbo].[Lances]  WITH CHECK ADD  CONSTRAINT [FK__Lances__Aleaciones__IdAleacion] FOREIGN KEY([IdAleacion])
REFERENCES [dbo].[Aleaciones] ([IdAleacion])
GO
ALTER TABLE [dbo].[Lances] CHECK CONSTRAINT [FK__Lances__Aleaciones__IdAleacion]
GO
ALTER TABLE [dbo].[Lances]  WITH CHECK ADD  CONSTRAINT [FK__Lances__Producciones__IdProduccion] FOREIGN KEY([IdProduccion])
REFERENCES [dbo].[Producciones] ([IdProduccion])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Lances] CHECK CONSTRAINT [FK__Lances__Producciones__IdProduccion]
GO
ALTER TABLE [dbo].[MantenimientoHornos]  WITH CHECK ADD  CONSTRAINT [fk-MantenimientoHornos_Maquinas] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[MantenimientoHornos] CHECK CONSTRAINT [fk-MantenimientoHornos_Maquinas]
GO
ALTER TABLE [dbo].[MaquinasProductos]  WITH CHECK ADD  CONSTRAINT [FK__MaquinasProductos__Maquinas__IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[MaquinasProductos] CHECK CONSTRAINT [FK__MaquinasProductos__Maquinas__IdMaquina]
GO
ALTER TABLE [dbo].[MaquinasProductos]  WITH CHECK ADD  CONSTRAINT [FK__MaquinasProductos__Productos__IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[MaquinasProductos] CHECK CONSTRAINT [FK__MaquinasProductos__Productos__IdProducto]
GO
ALTER TABLE [dbo].[Materiales]  WITH CHECK ADD  CONSTRAINT [fk_Materiales_AreaProcesos_1] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[Materiales] CHECK CONSTRAINT [fk_Materiales_AreaProcesos_1]
GO
ALTER TABLE [dbo].[Materiales]  WITH CHECK ADD  CONSTRAINT [fk_Materiales_Procesos_1] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[Materiales] CHECK CONSTRAINT [fk_Materiales_Procesos_1]
GO
ALTER TABLE [dbo].[MaterialesVaciado]  WITH CHECK ADD  CONSTRAINT [FK__Materiale__Materiales__IdMaterial] FOREIGN KEY([IdMaterial])
REFERENCES [dbo].[Materiales] ([IdMaterial])
GO
ALTER TABLE [dbo].[MaterialesVaciado] CHECK CONSTRAINT [FK__Materiale__Materiales__IdMaterial]
GO
ALTER TABLE [dbo].[MaterialesVaciado]  WITH CHECK ADD  CONSTRAINT [FK__Materiale__Producciones__IdProduccion] FOREIGN KEY([IdProduccion])
REFERENCES [dbo].[Producciones] ([IdProduccion])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[MaterialesVaciado] CHECK CONSTRAINT [FK__Materiale__Producciones__IdProduccion]
GO
ALTER TABLE [dbo].[Partran]  WITH CHECK ADD  CONSTRAINT [fk_Partran_Transacciones_IdTransaccion] FOREIGN KEY([IdTransaccion])
REFERENCES [dbo].[Transacciones] ([IdTransaccion])
GO
ALTER TABLE [dbo].[Partran] CHECK CONSTRAINT [fk_Partran_Transacciones_IdTransaccion]
GO
ALTER TABLE [dbo].[Pedidos]  WITH CHECK ADD  CONSTRAINT [fk_Pedidos_Almacenes_IdAlmacen] FOREIGN KEY([IdAlmacen])
REFERENCES [dbo].[Almacenes] ([IdAlmacen])
GO
ALTER TABLE [dbo].[Pedidos] CHECK CONSTRAINT [fk_Pedidos_Almacenes_IdAlmacen]
GO
ALTER TABLE [dbo].[Pedidos]  WITH CHECK ADD  CONSTRAINT [fk_Pedidos_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Pedidos] CHECK CONSTRAINT [fk_Pedidos_Productos_IdProducto]
GO
ALTER TABLE [dbo].[PedProg]  WITH CHECK ADD  CONSTRAINT [FK__PedProg__Pedidos__IdPedido] FOREIGN KEY([IdPedido])
REFERENCES [dbo].[Pedidos] ([IdPedido])
GO
ALTER TABLE [dbo].[PedProg] CHECK CONSTRAINT [FK__PedProg__Pedidos__IdPedido]
GO
ALTER TABLE [dbo].[PedProg]  WITH CHECK ADD  CONSTRAINT [FK__PedProg__Programaciones__IdProgramacion] FOREIGN KEY([IdProgramacion])
REFERENCES [dbo].[Programaciones] ([IdProgramacion])
GO
ALTER TABLE [dbo].[PedProg] CHECK CONSTRAINT [FK__PedProg__Programaciones__IdProgramacion]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Producciones_Area_IdArea] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Producciones_Area_IdArea]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Producciones_CentrosTrabajo_IdCentroTrabajo] FOREIGN KEY([IdCentroTrabajo])
REFERENCES [dbo].[CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Producciones_CentrosTrabajo_IdCentroTrabajo]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Producciones_ProduccionesEstatus_IdProduccionEstatus] FOREIGN KEY([IdProduccionEstatus])
REFERENCES [dbo].[ProduccionesEstatus] ([IdProduccionEstatus])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Producciones_ProduccionesEstatus_IdProduccionEstatus]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Producciones_SubProcesos_IdSubProceso] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Producciones_SubProcesos_IdSubProceso]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Seguimientos_Empleados_IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Seguimientos_Empleados_IdEmpleado]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Seguimientos_Maquinas_IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Seguimientos_Maquinas_IdMaquina]
GO
ALTER TABLE [dbo].[Producciones]  WITH CHECK ADD  CONSTRAINT [fk_Seguimientos_Turnos_IdTurno] FOREIGN KEY([IdTurno])
REFERENCES [dbo].[Turnos] ([IdTurno])
GO
ALTER TABLE [dbo].[Producciones] CHECK CONSTRAINT [fk_Seguimientos_Turnos_IdTurno]
GO
ALTER TABLE [dbo].[ProduccionesDefecto]  WITH CHECK ADD  CONSTRAINT [FK__ProduccionesDefecto_Defectos_IdDefectoTipo] FOREIGN KEY([IdDefectoTipo])
REFERENCES [dbo].[DefectosTipo] ([IdDefectoTipo])
GO
ALTER TABLE [dbo].[ProduccionesDefecto] CHECK CONSTRAINT [FK__ProduccionesDefecto_Defectos_IdDefectoTipo]
GO
ALTER TABLE [dbo].[ProduccionesDefecto]  WITH CHECK ADD  CONSTRAINT [FK__ProduccionesDefecto_ProduccionesDetalle_IdProduccionDetalle] FOREIGN KEY([IdProduccionDetalle])
REFERENCES [dbo].[ProduccionesDetalle] ([IdProduccionDetalle])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ProduccionesDefecto] CHECK CONSTRAINT [FK__ProduccionesDefecto_ProduccionesDetalle_IdProduccionDetalle]
GO
ALTER TABLE [dbo].[ProduccionesDetalle]  WITH CHECK ADD  CONSTRAINT [fk_ProduccionesDetalle_PartesMolde_IdParteMolde] FOREIGN KEY([IdParteMolde])
REFERENCES [dbo].[PartesMolde] ([IdParteMolde])
GO
ALTER TABLE [dbo].[ProduccionesDetalle] CHECK CONSTRAINT [fk_ProduccionesDetalle_PartesMolde_IdParteMolde]
GO
ALTER TABLE [dbo].[ProduccionesDetalle]  WITH CHECK ADD  CONSTRAINT [fk_ProduccionesDetalle_Producciones_IdProduccion] FOREIGN KEY([IdProduccion])
REFERENCES [dbo].[Producciones] ([IdProduccion])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ProduccionesDetalle] CHECK CONSTRAINT [fk_ProduccionesDetalle_Producciones_IdProduccion]
GO
ALTER TABLE [dbo].[ProduccionesDetalle]  WITH CHECK ADD  CONSTRAINT [fk_ProduccionesDetalle_Productos_IdProductos] FOREIGN KEY([IdProductos])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[ProduccionesDetalle] CHECK CONSTRAINT [fk_ProduccionesDetalle_Productos_IdProductos]
GO
ALTER TABLE [dbo].[ProduccionesDetalle]  WITH CHECK ADD  CONSTRAINT [fk_ProduccionesDetalle_Programaciones_IdProgramacion] FOREIGN KEY([IdProgramacion])
REFERENCES [dbo].[Programaciones] ([IdProgramacion])
GO
ALTER TABLE [dbo].[ProduccionesDetalle] CHECK CONSTRAINT [fk_ProduccionesDetalle_Programaciones_IdProgramacion]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_Aleaciones_IdAleacion] FOREIGN KEY([IdAleacion])
REFERENCES [dbo].[Aleaciones] ([IdAleacion])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_Aleaciones_IdAleacion]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_AreaAct_IdAreaAct] FOREIGN KEY([IdAreaAct])
REFERENCES [dbo].[AreaActual] ([IdAreaAct])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_AreaAct_IdAreaAct]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_Marcas_IdMarca] FOREIGN KEY([IdMarca])
REFERENCES [dbo].[Marcas] ([IdMarca])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_Marcas_IdMarca]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_PartesMolde_IdParteMolde] FOREIGN KEY([IdParteMolde])
REFERENCES [dbo].[PartesMolde] ([IdParteMolde])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_PartesMolde_IdParteMolde]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_Presentacion_IdPresentacion] FOREIGN KEY([IdPresentacion])
REFERENCES [dbo].[Presentaciones] ([IDPresentacion])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_Presentacion_IdPresentacion]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_Productos_IdProductoCasting] FOREIGN KEY([IdProductoCasting])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_Productos_IdProductoCasting]
GO
ALTER TABLE [dbo].[Productos]  WITH CHECK ADD  CONSTRAINT [fk_Productos_ProductosEstatus_IdProductosEstatus] FOREIGN KEY([IdProductosEstatus])
REFERENCES [dbo].[ProductosEstatus] ([IdProductosEstatus])
GO
ALTER TABLE [dbo].[Productos] CHECK CONSTRAINT [fk_Productos_ProductosEstatus_IdProductosEstatus]
GO
ALTER TABLE [dbo].[ProductosEnsamble]  WITH CHECK ADD  CONSTRAINT [FK_ProductosEnsamble_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[ProductosEnsamble] CHECK CONSTRAINT [FK_ProductosEnsamble_Productos_IdProducto]
GO
ALTER TABLE [dbo].[ProductosEnsamble]  WITH CHECK ADD  CONSTRAINT [FK_ProductosEnsamble_Productos_IdProducto2] FOREIGN KEY([IdComponente])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[ProductosEnsamble] CHECK CONSTRAINT [FK_ProductosEnsamble_Productos_IdProducto2]
GO
ALTER TABLE [dbo].[Programaciones]  WITH CHECK ADD  CONSTRAINT [fk_Programaciones_Areas_IdArea] FOREIGN KEY([IdArea])
REFERENCES [dbo].[Areas] ([IdArea])
GO
ALTER TABLE [dbo].[Programaciones] CHECK CONSTRAINT [fk_Programaciones_Areas_IdArea]
GO
ALTER TABLE [dbo].[Programaciones]  WITH CHECK ADD  CONSTRAINT [fk_Programaciones_IdEmpleado_IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[Programaciones] CHECK CONSTRAINT [fk_Programaciones_IdEmpleado_IdEmpleado]
GO
ALTER TABLE [dbo].[Programaciones]  WITH CHECK ADD  CONSTRAINT [fk_Programaciones_Pedidos_IdPedido] FOREIGN KEY([IdPedido])
REFERENCES [dbo].[Pedidos] ([IdPedido])
GO
ALTER TABLE [dbo].[Programaciones] CHECK CONSTRAINT [fk_Programaciones_Pedidos_IdPedido]
GO
ALTER TABLE [dbo].[Programaciones]  WITH CHECK ADD  CONSTRAINT [fk_Programaciones_Productos_IdProducto] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Programaciones] CHECK CONSTRAINT [fk_Programaciones_Productos_IdProducto]
GO
ALTER TABLE [dbo].[Programaciones]  WITH CHECK ADD  CONSTRAINT [fk_Programaciones_ProgramacionesEstatus_IdProgramacionEstatus] FOREIGN KEY([IdProgramacionEstatus])
REFERENCES [dbo].[ProgramacionesEstatus] ([IdProgramacionEstatus])
GO
ALTER TABLE [dbo].[Programaciones] CHECK CONSTRAINT [fk_Programaciones_ProgramacionesEstatus_IdProgramacionEstatus]
GO
ALTER TABLE [dbo].[ProgramacionesAlma]  WITH CHECK ADD  CONSTRAINT [fk_ProgramacionesAlma_Almas_IdAlmas] FOREIGN KEY([IdAlmas])
REFERENCES [dbo].[Almas] ([IdAlma])
GO
ALTER TABLE [dbo].[ProgramacionesAlma] CHECK CONSTRAINT [fk_ProgramacionesAlma_Almas_IdAlmas]
GO
ALTER TABLE [dbo].[ProgramacionesAlma]  WITH CHECK ADD  CONSTRAINT [fk_ProgramacionesAlma_Empleados_IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[ProgramacionesAlma] CHECK CONSTRAINT [fk_ProgramacionesAlma_Empleados_IdEmpleado]
GO
ALTER TABLE [dbo].[ProgramacionesAlma]  WITH CHECK ADD  CONSTRAINT [fk_ProgramacionesAlma_Programaciones_IdProgramacion] FOREIGN KEY([IdProgramacion])
REFERENCES [dbo].[Programaciones] ([IdProgramacion])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ProgramacionesAlma] CHECK CONSTRAINT [fk_ProgramacionesAlma_Programaciones_IdProgramacion]
GO
ALTER TABLE [dbo].[ProgramacionesAlma]  WITH CHECK ADD  CONSTRAINT [fk_ProgramacionesAlma_ProgramacionesEstatus_IdProgramacionEstatus] FOREIGN KEY([IdProgramacionEstatus])
REFERENCES [dbo].[ProgramacionesEstatus] ([IdProgramacionEstatus])
GO
ALTER TABLE [dbo].[ProgramacionesAlma] CHECK CONSTRAINT [fk_ProgramacionesAlma_ProgramacionesEstatus_IdProgramacionEstatus]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia]  WITH CHECK ADD  CONSTRAINT [FK__ProgramacionesAlmaDia_CentrosTrabajo_IdCentroTrabajo] FOREIGN KEY([IdCentroTrabajo])
REFERENCES [dbo].[CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia] CHECK CONSTRAINT [FK__ProgramacionesAlmaDia_CentrosTrabajo_IdCentroTrabajo]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia]  WITH CHECK ADD  CONSTRAINT [FK__ProgramacionesAlmaDia_Maquinas_IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia] CHECK CONSTRAINT [FK__ProgramacionesAlmaDia_Maquinas_IdMaquina]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia]  WITH CHECK ADD  CONSTRAINT [FK__ProgramacionesAlmaDia_ProgramacionesAlmaSemana_IdProgramacionAlmaSemana] FOREIGN KEY([IdProgramacionAlmaSemana])
REFERENCES [dbo].[ProgramacionesAlmaSemana] ([IdProgramacionAlmaSemana])
GO
ALTER TABLE [dbo].[ProgramacionesAlmaDia] CHECK CONSTRAINT [FK__ProgramacionesAlmaDia_ProgramacionesAlmaSemana_IdProgramacionAlmaSemana]
GO
ALTER TABLE [dbo].[ProgramacionesAlmaSemana]  WITH CHECK ADD  CONSTRAINT [FK_ProgramacionesAlmaSemana_ProgramacionesAlma_IdProgramacionAlma] FOREIGN KEY([IdProgramacionAlma])
REFERENCES [dbo].[ProgramacionesAlma] ([IdProgramacionAlma])
GO
ALTER TABLE [dbo].[ProgramacionesAlmaSemana] CHECK CONSTRAINT [FK_ProgramacionesAlmaSemana_ProgramacionesAlma_IdProgramacionAlma]
GO
ALTER TABLE [dbo].[ProgramacionesDia]  WITH CHECK ADD  CONSTRAINT [FK__Programac__IdAre__49CEE3AF] FOREIGN KEY([IdAreaProceso])
REFERENCES [dbo].[AreaProcesos] ([IdAreaProceso])
GO
ALTER TABLE [dbo].[ProgramacionesDia] CHECK CONSTRAINT [FK__Programac__IdAre__49CEE3AF]
GO
ALTER TABLE [dbo].[ProgramacionesDia]  WITH CHECK ADD  CONSTRAINT [FK__Programac__IdCen__4AC307E8] FOREIGN KEY([IdCentroTrabajo])
REFERENCES [dbo].[CentrosTrabajo] ([IdCentroTrabajo])
GO
ALTER TABLE [dbo].[ProgramacionesDia] CHECK CONSTRAINT [FK__Programac__IdCen__4AC307E8]
GO
ALTER TABLE [dbo].[ProgramacionesDia]  WITH CHECK ADD  CONSTRAINT [FK__Programac__IdMaq__4BB72C21] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[ProgramacionesDia] CHECK CONSTRAINT [FK__Programac__IdMaq__4BB72C21]
GO
ALTER TABLE [dbo].[ProgramacionesDia]  WITH CHECK ADD  CONSTRAINT [FK__Programac__IdPro__4CAB505A] FOREIGN KEY([IdProgramacionSemana])
REFERENCES [dbo].[ProgramacionesSemana] ([IdProgramacionSemana])
GO
ALTER TABLE [dbo].[ProgramacionesDia] CHECK CONSTRAINT [FK__Programac__IdPro__4CAB505A]
GO
ALTER TABLE [dbo].[ProgramacionesDia]  WITH CHECK ADD  CONSTRAINT [FK__Programac__IdTur__4D9F7493] FOREIGN KEY([IdTurno])
REFERENCES [dbo].[Turnos] ([IdTurno])
GO
ALTER TABLE [dbo].[ProgramacionesDia] CHECK CONSTRAINT [FK__Programac__IdTur__4D9F7493]
GO
ALTER TABLE [dbo].[ProgramacionesSemana]  WITH CHECK ADD  CONSTRAINT [FK__ProgramacionesSemana_Programaciones_IdProgramacion] FOREIGN KEY([IdProgramacion])
REFERENCES [dbo].[Programaciones] ([IdProgramacion])
GO
ALTER TABLE [dbo].[ProgramacionesSemana] CHECK CONSTRAINT [FK__ProgramacionesSemana_Programaciones_IdProgramacion]
GO
ALTER TABLE [dbo].[ResumenFechaMoldeo]  WITH CHECK ADD  CONSTRAINT [FK_ResumenFechaMoldeo_FechaMoldeo] FOREIGN KEY([IdFechaMoldeo])
REFERENCES [dbo].[FechaMoldeo] ([IdFechaMoldeo])
GO
ALTER TABLE [dbo].[ResumenFechaMoldeo] CHECK CONSTRAINT [FK_ResumenFechaMoldeo_FechaMoldeo]
GO
ALTER TABLE [dbo].[ResumenFechaMoldeo]  WITH CHECK ADD  CONSTRAINT [FK_ResumenFechaMoldeo_SubProcesos] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[ResumenFechaMoldeo] CHECK CONSTRAINT [FK_ResumenFechaMoldeo_SubProcesos]
GO
ALTER TABLE [dbo].[Series]  WITH CHECK ADD  CONSTRAINT [PK_Series_Productos] FOREIGN KEY([IdProducto])
REFERENCES [dbo].[Productos] ([IdProducto])
GO
ALTER TABLE [dbo].[Series] CHECK CONSTRAINT [PK_Series_Productos]
GO
ALTER TABLE [dbo].[Series]  WITH CHECK ADD  CONSTRAINT [PK_Series_SubProceso] FOREIGN KEY([IdSubProceso])
REFERENCES [dbo].[SubProcesos] ([IdSubProceso])
GO
ALTER TABLE [dbo].[Series] CHECK CONSTRAINT [PK_Series_SubProceso]
GO
ALTER TABLE [dbo].[SeriesDetalles]  WITH CHECK ADD  CONSTRAINT [FK__SeriesDetalles_ProduccionesDetalle_IdProduccionDetalle] FOREIGN KEY([IdProduccionDetalle])
REFERENCES [dbo].[ProduccionesDetalle] ([IdProduccionDetalle])
GO
ALTER TABLE [dbo].[SeriesDetalles] CHECK CONSTRAINT [FK__SeriesDetalles_ProduccionesDetalle_IdProduccionDetalle]
GO
ALTER TABLE [dbo].[SeriesDetalles]  WITH CHECK ADD  CONSTRAINT [FK__SeriesDetalles_Series_IdSerie] FOREIGN KEY([IdSerie])
REFERENCES [dbo].[Series] ([IdSerie])
GO
ALTER TABLE [dbo].[SeriesDetalles] CHECK CONSTRAINT [FK__SeriesDetalles_Series_IdSerie]
GO
ALTER TABLE [dbo].[SeriesPartidas]  WITH CHECK ADD  CONSTRAINT [FK__SeriesPartidas_Partran_IdPartran] FOREIGN KEY([IdPartran])
REFERENCES [dbo].[Partran] ([IdPartran])
GO
ALTER TABLE [dbo].[SeriesPartidas] CHECK CONSTRAINT [FK__SeriesPartidas_Partran_IdPartran]
GO
ALTER TABLE [dbo].[SeriesPartidas]  WITH CHECK ADD  CONSTRAINT [FK__SeriesPartidas_Series_IdSerie] FOREIGN KEY([IdSerie])
REFERENCES [dbo].[Series] ([IdSerie])
GO
ALTER TABLE [dbo].[SeriesPartidas] CHECK CONSTRAINT [FK__SeriesPartidas_Series_IdSerie]
GO
ALTER TABLE [dbo].[SubProcesos]  WITH CHECK ADD  CONSTRAINT [FK__SubProcesos__Procesos__IdProceso] FOREIGN KEY([IdProceso])
REFERENCES [dbo].[Procesos] ([IdProceso])
GO
ALTER TABLE [dbo].[SubProcesos] CHECK CONSTRAINT [FK__SubProcesos__Procesos__IdProceso]
GO
ALTER TABLE [dbo].[Tarimas]  WITH CHECK ADD  CONSTRAINT [FK_Tarimas_ProgramacionesDia_IdProgramacionDia] FOREIGN KEY([IdProgramacionDia])
REFERENCES [dbo].[ProgramacionesDia] ([IdProgramacionDia])
GO
ALTER TABLE [dbo].[Tarimas] CHECK CONSTRAINT [FK_Tarimas_ProgramacionesDia_IdProgramacionDia]
GO
ALTER TABLE [dbo].[Temperaturas]  WITH CHECK ADD  CONSTRAINT [FK__Temperaturas_Empleados_IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[Temperaturas] CHECK CONSTRAINT [FK__Temperaturas_Empleados_IdEmpleado]
GO
ALTER TABLE [dbo].[Temperaturas]  WITH CHECK ADD  CONSTRAINT [FK__Temperaturas_Maquinas_IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[Temperaturas] CHECK CONSTRAINT [FK__Temperaturas_Maquinas_IdMaquina]
GO
ALTER TABLE [dbo].[Temperaturas]  WITH CHECK ADD  CONSTRAINT [FK__Temperaturas_Producciones_IdProduccion] FOREIGN KEY([IdProduccion])
REFERENCES [dbo].[Producciones] ([IdProduccion])
GO
ALTER TABLE [dbo].[Temperaturas] CHECK CONSTRAINT [FK__Temperaturas_Producciones_IdProduccion]
GO
ALTER TABLE [dbo].[TiemposMuerto]  WITH CHECK ADD  CONSTRAINT [FK__TiemposMuerto_Causas_IdCausa] FOREIGN KEY([IdCausa])
REFERENCES [dbo].[Causas] ([IdCausa])
GO
ALTER TABLE [dbo].[TiemposMuerto] CHECK CONSTRAINT [FK__TiemposMuerto_Causas_IdCausa]
GO
ALTER TABLE [dbo].[TiemposMuerto]  WITH CHECK ADD  CONSTRAINT [FK__TiemposMuerto_Empleados_IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[TiemposMuerto] CHECK CONSTRAINT [FK__TiemposMuerto_Empleados_IdEmpleado]
GO
ALTER TABLE [dbo].[TiemposMuerto]  WITH CHECK ADD  CONSTRAINT [FK__TiemposMuerto_Maquinas_IdMaquina] FOREIGN KEY([IdMaquina])
REFERENCES [dbo].[Maquinas] ([IdMaquina])
GO
ALTER TABLE [dbo].[TiemposMuerto] CHECK CONSTRAINT [FK__TiemposMuerto_Maquinas_IdMaquina]
GO
ALTER TABLE [dbo].[TiemposMuerto]  WITH CHECK ADD  CONSTRAINT [FK__TiemposMuerto_Turnos_IdTurno] FOREIGN KEY([IdTurno])
REFERENCES [dbo].[Turnos] ([IdTurno])
GO
ALTER TABLE [dbo].[TiemposMuerto] CHECK CONSTRAINT [FK__TiemposMuerto_Turnos_IdTurno]
GO
ALTER TABLE [dbo].[user]  WITH CHECK ADD  CONSTRAINT [FK__User__IdEmpleado__IdEmpleado] FOREIGN KEY([IdEmpleado])
REFERENCES [dbo].[Empleados] ([IdEmpleado])
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [FK__User__IdEmpleado__IdEmpleado]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Moldeo Permanente 
Bronce
 Acero' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Areas', @level2type=N'COLUMN',@level2name=N'Descripcion'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Collingnon 
Cooper 
Jabsco 
Rain Bird' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Marcas', @level2type=N'COLUMN',@level2name=N'Descripcion'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Almacen de la orden de entrega' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'IdAlmacen'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Codigo de la orden de entrega' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Codigo'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Numero de la partida de la orden de entrega' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Numero'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Fecha de la orden de entrega' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Fecha'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Cliente de la orden de entrega' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Cliente'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Orden de compra del cliente (OE_DOCUMENTO1)' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'OrdenCompra'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Estatus de la orden de entrega PO_STATUS' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Estatus'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'POE_DctoAdicionalFecha' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'FechaEmbarque'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'POE_Observaciones' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Pedidos', @level2type=N'COLUMN',@level2name=N'Observaciones'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Acero 
Bronce' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Presentaciones', @level2type=N'COLUMN',@level2name=N'Descripcion'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Moldeado Vaciado' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Procesos', @level2type=N'COLUMN',@level2name=N'Descripcion'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'CampoUsuario1' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Productos', @level2type=N'COLUMN',@level2name=N'PesoCasting'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'CampoUsuario2' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Productos', @level2type=N'COLUMN',@level2name=N'PesoArania'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Dia Noche' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Turnos', @level2type=N'COLUMN',@level2name=N'Descripcion'
GO
