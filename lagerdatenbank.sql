USE [master]
GO
/****** Object:  Database [LagerDatenbank]    Script Date: 23.04.2018 17:15:38 ******/
CREATE DATABASE [LagerDatenbank]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'LagerDatenbank', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL12.SQLEXPRESS\MSSQL\DATA\LagerDatenbank.mdf' , SIZE = 5120KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'LagerDatenbank_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL12.SQLEXPRESS\MSSQL\DATA\LagerDatenbank_log.ldf' , SIZE = 2048KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [LagerDatenbank] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [LagerDatenbank].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [LagerDatenbank] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [LagerDatenbank] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [LagerDatenbank] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [LagerDatenbank] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [LagerDatenbank] SET ARITHABORT OFF 
GO
ALTER DATABASE [LagerDatenbank] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [LagerDatenbank] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [LagerDatenbank] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [LagerDatenbank] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [LagerDatenbank] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [LagerDatenbank] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [LagerDatenbank] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [LagerDatenbank] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [LagerDatenbank] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [LagerDatenbank] SET  DISABLE_BROKER 
GO
ALTER DATABASE [LagerDatenbank] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [LagerDatenbank] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [LagerDatenbank] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [LagerDatenbank] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [LagerDatenbank] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [LagerDatenbank] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [LagerDatenbank] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [LagerDatenbank] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [LagerDatenbank] SET  MULTI_USER 
GO
ALTER DATABASE [LagerDatenbank] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [LagerDatenbank] SET DB_CHAINING OFF 
GO
ALTER DATABASE [LagerDatenbank] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [LagerDatenbank] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [LagerDatenbank] SET DELAYED_DURABILITY = DISABLED 
GO
USE [LagerDatenbank]
GO
/****** Object:  Table [dbo].[Customer_Directory]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Customer_Directory](
	[Customer_ID] [int] IDENTITY(1,1) NOT NULL,
	[Company_Name] [varchar](50) NULL,
	[Contact_Telefone] [varchar](50) NOT NULL,
	[Contact_Email] [varchar](50) NOT NULL,
	[Zip_Code] [int] NULL,
	[Street] [varchar](50) NULL,
	[City] [varchar](50) NULL,
 CONSTRAINT [PK_Kundenverzeichnis] PRIMARY KEY CLUSTERED 
(
	[Customer_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Delivery]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Delivery](
	[Deliveryreceipt] [bigint] NOT NULL,
	[Customer_ID] [int] NOT NULL,
	[Warehouse_ID] [int] NOT NULL,
	[Kind_of_Delivery] [nchar](10) NOT NULL,
	[Date] [date] NULL,
	[Comment] [text] NULL,
	[Document] [image] NULL,
 CONSTRAINT [PK_Delivery] PRIMARY KEY CLUSTERED 
(
	[Deliveryreceipt] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Delivery_has_Item]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Delivery_has_Item](
	[Deliveryreceipt] [bigint] NOT NULL,
	[Item_ID] [int] NOT NULL,
	[Amount] [int] NULL,
 CONSTRAINT [PK_Lieferung_hat_Artikel] PRIMARY KEY CLUSTERED 
(
	[Deliveryreceipt] ASC,
	[Item_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Item_Directory]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Item_Directory](
	[Item_ID] [int] IDENTITY(1,1) NOT NULL,
	[Name] [nchar](50) NOT NULL,
	[EAN] [nchar](50) NOT NULL,
	[Item_NR] [nchar](50) NOT NULL,
	[Comment] [nchar](50) NULL,
 CONSTRAINT [PK_Item_Directory] PRIMARY KEY CLUSTERED 
(
	[Item_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Warehouse_Directory]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Warehouse_Directory](
	[Warehouse_ID] [int] IDENTITY(1,1) NOT NULL,
	[Warehouse_Name] [varchar](50) NULL,
	[Zip_Code] [varchar](50) NULL,
	[Street] [varchar](50) NULL,
	[City] [varchar](50) NULL,
 CONSTRAINT [PK_Lagerverzeichnis] PRIMARY KEY CLUSTERED 
(
	[Warehouse_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Warehouse_has_Item]    Script Date: 23.04.2018 17:15:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Warehouse_has_Item](
	[Warehouse_ID] [int] NOT NULL,
	[Item_ID] [int] NOT NULL,
	[Amount] [int] NOT NULL,
 CONSTRAINT [PK_Warehouse_has_Item] PRIMARY KEY CLUSTERED 
(
	[Warehouse_ID] ASC,
	[Item_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[Delivery]  WITH CHECK ADD  CONSTRAINT [FK_Delivery_Customer_Directory] FOREIGN KEY([Customer_ID])
REFERENCES [dbo].[Customer_Directory] ([Customer_ID])
GO
ALTER TABLE [dbo].[Delivery] CHECK CONSTRAINT [FK_Delivery_Customer_Directory]
GO
ALTER TABLE [dbo].[Delivery]  WITH CHECK ADD  CONSTRAINT [FK_Delivery_Warehouse_Directory] FOREIGN KEY([Warehouse_ID])
REFERENCES [dbo].[Warehouse_Directory] ([Warehouse_ID])
GO
ALTER TABLE [dbo].[Delivery] CHECK CONSTRAINT [FK_Delivery_Warehouse_Directory]
GO
ALTER TABLE [dbo].[Delivery_has_Item]  WITH CHECK ADD  CONSTRAINT [FK_Delivery_has_Item_Delivery] FOREIGN KEY([Deliveryreceipt])
REFERENCES [dbo].[Delivery] ([Deliveryreceipt])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Delivery_has_Item] CHECK CONSTRAINT [FK_Delivery_has_Item_Delivery]
GO
ALTER TABLE [dbo].[Delivery_has_Item]  WITH CHECK ADD  CONSTRAINT [FK_Delivery_has_Item_Item_Directory] FOREIGN KEY([Item_ID])
REFERENCES [dbo].[Item_Directory] ([Item_ID])
GO
ALTER TABLE [dbo].[Delivery_has_Item] CHECK CONSTRAINT [FK_Delivery_has_Item_Item_Directory]
GO
ALTER TABLE [dbo].[Warehouse_has_Item]  WITH CHECK ADD  CONSTRAINT [FK_Warehouse_has_Item_Item_Directory] FOREIGN KEY([Item_ID])
REFERENCES [dbo].[Item_Directory] ([Item_ID])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Warehouse_has_Item] CHECK CONSTRAINT [FK_Warehouse_has_Item_Item_Directory]
GO
ALTER TABLE [dbo].[Warehouse_has_Item]  WITH CHECK ADD  CONSTRAINT [FK_Warehouse_has_Item_Warehouse_Directory] FOREIGN KEY([Warehouse_ID])
REFERENCES [dbo].[Warehouse_Directory] ([Warehouse_ID])
GO
ALTER TABLE [dbo].[Warehouse_has_Item] CHECK CONSTRAINT [FK_Warehouse_has_Item_Warehouse_Directory]
GO
USE [master]
GO
ALTER DATABASE [LagerDatenbank] SET  READ_WRITE 
GO
