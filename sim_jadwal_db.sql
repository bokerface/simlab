USE [simjadwal]
GO
/****** Object:  Table [dbo].[isi_kurikulum]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[isi_kurikulum](
	[id] [int] NULL,
	[id_kurikulum] [varchar](50) NULL,
	[id_matkul] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[jadwal_praktikum]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[jadwal_praktikum](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_matkul] [int] NULL,
	[semester] [int] NULL,
	[tanggal] [date] NULL,
	[jam_mulai] [time](0) NULL,
	[jam_selesai] [time](0) NULL,
	[pembicara] [varchar](255) NULL,
	[tempat] [varchar](255) NULL,
	[t_akademik] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[jadwal_softskill]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[jadwal_softskill](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_matkul] [varchar](50) NULL,
	[semester] [int] NULL,
	[tanggal] [date] NULL,
	[jam_mulai] [time](0) NULL,
	[jam_selesai] [time](0) NULL,
	[pembicara] [varchar](255) NULL,
	[tempat] [varchar](255) NULL,
	[t_akademik] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[kuliah_lapangan]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[kuliah_lapangan](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[acara] [varchar](255) NULL,
	[tanggal_start] [datetime2](0) NULL,
	[tanggal_end] [datetime2](0) NULL,
	[instansi] [varchar](50) NULL,
	[tema] [varchar](50) NULL,
	[id_praktikum] [varchar](50) NULL,
	[tahun_ajaran] [int] NULL,
	[semester] [smallint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[kuliah_umum]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[kuliah_umum](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tanggal] [date] NULL,
	[jam_mulai] [time](0) NULL,
	[jam_selesai] [time](0) NULL,
	[tema] [varchar](50) NULL,
	[id_praktikum] [varchar](20) NULL,
	[tahun_ajaran] [smallint] NULL,
	[semester] [smallint] NULL,
	[tempat] [varchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[kurikulum]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[kurikulum](
	[id_kurikulum] [int] NULL,
	[nama] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[laporan_praktikum_dosen]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[laporan_praktikum_dosen](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_praktikum] [varchar](50) NULL,
	[id_dosen] [varchar](50) NULL,
	[tahun] [int] NULL,
	[laporan_praktikum] [text] NULL,
	[laporan_kuliah_umum] [text] NULL,
	[laporan_kuliah_lapangan] [text] NULL,
	[catatan1] [text] NULL,
	[catatan2] [text] NULL,
	[catatan3] [text] NULL,
	[praktikum_selesai] [varchar](1) NULL,
	[kuliah_umum_selesai] [varchar](1) NULL,
	[kuliah_lapangan_selesai] [varchar](1) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[mhs_krs]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mhs_krs](
	[t_akademik] [int] NULL,
	[STUDENTID] [varchar](50) NULL,
	[id_matkul] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[mhs_nilai]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mhs_nilai](
	[t_akademik] [int] NULL,
	[id_matkul] [int] NULL,
	[STUDENTID] [varchar](50) NULL,
	[nilai] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[pembayaran]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pembayaran](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tanggal] [date] NULL,
	[file_bukti] [text] NULL,
	[nominal] [int] NULL,
	[id_dosen] [int] NULL,
	[id_praktikum] [varchar](15) NULL,
	[id_tahun] [int] NULL,
	[jenis] [varchar](50) NULL,
	[metode] [varchar](50) NULL,
	[semester] [smallint] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[presensi_softskill]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[presensi_softskill](
	[id] [int] NULL,
	[STUDENTID] [varchar](50) NULL,
	[id_matkul] [int] NULL,
	[kehadiran] [int] NULL,
	[t_akademik] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[profil_dosen]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[profil_dosen](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_pegawai] [int] NULL,
	[no_rek] [varchar](20) NULL,
	[bank] [varchar](255) NULL,
	[cabang] [varchar](50) NULL,
	[nama_rekening] [varchar](255) NULL,
	[telepon] [varchar](14) NULL,
	[whatsapp] [varchar](14) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[softskill_mahasiswa]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[softskill_mahasiswa](
	[studentid] [varchar](15) NOT NULL,
	[termid] [varchar](5) NOT NULL,
	[thajaranid] [varchar](4) NOT NULL,
	[course_id] [varchar](15) NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_akademik_kurikulum]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_akademik_kurikulum](
	[id] [int] NULL,
	[t_akademik] [int] NULL,
	[id_kurikulum] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_pembicara]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_pembicara](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_kuliah_umum] [int] NOT NULL,
	[nama] [varchar](255) NULL,
	[jabatan] [varchar](255) NULL,
	[foto] [varchar](255) NULL,
	[instansi] [varchar](255) NULL,
	[tipe] [char](1) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](50) NULL,
	[password] [varchar](255) NULL,
	[email] [varchar](255) NULL,
	[telp] [varchar](14) NULL,
	[role] [int] NULL,
	[fullname] [varchar](255) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Kurikulum_Angkatan]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Kurikulum_Angkatan](
	[id] [smallint] IDENTITY(1,1) NOT NULL,
	[tahun] [smallint] NULL,
	[semester] [smallint] NULL,
	[angkatan] [smallint] NULL,
	[kurikulum] [varchar](20) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Kurikulum_Matakuliah_Softskill]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Kurikulum_Matakuliah_Softskill](
	[implemented_curriculum] [varchar](20) NULL,
	[course_id] [varchar](15) NULL,
	[aplied_sks] [decimal](4, 2) NULL,
	[study_level] [smallint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Kurikulum_Softskill]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Kurikulum_Softskill](
	[KURIKULUM_ID] [varchar](20) NULL,
	[NAME_OF_CURRICULUM] [varchar](200) NULL,
	[URUT] [smallint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Softskill]    Script Date: 23/10/2021 09:15:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Softskill](
	[course_id] [varchar](15) NULL,
	[name_of_course] [varchar](200) NULL
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[jadwal_softskill] ON 

INSERT [dbo].[jadwal_softskill] ([id], [id_matkul], [semester], [tanggal], [jam_mulai], [jam_selesai], [pembicara], [tempat], [t_akademik]) VALUES (3, N'PLTH2', 2, CAST(N'2021-09-26' AS Date), CAST(N'09:00:00' AS Time), CAST(N'11:00:00' AS Time), N'Pembicara 2', N'Gedung 2', 2021)
INSERT [dbo].[jadwal_softskill] ([id], [id_matkul], [semester], [tanggal], [jam_mulai], [jam_selesai], [pembicara], [tempat], [t_akademik]) VALUES (2, N'PLTH1', 2, CAST(N'2021-09-25' AS Date), CAST(N'08:45:00' AS Time), CAST(N'11:00:00' AS Time), N'Pembicara 1', N'Gedung 1', 2021)
SET IDENTITY_INSERT [dbo].[jadwal_softskill] OFF
GO
SET IDENTITY_INSERT [dbo].[kuliah_lapangan] ON 

INSERT [dbo].[kuliah_lapangan] ([id], [acara], [tanggal_start], [tanggal_end], [instansi], [tema], [id_praktikum], [tahun_ajaran], [semester]) VALUES (11, N'asdasasd', CAST(N'2021-10-13T16:18:00.0000000' AS DateTime2), CAST(N'2021-10-15T16:18:00.0000000' AS DateTime2), N'qeqweqweqwe', N'asdasd', N'GOV302P', 2021, 3)
SET IDENTITY_INSERT [dbo].[kuliah_lapangan] OFF
GO
SET IDENTITY_INSERT [dbo].[kuliah_umum] ON 

INSERT [dbo].[kuliah_umum] ([id], [tanggal], [jam_mulai], [jam_selesai], [tema], [id_praktikum], [tahun_ajaran], [semester], [tempat]) VALUES (12, CAST(N'2021-10-10' AS Date), CAST(N'14:00:00' AS Time), CAST(N'14:45:00' AS Time), N'tema', N'GOV302P', 2021, 3, N'LAB')
SET IDENTITY_INSERT [dbo].[kuliah_umum] OFF
GO
SET IDENTITY_INSERT [dbo].[laporan_praktikum_dosen] ON 

INSERT [dbo].[laporan_praktikum_dosen] ([id], [id_praktikum], [id_dosen], [tahun], [laporan_praktikum], [laporan_kuliah_umum], [laporan_kuliah_lapangan], [catatan1], [catatan2], [catatan3], [praktikum_selesai], [kuliah_umum_selesai], [kuliah_lapangan_selesai]) VALUES (3, N'GOV302P', N'1565', 2021, N'20211020091830.pdf', N'20211020091830.pdf', N'20211020094133.pdf', N'', N'', N'', N'1', N'1', N'1')
SET IDENTITY_INSERT [dbo].[laporan_praktikum_dosen] OFF
GO
SET IDENTITY_INSERT [dbo].[pembayaran] ON 

INSERT [dbo].[pembayaran] ([id], [tanggal], [file_bukti], [nominal], [id_dosen], [id_praktikum], [id_tahun], [jenis], [metode], [semester]) VALUES (8, CAST(N'2021-09-22' AS Date), N'20210921071828.png', 3000000, 1605, N'PEM402P', 2018, N'praktikum', N'transfer', 2)
INSERT [dbo].[pembayaran] ([id], [tanggal], [file_bukti], [nominal], [id_dosen], [id_praktikum], [id_tahun], [jenis], [metode], [semester]) VALUES (9, CAST(N'2021-09-14' AS Date), N'20210921071852.png', 2000000, 1605, N'PEM402P', 2018, N'kuliah-umum', N'tunai', 2)
INSERT [dbo].[pembayaran] ([id], [tanggal], [file_bukti], [nominal], [id_dosen], [id_praktikum], [id_tahun], [jenis], [metode], [semester]) VALUES (10, CAST(N'2021-09-15' AS Date), N'20210921071923.png', 2500000, 1605, N'PEM402P', 2018, N'kuliah-lapangan', N'transfer', 2)
SET IDENTITY_INSERT [dbo].[pembayaran] OFF
GO
SET IDENTITY_INSERT [dbo].[profil_dosen] ON 

INSERT [dbo].[profil_dosen] ([id], [id_pegawai], [no_rek], [bank], [cabang], [nama_rekening], [telepon], [whatsapp]) VALUES (1, 2781, N'12351312353453212', N'BCA', N'Solo', N'Kaleh Putro Setio Kusumo, Rd. , S.IP.', N'084275619631', N'089631834271')
INSERT [dbo].[profil_dosen] ([id], [id_pegawai], [no_rek], [bank], [cabang], [nama_rekening], [telepon], [whatsapp]) VALUES (4, 2932, N'36273654328457362185', N'Mandiri', N'Yogyakarta', N'Aditya Rahman Hafidz', N'089724531723', N'083459126742')
INSERT [dbo].[profil_dosen] ([id], [id_pegawai], [no_rek], [bank], [cabang], [nama_rekening], [telepon], [whatsapp]) VALUES (1002, 1605, N'23516836153189', N'BRI', N'Bantul', N'Dian Eka Rahmawati', NULL, NULL)
INSERT [dbo].[profil_dosen] ([id], [id_pegawai], [no_rek], [bank], [cabang], [nama_rekening], [telepon], [whatsapp]) VALUES (2002, 1565, N'097631235233', N'BRI', N'Solo', N'Bambang Eka Cahya Widodo', N'084527326432', N'084527326432')
SET IDENTITY_INSERT [dbo].[profil_dosen] OFF
GO
INSERT [dbo].[softskill_mahasiswa] ([studentid], [termid], [thajaranid], [course_id]) VALUES (N'20120520088', N'1', N'2013', N'SS003')
INSERT [dbo].[softskill_mahasiswa] ([studentid], [termid], [thajaranid], [course_id]) VALUES (N'20120520088', N'1', N'2014', N'SS005')
INSERT [dbo].[softskill_mahasiswa] ([studentid], [termid], [thajaranid], [course_id]) VALUES (N'20120520088', N'2', N'2013', N'SS004')
INSERT [dbo].[softskill_mahasiswa] ([studentid], [termid], [thajaranid], [course_id]) VALUES (N'20120520088', N'2', N'2014', N'SS006')
INSERT [dbo].[softskill_mahasiswa] ([studentid], [termid], [thajaranid], [course_id]) VALUES (N'20120520088', N'2', N'2014', N'SS007')
GO
SET IDENTITY_INSERT [dbo].[t_pembicara] ON 

INSERT [dbo].[t_pembicara] ([id], [id_kuliah_umum], [nama], [jabatan], [foto], [instansi], [tipe]) VALUES (18, 12, N'moderator', NULL, N'20211011085446.png', NULL, N'm')
INSERT [dbo].[t_pembicara] ([id], [id_kuliah_umum], [nama], [jabatan], [foto], [instansi], [tipe]) VALUES (19, 12, N'pem001', N'jabatan pembicara', N'20211011092337.png', N'instansi pembicara', N'p')
INSERT [dbo].[t_pembicara] ([id], [id_kuliah_umum], [nama], [jabatan], [foto], [instansi], [tipe]) VALUES (20, 12, N'sdassss', N'asdasd', N'20211011091146.png', N'asdasad', N'p')
INSERT [dbo].[t_pembicara] ([id], [id_kuliah_umum], [nama], [jabatan], [foto], [instansi], [tipe]) VALUES (2002, 12, N'asdasda', N'asdasasd', N'20211012092102.png', N'asdasdasd', N'p')
SET IDENTITY_INSERT [dbo].[t_pembicara] OFF
GO
SET IDENTITY_INSERT [dbo].[users] ON 

INSERT [dbo].[users] ([id], [username], [password], [email], [telp], [role], [fullname], [created_at], [updated_at]) VALUES (1, N'admin', N'$2a$12$qTLENPidPQiJsXkWTts.Je1DjVo9uR/JpV2SejMLJFE6ehfMLduOC', N'admin@admin.com', N'1234567', 1, N'admin', NULL, NULL)
SET IDENTITY_INSERT [dbo].[users] OFF
GO
SET IDENTITY_INSERT [dbo].[V_Kurikulum_Angkatan] ON 

INSERT [dbo].[V_Kurikulum_Angkatan] ([id], [tahun], [semester], [angkatan], [kurikulum]) VALUES (2, 2021, 1, 2021, N'SOFT-2019')
SET IDENTITY_INSERT [dbo].[V_Kurikulum_Angkatan] OFF
GO
INSERT [dbo].[V_Kurikulum_Matakuliah_Softskill] ([implemented_curriculum], [course_id], [aplied_sks], [study_level]) VALUES (N'SOFT-2019', N'SS001', NULL, 1)
GO
INSERT [dbo].[V_Kurikulum_Softskill] ([KURIKULUM_ID], [NAME_OF_CURRICULUM], [URUT]) VALUES (N'SOFT-2019', N'Softskill 2019', 1)
GO
INSERT [dbo].[V_Softskill] ([course_id], [name_of_course]) VALUES (N'PLTH1', N'Penulisan Karya Ilmiah')
INSERT [dbo].[V_Softskill] ([course_id], [name_of_course]) VALUES (N'PLTH2', N'Spiritual Leadership')
INSERT [dbo].[V_Softskill] ([course_id], [name_of_course]) VALUES (N'PLTH3', N'MICE (Meeting, Incentive, Conference & Exhibition)')
INSERT [dbo].[V_Softskill] ([course_id], [name_of_course]) VALUES (N'PLTH4', N'Team Work/Outbond')
GO
