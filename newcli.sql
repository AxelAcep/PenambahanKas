-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 01:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newcli`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(16, 'Donasi'),
(17, 'bulanan anggota'),
(18, 'jualan'),
(19, 'kolaborasi'),
(20, 'proker'),
(21, 'makan makan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about`
--

CREATE TABLE `tbl_about` (
  `about_id` int(11) NOT NULL,
  `about_name` varchar(255) NOT NULL,
  `about_image` varchar(100) DEFAULT NULL,
  `about_description` text DEFAULT NULL,
  `about_alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_about`
--

INSERT INTO `tbl_about` (`about_id`, `about_name`, `about_image`, `about_description`, `about_alamat`) VALUES
(1, 'PMII ', 'about1.jpg', 'Pergerakan Mahasiswa Islam Indonesia', 'Jl. Taman Amir Hamzah, Pegangsaan, Menteng, Jakarta Pusat 10320');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) DEFAULT NULL,
  `category_slug` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `category_slug`) VALUES
(1, 'Articles', 'articles'),
(2, 'News', 'news'),
(3, 'Opinion', 'opinion'),
(4, 'Abstract', 'abstract');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` int(11) NOT NULL,
  `comment_date` timestamp NULL DEFAULT current_timestamp(),
  `comment_name` varchar(60) DEFAULT NULL,
  `comment_email` varchar(90) DEFAULT NULL,
  `comment_message` text DEFAULT NULL,
  `comment_status` int(11) DEFAULT 0,
  `comment_parent` int(11) DEFAULT 0,
  `comment_post_id` int(11) DEFAULT NULL,
  `comment_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home`
--

CREATE TABLE `tbl_home` (
  `home_id` int(11) NOT NULL,
  `home_caption_1` varchar(200) DEFAULT NULL,
  `home_caption_2` varchar(200) DEFAULT NULL,
  `home_video` varchar(255) NOT NULL,
  `home_bg_heading` varchar(50) DEFAULT NULL,
  `home_bg_testimonial` varchar(50) DEFAULT NULL,
  `home_bg_testimonial2` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_home`
--

