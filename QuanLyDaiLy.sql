-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 28, 2019 lúc 05:52 AM
-- Phiên bản máy phục vụ: 10.1.26-MariaDB
-- Phiên bản PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `QuanLyDaiLy`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `BaoCao_CongNo` (IN `thang` TINYINT, IN `nam` SMALLINT)  NO SQL
select bb.TenDL,  NoDau, bb.PhatSinh, (select case when aa.NoDau <> 0 then aa.NoDau + bb.PhatSinh else bb.PhatSinh end) as NoCuoi from 
(select c.MaDL, (select case when e.tong2 <> 0 then c.tong1 - e.tong2 else c.tong1 end) as NoDau from (select d.MaDL, sum(p.ConLai) as tong1 from daily d, phieuxuat p where d.MaDL = p.MaDL and p.NgayLapPX < concat(nam,"-",thang,"-",01) and p.DeleteFlag = 0 and p.TinhTrang =1 and d.DeleteFlag = 0 group by d.MaDL) as c left join 
(select d.MaDL, sum(pt.SoTienThu) as tong2 from daily d, phieuthu pt where d.MaDL = pt.MaDL and pt.NgayThuTien < concat(nam,"-",thang,"-",01) and d.DeleteFlag = 0 and pt.DeleteFlag = 0  group by d.MaDL) as e on c.MaDL = e.MaDL) as aa
right join
(select a.MaDL, a.TenDL, (select case when b.tong2 <> 0 then a.tong1 - b.tong2 else a.tong1 end) as PhatSinh from (select d.MaDL, d.TenDL, sum(p.ConLai) as tong1 from daily d, phieuxuat p where d.MaDL = p.MaDL and month(p.NgayLapPX) = thang and year(p.NgayLapPX)= nam and p.DeleteFlag = 0 and p.TinhTrang =1 and d.DeleteFlag = 0 group by d.MaDL) as a left join 
(select d.MaDL, sum(pt.SoTienThu) as tong2 from daily d, phieuthu pt where d.MaDL = pt.MaDL and month(pt.NgayThuTien) = thang and year(pt.NgayThuTien)= nam and d.DeleteFlag = 0 and pt.DeleteFlag = 0 group by d.MaDL) as b on a.MaDL = b.MaDL) as bb
on aa.MaDL = bb.MaDL$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BaoCao_DoanhSo` (IN `thang` SMALLINT, OUT `tong` FLOAT, IN `nam` SMALLINT)  NO SQL
begin
select sum(sum1.tongTriGia) into tong from (select SUM(p.TongTien) as tongTriGia from daily d, phieuxuat p where d.MaDL = p.MaDL and p.TinhTrang =1 and p.DeleteFlag = 0 and d.DeleteFlag=0 and month(p.NgayLapPX) = thang and year(p.NgayLapPX) = nam group by d.TenDL) as sum1;
select d.TenDL, count(MaPX) as soPhieuXuat, SUM(p.TongTien) as tongTriGia,
SUM(p.TongTien)/tong as tiLe from daily d, phieuxuat p where d.MaDL = p.MaDL and p.TinhTrang =1 and p.DeleteFlag = 0 and d.DeleteFlag=0 and month(p.NgayLapPX) = thang and year(p.NgayLapPX) = nam
group by d.TenDL;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_CTPhieuXuat` (IN `idPX` SMALLINT(6), IN `idMH` VARCHAR(10))  delete from ctphieuxuat where MaPX = idPX and MaMH = idMH$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Daily` (IN `iddl` VARCHAR(10))  BEGIN
  Update `bk_daily`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaDL` like `iddl`;

  UPDATE `daily` 
  SET `DeleteFlag` = 1
  WHERE `MaDL` like `iddl`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_DonVi` (IN `iddonvi` SMALLINT(6))  BEGIN
  Update `bk_donvi`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaDonVi` = `iddonvi`;

  UPDATE `donvi` 
  SET `DeleteFlag` = 1
  WHERE `MaDonVi` = `iddonvi`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_LoaiDaily` (IN `id` SMALLINT)  BEGIN
  Update bk_loaidaily
  SET
    deleteTime = NOW()
  WHERE 
    MaLoaiDL = id;
  UPDATE loaidaily 
  SET DeleteFlag = 1
  WHERE MaLoaiDL = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_LoaiUser` (IN `idloaiuser` SMALLINT(6))  BEGIN
  Update `bk_loaiuser`
  SET `End` = NOW(), 
    `deleteTime` = NOW()
  WHERE 
    `MaLoaiUser` = `idloaiuser`;

  UPDATE `loaiuser` 
  SET `DeleteFlag` = 1,
   `End` = Now()
  WHERE `MaLoaiUser` = `idloaiuser`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_MatHang` (IN `idmh` VARCHAR(10))  BEGIN
  Update `bk_mathang`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaMH` like `idmh`;

  UPDATE `mathang` 
  SET `DeleteFlag` = 1
  WHERE `MaMH` like `idmh`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_PhieuDaXuat` (IN `idpx` SMALLINT(6))  BEGIN
  DECLARE `maDaiLy` varchar(10);
  DECLARE `tienNoCu` float;
  SELECT `MaDL` into `maDaiLy` FROM  `phieuxuat` WHERE `MaPX` = `idpx`;
  SELECT `ConLai` into `tienNoCu` FROM `phieuxuat` WHERE `MaPX` = `idpx`;
  
  Update `daily`
  SET `TienNo` = `TienNo` - `tienNoCu`
  WHERE
    `MaDL` = `maDaiLy`;

  Update `bk_phieuxuat`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaPX` = `idpx`;

  UPDATE `phieuxuat` 
  SET `DeleteFlag` = 1
  WHERE `MaPX` = `idpx`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_PhieuThu` (IN `id` SMALLINT(6), IN `idDL` VARCHAR(10))  BEGIN
	DECLARE nocu float;
    DECLARE tienthucu float;
    select  TienNo into nocu from daily where MaDL = idDL; 
    select SoTienThu into tienthucu from phieuthu where MaPT=id;
    update daily set TienNo = nocu + tienthucu where MaDL = idDL;
  Update `bk_phieuthu`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaPT` = `id`;

  UPDATE `phieuthu` 
  SET `DeleteFlag` = 1
  WHERE `MaPT` = `id`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_PhieuXuat` (IN `idPX` SMALLINT)  NO SQL
BEGIN
  UPDATE `phieuxuat` 
  SET `DeleteFlag` = 1
  WHERE `MaPX` = `idPX`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Quan` (IN `idquan` SMALLINT(6))  BEGIN
  Update `bk_quan`
  SET
    `deleteTime` = NOW()
  WHERE 
    `MaQuan` = `idquan`;

  UPDATE `quan` 
  SET `DeleteFlag` = 1
  WHERE `MaQuan` = `idquan`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_TaiKhoan` (IN `idusername` VARCHAR(128))  BEGIN
  Update `bk_taikhoan`
  SET `End` = NOW(), 
    `deleteTime` = NOW()
  WHERE 
    `UserName` = `idusename`;

  UPDATE `taikhoan` 
  SET `DeleteFlag` = 1,
   `End` = Now()
  WHERE `UserName` = `idusename`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_CTPhieuXuat` (IN `idPX` SMALLINT, IN `idMH` VARCHAR(10), IN `soluong` MEDIUMINT)  BEGIN
