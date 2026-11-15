


--   SOAL 1 : MEMBUAT SKEMA DATABASE                       

CREATE DATABASE IF NOT EXISTS penjualan
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE penjualan;

-- Hapus tabel dari tabel anak ke tabel induk (agar tidak terhalang foreign key)
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS user;


-- Tabel supplier

CREATE TABLE supplier (
    id     INT          NOT NULL AUTO_INCREMENT,  
    nama   VARCHAR(100) NOT NULL,                 
    telp   VARCHAR(12)  NOT NULL,                 
    alamat TEXT         NOT NULL,                 
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel pelanggan

CREATE TABLE pelanggan (
    id            VARCHAR(20)   NOT NULL,         
    nama          VARCHAR(100)  NOT NULL,        
    jenis_kelamin ENUM('L','P') NOT NULL,         
    telp          VARCHAR(12)   NOT NULL,         
    alamat        TEXT          NOT NULL,        
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel user

CREATE TABLE user (
    id_user  TINYINT      NOT NULL AUTO_INCREMENT, 
    username VARCHAR(30)  NOT NULL,               
    password VARCHAR(35)  NOT NULL,              
    nama     VARCHAR(50)  NOT NULL,               
    alamat   VARCHAR(150) NOT NULL,               
    hp       VARCHAR(20)  NOT NULL,             
    level    TINYINT      NOT NULL,               
    PRIMARY KEY (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel barang (supplier_id -> supplier.id)

CREATE TABLE barang (
    id          INT          NOT NULL AUTO_INCREMENT, 
    kode_barang VARCHAR(10)  NOT NULL,                
    nama_barang VARCHAR(100) NOT NULL,                
    harga       INT          NOT NULL,               
    stok        INT          NOT NULL,                
    supplier_id INT          NOT NULL,               
    PRIMARY KEY (id),
    CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id)
        REFERENCES supplier (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel transaksi (pelanggan_id -> pelanggan.id)

CREATE TABLE transaksi (
    id              INT         NOT NULL AUTO_INCREMENT, 
    waktu_transaksi DATE        NOT NULL,                
    keterangan      TEXT        NOT NULL,                
    total           INT         NOT NULL,                
    pelanggan_id    VARCHAR(20) NOT NULL,                
    PRIMARY KEY (id),
    CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id)
        REFERENCES pelanggan (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel transaksi_detail (composite primary key)

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,                        
    barang_id    INT NOT NULL,                        
    harga        INT NOT NULL,                        
    qty          INT NOT NULL,                        
    PRIMARY KEY (transaksi_id, barang_id),
    CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id)
        REFERENCES transaksi (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id)
        REFERENCES barang (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabel pembayaran (transaksi_id -> transaksi.id)

CREATE TABLE pembayaran (
    id           INT                                NOT NULL AUTO_INCREMENT, 
    waktu_bayar  DATETIME                           NOT NULL,                
    total        INT                                NOT NULL,                
    metode       ENUM('TUNAI','TRANSFER','EDC')     NOT NULL,               
    transaksi_id INT                                NOT NULL,               
    PRIMARY KEY (id),
    CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id)
        REFERENCES transaksi (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--   SOAL 2 : MENGISI DATA MASTER DAN DATA TRANSAKSI       


USE penjualan;


INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Rejeki', '081234567890', 'Sidoarjo'),
(5, 'PT. Jaya Abadi', '0315551234', 'Gresik'),
(6, 'CV. Mitra Sejahtera', '082134567890', 'Malang'),
(7, 'PT. Tirta Makmur', '0318887766', 'Mojokerto'),
(8, 'UD. Berkah Sentosa', '085612345678', 'Pamekasan'),
(9, 'PT. Nusantara Pangan', '0217654321', 'Jakarta'),
(10, 'CV. Cahaya Baru', '087712345678', 'Sampang');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Ahmad Fauzi', 'L', '081234500001', 'Jl. Raya Kamal No. 12, Bangkalan'),
('PLG002', 'Siti Nurhaliza', 'P', '081234500002', 'Jl. Merdeka No. 5, Surabaya'),
('PLG003', 'Budi Santoso', 'L', '081234500003', 'Jl. Diponegoro No. 21, Sidoarjo'),
('PLG004', 'Dewi Lestari', 'P', '081234500004', 'Jl. Pahlawan No. 8, Gresik'),
('PLG005', 'Rizky Pratama', 'L', '081234500005', 'Jl. Veteran No. 17, Malang'),
('PLG006', 'Putri Anggraini', 'P', '081234500006', 'Jl. Ahmad Yani No. 30, Surabaya'),
('PLG007', 'Hendra Wijaya', 'L', '081234500007', 'Jl. Gajah Mada No. 9, Mojokerto'),
('PLG008', 'Maya Sari', 'P', '081234500008', 'Jl. Trunojoyo No. 14, Bangkalan'),
('PLG009', 'Dimas Prakoso', 'L', '081234500009', 'Jl. Sudirman No. 3, Pamekasan'),
('PLG010', 'Lina Marlina', 'P', '081234500010', 'Jl. Pemuda No. 26, Sampang');

INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin', MD5('admin123'), 'Muhammad Ryan Hidayatullah', 'Jl. Raya Telang, Bangkalan', '081230000001', 1),
(2, 'kasir1', MD5('kasir123'), 'Andi Saputra', 'Jl. Merdeka No. 10, Surabaya', '081230000002', 2),
(3, 'kasir2', MD5('kasir456'), 'Rina Marlina', 'Jl. Pahlawan No. 4, Gresik', '081230000003', 2),
(4, 'kasir3', MD5('kasir789'), 'Joko Susilo', 'Jl. Diponegoro No. 7, Sidoarjo', '081230000004', 2),
(5, 'gudang1', MD5('gudang123'), 'Wahyu Hidayat', 'Jl. Veteran No. 15, Malang', '081230000005', 2),
(6, 'gudang2', MD5('gudang456'), 'Fitri Handayani', 'Jl. Gajah Mada No. 2, Mojokerto', '081230000006', 2),
(7, 'manajer', MD5('manajer123'), 'Hartono Wibowo', 'Jl. Sudirman No. 21, Surabaya', '081230000007', 1),
(8, 'sales1', MD5('sales123'), 'Yuni Astuti', 'Jl. Trunojoyo No. 18, Bangkalan', '081230000008', 2),
(9, 'sales2', MD5('sales456'), 'Eko Prasetyo', 'Jl. Ahmad Yani No. 9, Pamekasan', '081230000009', 2),
(10, 'owner', MD5('owner123'), 'Bambang Sutrisno', 'Jl. Pemuda No. 1, Sampang', '081230000010', 1);

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras Premium 5kg', 68000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2L', 36000, 80, 1),
(3, 'BRG003', 'Gula Pasir 1kg', 16000, 120, 2),
(4, 'BRG004', 'Tepung Terigu 1kg', 12000, 100, 2),
(5, 'BRG005', 'Kopi Bubuk 200g', 22000, 60, 3),
(6, 'BRG006', 'Teh Celup isi 25', 9000, 150, 3),
(7, 'BRG007', 'Susu UHT 1L', 18000, 90, 4),
(8, 'BRG008', 'Mie Instan Goreng', 3500, 500, 5),
(9, 'BRG009', 'Sabun Mandi 100g', 4500, 200, 6),
(10, 'BRG010', 'Deterjen Bubuk 800g', 24000, 70, 7);

-- ---------------- DATA TRANSAKSI ----------------

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Pembelian kebutuhan dapur', 152000, 'PLG001'),
(2, '2026-10-02', 'Pembelian minyak goreng', 36000, 'PLG002'),
(3, '2026-10-03', 'Stok warung', 93000, 'PLG003'),
(4, '2026-10-05', 'Pembelian teh', 18000, 'PLG004'),
(5, '2026-10-07', 'Kebutuhan rumah tangga', 117000, 'PLG005'),
(6, '2026-10-09', 'Pembelian deterjen dan gula', 56000, 'PLG006'),
(7, '2026-10-12', 'Pembelian beras', 68000, 'PLG007'),
(8, '2026-10-15', 'Stok mie dan minyak', 142000, 'PLG008'),
(9, '2026-10-18', 'Pembelian kopi dan teh', 53000, 'PLG009'),
(10, '2026-10-22', 'Belanja bulanan', 96000, 'PLG010');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 68000, 2),
(1, 3, 16000, 1),
(2, 2, 36000, 1),
(3, 4, 12000, 3),
(3, 5, 22000, 1),
(3, 8, 3500, 10),
(4, 6, 9000, 2),
(5, 7, 18000, 6),
(5, 9, 4500, 2),
(6, 10, 24000, 1),
(6, 3, 16000, 2),
(7, 1, 68000, 1),
(8, 8, 3500, 20),
(8, 2, 36000, 2),
(9, 5, 22000, 2),
(9, 6, 9000, 1),
(10, 4, 12000, 1),
(10, 7, 18000, 2),
(10, 10, 24000, 2);

INSERT INTO pembayaran (id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-10-01 09:15:00', 152000, 'TUNAI', 1),
(2, '2026-10-02 10:30:00', 36000, 'TRANSFER', 2),
(3, '2026-10-03 11:05:00', 93000, 'EDC', 3),
(4, '2026-10-05 13:20:00', 18000, 'TUNAI', 4),
(5, '2026-10-07 14:45:00', 117000, 'TUNAI', 5),
(6, '2026-10-09 08:50:00', 56000, 'TRANSFER', 6),
(7, '2026-10-12 15:10:00', 68000, 'EDC', 7),
(8, '2026-10-15 16:00:00', 142000, 'TRANSFER', 8),
(9, '2026-10-18 10:10:00', 53000, 'TUNAI', 9),
(10, '2026-10-22 12:25:00', 96000, 'EDC', 10);