INSERT INTO `tbl_home` (`home_id`, `home_caption_1`, `home_caption_2`, `home_video`, `home_bg_heading`, `home_bg_testimonial`, `home_bg_testimonial2`) VALUES
(1, 'Selamat Datang di', 'District Board of Indonesian Moslem Student Movement', 'https://www.youtube.com/watch?v=EvOiPmEtAPQ', 'hero-bg.jpg', 'testimonials-1.jpg', 'home-2.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inbox`
--

CREATE TABLE `tbl_inbox` (
  `inbox_id` int(11) NOT NULL,
  `inbox_name` varchar(50) DEFAULT NULL,
  `inbox_email` varchar(80) DEFAULT NULL,
  `inbox_subject` varchar(200) DEFAULT NULL,
  `inbox_message` text DEFAULT NULL,
  `inbox_created_at` timestamp NULL DEFAULT current_timestamp(),
  `inbox_status` varchar(2) DEFAULT '0' COMMENT '0=Unread, 1=Read'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(50) DEFAULT NULL,
  `member_link` varchar(50) DEFAULT NULL,
  `member_desc` text DEFAULT NULL,
  `member_image` varchar(50) DEFAULT NULL,
  `member_created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navbar`
--

CREATE TABLE `tbl_navbar` (
  `navbar_id` int(11) NOT NULL,
  `navbar_name` varchar(50) DEFAULT NULL,
  `navbar_slug` varchar(200) DEFAULT NULL,
  `navbar_parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(250) DEFAULT NULL,
  `post_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_contents` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_image` varchar(40) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT current_timestamp(),
  `post_last_update` datetime DEFAULT NULL,
  `post_category_id` int(11) DEFAULT NULL,
  `post_tags` varchar(225) DEFAULT NULL,
  `post_slug` varchar(250) DEFAULT NULL,
  `post_status` int(11) DEFAULT NULL COMMENT '1=Publish, 0=Unpublish',
  `post_views` int(11) DEFAULT 0,
  `post_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`post_id`, `post_title`, `post_description`, `post_contents`, `post_image`, `post_date`, `post_last_update`, `post_category_id`, `post_tags`, `post_slug`, `post_status`, `post_views`, `post_user_id`) VALUES
(1, 'Evaluasi Media Penerbitan, Ciptakan Karya Gerakan Intelektual PMII', 'Dalam kalimat sajak lagu mars PMII tersebut, justru seluruh warga penggerak perubahan ini memahami makna dari kalimat itu. ', '<p style=\"text-align: justify; \">Siapa yang masih belum tau dengan kumpulan organisasi berbendera biru kuning. Saya yakin rata-rata sudah mengetahuinya, entah di jalan ataupun dalam ruangan pendidikan, bahkan menjadi mayoritas mahasiswa sebagai ruang berorganisasi. Karena gerak gerik organisasi Pergerakan Mahasiswa Islam Indonesia (PMII) kian mudah dipandang, sebab para kaderisasinya sangat menonjol bila terdapat bencana alam disekitarnya. Namun terdapat keganjalan dalam eksistensi warga pergerakan ini hendak turun ke jalan, yakni media penerbitan berita atau sering kali disebut news. Aksiologi yang diandalkan tidak cukup dengan kekurangan pemikiran atau sapaan akrabnya intelektual. Karena menjadi kader dalam organisasi PMII seharusnya mempunyai pemikiran tinggi dan karya sebagai identitas diri sebagai bukti. Maka dari itu, media penerbitan PMII tahun 2021 ini butuh di evaluasi dan di-booming-kan.</p><p style=\"text-align: justify; \">“Denganmu PMII pergerakanku, ilmu dan bakti ku berikan” kalimat sajak dalam lagu mars PMII.</p><p style=\"text-align: justify; \">Dalam kalimat sajak lagu mars PMII tersebut, justru seluruh warga penggerak perubahan ini memahami makna dari kalimat itu. Bagiku sangat bagus untuk dimaknai dan diteliti, bagaimana bergerak di dalam organisasi harus berilmu dan berbakti. Berilmu dalam artian mempunyai bahan atau akal untuk mengedepankan, mengharumkan identitas PMII dalam berbangsa dan bernegara. Bakti dalam menciptakan suatu karya sesuai keseniannya akan menjadi sebagai sumbangsihnya terhadap organisasi PMII.</p><p style=\"text-align: justify; \">Mengapa harus dievaluasi?</p><p style=\"text-align: justify; \">Setelah satu tahun berjalan menjadi anggota dalam organisasi PMII, tepatnya di salah satu daerah wilayah kota santri Jombang, berdasarkan pengamatan saya secara terang bahwa kader PMII kian dinyatakan mellek media. Namun konon nyatanya sedikit berkarya, atau sering disapa dengan hanya menduga-duga. Maka dari itu, sampai tulisan ini terbit saya harapkan kepada pimpinan Ketua Cabang PMII Jombang, M. Arif Hakim untuk mengevaluasi kembali guna mem-booming-kan perkembangan para kader melalui media.</p><p style=\"text-align: justify; \">Apa guna berkarya dalam organisasi PMII?</p><p style=\"text-align: justify; \">Perlu diketahui, PMII yang dikenal dengan warga pergerakan intelektual setidaknya bisa menciptakan gerakan nyatanya dari karya seninya. Contohnya, 17 April 2021 seluruh warga pergerakan akan merayakan hari lahir organisasi PMII, dari situ kita sudah bisa berkarya dengan menuliskan sejarah atau perayaan yang berbeda dari sebelumnya. Konon katanya sejarah yang dibilang penting dan layak untuk diingat, apa salahnya kita ciptakan dengan karya yang berbeda guna akan dikenang oleh masyarakat hingga kepemerintahan.</p><p style=\"text-align: justify; \">Mungkin segenap rasa hormat dan selamat bagi seluruh warga pergerakan menjelang hari lahirnya organisasi Pergerakan Mahasiswa Islam Indonesia, pada 17 April 2021 mendatang. Saya sendiri selaku masih anggota di ranah fakultas Rayon Fakultas Bisnis dan Bahasa (FBB) Komisariat Umar Tamim, Jombang mengharap agar seluruhnya di setiap naungan organisasi PMII bisa mengevaluasi kembali media penerbitannya, guna saling bersahabat untuk membumikan perkembangan organisasi PMII kedepannya. Jum’at (09/04/2021).</p><p style=\"text-align: justify; \"><b>Muhammad Fa\'iz Hasan</b><br></p><p style=\"text-align: justify; \"><br></p><p style=\"text-align: justify; \">Sumber: <a href=\"https://ikilhojatim.com/evaluasi-media-penerbitan-ciptakan-karya-gerakan-intelektual-pmii/\" target=\"_blank\">ikilhojatim.com</a></p><p style=\"text-align: justify; \"><br></p>', 'ccca7e866c78966d4d7f3110303ef43d.jpg', '2021-10-22 17:41:12', NULL, 3, 'pmii,pmiidev,pmiimedia,pmiimaju,pmiimendunia', 'evaluasi-media-penerbitan--ciptakan-karya-gerakan-intelektual-pmii', 1, 4, 4),
(2, 'E-Koran Media Komunis Wadah Menulis untuk Aktivis', 'Media menulis yang saat ini dapat mendukung hal tersebut pun sudah tidak terhitung, baik yang cetak maupun non cetak, segala bentuk platform sudah berkeliaran bebas serta dapat dinikmati oleh masyarakat tanpa batas. ', '<p style=\"text-align: justify; \">Telah resmi di buka&nbsp; E- Koran Media Komunis, salah satu media informasi yang dimilki oleh organisasi Pergerakan Mahasiswa Islam Indonesia (PMII) Komisariat Universitas Islam Malang (Unisma) hari ini tanggal 16 Maret 2021. Selain membaca, keterampilan berbahasa yang penting dimiliki adalah menulis, menyampaikan apa yang menjadi sudut pandang pribadi, baik yang besifat objektif atau subjektif sekalipun. Peka membaca sekitar kemudian menkontruksinya menjadi sebuah tulisan yang bisa dibaca masyarakat luas, menyumbangkan pengetahuan baru yang bersifat positif, bisa menjadi nilai plus untuk kita sebagai manusia yang meyakini perihal khoirunnas anfa’uhum linnas</p><p style=\"text-align: justify; \">Media menulis yang saat ini dapat mendukung hal tersebut pun sudah tidak terhitung, baik yang cetak maupun non cetak, segala bentuk platform sudah berkeliaran bebas serta dapat dinikmati oleh masyarakat tanpa batas. Tinggal ditanyakan kembali kepada diri sendiri apakah kita mau memilih diam ditempat atau bergerak menjadi bagian dari orang-orang yang tulisannya sudah dinikmati banyak kalangan. Maka dari itu, Team devisi Lembaga Pers Komisariat (LPK) Pergerakan Mahasiswa Islam Indonesia (PMII) Komisariat Universitas Islam malang (Unisma) memilih satu media berupa “E-Koran Media Komunis” yang bisa menjadi wadah menulis dan menunjang minat bakat kader PMII sebagai aktivis organisasi yang sejadinya setiap kader pasti memilki potensi dalam bidang tersebut. Dalam hal ini, E-Koran Media Komunis juga menyediakan berbagai kategori seperti opini, karya ilmiah dan lain sebagainya, websitenya juga bisa diakses dengan mudah.</p><p style=\"text-align: justify; \">Adanya website ini selain menjadi media menulis, juga diharapkan menjadi warna baru dari Pergerakan Mahsiwa Islam Indonesia (PMII) yang terus dijaga, dirawat dengan baik sehingga tidak ada istilah mati suri. Media yang dapat dijadikani alat bagi sahabat sahabati pergerakan untuk lebih berani melantangkan opini terutama di kondisi saat ini yang mengharuskan kita untuk berpikir lebih kreatif nan lebih aktif, lebih sabar menerima situasi yang tidak tahu sampai kapan pandemi, dan lebih kuat untuk melawan kerasnya dunia digitalisasi yang semakin hebat.</p><p style=\"text-align: justify; \">Dalam hal ini, ketua komisariat PMII Unisma sahabat Maksum menyampaikan apa yang dilihat dengan adanya E-koran Media Komunis “Media ini hadir salah satunya untuk menunaikan point terakhir dari pilar demokrasi, tidak muluk-muluk, dengan harapan sederhana ruang dealektika modern ini selain sebagai pangkalan data, sarana informasi, brand organisasi, juga untuk menjadi wadah utuh menampung gagasan-gagasan keren, ide-ide kreatif dari setiap kader PMII khususnya di lingkup Unisma”. Ketua Kopri PMII Komisariat Unisma Sahabati Firda juga menambahkan “Besar harapan saya, dengan adanya E-Koran Media Komunis mampu menggugah selera literasi bagi para kader PMII Unisma untuk menuangkan cita rasa tulisan-tulisan terbaiknya di website E-Koran PMII Unisma, karena entah diakui atau tidak, hari ini kita hidup di dunia yang penuh dengan informasi atau bisa dikatakan tengah&nbsp; mengalami banjir informasi (Flood of information) namun miskin makna, maka adanya media ini guna menghadirkan informasi kritis-solutif”.</p><p style=\"text-align: justify; \">Selain itu, koordinator devisi Media Pers Komisariat (LPK) juga menyampaikan harapannya “Dengan adanya E-Koran Media Komunis ini, saya berharap kepada kader PMII di bawah naungan komisariat Unisma untuk berani menyampaikan gagasan yang ada dalam pikiran masing-masing kader PMII, baik berupa karya ilmiah, opini ataupun berita tentang isu-isu saat ini. Saya harap kader-kader PMII tidak merasa canggung atau sungkan dalam berkarya segila mungkin.” jelas sahabat Yasak</p><p style=\"text-align: justify; \">Harapan-harapan baik yang sejatinya dapat direlisasikan secara sempurna dengan kerja sama semua elemen PMII Komisariat Unisma baik kader dari semua Rayon, Team bahkan sahabat sahabati yang sudah demisioner. Berkontribusi untuk menuangkan idenya melalui tulisan, memberi izin untuk dipublikasikan hingga dapat dikonsumsi banyak orang, karena website ini layaknya sebuah tanaman yang perlu diberi makan agar tetap memberi manfaat pada sekitar, tidak mati apalagi dilupakan. Kita sebagai manusia, yang dianggap sebagai aktivis pergerakan oleh masyarakat umum, selayaknya terus barusaha agar tidak tuli ketika mendengarkan sebuah aspirasi, tidak buta untuk membaca berita, tidak bisu untuk menyampaikan kebenaran baru dan tidak lumpuh untuk berpikir secara utuh.</p><p style=\"text-align: justify; \"><br></p><p style=\"text-align: justify; \">Sumber: <a href=\"https://pmiiunisma.id/e-koran-media-komunis-wadah-menulis-untuk-aktivis/\" target=\"_blank\">pmiiunisma.id</a></p><p style=\"text-align: justify; \"><br></p>', '77a9b4d95d54ff320de62abd90a669e7.jpg', '2021-10-22 17:44:23', NULL, 2, 'pmii,pmiidev,pmiimendunia,kemahasiswaan,kebangsaan,pemuda', 'e-koran-media-komunis-wadah-menulis-untuk-aktivis', 1, 7, 5),
(3, 'Perlunya Edukasi Media, PMII IAIN Pontianak Adakan Ngaji Media', 'Kader PCI PMII Jerman mengatakan bahwa penyelenggaraan Ngaji Media ini merupakan bentuk upaya meningkatkan kecerdasan dalam bermedia sosial. ', '<p style=\"text-align: justify; \">Pergerakan Mahasiswa Islam Indonesia (PMII) Komisariat IAIN Pontianak telah mengadakan Ngaji Media Chapter 1. Kegiatan ini berlangsung secara daring menggunakan platform Zoom Meeting Pada Sabtu dengan Tema \"Kader PMII Perlu Popularitas atau Kepakaran\" (07/08/2021).&nbsp;</p><p style=\"text-align: justify; \">Kajian ini diikuti oleh Keluarga Besar PMII Komisariat IAIN Pontianak dan Kader PMII se-Indonesia berjumlah 50 Orang. Pemateri dalam kegiatan ini Narendra Ning Ampeldenta atau akrab disapa Rake selaku Direktur Kominfo Perhimpunan Pelajar Indonesia (PPI) dan Kader PCI PMII Jerman.&nbsp;</p><p style=\"text-align: justify; \">Sahabat Novianto membuka kajian tersebut dengan mengutip apa yang disampaikan oleh Ketua Umum PB PMII, Gus Abe mengatakan bahwa kader PMII harus menjadi Key Opinion Leader yang dimana ketika ada suatu topik tidak harus melulu menjadi pengikut dari Opini yang dibuat oleh seseorang, ujarnya.</p><p style=\"text-align: justify; \">Kemudian sudah seharusnya kita sebagai kader PMII harus menjadi orang yang terdepan dalam membuat suatu opini yang tentunya sebagai Mahasiswa akademisi harus betul betul mengontrol dan ikut mengawal permasalahan bangsa ini. Maka dari itu tema yang diangkat pada kesempatan tersebut sangat relevan untuk dibahas.</p><p style=\"text-align: justify; \">Selanjutnya, sahabat Rake selaku pemateri Ngaji Media memaparkan “dalam popularitas atau kepakaran adalah satu kesatuan yang tidak terpisahkan dalam menciptakan opini. dalam hal edukasi ke warga netizen perlu memiliki kepakaran dan dalam penyampaian perlu kepopularitasan agar hal ini tercipta suatu kolaborasi yang positif \"tuturnya.</p><p style=\"text-align: justify; \">Kader PCI PMII Jerman mengatakan bahwa penyelenggaraan Ngaji Media ini merupakan bentuk upaya meningkatkan kecerdasan dalam bermedia sosial. Kegiatan ini peserta tidak hanya mendengar materi yang disampaikan akan tetapi peserta juga ikut bertanya dan berdiskusi terkait tema tersebut. Peserta sangat bersemangat dan antusias mengikuti kajian ini dan peserta berharap agar kajian ini dapat berlangsung secara berkelanjutan sampai peserta bisa memahami ilmu yang telah didapatkan.</p><p style=\"text-align: justify; \"><br></p><p style=\"text-align: justify; \">Sumber: <a href=\"https://www.pmiiiainpontianak.or.id/2021/08/perlunya-edukasi-media-pmii-iain.html\" target=\"_blank\">pmiiiainpontianak.or.id</a></p><p style=\"text-align: justify; \"><br></p>', '91f36c86d503fca2efb0fa46db377b21.jpg', '2021-10-22 17:46:21', NULL, 2, 'pmii,pmiidev,keindonesiaan,keislaman,kemahasiswaan,kebangsaan', 'perlunya-edukasi-media--pmii-iain-pontianak-adakan-ngaji-media', 1, 4, 4),
(13, 'Taman Bermain Para Warga Pergerakkan', 'Meta Description', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur amet unde id asperiores laudantium deserunt cum omnis voluptates perferendis cumque. Quisquam nobis incidunt veritatis molestias explicabo ipsum, laborum quaerat? Illo.<br></p>', 'default-post.png', '2022-11-08 02:22:09', '2022-11-08 09:22:09', 4, 'pmii,pmiidev,pmiimedia', 'taman-bermain-para-warga-pergerakkan', 1, 4, 10),
(15, 'coba post method post update kedua', 'updated kedua', '<p><br></p>', '1667959918_2d33e80f304ad8e0c7ee.png', '2022-11-08 12:09:32', '2022-11-12 17:54:44', 1, 'pmiidev,pmiimedia', 'coba-post-method-post-885', 1, 3, 10),
(16, 'Coba dari author sera masumi', '', '<p>lorem ipsum sit dolor amet kiulna mausik nuretra</p>', '1668339848_1d3cc253471e07acced5.png', '2022-11-12 22:41:04', '2022-11-13 05:44:08', 1, 'pmii,pmiidev,pmiimedia,kemahasiswaan,pemuda', 'coba-dari-author-sera-masumi', 1, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_views`
--

CREATE TABLE `tbl_post_views` (
  `view_id` int(11) NOT NULL,
  `view_date` timestamp NULL DEFAULT current_timestamp(),
  `view_ip` varchar(50) DEFAULT NULL,
  `view_post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_post_views`
--

INSERT INTO `tbl_post_views` (`view_id`, `view_date`, `view_ip`, `view_post_id`) VALUES
(76, '2020-07-28 16:21:13', '::1', 21),
(77, '2020-10-20 16:54:43', '::1', 21),
(78, '2020-11-14 13:44:03', '::1', 21),
(79, '2020-11-15 18:46:15', '::1', 21),
(80, '2020-11-16 05:45:04', '::1', 18),
(81, '2020-11-16 15:05:16', '::1', 20),
(82, '2020-11-16 15:43:04', '::1', 19),
(83, '2020-11-16 17:05:16', '::1', 20),
(84, '2020-11-16 17:05:24', '::1', 21),
(85, '2020-11-16 18:05:02', '::1', 19),
(86, '2020-11-16 18:29:45', '::1', 18),
(87, '2020-11-17 03:20:38', '::1', 22),
(88, '2020-11-21 05:27:58', '::1', 22),
(89, '2020-11-21 05:34:10', '::1', 18),
(90, '2020-11-21 06:15:43', '::1', 19),
(91, '2020-11-21 06:38:27', '::1', 20),
(92, '2020-11-21 17:00:55', '::1', 22),
(93, '2020-11-21 17:03:12', '::1', 18),
(94, '2020-11-21 17:40:27', '::1', 21),
(95, '2020-11-22 10:34:32', '::1', 19),
(96, '2020-11-22 11:42:07', '::1', 20),
(97, '2021-07-01 13:40:40', '::1', 22),
(98, '2021-07-01 14:02:35', '::1', 21),
(99, '2021-07-02 06:22:44', '::1', 21),
(100, '2021-07-03 06:07:16', '::1', 22),
(101, '2021-07-03 06:31:25', '::1', 21),
(102, '2021-07-03 13:40:24', '::1', 18),
(103, '2021-07-03 13:40:52', '::1', 19),
(104, '2021-07-03 15:23:26', '::1', 20),
(105, '2021-07-03 17:02:54', '::1', 22),
(106, '2021-07-03 17:11:15', '::1', 20),
(107, '2021-07-03 17:14:33', '::1', 21),
(108, '2021-07-04 04:41:56', '::1', 19),
(109, '2021-07-04 05:00:05', '::1', 18),
(110, '2021-07-04 09:45:57', '::1', 23),
(111, '2021-07-04 10:36:53', '::1', 24),
(112, '2021-07-04 10:38:58', '::1', 25),
(113, '2021-07-04 10:51:42', '::1', 26),
(114, '2021-07-04 10:52:29', '::1', 27),
(115, '2021-07-04 11:07:30', '::1', 29),
(116, '2021-07-04 11:22:43', '::1', 30),
(117, '2021-07-04 11:23:08', '::1', 28),
(118, '2021-07-07 09:18:27', '::1', 30),
(119, '2021-07-07 10:12:18', '::1', 27),
(120, '2021-07-07 10:19:01', '::1', 25),
(121, '2021-07-24 14:21:43', '::1', 30),
(122, '2021-07-24 16:33:33', '::1', 28),
(123, '2021-07-26 13:17:09', '::1', 30),
(124, '2021-07-26 15:42:11', '::1', 27),
(125, '2021-07-26 15:52:11', '::1', 25),
(126, '2021-07-26 16:01:51', '::1', 23),
(127, '2021-07-26 16:10:44', '::1', 29),
(128, '2021-07-26 17:36:25', '::1', 33),
(129, '2021-07-26 17:42:10', '::1', 31),
(130, '2021-07-27 03:18:13', '::1', 32),
(131, '2021-07-27 03:20:08', '::1', 28),
(132, '2021-07-27 03:20:32', '::1', 24),
(133, '2021-07-29 10:35:41', '::1', 32),
(134, '2021-07-29 11:06:55', '::1', 33),
(135, '2021-07-29 11:07:47', '::1', 24),
(136, '2021-07-29 11:07:59', '::1', 23),
(137, '2021-07-30 10:21:56', '::1', 28),
(138, '2021-07-30 10:28:44', '::1', 33),
(139, '2021-07-30 10:29:02', '::1', 23),
(140, '2021-07-30 11:42:20', '::1', 31),
(141, '2021-07-30 17:13:03', '::1', 33),
(142, '2021-08-18 17:03:58', '::1', 33),
(143, '2021-08-31 18:35:19', '::1', 33),
(144, '2021-09-04 17:07:00', '::1', 33),
(145, '2021-10-22 15:12:33', '::1', 32),
(146, '2021-10-22 15:50:21', '::1', 33),
(147, '2021-10-22 16:17:10', '::1', 24),
(148, '2021-10-22 17:48:56', '::1', 3),
(149, '2021-10-22 17:50:40', '::1', 2),
(150, '2021-11-15 15:22:53', '::1', 2),
(151, '2022-11-07 00:42:23', '::1', 1),
(152, '2022-11-07 00:42:43', '::1', 2),
(153, '2022-11-07 00:42:52', '::1', 3),
(154, '2022-11-08 13:06:12', '::1', 2),
(155, '2022-11-08 15:10:11', '::1', 11),
(156, '2022-11-08 15:12:44', '::1', 12),
(157, '2022-11-08 15:22:21', '::1', 13),
(158, '2022-11-08 22:59:15', '::1', 13),
(159, '2022-11-08 23:24:52', '::1', 3),
(160, '2022-11-08 23:25:11', '::1', 1),
(161, '2022-11-09 00:53:50', '::1', 2),
(162, '2022-11-09 02:17:09', '::1', 15),
(163, '2022-11-10 00:47:42', '::1', 1),
(164, '2022-11-10 00:54:16', '::1', 2),
(165, '2022-11-10 00:54:28', '::1', 3),
(166, '2022-11-10 01:40:44', '::1', 15),
(167, '2022-11-13 07:11:57', '::1', 15),
(168, '2022-11-13 07:12:34', '::1', 1),
(169, '2022-11-13 07:13:13', '::1', 13),
(170, '2022-11-13 11:41:12', '::1', 16),
(171, '2022-11-14 01:05:40', '::1', 13),
(172, '2022-11-14 07:25:34', '::1', 2),
(173, '2022-11-14 07:39:43', '::1', 15),
(174, '2022-12-15 08:54:26', '::1', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site`
--

CREATE TABLE `tbl_site` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `site_title` varchar(200) DEFAULT NULL,
  `site_description` text DEFAULT NULL,
  `site_favicon` varchar(50) DEFAULT NULL,
  `site_logo_header` varchar(50) DEFAULT NULL,
  `site_logo_footer` varchar(50) DEFAULT NULL,
  `site_logo_big` varchar(50) DEFAULT NULL,
  `site_facebook` varchar(150) DEFAULT NULL,
  `site_twitter` varchar(150) DEFAULT NULL,
  `site_instagram` varchar(150) DEFAULT NULL,
  `site_pinterest` varchar(150) DEFAULT NULL,
  `site_linkedin` varchar(150) DEFAULT NULL,
  `site_wa` varchar(15) DEFAULT NULL,
  `site_mail` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_site`
--

INSERT INTO `tbl_site` (`site_id`, `site_name`, `site_title`, `site_description`, `site_favicon`, `site_logo_header`, `site_logo_footer`, `site_logo_big`, `site_facebook`, `site_twitter`, `site_instagram`, `site_pinterest`, `site_linkedin`, `site_wa`, `site_mail`) VALUES
(1, 'PMII', 'PMII', 'Website Resmi Pergerakan Mahasiswa Islam Indonesia', 'favicon.png', 'apple-touch-icon2.png', 'favicon.png', 'logobig.jpg', 'https://www.facebook.com/pmiidev', 'https://twitter.com/pmiidev', 'https://www.instagram.com/pmiidev', 'https://id.pinterest.com/login/', 'https://www.linkedin.com/in/irchamali', '6285000111222', 'pmiidev9@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribe`
--

CREATE TABLE `tbl_subscribe` (
  `subscribe_id` int(11) NOT NULL,
  `subscribe_email` varchar(100) DEFAULT NULL,
  `subscribe_created_at` timestamp NULL DEFAULT current_timestamp(),
  `subscribe_status` int(11) DEFAULT 0,
  `subscribe_rating` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags`
--

CREATE TABLE `tbl_tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_tags`
--

INSERT INTO `tbl_tags` (`tag_id`, `tag_name`) VALUES
(1, 'pmii'),
(2, 'pmiidev'),
(3, 'pmiimedia'),
(4, 'pmiimaju'),
(7, 'pmiimendunia'),
(8, 'keindonesiaan'),
(9, 'keislaman'),
(10, 'kemahasiswaan'),
(11, 'kebangsaan'),
(13, 'pemuda');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `Team_id` int(11) NOT NULL,
  `Team_name` varchar(50) DEFAULT NULL,
  `Team_jabatan` varchar(50) DEFAULT NULL,
  `Team_image` varchar(50) DEFAULT NULL,
  `Team_twitter` varchar(50) DEFAULT NULL,
  `Team_facebook` varchar(50) DEFAULT NULL,
  `Team_instagram` varchar(50) DEFAULT NULL,
  `Team_linked` varchar(50) DEFAULT NULL,
  `Team_created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`Team_id`, `Team_name`, `Team_jabatan`, `Team_image`, `Team_twitter`, `Team_facebook`, `Team_instagram`, `Team_linked`, `Team_created_at`) VALUES
(1, 'Muhammad', 'Ketua ', '1671101691_f31faef320b4d9289f0e.jpg', 'https://twitter.com', 'https://facebook.com', 'https://instagram.com', 'https://linkedin.com', '2022-12-15 10:49:06'),
(2, 'Aisyah', 'Sekretaris', '1671101673_51deb8fd14c1e0e2f08c.jpg', 'https://twitter.com', 'https://facebook.com', 'https://instagram.com', 'https://linkedin.com', '2022-12-15 10:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE `tbl_testimonial` (
  `testimonial_id` int(11) NOT NULL,
  `testimonial_name` varchar(50) DEFAULT NULL,
  `testimonial_angkatan` varchar(50) DEFAULT NULL,
  `testimonial_content` text DEFAULT NULL,
  `testimonial_image` varchar(50) DEFAULT NULL,
  `testimonial_created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_testimonial`
--

INSERT INTO `tbl_testimonial` (`testimonial_id`, `testimonial_name`, `testimonial_angkatan`, `testimonial_content`, `testimonial_image`, `testimonial_created_at`) VALUES
(1, 'Muhammad', '2021-2022', 'Hello World!', '1671101002_45bb6d140f4f1a7304e6.png', '2022-12-15 10:43:22'),
(2, 'Aisyah', '2022-2023', 'Salam Pergerakan!', '1671101467_eb2be0a5d9c16adfd49d.png', '2022-12-15 10:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_kas`
--

CREATE TABLE `tbl_transaksi_kas` (
  `kode_kas` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jenis` enum('pemasukan','pengeluaran') DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaksi_kas`
--

INSERT INTO `tbl_transaksi_kas` (`kode_kas`, `user_id`, `jenis`, `jumlah`, `tanggal`, `kategori`) VALUES
('300599D8', 5, 'pemasukan', 50000, '2025-05-24', 'Donasi'),
('5411173C', 5, 'pengeluaran', 44000, '2025-05-24', 'bulanan anggota'),
('555003BC', 4, 'pemasukan', 30000, '2025-05-24', 'Donasi'),
('59F189ED', 4, 'pengeluaran', 10000, '2025-05-24', 'Donasi'),
('B5D14833', 5, 'pemasukan', 50000, '2025-05-24', 'bulanan anggota'),
('CAA8BC98', 5, 'pemasukan', 200000, '2025-05-24', 'jualan'),
('CF7AE492', 5, 'pengeluaran', 21000, '2025-05-24', 'proker'),
('E0A2EDDC', 5, 'pemasukan', 45000, '2025-05-24', 'kolaborasi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uang_kas`
--

CREATE TABLE `tbl_uang_kas` (
  `id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_uang_kas`
--

INSERT INTO `tbl_uang_kas` (`id`, `jumlah`) VALUES
(1, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(60) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_level` varchar(10) DEFAULT NULL,
  `user_status` varchar(10) DEFAULT '1',
  `user_photo` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `user_status`, `user_photo`) VALUES
(4, 'Author Dev', 'author@gmail.com', '$2y$10$t6RvwyS7bK4fywnM0JzGkuwJNfT/3/2qyXElYpm7tEiLPMmOi2DjO', '2', '1', '4894343ac02c28e5f292e7fa60ba447b.png'),
(5, 'Admin Dev', 'admin@gmail.com', '$2y$10$/8/4kk9kNyra9AHiu8TIeuUDC89/W/wAYtNIjxiGTTT../GXpQoXK', '1', '1', '225fc323cfd8ddae21b10991a6468916.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visitors`
--

CREATE TABLE `tbl_visitors` (
  `visit_id` int(11) NOT NULL,
  `visit_date` timestamp NULL DEFAULT current_timestamp(),
  `visit_ip` varchar(50) DEFAULT NULL,
  `visit_platform` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_visitors`
--

INSERT INTO `tbl_visitors` (`visit_id`, `visit_date`, `visit_ip`, `visit_platform`) VALUES
(541327, '2019-03-18 14:07:36', '::1', 'Firefox'),
(541328, '2019-03-19 03:33:51', '::1', 'Chrome'),
(541329, '2019-03-20 01:00:19', '::1', 'Chrome'),
(541330, '2019-04-05 01:53:28', '::1', 'Firefox'),
(541331, '2019-04-06 01:37:35', '::1', 'Chrome'),
(541332, '2019-04-06 23:04:12', '::1', 'Chrome'),
(541333, '2019-04-09 12:19:32', '::1', 'Chrome'),
(541334, '2019-04-10 01:33:03', '::1', 'Chrome'),
(541335, '2019-04-11 03:30:38', '::1', 'Chrome'),
(541336, '2019-04-11 03:30:38', '::1', 'Chrome'),
(541337, '2019-04-12 03:51:42', '::1', 'Chrome'),
(541338, '2019-04-12 21:55:51', '::1', 'Chrome'),
(541339, '2019-04-14 01:30:40', '::1', 'Chrome'),
(541340, '2019-04-15 01:42:53', '::1', 'Chrome'),
(541341, '2019-05-08 02:07:09', '::1', 'Chrome'),
(541342, '2019-05-21 05:55:14', '::1', 'Firefox'),
(541343, '2019-08-28 07:08:22', '::1', 'Firefox'),
(541344, '2019-12-17 06:04:57', '::1', 'Firefox'),
(541345, '2019-12-18 01:34:25', '::1', 'Firefox'),
(541346, '2019-12-19 02:21:23', '::1', 'Firefox'),
(541347, '2019-12-20 07:47:00', '::1', 'Firefox'),
(541348, '2019-12-28 02:58:34', '::1', 'Firefox'),
(541349, '2019-12-29 08:48:39', '::1', 'Firefox'),
(541350, '2019-12-30 03:24:04', '::1', 'Firefox'),
(541351, '2019-12-31 02:47:15', '::1', 'Firefox'),
(541352, '2020-01-01 02:24:55', '::1', 'Firefox'),
(541353, '2020-01-02 01:58:25', '::1', 'Firefox'),
(541354, '2020-01-03 03:15:30', '::1', 'Firefox'),
(541355, '2020-01-04 03:31:49', '::1', 'Firefox'),
(541356, '2020-01-05 06:58:35', '127.0.0.1', 'Firefox'),
(541357, '2020-01-06 06:03:25', '::1', 'Firefox'),
(541358, '2020-01-07 00:57:59', '::1', 'Firefox'),
(541359, '2020-01-08 05:53:44', '::1', 'Firefox'),
(541360, '2020-01-12 04:18:15', '::1', 'Firefox'),
(541361, '2020-01-27 13:54:20', '::1', 'Chrome'),
(541362, '2020-01-27 17:03:12', '::1', 'Chrome'),
(541363, '2020-01-29 06:16:34', '::1', 'Chrome'),
(541364, '2020-01-29 17:07:41', '::1', 'Chrome'),
(541365, '2020-02-01 07:10:48', '::1', 'Chrome'),
(541366, '2020-02-08 04:10:12', '::1', 'Chrome'),
(541367, '2020-03-23 11:34:09', '::1', 'Chrome'),
(541368, '2020-04-10 16:29:23', '::1', 'Chrome'),
(541369, '2020-04-11 13:57:38', '::1', 'Chrome'),
(541370, '2020-04-16 06:37:49', '::1', 'Chrome'),
(541371, '2020-04-20 12:31:53', '::1', 'Chrome'),
(541372, '2020-07-11 13:37:15', '::1', 'Chrome'),
(541373, '2020-07-27 10:39:05', '::1', 'Chrome'),
(541374, '2020-07-28 03:21:12', '::1', 'Chrome'),
(541375, '2020-10-18 16:51:19', '::1', 'Chrome'),
(541376, '2020-10-19 03:59:15', '::1', 'Chrome'),
(541377, '2020-10-20 05:15:15', '::1', 'Chrome'),
(541378, '2020-10-20 17:05:05', '::1', 'Chrome'),
(541379, '2020-10-22 00:42:32', '::1', 'Chrome'),
(541380, '2020-10-23 16:47:35', '::1', 'Chrome'),
(541381, '2020-11-06 10:22:09', '::1', 'Chrome'),
(541382, '2020-11-14 05:17:18', '::1', 'Chrome'),
(541383, '2020-11-14 17:06:44', '::1', 'Chrome'),
(541384, '2020-11-15 17:00:03', '::1', 'Chrome'),
(541385, '2020-11-16 17:05:16', '::1', 'Chrome'),
(541386, '2020-11-18 04:08:49', '::1', 'Chrome'),
(541387, '2020-11-19 13:09:52', '::1', 'Chrome'),
(541388, '2020-11-19 17:45:32', '::1', 'Chrome'),
(541389, '2020-11-21 05:06:14', '::1', 'Chrome'),
(541390, '2020-11-21 17:00:54', '::1', 'Chrome'),
(541391, '2020-12-26 14:24:04', '::1', 'Chrome'),
(541392, '2021-07-01 13:35:17', '::1', 'Chrome'),
(541393, '2021-07-01 17:57:09', '::1', 'Chrome'),
(541394, '2021-07-03 05:04:57', '::1', 'Chrome'),
(541395, '2021-07-03 17:02:54', '::1', 'Chrome'),
(541396, '2021-07-07 09:18:16', '::1', 'Chrome'),
(541397, '2021-07-15 02:37:30', '::1', 'Chrome'),
(541398, '2021-07-17 05:19:51', '::1', 'Chrome'),
(541399, '2021-07-18 15:11:33', '::1', 'Chrome'),
(541400, '2021-07-20 07:41:24', '::1', 'Chrome'),
(541401, '2021-07-24 11:47:28', '::1', 'Chrome'),
(541402, '2021-07-25 05:19:56', '::1', 'Chrome'),
(541403, '2021-07-26 00:55:45', '::1', 'Chrome'),
(541404, '2021-07-26 17:34:56', '::1', 'Chrome'),
(541405, '2021-07-29 09:48:11', '::1', 'Chrome'),
(541406, '2021-07-30 07:37:48', '::1', 'Chrome'),
(541407, '2021-07-30 17:13:03', '::1', 'Chrome'),
(541408, '2021-08-11 08:18:27', '::1', 'Chrome'),
(541409, '2021-08-17 18:34:52', '::1', 'Chrome'),
(541410, '2021-08-18 17:03:10', '::1', 'Chrome'),
(541411, '2021-08-19 17:02:58', '::1', 'Chrome'),
(541412, '2021-08-20 17:22:43', '::1', 'Chrome'),
(541413, '2021-08-22 09:32:28', '::1', 'Chrome'),
(541414, '2021-08-23 03:36:58', '::1', 'Chrome'),
(541415, '2021-08-27 02:48:46', '::1', 'Chrome'),
(541416, '2021-08-31 18:35:04', '::1', 'Chrome'),
(541417, '2021-09-02 01:57:14', '::1', 'Chrome'),
(541418, '2021-09-04 17:06:47', '::1', 'Chrome'),
(541419, '2021-10-02 15:28:31', '::1', 'Chrome'),
(541420, '2021-10-12 17:59:47', '::1', 'Chrome'),
(541421, '2021-10-21 15:56:53', '::1', 'Chrome'),
(541422, '2021-10-21 17:00:19', '::1', 'Chrome'),
(541423, '2021-10-22 17:05:50', '::1', 'Chrome'),
(541424, '2021-11-15 15:14:32', '::1', 'Chrome'),
(541425, '2022-11-07 00:37:20', '::1', 'Chrome 107.0.0.0'),
(541426, '2022-11-08 01:13:09', '::1', 'Chrome 107.0.0.0'),
(541427, '2022-11-08 22:55:58', '::1', 'Chrome 107.0.0.0'),
(541428, '2022-11-10 00:41:23', '::1', 'Chrome 107.0.0.0'),
(541429, '2022-11-11 06:47:42', '::1', 'Chrome 107.0.0.0'),
(541430, '2022-11-12 06:05:44', '::1', 'Chrome 107.0.0.0'),
(541431, '2022-11-12 22:54:02', '::1', 'Chrome 107.0.0.0'),
(541432, '2022-11-14 00:48:24', '::1', 'Chrome 107.0.0.0'),
(541433, '2022-12-15 08:53:08', '::1', 'Chrome 108.0.0.0'),
(541434, '2025-05-21 08:00:19', '::1', 'Edge 136.0.0.0'),
(541435, '2025-05-22 00:57:18', '::1', 'Edge 136.0.0.0'),
(541436, '2025-05-23 01:13:08', '::1', 'Edge 136.0.0.0'),
(541437, '2025-05-24 04:54:44', '::1', 'Edge 136.0.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_about`
--
ALTER TABLE `tbl_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_home`
--
ALTER TABLE `tbl_home`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `tbl_inbox`
--
ALTER TABLE `tbl_inbox`
  ADD PRIMARY KEY (`inbox_id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tbl_navbar`
--
ALTER TABLE `tbl_navbar`
  ADD PRIMARY KEY (`navbar_id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_post_views`
--
ALTER TABLE `tbl_post_views`
  ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `tbl_site`
--
ALTER TABLE `tbl_site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `tbl_subscribe`
--
ALTER TABLE `tbl_subscribe`
  ADD PRIMARY KEY (`subscribe_id`);

--
-- Indexes for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`Team_id`);

--
-- Indexes for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `tbl_transaksi_kas`
--
ALTER TABLE `tbl_transaksi_kas`
  ADD PRIMARY KEY (`kode_kas`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_uang_kas`
--
ALTER TABLE `tbl_uang_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_visitors`
--
ALTER TABLE `tbl_visitors`
  ADD PRIMARY KEY (`visit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_about`
--
ALTER TABLE `tbl_about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_home`
--
ALTER TABLE `tbl_home`
  MODIFY `home_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inbox`
--
ALTER TABLE `tbl_inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_navbar`
--
ALTER TABLE `tbl_navbar`
  MODIFY `navbar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_post_views`
--
ALTER TABLE `tbl_post_views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `tbl_site`
--
ALTER TABLE `tbl_site`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_subscribe`
--
ALTER TABLE `tbl_subscribe`
  MODIFY `subscribe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `Team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_visitors`
--
ALTER TABLE `tbl_visitors`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541438;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_transaksi_kas`
--
ALTER TABLE `tbl_transaksi_kas`
  ADD CONSTRAINT `tbl_transaksi_kas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