INSERT INTO ctphieuxuat(MaPX, MaMH, SoLuong) VALUES (idPX,idMH,soluong);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_DaiLy` (IN `tenDL` VARCHAR(50), IN `idLoaiDL` SMALLINT, IN `dienThoai` VARCHAR(20), IN `diaChi` VARCHAR(100), IN `idQuan` SMALLINT)  BEGIN
INSERT INTO daily(MaDL, TenDL, MaLoaiDL, DienThoai, DiaChi, MaQuan, NgayTiepNhan) VALUES (Auto_idDL(), tenDL, idLoaiDL, dienThoai, diaChi, idQuan, NOW());
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_DonVi` (IN `tenDV` VARCHAR(30))  BEGIN
INSERT INTO `donvi`(`TenDonVi`,End) VALUES (tenDV,NOW() + INTERVAL 10 year);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_LoaiDaiLy` (IN `tenLoaiDL` VARCHAR(20), IN `duocPhep` FLOAT)  BEGIN
INSERT INTO loaidaily(TenLoaiDL,TienNoToiDa,End) VALUES (tenLoaiDL,duocPhep, NOW() + INTERVAL 10 year);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_MatHang` (IN `tenMH` VARCHAR(30), IN `anhMH` VARCHAR(50), IN `maDonVi` SMALLINT, IN `gia` FLOAT)  BEGIN
INSERT INTO mathang(MaMH, TenMH,AnhMH,MaDonVi,Gia,End) VALUES (Auto_IdMH(),tenMH,anhMH,maDonVi,gia,NOW() + INTERVAL 10 year);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_PhieuThu` (IN `idDL` VARCHAR(10), IN `tienThu` FLOAT)  BEGIN
insert into phieuthu(MaDL,SoTienThu,NgayThuTien,End) values(idDL,tienThu,NOW(),NOW() + INTERVAL 10 year);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_PhieuXuat` (IN `idDL` VARCHAR(10))  BEGIN
INSERT INTO phieuxuat(NgayLapPX, MaDL) VALUES (NOW(),idDL);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Quan` (IN `tenQuan` VARCHAR(20))  BEGIN
INSERT INTO quan(TenQuan) VALUES (tenQuan);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PhucHoi_DaiLy` (IN `id` VARCHAR(10))  NO SQL
update daily set DeleteFlag = 0 where MaDL = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PhucHoi_MatHang` (IN `id` VARCHAR(10))  NO SQL
update mathang set DeleteFlag = 0 where MaMH = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PhucHoi_PhieuThu` (IN `id` SMALLINT, IN `idDL` VARCHAR(10))  NO SQL
BEGIN
	DECLARE nocu float;
    DECLARE tienthucu float;
    select  TienNo into nocu from daily where MaDL = idDL; 
    select SoTienThu into tienthucu from phieuthu where MaPT=id;
    update daily set TienNo = nocu - tienthucu where MaDL = idDL;
  UPDATE `phieuthu` 
  SET `DeleteFlag` = 0
  WHERE `MaPT` = `id`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PhucHoi_PhieuXuat` (IN `idpx` SMALLINT)  NO SQL
BEGIN
  DECLARE `maDaiLy` varchar(10);
  DECLARE `tienNoCu` float;
  SELECT `MaDL` into `maDaiLy` FROM  `phieuxuat` WHERE `MaPX` = `idpx`;
  SELECT `ConLai` into `tienNoCu` FROM `phieuxuat` WHERE `MaPX` = `idpx`;
  
  Update `daily`
  SET `TienNo` = `TienNo` + `tienNoCu`
  WHERE
    `MaDL` = `maDaiLy`;

  UPDATE `phieuxuat` 
  SET `DeleteFlag` = 0
  WHERE `MaPX` = `idpx`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_DaiLy` ()  BEGIN
	select * from daily d, loaidaily l, quan q where m.MaDonVi = d.MaDonVi and d.MaQuan = q.MaQuan and DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_DonVi` ()  BEGIN
	select * from donvi where DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_LoaiDL` ()  BEGIN
	select * from loaidaily where DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_MatHang` ()  BEGIN
	select * from mathang m, donvi d where m.MaDonVi = d.MaDonVi and DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_PhieuThu` ()  BEGIN
	select p.*,d.MaDL, TenDL,DienThoai,DiaChi from daily d, phieuthu p  where d.MaDL = p.MaDL and p.DeleteFlag =0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_PhieuXuat_ChuaXuat` ()  BEGIN
	select * from phieuxuat where DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_PhieuXuat_DaXuat` ()  BEGIN
	select * from phieuxuat WHERE DeleteFlag = 0 and tinhtrang = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_Quan` ()  BEGIN
	select * from quan where DeleteFlag = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_CTPhieuXuat` (IN `idPX` SMALLINT, IN `idMH` VARCHAR(10), IN `sl` MEDIUMINT)  NO SQL
BEGIN
update ctphieuxuat set SoLuong = SoLuong + sl where MaPX = idPX and MaMH = idMH;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_DaiLy` (IN `id` VARCHAR(10), IN `tenDL` VARCHAR(50), IN `idLoaiDL` SMALLINT, IN `dienThoai` VARCHAR(20), IN `diaChi` VARCHAR(100), IN `idQuan` SMALLINT)  BEGIN
update daily set TenDL = tenDL, MaLoaiDL = idLoaiDL, DienThoai = dienThoai, DiaChi = diaChi, MaQuan = idQuan where MaDL = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_DonVi` (IN `id` SMALLINT, IN `tenDV` VARCHAR(30))  BEGIN
update donvi set TenDonVi = tenDV where MaDonVi = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_LoaiDL` (IN `id` SMALLINT, IN `tenLoaiDL` VARCHAR(20), IN `duocPhep` FLOAT)  BEGIN
update loaidaily set TenLoaiDL = tenLoaiDL, TienNoToiDa = duocPhep where MaLoaiDL = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_MatHang` (IN `id` VARCHAR(10), IN `tenMH` VARCHAR(30), IN `AnhMH` VARCHAR(50), IN `idDV` SMALLINT, IN `gia` FLOAT)  BEGIN
update mathang set TenMH = TenMH, AnhMH = anhMH, MaDonVi = idDV, Gia = gia where MaMH = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Phieuthu` (IN `id` SMALLINT, IN `tienthuNew` FLOAT, IN `idDL` VARCHAR(10))  BEGIN
	DECLARE nocu float;
    DECLARE tienthucu float;
    select  TienNo into nocu from daily where MaDL = idDL; 
    select SoTienThu into tienthucu from phieuthu where MaPT=id;
    update daily set TienNo = tienthucu - tienthuNew + nocu where MaDL = idDL;
    update phieuthu set SoTienThu = tienthuNew where MaPT = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_PhieuXuat` (IN `id` SMALLINT, IN `status` BOOLEAN, IN `idDL` VARCHAR(10))  BEGIN
	DECLARE cl float;
    select ConLai into cl from phieuxuat WHERE MaPX = id;
	update daily set TienNo = TienNo - cl where MaDL = idDL;
	update phieuxuat set TinhTrang= status,TienTra = 0,ConLai =0, TongTien = 0, End = NOW() + INTERVAL 10 year where MaPX = id;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Quan` (IN `id` SMALLINT, IN `tenQuan` VARCHAR(20))  BEGIN
update quan set TenQuan = tenQuan where MaQuan = id and DeleteFlag=0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_ThamSo` (IN `id` SMALLINT, IN `giaTri` FLOAT)  NO SQL
update thamso set GiaTri = giaTri where MaTS = id$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Auto_IdDL` () RETURNS VARCHAR(10) CHARSET utf8 BEGIN
	DECLARE id VARCHAR(10);
    DECLARE dem tinyint;
    SELECT COUNT(MaDL) into dem FROM daily;
	IF dem = 0 then
		set id = 'DL00000001';
	ELSE
		SELECT MAX(RIGHT(MaDL, 8)) into id FROM daily;
		SELECT
        CASE
			WHEN id >= 0 and id < 9 THEN concat('DL0000000', CONVERT(CONVERT(id,int) + 1,CHAR))
			WHEN id >= 9 and id < 99 THEN concat('DL000000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 99 and id <999 THEN concat('DL00000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 999 and id <9999 THEN concat('DL0000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 9999 and id < 99999 THEN concat('DL000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 99999 and id < 999999 THEN concat('DL00', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 999999 and id < 9999999 THEN concat('DL0', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 9999999 THEN concat('DL', CONVERT(CONVERT(id, int) + 1, CHAR))
		END into id;
    END IF;
	RETURN id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Auto_IdMH` () RETURNS VARCHAR(10) CHARSET utf8 BEGIN
	DECLARE id VARCHAR(10);
    DECLARE dem tinyint;
    SELECT COUNT(MaMH) into dem FROM mathang;
	IF dem = 0 then
		set id = 'MH00000001';
	ELSE
		SELECT MAX(RIGHT(MaMH, 8)) into id FROM mathang;
		SELECT
        CASE
			WHEN id >= 0 and id < 9 THEN concat('MH0000000', CONVERT(CONVERT(id,int) + 1,CHAR))
			WHEN id >= 9 and id < 99 THEN concat('MH000000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 99 and id <999 THEN concat('MH00000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 999 and id <9999 THEN concat('MH0000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 9999 and id < 99999 THEN concat('MH000', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 99999 and id < 999999 THEN concat('MH00', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 999999 and id < 9999999 THEN concat('MH0', CONVERT(CONVERT(id, int) + 1, CHAR))
            WHEN id >= 9999999 THEN concat('MH', CONVERT(CONVERT(id, int) + 1, CHAR))
		END into id;
    END IF;
	RETURN id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_ctphieuxuat`
--

CREATE TABLE `bk_ctphieuxuat` (
  `MaCTPX` smallint(6) NOT NULL,
  `MaPX` smallint(6) NOT NULL,
  `MaMH` varchar(10) NOT NULL,
  `SoLuong` mediumint(9) DEFAULT '0',
  `GiaMH` float DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_daily`
--

CREATE TABLE `bk_daily` (
  `MaDL` varchar(10) NOT NULL,
  `TenDL` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaLoaiDL` smallint(6) NOT NULL,
  `DienThoai` varchar(20) NOT NULL,
  `DiaChi` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaQuan` smallint(6) DEFAULT NULL,
  `NgayTiepNhan` datetime DEFAULT NULL,
  `TienNo` float DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_daily`
--

INSERT INTO `bk_daily` (`MaDL`, `TenDL`, `MaLoaiDL`, `DienThoai`, `DiaChi`, `MaQuan`, `NgayTiepNhan`, `TienNo`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
('DL00000001', 'Thong123', 5, '123456789', 'Binh Thạch', 16, '2019-05-23 00:51:20', 800000, '2019-05-23 00:51:20', '2029-05-23 00:51:20', '2019-05-28 10:33:19', '2019-05-23 01:13:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_donvi`
--

CREATE TABLE `bk_donvi` (
  `MaDonVi` smallint(6) NOT NULL,
  `TenDonVi` varchar(30) NOT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_donvi`
--

INSERT INTO `bk_donvi` (`MaDonVi`, `TenDonVi`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(6, 'Cái', '2019-05-23 00:53:17', '2029-05-23 00:53:17', NULL, NULL),
(7, 'Thùng', '2019-05-23 00:53:34', '2029-05-23 00:53:34', NULL, NULL),
(8, 'Bịch', '2019-05-23 00:53:41', '2029-05-23 00:53:41', NULL, NULL),
(9, 'Hộp', '2019-05-23 00:53:50', '2029-05-23 00:53:50', NULL, NULL),
(10, 'Chiếc', '2019-05-23 00:54:11', '2029-05-23 00:54:11', NULL, NULL),
(11, 'abc', '2019-05-23 00:54:18', '2029-05-23 00:54:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_loaidaily`
--

CREATE TABLE `bk_loaidaily` (
  `MaLoaiDL` smallint(6) NOT NULL,
  `TenLoaiDL` varchar(20) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `TienNo` float DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_loaidaily`
--

INSERT INTO `bk_loaidaily` (`MaLoaiDL`, `TenLoaiDL`, `TienNo`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(5, 'DL 1', 0, '2019-05-23 00:46:36', '2029-05-23 00:46:36', NULL, NULL),
(6, 'Dl 2', 0, '2019-05-23 00:47:12', '2029-05-23 00:47:12', NULL, NULL),
(7, 'Vàng', 0, '2019-05-23 00:47:59', '2029-05-23 00:47:59', NULL, NULL),
(8, 'Bạc', 0, '2019-05-23 00:48:16', '2029-05-23 00:48:16', NULL, NULL),
(9, 'siêu cấp', 0, '2019-05-23 00:48:35', '2029-05-23 00:48:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_loaiuser`
--

CREATE TABLE `bk_loaiuser` (
  `MaLoaiUser` smallint(6) NOT NULL,
  `TenLoaiUser` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_loaiuser`
--

INSERT INTO `bk_loaiuser` (`MaLoaiUser`, `TenLoaiUser`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(9, '', '2019-05-23 01:09:21', '2029-05-23 01:09:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_mathang`
--

CREATE TABLE `bk_mathang` (
  `MaMH` varchar(10) NOT NULL,
  `TenMH` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `AnhMH` varchar(50) DEFAULT NULL,
  `MaDonVi` smallint(6) NOT NULL,
  `Gia` float DEFAULT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_mathang`
--

INSERT INTO `bk_mathang` (`MaMH`, `TenMH`, `AnhMH`, `MaDonVi`, `Gia`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
('MH00000001', '123', 'upload/', 6, 1000000, '2019-05-23 00:55:37', '2029-05-23 00:55:37', '2020-05-28 10:21:15', '2019-05-28 10:21:15'),
('MH00000002', 'abc', 'upload/', 6, 2000000, '2019-05-23 00:55:58', '2029-05-23 00:55:58', NULL, NULL),
('MH00000003', '456', 'upload/', 6, 1234, '2019-05-23 00:56:11', '2029-05-23 00:56:11', NULL, NULL),
('MH00000004', '789', 'upload/', 6, 123, '2019-05-23 00:56:20', '2029-05-23 00:56:20', '2020-05-28 10:09:11', '2019-05-28 10:09:11'),
('MH00000005', 'Kem', 'img/', 6, 5678, '2019-05-23 00:56:33', '2029-05-23 00:56:33', '2020-05-23 00:57:02', '2019-05-23 00:57:02'),
('MH00000006', 'abcd', 'upload/livingroom.jpg', 6, 12345600, '2019-05-28 10:10:30', '2029-05-28 10:10:30', '2020-05-28 10:10:53', '2019-05-28 10:10:53'),
('MH00000007', 'abcd', 'upload/livingroom.jpg', 6, 123456, '2019-05-28 10:11:24', '2029-05-28 10:11:24', '2020-05-28 10:12:08', '2019-05-28 10:12:08'),
('MH00000008', 'abc2345678', 'upload/', 6, -12345700, '2019-05-28 10:12:32', '2029-05-28 10:12:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_phieuthu`
--

CREATE TABLE `bk_phieuthu` (
  `MaPT` smallint(6) NOT NULL,
  `MaDL` varchar(10) NOT NULL,
  `SoTienThu` float DEFAULT '0',
  `NgayThuTien` datetime NOT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_phieuthu`
--

INSERT INTO `bk_phieuthu` (`MaPT`, `MaDL`, `SoTienThu`, `NgayThuTien`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(8, 'DL00000001', 200000, '2019-05-23 01:00:45', '2019-05-23 01:00:45', '2029-05-23 01:00:45', NULL, '2019-05-23 01:01:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_phieuxuat`
--

CREATE TABLE `bk_phieuxuat` (
  `MaPX` smallint(6) NOT NULL,
  `NgayLapPX` datetime NOT NULL,
  `MaDL` varchar(10) NOT NULL,
  `TongTien` float DEFAULT '0',
  `ConLai` float DEFAULT '0',
  `TienTra` float DEFAULT '0',
  `TinhTrang` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_phieuxuat`
--

INSERT INTO `bk_phieuxuat` (`MaPX`, `NgayLapPX`, `MaDL`, `TongTien`, `ConLai`, `TienTra`, `TinhTrang`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(7, '2019-05-23 00:59:30', 'DL00000001', 1056780, 1000000, 56780, 1, '2019-05-23 01:00:01', '2029-05-23 01:00:01', '2020-05-23 00:59:39', '2019-05-23 00:59:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_quan`
--

CREATE TABLE `bk_quan` (
  `MaQuan` smallint(6) NOT NULL,
  `TenQuan` varchar(20) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bk_quan`
--

INSERT INTO `bk_quan` (`MaQuan`, `TenQuan`, `Start`, `End`, `BackUp`, `deleteTime`) VALUES
(16, 'Quận 1 ', '2019-05-23 00:49:13', '2029-05-23 00:49:13', NULL, NULL),
(17, 'Quận 2', '2019-05-23 00:49:28', '2029-05-23 00:49:28', NULL, NULL),
(18, 'Quận 3', '2019-05-23 00:49:38', '2029-05-23 00:49:38', NULL, NULL),
(19, 'Quận 4', '2019-05-23 00:50:25', '2029-05-23 00:50:25', NULL, NULL),
(20, 'Quận 5', '2019-05-23 01:10:27', '2029-05-23 01:10:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bk_taikhoan`
--

CREATE TABLE `bk_taikhoan` (
  `UserName` varchar(128) NOT NULL,
  `Pass` varchar(128) NOT NULL,
  `DisplayName` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaLoaiUser` smallint(6) NOT NULL,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `BackUp` datetime DEFAULT NULL,
  `deleteTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ctphieuxuat`
--

CREATE TABLE `ctphieuxuat` (
  `MaPX` smallint(6) NOT NULL,
  `MaMH` varchar(10) NOT NULL,
  `GiaMH` float DEFAULT NULL,
  `SoLuong` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `ctphieuxuat`
--

INSERT INTO `ctphieuxuat` (`MaPX`, `MaMH`, `GiaMH`, `SoLuong`) VALUES
(7, 'MH00000001', NULL, 1),
(7, 'MH00000005', NULL, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `daily`
--

CREATE TABLE `daily` (
  `MaDL` varchar(10) NOT NULL,
  `TenDL` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaLoaiDL` smallint(6) NOT NULL,
  `DienThoai` varchar(20) NOT NULL,
  `DiaChi` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaQuan` smallint(6) DEFAULT NULL,
  `NgayTiepNhan` datetime DEFAULT NULL,
  `TienNo` float DEFAULT '0',
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `daily`
--

INSERT INTO `daily` (`MaDL`, `TenDL`, `MaLoaiDL`, `DienThoai`, `DiaChi`, `MaQuan`, `NgayTiepNhan`, `TienNo`, `DeleteFlag`, `Start`, `End`) VALUES
('DL00000001', 'Thong123', 5, '123456789', 'Binh Thạch', 16, '2019-05-23 00:51:20', 800000, 0, '2019-05-23 00:51:20', NULL);

--
-- Bẫy `daily`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_DaiLy` AFTER INSERT ON `daily` FOR EACH ROW BEGIN
  INSERT INTO `bk_daily`
  SET `MaDL` = NEW.`MaDL`, 
    `TenDL` = NEW.`TenDL`,
    `MaLoaiDL` = NEW.`MaLoaiDL`,
    `DienThoai` = NEW.`DienThoai`,
    `DiaChi` = NEW.`DiaChi`,
    `MaQuan` = NEW.`MaQuan`,
    `NgayTiepNhan` = NEW.`NgayTiepNhan`,
    `TienNo` = NEW.`TienNo`,
    `Start` = NOW(),
     End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_DaiLy` BEFORE INSERT ON `daily` FOR EACH ROW BEGIN
  SET 
    New.`Start` = NOW(),
    New.`DeleteFlag` = 0;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_DaiLy` AFTER UPDATE ON `daily` FOR EACH ROW BEGIN
  Update `bk_daily`
  SET `TenDL` = NEW.`TenDL`,
    `MaLoaiDL` = NEW.`MaLoaiDL`,
    `DienThoai` = NEW.`DienThoai`,
    `DiaChi` = NEW.`DiaChi`,
    `MaQuan` = NEW.`MaQuan`,
    `TienNo`= NEW.`TienNo`,
    `NgayTiepNhan` = NEW.`NgayTiepNhan`,
    `BackUp` = NOW()
  WHERE 
    `MaDL` = OLD.`MaDL`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donvi`
--

CREATE TABLE `donvi` (
  `MaDonVi` smallint(6) NOT NULL,
  `TenDonVi` varchar(30) NOT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `donvi`
--

INSERT INTO `donvi` (`MaDonVi`, `TenDonVi`, `DeleteFlag`, `Start`, `End`) VALUES
(6, 'Cái', 0, '2019-05-23 00:53:17', '2029-05-23 00:53:17'),
(7, 'Thùng', 0, '2019-05-23 00:53:34', '2029-05-23 00:53:34'),
(8, 'Bịch', 0, '2019-05-23 00:53:41', '2029-05-23 00:53:41'),
(9, 'Hộp', 0, '2019-05-23 00:53:50', '2029-05-23 00:53:50'),
(10, 'Chiếc', 0, '2019-05-23 00:54:11', '2029-05-23 00:54:11'),
(11, 'abc', 0, '2019-05-23 00:54:18', '2029-05-23 00:54:18');

--
-- Bẫy `donvi`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_DonVi` AFTER INSERT ON `donvi` FOR EACH ROW BEGIN
  INSERT INTO `bk_donvi`
  SET `MaDonVi` = NEW.`MaDonVi`, 
    `TenDonVi` = NEW.`TenDonVi`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_DonVi` BEFORE INSERT ON `donvi` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_DonVi` AFTER UPDATE ON `donvi` FOR EACH ROW BEGIN
  if NEW.`DeleteFlag` = 1 then
  Update `bk_donvi`
  SET 
    `deleteTime` = NOW(),
    `BackUp` = NOW() + INTERVAL 1 year
  WHERE 
    `MaDonVi` = OLD.`MaDonVi`;
  ELSE
  Update `bk_donvi`
  SET `TenDonVi` = NEW.`TenDonVi`
  WHERE 
    `MaDonVi` = OLD.`MaDonVi`;
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaidaily`
--

CREATE TABLE `loaidaily` (
  `MaLoaiDL` smallint(6) NOT NULL,
  `TenLoaiDL` varchar(20) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `TienNoToiDa` float NOT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loaidaily`
--

INSERT INTO `loaidaily` (`MaLoaiDL`, `TenLoaiDL`, `TienNoToiDa`, `DeleteFlag`, `Start`, `End`) VALUES
(5, 'DL 1', 1000000, 0, '2019-05-23 00:46:36', '2029-05-23 00:46:36'),
(6, 'Dl 2', 5000000, 0, '2019-05-23 00:47:12', '2029-05-23 00:47:12'),
(7, 'Vàng', 10000000, 0, '2019-05-23 00:47:59', '2029-05-23 00:47:59'),
(8, 'Bạc', 8000000, 0, '2019-05-23 00:48:16', '2029-05-23 00:48:16'),
(9, 'siêu cấp', 15000000, 0, '2019-05-23 00:48:35', '2029-05-23 00:48:35');

--
-- Bẫy `loaidaily`phieu
--
DELIMITER $$
CREATE TRIGGER `Insert_A_LoaiDaiLy` AFTER INSERT ON `loaidaily` FOR EACH ROW BEGIN
  INSERT INTO `bk_loaidaily`
  SET `MaLoaiDL` = NEW.`MaLoaiDL`, 
    `TenLoaiDL` = NEW.`TenLoaiDL`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_LoaiDaiLy` BEFORE INSERT ON `loaidaily` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_LoaiDaily` AFTER UPDATE ON `loaidaily` FOR EACH ROW BEGIN
  if NEW.`DeleteFlag` = 1 then
  update `bk_loaidaily`
  set `deleteTime` = NOW(),
       `BackUp` = NOW() + INTERVAL 1 year
         WHERE 
    `MaLoaiDL` = OLD.`MaLoaiDL`;
  else
  Update `bk_loaidaily`
  SET `TenLoaiDL` = NEW.`TenLoaiDL`
  WHERE 
    `MaLoaiDL` = OLD.`MaLoaiDL`;
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaiuser`
--

CREATE TABLE `loaiuser` (
  `MaLoaiUser` smallint(6) NOT NULL,
  `TenLoaiUser` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Role` varchar(1100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loaiuser`
--

INSERT INTO `loaiuser` (`MaLoaiUser`, `TenLoaiUser`, `Role`, `DeleteFlag`, `Start`, `End`) VALUES
(7, 'culi', 'Danh Mục Đại Lý/index.php?controller=dai-ly, Loại Đại Lý - Quận/index.php?controller=loai-dai-ly,Danh Mục Mặt Hàng/index.php?controller=mat-hang,Danh Mục Phiếu Xuất/index.php?controller=phieu-xuat,Danh Mục Phiếu Thu/index.php?controller=phieu-thu,Thêm Mặt Hàng Vào Phiếu/index.php?controller=them-mat-hang,Danh Mục Đơn Vị Tính/index.php?controller=don-vi,Danh Mục Phiếu Đã Xuất/index.php?controller=phieu-da-xuat,Phục Hồi Đại Lý/index.php?controller=ph-dai-ly,Qui Định/index.php?controller=qui-dinh,', 0, '2019-05-05 14:53:27', NULL),
(8, 'admin', 'Danh Mục Đại Lý/index.php?controller=dai-ly, Loại Đại Lý - Quận/index.php?controller=loai-dai-ly,Danh Mục Mặt Hàng/index.php?controller=mat-hang,Danh Mục Phiếu Xuất/index.php?controller=phieu-xuat,Danh Mục Phiếu Thu/index.php?controller=phieu-thu,Danh Mục Phiếu Thu Đã Tạo/index.php?controller=phieu-thu-da-lap,Thêm Mặt Hàng Vào Phiếu/index.php?controller=them-mat-hang,Danh Mục Đơn Vị Tính/index.php?controller=don-vi,Danh Mục Phiếu Đã Xuất/index.php?controller=phieu-da-xuat,Chi Tiết Phiếu Đã Xuất/index.php?controller=ct-phieu-da-xuat,Báo Cáo Doanh Số/index.php?controller=bao-cao-doanh-so,Báo Cáo Công Nợ/index.php?controller=bao-cao-cong-no,Phục Hồi Đại Lý/index.php?controller=ph-dai-ly,Phục Hồi Mặt Hàng/index.php?controller=ph-mat-hang,Phục Hồi Phiếu Xuất/index.php?controller=ph-phieu-xuat,Phục Hồi Phiếu Thu/index.php?controller=ph-phieu-thu,Quản Lý Tài Khoản/index.php?controller=tai-khoan,Thêm Loại Tài Khoản/index.php?controller=loai-tai-khoan,Sửa Loại Tài Khoản/index.php?controller=sua-loaitk,Lịch Sử Đăng Nhập/index.php?controller=lich-su,Qui Định/index.php?controller=qui-dinh,', 0, '2019-05-05 23:00:01', NULL),
(9, '', 'Qui Định/index.php?controller=qui-dinh,', 0, '2019-05-23 01:09:21', '2029-05-23 01:09:21');

--
-- Bẫy `loaiuser`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_LoaiUser` AFTER INSERT ON `loaiuser` FOR EACH ROW BEGIN
  INSERT INTO `bk_loaiuser`
  SET `MaLoaiUser` = NEW.`MaLoaiUser`, 
    `TenLoaiUser` = NEW.`TenLoaiUser`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_LoaiUser` BEFORE INSERT ON `loaiuser` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_LoaiUser` AFTER UPDATE ON `loaiuser` FOR EACH ROW BEGIN
if NEW.DeleteFlag = 1 THEN
  Update `bk_loaiuser`
  SET
    `BackUp` = NOW() + INTERVAL 1 year,
    `deleteTime` = NOW()
  WHERE 
    `MaLoaiUser` = OLD.`MaLoaiUser`;
else
  Update `bk_loaiuser`
  SET `TenLoaiUser` = NEW.`TenLoaiUser`
  WHERE 
    `MaLoaiUser` = OLD.`MaLoaiUser`;
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mathang`
--

CREATE TABLE `mathang` (
  `MaMH` varchar(10) NOT NULL,
  `TenMH` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `AnhMH` varchar(50) DEFAULT NULL,
  `MaDonVi` smallint(6) NOT NULL,
  `Gia` float NOT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `mathang`
--

INSERT INTO `mathang` (`MaMH`, `TenMH`, `AnhMH`, `MaDonVi`, `Gia`, `DeleteFlag`, `Start`, `End`) VALUES
('MH00000001', '123', 'upload/', 6, 1000000, 1, '2019-05-23 00:55:37', '2029-05-23 00:55:37'),
('MH00000002', 'abc', 'upload/', 6, 2000000, 0, '2019-05-23 00:55:58', '2029-05-23 00:55:58'),
('MH00000003', '456', 'upload/', 6, 1234, 0, '2019-05-23 00:56:11', '2029-05-23 00:56:11'),
('MH00000004', '789', 'upload/', 6, 123, 1, '2019-05-23 00:56:20', '2029-05-23 00:56:20'),
('MH00000005', 'Kem', 'img/', 6, 5678, 0, '2019-05-23 00:56:33', '2029-05-23 00:56:33'),
('MH00000006', 'abcd', 'upload/livingroom.jpg', 6, 12345600, 0, '2019-05-28 10:10:30', '2029-05-28 10:10:30'),
('MH00000007', 'abcd', 'upload/livingroom.jpg', 6, 123456, 1, '2019-05-28 10:11:24', '2029-05-28 10:11:24'),
('MH00000008', 'abc2345678', 'upload/', 6, -12345700, 0, '2019-05-28 10:12:32', '2029-05-28 10:12:32');

--
-- Bẫy `mathang`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_MatHang` AFTER INSERT ON `mathang` FOR EACH ROW BEGIN
  INSERT INTO `bk_mathang`
  SET `MaMH` = NEW.`MaMH`, 
    `TenMH` = NEW.`TenMH`,
    `AnhMH` = NEW.`AnhMH`,
    `MaDonVi` = NEW.`MaDonVi`,
    `Gia` = NEW.`Gia`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_MatHang` BEFORE INSERT ON `mathang` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_MatHang` AFTER UPDATE ON `mathang` FOR EACH ROW BEGIN
 if NEW.DeleteFlag =1 THEN
  Update `bk_mathang`
 SET
   `BackUp` = NOW() + INTERVAL 1 year,
    `deleteTime` = NOW()
 WHERE 
   `MaMH` = OLD.`MaMH`;
 else
 Update `bk_mathang`
 SET `TenMH` = NEW.`TenMH`,
   `AnhMH` = NEW.`AnhMH`,
   `MaDonVi` = NEW.`MaDonVi`,
   `Gia` = NEW.`Gia`
 WHERE 
   `MaMH` = OLD.`MaMH`;
   end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuthu`
--

CREATE TABLE `phieuthu` (
  `MaPT` smallint(6) NOT NULL,
  `MaDL` varchar(10) DEFAULT NULL,
  `SoTienThu` float DEFAULT NULL,
  `NgayThuTien` datetime DEFAULT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieuthu`
--

INSERT INTO `phieuthu` (`MaPT`, `MaDL`, `SoTienThu`, `NgayThuTien`, `DeleteFlag`, `Start`, `End`) VALUES
(8, 'DL00000001', 200000, '2019-05-23 01:00:45', 0, '2019-05-23 01:00:45', '2029-05-23 01:00:45');

--
-- Bẫy `phieuthu`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_PhieuThu` AFTER INSERT ON `phieuthu` FOR EACH ROW BEGIN
	DECLARE nocu float;
    select  TienNo into nocu from daily where MaDL = NEW.MaDL; 
    update daily set TienNo = nocu - NEW.SoTienThu where MaDL = NEW.MaDL;
    insert into `bk_phieuthu`(MaPT,MaDL,SoTienThu,NgayThuTien,Start,End)
    values(NEW.MaPT,NEW.MaDL,NEW.SoTienThu,NEW.NgayThuTien,NOW(),NOW()+ INTERVAL 10 year);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_PhieuThu` BEFORE INSERT ON `phieuthu` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuat`
--

CREATE TABLE `phieuxuat` (
  `MaPX` smallint(6) NOT NULL,
  `NgayLapPX` datetime NOT NULL,
  `MaDL` varchar(10) NOT NULL,
  `TongTien` float DEFAULT '0',
  `ConLai` float DEFAULT '0',
  `TienTra` float DEFAULT '0',
  `TinhTrang` tinyint(1) DEFAULT '0',
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieuxuat`
--

INSERT INTO `phieuxuat` (`MaPX`, `NgayLapPX`, `MaDL`, `TongTien`, `ConLai`, `TienTra`, `TinhTrang`, `DeleteFlag`, `Start`, `End`) VALUES
(7, '2019-05-23 00:59:30', 'DL00000001', 1056780, 1000000, 56780, 1, 0, '2019-05-23 00:57:23', '2029-05-23 00:57:23'),
(8, '2019-05-28 10:20:27', 'DL00000001', 0, 0, 0, 0, 0, '2019-05-28 10:20:27', '2029-05-28 10:20:27');

--
-- Bẫy `phieuxuat`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_PhieuXuat` AFTER INSERT ON `phieuxuat` FOR EACH ROW BEGIN
  if NEW.TinhTrang = 1 then
  insert into `bk_phieuxuat`
  SET
      `MaPX` = NEW.`MaPX`,
    `NgayLapPX` = NEW.`NgayLapPX`,
    `MaDL` = NEW.`MaDL`,
    `TongTien` = NEW.`TongTien`,
    `ConLai` = NEW.`ConLai`,
    `TienTra` = NEW.`TienTra`,
    `TinhTrang` = NEW.`TinhTrang`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
   end if;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_PhieuXuat` BEFORE INSERT ON `phieuxuat` FOR EACH ROW BEGIN
	SET 
    New.`Start` = NOW(),
    NEW.`End` = NOW()+ INTERVAL 10 year,
    New.`DeleteFlag` = 0;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_PhieuXuat` AFTER UPDATE ON `phieuxuat` FOR EACH ROW BEGIN
  declare dem SMALLINT;
  select count(MaPX) into dem from bk_phieuxuat where MaPX = NEW.MaPX;
  if NEW.TinhTrang = 1 and dem <> 0 then
  update `bk_phieuxuat`
  SET
    `NgayLapPX` = NEW.`NgayLapPX`,
    `MaDL` = NEW.`MaDL`,
    `TongTien` = NEW.`TongTien`,
    `ConLai` = NEW.`ConLai`,
    `TienTra` = NEW.`TienTra`,
    `TinhTrang` = NEW.`TinhTrang`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year
    where `MaPX`=OLD.MaPX;
   ELSE
     insert into `bk_phieuxuat`
  SET
  	`MaPX` = NEW.`MaPX`,
    `NgayLapPX` = NEW.`NgayLapPX`,
    `MaDL` = NEW.`MaDL`,
    `TongTien` = NEW.`TongTien`,
    `ConLai` = NEW.`ConLai`,
    `TienTra` = NEW.`TienTra`,
    `TinhTrang` = NEW.`TinhTrang`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
   end if;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_B_PhieuXuat` BEFORE UPDATE ON `phieuxuat` FOR EACH ROW BEGIN
  if OLD.TinhTrang = 1 and NEW.DeleteFlag = 1 then
  update `bk_phieuxuat`
  SET 
    `BackUp` = NOW() + INTERVAL 1 year,
    `deleteTime` = NOW()
    where `MaPX` = OLD.`MaPX`;
   end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quan`
--

CREATE TABLE `quan` (
  `MaQuan` smallint(6) NOT NULL,
  `TenQuan` varchar(20) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `quan`
--

INSERT INTO `quan` (`MaQuan`, `TenQuan`, `DeleteFlag`, `Start`, `End`) VALUES
(16, 'Quận 1 ', 0, '2019-05-23 00:49:13', NULL),
(17, 'Quận 2', 0, '2019-05-23 00:49:28', NULL),
(18, 'Quận 3', 0, '2019-05-23 00:49:38', NULL),
(19, 'Quận 4', 0, '2019-05-23 00:50:25', NULL),
(20, 'Quận 5', 0, '2019-05-23 01:10:27', NULL);

--
-- Bẫy `quan`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_Quan` AFTER INSERT ON `quan` FOR EACH ROW BEGIN
  INSERT INTO `bk_quan`
  SET `MaQuan` = NEW.`MaQuan`, 
    `TenQuan` = NEW.`TenQuan`,
    `Start` = NOW(),
    End = NOW() + INTERVAL 10 year;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_Quan` BEFORE INSERT ON `quan` FOR EACH ROW BEGIN
  SET 
    New.`Start` = NOW(),
    New.`DeleteFlag` = 0;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_Quan` AFTER UPDATE ON `quan` FOR EACH ROW BEGIN
  if NEW.DeleteFlag = 1 THEN
    Update `bk_quan`
  SET `TenQuan` = NEW.`TenQuan`,
    `BackUp` = NOW() + INTERVAL 1 year,
    `deleteTime` = NOW()
  WHERE 
    `MaQuan` = OLD.`MaQuan`;
  else
  Update `bk_quan`
  SET `TenQuan` = NEW.`TenQuan`
  WHERE 
    `MaQuan` = OLD.`MaQuan`;
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `UserName` varchar(128) NOT NULL,
  `Pass` varchar(128) NOT NULL,
  `DisplayName` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MaLoaiUser` smallint(6) NOT NULL,
  `DeleteFlag` tinyint(1) DEFAULT '0',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Bẫy `taikhoan`
--
DELIMITER $$
CREATE TRIGGER `Insert_A_TaiKhoan` AFTER INSERT ON `taikhoan` FOR EACH ROW BEGIN
  INSERT INTO `bk_taikhoan`
  SET `UserName` = NEW.`UserName`, 
    `Pass` = NEW.`Pass`,
    `DisplayName` = NEW.`DisplayName`,
    `MaLoaiUser` = NEW.`MaLoaiUser`,
    `Start` = NOW(),
    `BackUp` = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insert_B_TaiKhoan` BEFORE INSERT ON `taikhoan` FOR EACH ROW BEGIN
  SET 
    New.`Start` = NOW(),
    New.`DeleteFlag` = 0;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update_A_TaiKhoan` AFTER UPDATE ON `taikhoan` FOR EACH ROW BEGIN
  Update `bk_taikhoan`
  SET `Pass` = NEW.`Pass`,
    `DisplayName` = NEW.`DisplayName`,
    `MaLoaiUser` = NEW.`MaLoaiUser`,
    `BackUp` = NOW()
  WHERE 
    `MaLoaiUser` = OLD.`MaLoaiUser`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thamso`
--

CREATE TABLE `thamso` (
  `MaTS` tinyint(4) NOT NULL,
  `GiaTri` float DEFAULT '0',
  `GhiChu` varchar(256) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `thamso`
--

INSERT INTO `thamso` (`MaTS`, `GiaTri`, `GhiChu`) VALUES
(1, 5, 'Số loại đại lý tối đa'),
(2, 5, 'Số mặt hàng tối đa'),
(3, 5, 'Số đơn vị tính tối đa'),
(4, 5, 'Số quận tối đa'),
(7, 4, 'Số đại lý tối đa của mỗi quận');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `view1`
-- (See below for the actual view)
--
CREATE TABLE `view1` (
`MaPX` smallint(6)
,`TongTien` float
,`MaDL` varchar(10)
,`NgayLapPX` datetime
,`DeleteFlag` tinyint(1)
,`TinhTrang` tinyint(1)
,`TenDL` varchar(50)
,`DeleteFlag1` tinyint(1)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `view2`
-- (See below for the actual view)
--
CREATE TABLE `view2` (
`MaPX` smallint(6)
,`NgayLapPX` datetime
,`TongTien` float
,`TinhTrang` tinyint(1)
,`DeleteFlag` tinyint(1)
,`TenDL` varchar(50)
);

-- --------------------------------------------------------

--
-- Cấu trúc cho view `view1`
--
DROP TABLE IF EXISTS `view1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view1`  AS  select `phieuxuat`.`MaPX` AS `MaPX`,`phieuxuat`.`TongTien` AS `TongTien`,`phieuxuat`.`MaDL` AS `MaDL`,`phieuxuat`.`NgayLapPX` AS `NgayLapPX`,`phieuxuat`.`DeleteFlag` AS `DeleteFlag`,`phieuxuat`.`TinhTrang` AS `TinhTrang`,`daily`.`TenDL` AS `TenDL`,`daily`.`DeleteFlag` AS `DeleteFlag1` from (`phieuxuat` join `daily` on((`phieuxuat`.`MaDL` = `daily`.`MaDL`))) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `view2`
--
DROP TABLE IF EXISTS `view2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view2`  AS  select `phieuxuat`.`MaPX` AS `MaPX`,`phieuxuat`.`NgayLapPX` AS `NgayLapPX`,`phieuxuat`.`TongTien` AS `TongTien`,`phieuxuat`.`TinhTrang` AS `TinhTrang`,`phieuxuat`.`DeleteFlag` AS `DeleteFlag`,`daily`.`TenDL` AS `TenDL` from (`phieuxuat` join `daily` on((`phieuxuat`.`MaDL` = `daily`.`MaDL`))) ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bk_ctphieuxuat`
--
ALTER TABLE `bk_ctphieuxuat`
  ADD PRIMARY KEY (`MaCTPX`),
  ADD KEY `MaPX` (`MaPX`),
  ADD KEY `MaMH` (`MaMH`);

--
-- Chỉ mục cho bảng `bk_daily`
--
ALTER TABLE `bk_daily`
  ADD PRIMARY KEY (`MaDL`),
  ADD KEY `MaLoaiDL` (`MaLoaiDL`),
  ADD KEY `MaQuan` (`MaQuan`);

--
-- Chỉ mục cho bảng `bk_donvi`
--
ALTER TABLE `bk_donvi`
  ADD PRIMARY KEY (`MaDonVi`);

--
-- Chỉ mục cho bảng `bk_loaidaily`
--
ALTER TABLE `bk_loaidaily`
  ADD PRIMARY KEY (`MaLoaiDL`);

--
-- Chỉ mục cho bảng `bk_loaiuser`
--
ALTER TABLE `bk_loaiuser`
  ADD PRIMARY KEY (`MaLoaiUser`);

--
-- Chỉ mục cho bảng `bk_mathang`
--
ALTER TABLE `bk_mathang`
  ADD PRIMARY KEY (`MaMH`),
  ADD KEY `bk_mathang_fk_bk_donvi` (`MaDonVi`);

--
-- Chỉ mục cho bảng `bk_phieuthu`
--
ALTER TABLE `bk_phieuthu`
  ADD PRIMARY KEY (`MaPT`),
  ADD KEY `asd` (`MaDL`);

--
-- Chỉ mục cho bảng `bk_phieuxuat`
--
ALTER TABLE `bk_phieuxuat`
  ADD PRIMARY KEY (`MaPX`),
  ADD KEY `MaDL` (`MaDL`);

--
-- Chỉ mục cho bảng `bk_quan`
--
ALTER TABLE `bk_quan`
  ADD PRIMARY KEY (`MaQuan`);

--
-- Chỉ mục cho bảng `bk_taikhoan`
--
ALTER TABLE `bk_taikhoan`
  ADD PRIMARY KEY (`UserName`),
  ADD KEY `MaLoaiUser` (`MaLoaiUser`);

--
-- Chỉ mục cho bảng `ctphieuxuat`
--
ALTER TABLE `ctphieuxuat`
  ADD PRIMARY KEY (`MaPX`,`MaMH`),
  ADD KEY `MaMH` (`MaMH`);

--
-- Chỉ mục cho bảng `daily`
--
ALTER TABLE `daily`
  ADD PRIMARY KEY (`MaDL`),
  ADD KEY `MaLoaiDL` (`MaLoaiDL`),
  ADD KEY `MaQuan` (`MaQuan`);

--
-- Chỉ mục cho bảng `donvi`
--
ALTER TABLE `donvi`
  ADD PRIMARY KEY (`MaDonVi`);

--
-- Chỉ mục cho bảng `loaidaily`
--
ALTER TABLE `loaidaily`
  ADD PRIMARY KEY (`MaLoaiDL`);

--
-- Chỉ mục cho bảng `loaiuser`
--
ALTER TABLE `loaiuser`
  ADD PRIMARY KEY (`MaLoaiUser`);

--
-- Chỉ mục cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD PRIMARY KEY (`MaMH`),
  ADD KEY `donvi_fk_donvi` (`MaDonVi`);

--
-- Chỉ mục cho bảng `phieuthu`
--
ALTER TABLE `phieuthu`
  ADD PRIMARY KEY (`MaPT`),
  ADD KEY `MaDL` (`MaDL`);

--
-- Chỉ mục cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD PRIMARY KEY (`MaPX`),
  ADD KEY `MaDL` (`MaDL`);

--
-- Chỉ mục cho bảng `quan`
--
ALTER TABLE `quan`
  ADD PRIMARY KEY (`MaQuan`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`UserName`),
  ADD KEY `MaLoaiUser` (`MaLoaiUser`);

--
-- Chỉ mục cho bảng `thamso`
--
ALTER TABLE `thamso`
  ADD PRIMARY KEY (`MaTS`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bk_ctphieuxuat`
--
ALTER TABLE `bk_ctphieuxuat`
  MODIFY `MaCTPX` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bk_donvi`
--
ALTER TABLE `bk_donvi`
  MODIFY `MaDonVi` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `bk_loaidaily`
--
ALTER TABLE `bk_loaidaily`
  MODIFY `MaLoaiDL` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `bk_loaiuser`
--
ALTER TABLE `bk_loaiuser`
  MODIFY `MaLoaiUser` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `bk_phieuthu`
--
ALTER TABLE `bk_phieuthu`
  MODIFY `MaPT` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `bk_phieuxuat`
--
ALTER TABLE `bk_phieuxuat`
  MODIFY `MaPX` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `bk_quan`
--
ALTER TABLE `bk_quan`
  MODIFY `MaQuan` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `donvi`
--
ALTER TABLE `donvi`
  MODIFY `MaDonVi` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `loaidaily`
--
ALTER TABLE `loaidaily`
  MODIFY `MaLoaiDL` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `loaiuser`
--
ALTER TABLE `loaiuser`
  MODIFY `MaLoaiUser` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `phieuthu`
--
ALTER TABLE `phieuthu`
  MODIFY `MaPT` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  MODIFY `MaPX` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `quan`
--
ALTER TABLE `quan`
  MODIFY `MaQuan` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `thamso`
--
ALTER TABLE `thamso`
  MODIFY `MaTS` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bk_ctphieuxuat`
--
ALTER TABLE `bk_ctphieuxuat`
  ADD CONSTRAINT `bk_ctphieuxuat_fk_bk_mathang` FOREIGN KEY (`MaMH`) REFERENCES `bk_mathang` (`MaMH`),
  ADD CONSTRAINT `bk_ctphieuxuat_fk_bk_phieuxuat` FOREIGN KEY (`MaPX`) REFERENCES `bk_phieuxuat` (`MaPX`);

--
-- Các ràng buộc cho bảng `bk_daily`
--
ALTER TABLE `bk_daily`
  ADD CONSTRAINT `bk_daily_fk_bk_loaidaily` FOREIGN KEY (`MaLoaiDL`) REFERENCES `bk_loaidaily` (`MaLoaiDL`),
  ADD CONSTRAINT `bk_daily_fk_bk_quan` FOREIGN KEY (`MaQuan`) REFERENCES `bk_quan` (`MaQuan`);

--
-- Các ràng buộc cho bảng `bk_mathang`
--
ALTER TABLE `bk_mathang`
  ADD CONSTRAINT `bk_mathang_fk_bk_donvi` FOREIGN KEY (`MaDonVi`) REFERENCES `bk_donvi` (`MaDonVi`);

--
-- Các ràng buộc cho bảng `bk_phieuthu`
--
ALTER TABLE `bk_phieuthu`
  ADD CONSTRAINT `asd` FOREIGN KEY (`MaDL`) REFERENCES `bk_daily` (`MaDL`);

--
-- Các ràng buộc cho bảng `bk_taikhoan`
--
ALTER TABLE `bk_taikhoan`
  ADD CONSTRAINT `bk_taikhoan_fk_bk_loaiuser` FOREIGN KEY (`MaLoaiUser`) REFERENCES `bk_loaiuser` (`MaLoaiUser`);

--
-- Các ràng buộc cho bảng `ctphieuxuat`
--
ALTER TABLE `ctphieuxuat`
  ADD CONSTRAINT `ctphieuxuat_ibfk_1` FOREIGN KEY (`MaMH`) REFERENCES `mathang` (`MaMH`),
  ADD CONSTRAINT `ctphieuxuat_ibfk_2` FOREIGN KEY (`MaPX`) REFERENCES `phieuxuat` (`MaPX`);

--
-- Các ràng buộc cho bảng `daily`
--
ALTER TABLE `daily`
  ADD CONSTRAINT `daily_fk_loaidaily` FOREIGN KEY (`MaLoaiDL`) REFERENCES `loaidaily` (`MaLoaiDL`),
  ADD CONSTRAINT `daily_fk_quan` FOREIGN KEY (`MaQuan`) REFERENCES `quan` (`MaQuan`);

--
-- Các ràng buộc cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD CONSTRAINT `donvi_fk_donvi` FOREIGN KEY (`MaDonVi`) REFERENCES `donvi` (`MaDonVi`);

--
-- Các ràng buộc cho bảng `phieuthu`
--
ALTER TABLE `phieuthu`
  ADD CONSTRAINT `phieuthu_ibfk_1` FOREIGN KEY (`MaDL`) REFERENCES `daily` (`MaDL`);

--
-- Các ràng buộc cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD CONSTRAINT `phieuxuat_fk_daily` FOREIGN KEY (`MaDL`) REFERENCES `daily` (`MaDL`);

--
-- Các ràng buộc cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_fk_loaiuser` FOREIGN KEY (`MaLoaiUser`) REFERENCES `loaiuser` (`MaLoaiUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
