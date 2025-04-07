-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 07. 19:36
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `turist`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `attractions`
--

CREATE TABLE `attractions` (
  `attractions_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('Múzeumok','Természeti látnivalók','Történelmi helyek','Szórakoztató helyek','Vallási helyek','Kulturális események') DEFAULT NULL,
  `interest` enum('Családbarát','Kalandturizmus','Kultúra és művészetek','Gasztronómia','Történelem','Sport') DEFAULT NULL,
  `open` time NOT NULL,
  `closed` time NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `attractions`
--

INSERT INTO `attractions` (`attractions_id`, `city_name`, `name`, `description`, `address`, `created_by`, `image`, `created_at`, `type`, `interest`, `open`, `closed`, `price`) VALUES
(1, 'Szabadka', 'Raichle-palota', 'A szecesszió egyik legszebb példája Vajdaságban.', 'Park Rajhl Ferenca 5', 'Admin', 'Raichle.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Családbarát', '00:00:00', '00:00:00', 0.00),
(2, 'Zenta', 'Zentai csata emlékmű', 'A híres 1697-es zentai csata emlékére épült.', 'Fő tér 1.', 'Admin', 'Zenta_emlekmu.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem', '00:00:00', '00:00:00', 0.00),
(3, 'Újvidék', 'Petrovaradini erőd', 'Egyik legjobb állapotban megmaradt barokk kori erődítmény.', 'Petrovaradin', 'Admin', 'Petrovaradin.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem', '00:00:00', '00:00:00', 0.00),
(4, 'Palics', 'Palicsi tó', 'Híres üdülőhely, a tó és környező parkjai.', 'Palics', 'Admin', 'Palics.jpg', '2024-12-10 14:03:17', 'Természeti látnivalók', 'Családbarát', '00:00:00', '00:00:00', 0.00),
(5, 'Magyarkanizsa', 'Termálfürdő', 'Híres gyógyfürdő, kellemes kikapcsolódásra.', 'Fürdő utca 2.', 'Admin', 'Magyarkanizsa_furdo.jpg', '2024-12-10 14:03:17', 'Szórakoztató helyek', 'Családbarát', '00:00:00', '00:00:00', 0.00),
(6, 'Szabadka', 'Zsinagóga', 'A világ egyik legszebb szecessziós zsinagógája.', 'Trg Jakaba i Komora 6', 'Admin', 'Szabadka_zsinagoga.jpg', '2024-12-10 14:03:17', 'Vallási helyek', 'Családbarát', '00:00:00', '00:00:00', 0.00),
(7, 'Óbecse', 'Fantast kastély', 'Különleges kastély egy szép park közepén.', 'Óbecse', 'Admin', 'Fantast.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem', '00:00:00', '00:00:00', 0.00),
(8, 'Újvidék', 'Duna-part', 'Kiváló sétahely gyönyörű kilátással a Dunára.', 'Duna-part', 'Admin', 'Ujvidek_duna.jpg', '2024-12-10 14:03:17', 'Természeti látnivalók', 'Családbarát', '00:00:00', '00:00:00', 0.00),
(9, 'Szenttamás', 'Gazdag Árpád-ház templom', 'Történelmi jelentőségű templom.', 'Fő tér', 'Admin', 'Szenttamas.jpg', '2024-12-10 14:03:17', 'Vallási helyek', 'Kultúra és művészetek', '00:00:00', '00:00:00', 0.00),
(10, 'Verbász', 'Verbászi kastély', 'Gyönyörű, klasszicista stílusú kastély.', 'Verbász', 'Admin', 'Verbasz_kastely.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem', '00:00:00', '00:00:00', 0.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `author`, `image`, `created_at`) VALUES
(1, 'Fedezd fel Vajdaság szépségeit!', 'Vajdaság, a Duna partján fekvő régió, gazdag történelemmel, kultúrával és természeti kincsekkel büszkélkedhet. Ha szeretnél elvonulni a nyüzsgő városok forgatagából, és egy autentikusabb, csendesebb helyen pihenni, Vajdaság tökéletes választás!\r\n\r\n1. Szabadka - A kultúra és a történelem városa\r\n\r\nSzabadka, a régió egyik legfontosabb városa, egyedülálló hangulattal várja látogatóit. A város nevezetességei között szerepel a lenyűgöző Városháza, valamint a híres Szabadkai Színház, ahol számos kultúrális esemény és előadás várja a közönséget. Szabadka igazi központja a Ferences templom és a város hangulatos főtere, ahol számos kávézó és étterem kínál helyi specialitásokat.\r\n\r\n2. Palicsi-tó - A pihenés és a természet szerelmeseinek\r\n\r\nA Palicsi-tó Vajdaság egyik legszebb természeti kincse. A tó környéke ideális helyszín a pihenésre, túrázásra, kerékpározásra, de a horgászat szerelmesei is megtalálják a számításaikat. A tóparton sétálva gyönyörű kilátásban gyönyörködhetünk, a híres Palicsi Állatkert pedig különleges élményeket kínál a családok számára.\r\n\r\n3. Novi Sad - A Duna partján fekvő kulturális központ\r\n\r\nNovi Sad, Vajdaság fővárosa, egy dinamikus és modern város, amely a Duna partján terül el. A város legismertebb nevezetessége a Petrovaradíni erőd, amely lélegzetelállító kilátást nyújt a folyóra és a városra. Novi Sad minden évben otthont ad a híres Exit Fesztiválnak, amely a zenei rendezvények egyik legnagyobb és legfontosabb eseménye a régióban.\r\n\r\n4. Törökkanizsa - A történelmi település varázsa\r\n\r\nTörökkanizsa, egy aprócska, de annál szebb település, amelyet a török idők hagyatéka is gazdagít. A város történelmi látnivalói, mint például a Török-kút és a régi mecsetek, elvarázsolják az ide látogatókat. A helyi piacokon pedig friss helyi termékek kaphatók, amelyek igazi kulináris élményt nyújtanak.\r\n\r\n5. Termálfürdők és wellness élmények\r\n\r\nVajdaság területén számos termálfürdő található, ahol a pihenés és a regenerálódás minden igényt kielégít. A legnépszerűbbek közé tartozik a Senta, a Kikinda és a Vrdnik-i termálfürdők, ahol nemcsak a víz gyógyító hatása, hanem a modern wellness szolgáltatások is várják a látogatókat.\r\n\r\nBefejezésül\r\n\r\nVajdaság valódi kincsesbánya minden utazó számára. A régió sokszínűsége, gazdag történelme és lenyűgöző tájai mindenkit rabul ejtenek. Ha szeretnél egy olyan helyet felfedezni, ahol a történelem, a kultúra és a természet tökéletes harmóniában találkozik, Vajdaság tökéletes úti cél!', 'Kiss Ádám', 'vajdasag_blog.jpg', '2024-12-10 14:03:36'),
(2, 'A palicsi tó története', 'Palics titkai és története.', 'Nagy Réka', 'palics_tortenet.jpg', '2024-12-10 14:03:36'),
(3, 'Mitől különleges a Petrovaradini erőd?', 'Ismerd meg a híres erőd részleteit!', 'Tóth László', 'petrovaradin_blog.jpg', '2024-12-10 14:03:36'),
(4, 'Zentai csata: történelem nyomában', 'Egy híres ütközet, amely a történelemkönyvek része.', 'Horváth Anna', 'zentai_csata_blog.jpg', '2024-12-10 14:03:36'),
(5, 'Kastélyok Vajdaságban', 'Fedezd fel a vajdasági kastélyok szépségeit.', 'Kovács Péter', 'kastelyok_blog.jpg', '2024-12-10 14:03:36'),
(6, 'Termálfürdők a régióban', 'A legjobb gyógyfürdők és termálfürdők Vajdaságban.', 'Farkas Tamás', 'termalfurdok.jpg', '2024-12-10 14:03:36'),
(7, 'A szecesszió csodái Szabadkán', 'Szabadka szecessziós építészeti kincsei.', 'Molnár Laura', 'szecesszio_szabadka.jpg', '2024-12-10 14:03:36'),
(8, 'Újvidék éjszakai élete', 'Bárok, kávézók és bulik Újvidéken.', 'Szabó Márk', 'ujvidek_ejszakai.jpg', '2024-12-10 14:03:36'),
(9, 'Történelmi templomok Vajdaságban', 'Fedezd fel Vajdaság régi templomait.', 'Boros Lilla', 'templomok_blog.jpg', '2024-12-10 14:03:36'),
(10, 'Duna-parti séták', 'A Duna-part Újvidéken és környékén.', 'Király Zsófia', 'duna_part.jpg', '2024-12-10 14:03:36');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cities`
--

INSERT INTO `cities` (`city_id`, `country_name`, `city_name`, `zip_code`, `created_at`) VALUES
(1, 'Szerbia', 'Szabadka', '24000', '2024-12-10 14:03:52'),
(2, 'Szerbia', 'Újvidék', '21000', '2024-12-10 14:03:52'),
(3, 'Szerbia', 'Zenta', '24400', '2024-12-10 14:03:52'),
(4, 'Szerbia', 'Óbecse', '21220', '2024-12-10 14:03:52'),
(5, 'Szerbia', 'Magyarkanizsa', '24420', '2024-12-10 14:03:52'),
(6, 'Szerbia', 'Palics', '24413', '2024-12-10 14:03:52'),
(7, 'Szerbia', 'Verbász', '21460', '2024-12-10 14:03:52'),
(8, 'Szerbia', 'Szenttamás', '21480', '2024-12-10 14:03:52'),
(9, 'Szerbia', 'Topolya', '24300', '2024-12-10 14:03:52'),
(10, 'Szerbia', 'Temerin', '21235', '2024-12-10 14:03:52');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `filter_search_statistics`
--

CREATE TABLE `filter_search_statistics` (
  `id` int(11) NOT NULL,
  `filter_name` varchar(255) NOT NULL,
  `filter_value` varchar(255) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `filter_search_statistics`
--

INSERT INTO `filter_search_statistics` (`id`, `filter_name`, `filter_value`, `count`) VALUES
(1, 'city', 'Palics', 16),
(3, 'type', 'Történelmi helyek', 15),
(4, 'interest', 'Történelem', 8),
(6, 'type', 'Szórakoztató helyek', 10),
(7, 'city', 'Óbecse', 15),
(11, 'city', 'Szabadka', 21),
(25, 'city', 'Szenttamás', 15),
(27, 'interest', 'Kultúra és művészetek', 9),
(31, 'type', 'Vallási helyek', 9),
(34, 'Város', 'Magyarkanizsa', 10),
(35, 'Város', 'Újvidék', 12),
(36, 'type', 'Természeti látnivalók', 9),
(37, 'interest', 'Családbarát', 19),
(39, 'city', 'Verbász', 1),
(40, 'city', 'Magyarkanizsa', 19),
(41, 'city', 'Újvidék', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(42) NOT NULL,
  `country` varchar(128) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `device_type` set('phone','tablet','computer') NOT NULL,
  `proxy` tinyint(1) NOT NULL,
  `isp` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `log`
--

INSERT INTO `log` (`id_log`, `user_agent`, `ip_address`, `country`, `date_time`, `device_type`, `proxy`, `isp`) VALUES
(1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-01-22 20:52:43', 'computer', 0, 'KE-ING'),
(2, 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25', '119.14.26.0', 'Taiwan', '2025-01-22 20:52:58', 'phone', 0, 'KE-ING'),
(3, 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25', '119.14.26.0', 'Taiwan', '2025-01-22 20:53:17', 'phone', 0, 'KE-ING'),
(4, 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25', '119.14.26.0', 'Taiwan', '2025-01-22 21:03:29', 'phone', 0, 'KE-ING'),
(5, 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25', '119.14.26.0', 'Taiwan', '2025-01-22 21:04:09', 'phone', 0, 'KE-ING'),
(6, 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25', '119.14.26.0', 'Taiwan', '2025-01-22 21:05:10', 'phone', 0, 'KE-ING'),
(7, 'Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-01-22 21:15:06', 'phone', 0, 'KE-ING'),
(8, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-01-22 21:15:18', 'computer', 0, 'KE-ING'),
(9, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-01-22 22:16:30', 'computer', 0, 'KE-ING'),
(10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-01-22 22:16:44', 'computer', 0, 'KE-ING'),
(11, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:15:43', 'computer', 0, 'KE-ING'),
(12, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:38:10', 'computer', 0, 'KE-ING'),
(13, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:45:29', 'phone', 0, 'KE-ING'),
(14, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:46:37', 'computer', 0, 'KE-ING'),
(15, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:47:29', 'computer', 0, 'KE-ING'),
(16, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:48:06', 'computer', 0, 'KE-ING'),
(17, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:49:03', 'phone', 0, 'KE-ING'),
(18, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:49:43', 'phone', 0, 'KE-ING'),
(19, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 20:57:21', 'computer', 0, 'KE-ING'),
(20, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 21:02:16', 'computer', 0, 'KE-ING'),
(21, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-14 21:12:34', 'computer', 0, 'KE-ING'),
(22, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:03:40', 'computer', 0, 'KE-ING'),
(23, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:24:01', 'computer', 0, 'KE-ING'),
(24, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:24:18', 'computer', 0, 'KE-ING'),
(25, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:25:58', 'phone', 0, 'KE-ING'),
(26, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:32:20', 'computer', 0, 'KE-ING'),
(27, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:43:37', 'computer', 0, 'KE-ING'),
(28, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:45:24', 'computer', 0, 'KE-ING'),
(29, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:53:26', 'computer', 0, 'KE-ING'),
(30, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 17:53:51', 'computer', 0, 'KE-ING'),
(31, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:00:25', 'computer', 0, 'KE-ING'),
(32, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:00:38', 'phone', 0, 'KE-ING'),
(33, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:01:03', 'computer', 0, 'KE-ING'),
(34, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:01:38', 'computer', 0, 'KE-ING'),
(35, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:04:45', 'computer', 0, 'KE-ING'),
(36, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:04:59', 'computer', 0, 'KE-ING'),
(37, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:05:03', 'computer', 0, 'KE-ING'),
(38, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:05:16', 'computer', 0, 'KE-ING'),
(39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:05:18', 'computer', 0, 'KE-ING'),
(40, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:05:41', 'computer', 0, 'KE-ING'),
(41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:05:53', 'computer', 0, 'KE-ING'),
(42, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:07:16', 'computer', 0, 'KE-ING'),
(43, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:07:40', 'computer', 0, 'KE-ING'),
(44, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:07:41', 'computer', 0, 'KE-ING'),
(45, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:18:37', 'computer', 0, 'KE-ING'),
(46, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:19:32', 'computer', 0, 'KE-ING'),
(47, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:19:43', 'computer', 0, 'KE-ING'),
(48, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:20:36', 'computer', 0, 'KE-ING'),
(49, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:32:43', 'computer', 0, 'KE-ING'),
(50, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:50:39', 'computer', 0, 'KE-ING'),
(51, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:50:54', 'computer', 0, 'KE-ING'),
(52, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:51:32', 'computer', 0, 'KE-ING'),
(53, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:52:06', 'computer', 0, 'KE-ING'),
(54, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:52:21', 'computer', 0, 'KE-ING'),
(55, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:10', 'computer', 0, 'KE-ING'),
(56, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:11', 'computer', 0, 'KE-ING'),
(57, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(58, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(59, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(60, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(61, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(62, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(63, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 18:53:12', 'computer', 0, 'KE-ING'),
(64, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:03:29', 'computer', 0, 'KE-ING'),
(65, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:03:44', 'computer', 0, 'KE-ING'),
(66, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:04:57', 'computer', 0, 'KE-ING'),
(67, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:09:30', 'phone', 0, 'KE-ING'),
(68, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:43:06', 'computer', 0, 'KE-ING'),
(69, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:44:35', 'computer', 0, 'KE-ING'),
(70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:44:53', 'computer', 0, 'KE-ING'),
(71, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:45:49', 'phone', 0, 'KE-ING'),
(72, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:46:08', 'phone', 0, 'KE-ING'),
(73, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:48:52', 'phone', 0, 'KE-ING'),
(74, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:49:33', 'computer', 0, 'KE-ING'),
(75, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:50:55', 'computer', 0, 'KE-ING'),
(76, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:53:20', 'computer', 0, 'KE-ING'),
(77, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:55:15', 'computer', 0, 'KE-ING'),
(78, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:57:19', 'computer', 0, 'KE-ING'),
(79, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 19:58:17', 'computer', 0, 'KE-ING'),
(80, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-24 20:00:33', 'computer', 0, 'KE-ING'),
(81, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 18:07:20', 'computer', 0, 'KE-ING'),
(82, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 18:26:50', 'computer', 0, 'KE-ING'),
(83, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:18:35', 'computer', 0, 'KE-ING'),
(84, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:18:53', 'computer', 0, 'KE-ING'),
(85, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:28:50', 'computer', 0, 'KE-ING'),
(86, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:29:57', 'computer', 0, 'KE-ING'),
(87, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:33:47', 'computer', 0, 'KE-ING'),
(88, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:34:04', 'computer', 0, 'KE-ING'),
(89, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:35:01', 'computer', 0, 'KE-ING'),
(90, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:35:18', 'computer', 0, 'KE-ING'),
(91, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 19:35:44', 'computer', 0, 'KE-ING'),
(92, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:02:48', 'computer', 0, 'KE-ING'),
(93, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:10:37', 'computer', 0, 'KE-ING'),
(94, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:12:18', 'computer', 0, 'KE-ING'),
(95, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:13:22', 'computer', 0, 'KE-ING'),
(96, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:15:28', 'phone', 0, 'KE-ING'),
(97, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:16:24', 'phone', 0, 'KE-ING'),
(98, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:17:54', 'phone', 0, 'KE-ING'),
(99, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:18:48', 'phone', 0, 'KE-ING'),
(100, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:19:22', 'phone', 0, 'KE-ING'),
(101, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:19:33', 'computer', 0, 'KE-ING'),
(102, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:20:51', 'computer', 0, 'KE-ING'),
(103, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:21:14', 'computer', 0, 'KE-ING'),
(104, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:21:31', 'computer', 0, 'KE-ING'),
(105, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:21:53', 'computer', 0, 'KE-ING'),
(106, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:22:06', 'computer', 0, 'KE-ING'),
(107, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-02-27 20:24:06', 'computer', 0, 'KE-ING'),
(108, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 12:43:09', 'computer', 0, 'KE-ING'),
(109, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 12:47:13', 'computer', 0, 'KE-ING'),
(110, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 12:47:29', 'computer', 0, 'KE-ING'),
(111, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 12:50:45', 'computer', 0, 'KE-ING'),
(112, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 13:12:46', 'computer', 0, 'KE-ING'),
(113, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 13:12:59', 'phone', 0, 'KE-ING'),
(114, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-01 13:13:26', 'phone', 0, 'KE-ING'),
(115, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 18:45:39', 'computer', 0, 'KE-ING'),
(116, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 18:51:22', 'phone', 0, 'KE-ING'),
(117, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 18:52:19', 'phone', 0, 'KE-ING'),
(118, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 18:53:59', 'phone', 0, 'KE-ING'),
(119, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 18:58:13', 'computer', 0, 'KE-ING'),
(120, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:04:33', 'computer', 0, 'KE-ING'),
(121, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:08:56', 'computer', 0, 'KE-ING'),
(122, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:11:47', 'computer', 0, 'KE-ING'),
(123, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:15:43', 'computer', 0, 'KE-ING'),
(124, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:16:33', 'computer', 0, 'KE-ING'),
(125, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:21:50', 'phone', 0, 'KE-ING'),
(126, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:22:54', 'phone', 0, 'KE-ING'),
(127, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:24:35', 'computer', 0, 'KE-ING'),
(128, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:31:17', 'computer', 0, 'KE-ING'),
(129, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:33:38', 'phone', 0, 'KE-ING'),
(130, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:35:30', 'phone', 0, 'KE-ING'),
(131, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:37:33', 'phone', 0, 'KE-ING'),
(132, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:38:15', 'phone', 0, 'KE-ING'),
(133, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:38:41', 'phone', 0, 'KE-ING'),
(134, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:39:15', 'phone', 0, 'KE-ING'),
(135, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:40:31', 'phone', 0, 'KE-ING'),
(136, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:41:05', 'phone', 0, 'KE-ING'),
(137, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:43:26', 'phone', 0, 'KE-ING'),
(138, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:44:46', 'phone', 0, 'KE-ING'),
(139, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:45:13', 'phone', 0, 'KE-ING'),
(140, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:45:28', 'phone', 0, 'KE-ING'),
(141, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:46:45', 'phone', 0, 'KE-ING'),
(142, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:46:56', 'phone', 0, 'KE-ING'),
(143, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:48:57', 'phone', 0, 'KE-ING'),
(144, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:50:00', 'phone', 0, 'KE-ING'),
(145, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:50:27', 'phone', 0, 'KE-ING'),
(146, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:50:37', 'phone', 0, 'KE-ING'),
(147, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:50:52', 'phone', 0, 'KE-ING'),
(148, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 19:51:57', 'phone', 0, 'KE-ING'),
(149, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 20:03:02', 'phone', 0, 'KE-ING'),
(150, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 20:04:20', 'phone', 0, 'KE-ING'),
(151, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 20:14:01', 'phone', 0, 'KE-ING'),
(152, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-03 20:20:47', 'phone', 0, 'KE-ING'),
(153, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 17:25:35', 'computer', 0, 'KE-ING'),
(154, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 17:41:06', 'computer', 0, 'KE-ING'),
(155, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:01:43', 'computer', 0, 'KE-ING'),
(156, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:03:57', 'computer', 0, 'KE-ING'),
(157, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:06:14', 'computer', 0, 'KE-ING'),
(158, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:06:33', 'computer', 0, 'KE-ING'),
(159, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:16:04', 'computer', 0, 'KE-ING'),
(160, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:17:11', 'computer', 0, 'KE-ING'),
(161, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:30:58', 'computer', 0, 'KE-ING'),
(162, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:32:38', 'computer', 0, 'KE-ING'),
(163, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:14', 'computer', 0, 'KE-ING'),
(164, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:14', 'computer', 0, 'KE-ING'),
(165, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:14', 'computer', 0, 'KE-ING'),
(166, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:14', 'computer', 0, 'KE-ING'),
(167, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:15', 'computer', 0, 'KE-ING'),
(168, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:15', 'computer', 0, 'KE-ING'),
(169, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:15', 'computer', 0, 'KE-ING'),
(170, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:15', 'computer', 0, 'KE-ING'),
(171, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:56:15', 'computer', 0, 'KE-ING'),
(172, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:03', 'computer', 0, 'KE-ING'),
(173, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:03', 'computer', 0, 'KE-ING'),
(174, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:03', 'computer', 0, 'KE-ING'),
(175, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(176, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(177, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(178, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(179, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(180, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:57:04', 'computer', 0, 'KE-ING'),
(181, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:58:11', 'computer', 0, 'KE-ING'),
(182, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:58:34', 'computer', 0, 'KE-ING'),
(183, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 19:58:48', 'computer', 0, 'KE-ING'),
(184, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:00:19', 'computer', 0, 'KE-ING'),
(185, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:01:03', 'computer', 0, 'KE-ING'),
(186, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:02:44', 'computer', 0, 'KE-ING'),
(187, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:03:59', 'computer', 0, 'KE-ING'),
(188, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:05:28', 'computer', 0, 'KE-ING'),
(189, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:05:44', 'computer', 0, 'KE-ING'),
(190, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:14:29', 'computer', 0, 'KE-ING'),
(191, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:16:10', 'computer', 0, 'KE-ING'),
(192, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:17:06', 'computer', 0, 'KE-ING'),
(193, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:17:34', 'computer', 0, 'KE-ING'),
(194, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:18:08', 'computer', 0, 'KE-ING'),
(195, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:18:34', 'computer', 0, 'KE-ING'),
(196, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:19:44', 'computer', 0, 'KE-ING'),
(197, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:20:13', 'computer', 0, 'KE-ING'),
(198, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:26:55', 'computer', 0, 'KE-ING'),
(199, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:27:11', 'computer', 0, 'KE-ING'),
(200, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:29:00', 'computer', 0, 'KE-ING'),
(201, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:35:12', 'computer', 0, 'KE-ING'),
(202, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:37:06', 'computer', 0, 'KE-ING'),
(203, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:42:06', 'computer', 0, 'KE-ING'),
(204, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:44:24', 'computer', 0, 'KE-ING'),
(205, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:47:20', 'computer', 0, 'KE-ING'),
(206, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:47:58', 'computer', 0, 'KE-ING'),
(207, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:49:00', 'computer', 0, 'KE-ING'),
(208, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:49:48', 'computer', 0, 'KE-ING'),
(209, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:50:41', 'computer', 0, 'KE-ING'),
(210, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 20:51:20', 'computer', 0, 'KE-ING'),
(211, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:04:28', 'computer', 0, 'KE-ING'),
(212, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:06:53', 'computer', 0, 'KE-ING'),
(213, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:08:01', 'computer', 0, 'KE-ING'),
(214, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:09:52', 'computer', 0, 'KE-ING'),
(215, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:11:52', 'computer', 0, 'KE-ING'),
(216, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:12:10', 'computer', 0, 'KE-ING'),
(217, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:13:07', 'computer', 0, 'KE-ING'),
(218, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:16:19', 'computer', 0, 'KE-ING'),
(219, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:17:16', 'computer', 0, 'KE-ING'),
(220, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:19:31', 'computer', 0, 'KE-ING'),
(221, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:24:17', 'computer', 0, 'KE-ING'),
(222, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:35:16', 'computer', 0, 'KE-ING'),
(223, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:37:25', 'computer', 0, 'KE-ING'),
(224, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:38:52', 'computer', 0, 'KE-ING'),
(225, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:39:39', 'computer', 0, 'KE-ING'),
(226, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:43:25', 'computer', 0, 'KE-ING'),
(227, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:45:01', 'computer', 0, 'KE-ING'),
(228, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:46:57', 'computer', 0, 'KE-ING'),
(229, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:56:47', 'computer', 0, 'KE-ING'),
(230, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:58:09', 'computer', 0, 'KE-ING'),
(231, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:58:26', 'computer', 0, 'KE-ING'),
(232, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:58:46', 'computer', 0, 'KE-ING'),
(233, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:59:03', 'computer', 0, 'KE-ING'),
(234, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 21:59:41', 'computer', 0, 'KE-ING'),
(235, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:08:16', 'computer', 0, 'KE-ING'),
(236, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:11:34', 'computer', 0, 'KE-ING'),
(237, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:14:39', 'computer', 0, 'KE-ING'),
(238, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:18:44', 'computer', 0, 'KE-ING'),
(239, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:20:35', 'computer', 0, 'KE-ING'),
(240, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:22:54', 'computer', 0, 'KE-ING'),
(241, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:25:39', 'computer', 0, 'KE-ING'),
(242, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:26:33', 'computer', 0, 'KE-ING'),
(243, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-04 22:27:53', 'computer', 0, 'KE-ING'),
(244, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:36:57', 'computer', 0, 'KE-ING'),
(245, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:37:53', 'computer', 0, 'KE-ING'),
(246, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:41:43', 'computer', 0, 'KE-ING'),
(247, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:42:24', 'computer', 0, 'KE-ING'),
(248, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:43:13', 'computer', 0, 'KE-ING'),
(249, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:43:31', 'computer', 0, 'KE-ING'),
(250, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:44:13', 'computer', 0, 'KE-ING'),
(251, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:44:30', 'computer', 0, 'KE-ING'),
(252, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:44:40', 'computer', 0, 'KE-ING'),
(253, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:48:11', 'computer', 0, 'KE-ING'),
(254, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:50:32', 'computer', 0, 'KE-ING');
INSERT INTO `log` (`id_log`, `user_agent`, `ip_address`, `country`, `date_time`, `device_type`, `proxy`, `isp`) VALUES
(255, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:50:56', 'computer', 0, 'KE-ING'),
(256, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:51:08', 'computer', 0, 'KE-ING'),
(257, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:52:58', 'computer', 0, 'KE-ING'),
(258, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 20:58:31', 'computer', 0, 'KE-ING'),
(259, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:00:39', 'computer', 0, 'KE-ING'),
(260, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:02:18', 'computer', 0, 'KE-ING'),
(261, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:04:38', 'computer', 0, 'KE-ING'),
(262, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:04:54', 'computer', 0, 'KE-ING'),
(263, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:11:40', 'computer', 0, 'KE-ING'),
(264, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:16:15', 'computer', 0, 'KE-ING'),
(265, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:17:12', 'computer', 0, 'KE-ING'),
(266, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:19:00', 'computer', 0, 'KE-ING'),
(267, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:19:56', 'computer', 0, 'KE-ING'),
(268, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:23:27', 'computer', 0, 'KE-ING'),
(269, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:23:42', 'computer', 0, 'KE-ING'),
(270, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:24:00', 'computer', 0, 'KE-ING'),
(271, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:27:06', 'computer', 0, 'KE-ING'),
(272, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:29:23', 'computer', 0, 'KE-ING'),
(273, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:30:32', 'computer', 0, 'KE-ING'),
(274, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:31:01', 'computer', 0, 'KE-ING'),
(275, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:32:18', 'computer', 0, 'KE-ING'),
(276, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:32:41', 'computer', 0, 'KE-ING'),
(277, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:32:56', 'computer', 0, 'KE-ING'),
(278, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:33:09', 'computer', 0, 'KE-ING'),
(279, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:34:12', 'computer', 0, 'KE-ING'),
(280, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:36:15', 'computer', 0, 'KE-ING'),
(281, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:36:42', 'computer', 0, 'KE-ING'),
(282, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:38:21', 'computer', 0, 'KE-ING'),
(283, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:39:15', 'computer', 0, 'KE-ING'),
(284, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:40:50', 'computer', 0, 'KE-ING'),
(285, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:42:50', 'computer', 0, 'KE-ING'),
(286, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:43:13', 'computer', 0, 'KE-ING'),
(287, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:43:47', 'computer', 0, 'KE-ING'),
(288, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:44:22', 'computer', 0, 'KE-ING'),
(289, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:44:52', 'computer', 0, 'KE-ING'),
(290, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:51:56', 'computer', 0, 'KE-ING'),
(291, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:52:29', 'computer', 0, 'KE-ING'),
(292, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-05 21:52:55', 'computer', 0, 'KE-ING'),
(293, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 17:01:49', 'computer', 0, 'KE-ING'),
(294, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 17:04:15', 'computer', 0, 'KE-ING'),
(295, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 17:08:34', 'computer', 0, 'KE-ING'),
(296, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 17:38:12', 'computer', 0, 'KE-ING'),
(297, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 17:38:41', 'computer', 0, 'KE-ING'),
(298, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 18:09:05', 'computer', 0, 'KE-ING'),
(299, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 18:41:22', 'computer', 0, 'KE-ING'),
(300, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 18:51:05', 'computer', 0, 'KE-ING'),
(301, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-06 19:23:11', 'computer', 0, 'KE-ING'),
(302, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:26:16', 'computer', 0, 'KE-ING'),
(303, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:30:08', 'computer', 0, 'KE-ING'),
(304, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:30:53', 'computer', 0, 'KE-ING'),
(305, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:31:39', 'computer', 0, 'KE-ING'),
(306, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:35:52', 'computer', 0, 'KE-ING'),
(307, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:38:58', 'computer', 0, 'KE-ING'),
(308, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 17:51:50', 'computer', 0, 'KE-ING'),
(309, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 18:31:46', 'computer', 0, 'KE-ING'),
(310, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-10 18:33:30', 'computer', 0, 'KE-ING'),
(311, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:08:25', 'computer', 0, 'KE-ING'),
(312, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:10:56', 'computer', 0, 'KE-ING'),
(313, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:11:07', 'computer', 0, 'KE-ING'),
(314, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:12:09', 'computer', 0, 'KE-ING'),
(315, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:13:20', 'computer', 0, 'KE-ING'),
(316, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:19:31', 'computer', 0, 'KE-ING'),
(317, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:21:19', 'computer', 0, 'KE-ING'),
(318, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:22:06', 'computer', 0, 'KE-ING'),
(319, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-24 13:22:21', 'computer', 0, 'KE-ING'),
(320, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 16:55:18', 'computer', 0, 'KE-ING'),
(321, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:04:31', 'computer', 0, 'KE-ING'),
(322, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:05:48', 'computer', 0, 'KE-ING'),
(323, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:07:58', 'computer', 0, 'KE-ING'),
(324, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:14:19', 'computer', 0, 'KE-ING'),
(325, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:14:55', 'computer', 0, 'KE-ING'),
(326, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:19:06', 'computer', 0, 'KE-ING'),
(327, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:21:37', 'computer', 0, 'KE-ING'),
(328, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:27:05', 'computer', 0, 'KE-ING'),
(329, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:41:21', 'computer', 0, 'KE-ING'),
(330, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:49:25', 'computer', 0, 'KE-ING'),
(331, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 17:55:27', 'computer', 0, 'KE-ING'),
(332, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:05:59', 'computer', 0, 'KE-ING'),
(333, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:06:14', 'computer', 0, 'KE-ING'),
(334, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:09:44', 'computer', 0, 'KE-ING'),
(335, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:10:50', 'computer', 0, 'KE-ING'),
(336, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:19:21', 'computer', 0, 'KE-ING'),
(337, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:19:41', 'computer', 0, 'KE-ING'),
(338, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:20:00', 'computer', 0, 'KE-ING'),
(339, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:21:24', 'computer', 0, 'KE-ING'),
(340, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:22:11', 'computer', 0, 'KE-ING'),
(341, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:23:39', 'computer', 0, 'KE-ING'),
(342, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:24:21', 'computer', 0, 'KE-ING'),
(343, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:24:51', 'computer', 0, 'KE-ING'),
(344, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:25:03', 'computer', 0, 'KE-ING'),
(345, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:25:17', 'computer', 0, 'KE-ING'),
(346, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:27:06', 'computer', 0, 'KE-ING'),
(347, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:28:57', 'computer', 0, 'KE-ING'),
(348, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:34:54', 'computer', 0, 'KE-ING'),
(349, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:36:07', 'computer', 0, 'KE-ING'),
(350, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-26 18:38:45', 'computer', 0, 'KE-ING'),
(351, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-31 17:00:34', 'computer', 0, 'KE-ING'),
(352, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-31 17:08:19', 'computer', 0, 'KE-ING'),
(353, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-31 18:12:23', 'computer', 0, 'KE-ING'),
(354, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-03-31 18:53:53', 'computer', 0, 'KE-ING'),
(355, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-04-01 12:47:18', 'computer', 0, 'KE-ING'),
(356, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '119.14.26.0', 'Taiwan', '2025-04-02 09:59:55', 'computer', 0, 'KE-ING');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `tour_name` varchar(255) NOT NULL,
  `tour_description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('private','public') DEFAULT 'private',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `favorites_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tours`
--

INSERT INTO `tours` (`tour_id`, `tour_name`, `tour_description`, `start_date`, `end_date`, `status`, `created_at`, `favorites_count`) VALUES
(1, 'Szabadka szecessziós túra', 'Ismerd meg Szabadka építészeti csodáit.', '2024-01-15', '2024-01-20', 'public', '2024-12-10 14:04:07', 1),
(3, 'Petrovaradini erőd túra', 'Fedezd fel a híres Petrovaradini erődöt.', '2024-03-05', '2024-03-10', 'public', '2024-12-10 14:04:07', 1),
(4, 'Zentai csata nyomában', 'Látogatás a Zentai csata emlékműhöz.', '2024-04-20', '2024-04-25', 'public', '2024-12-10 14:04:07', 0),
(5, 'Óbecsei kastélyok', 'Kastélyok és parkok Óbecsén.', '2024-05-10', '2024-05-15', 'public', '2024-12-10 14:04:07', 0),
(6, 'Magyarkanizsa termál túra', 'Pihenés és fürdőzés Magyarkanizsán.', '2024-06-15', '2024-06-20', 'public', '2024-12-10 14:04:07', 1),
(7, 'Duna-parti séta', 'Séta a Duna-parton Újvidéken.', '2024-07-25', '2024-07-30', 'public', '2024-12-10 14:04:07', 1),
(8, 'Szenttamás történelmi túra', 'Látogatás templomokhoz és emlékhelyekhez.', '2024-08-30', '2024-09-05', 'public', '2024-12-10 14:04:07', 0),
(9, 'Kastélyok Vajdaságban', 'Kastélylátogatás különböző városokban.', '2024-09-15', '2024-09-20', 'public', '2024-12-10 14:04:07', 0),
(10, 'Szabadkai városnézés', 'Szabadka főbb nevezetességei.', '2024-10-10', '2024-10-15', 'public', '2024-12-10 14:04:07', 1),
(27, 'tyjiu', 'kfuyki', '2025-01-20', '2025-01-25', 'private', '2025-01-22 16:01:15', 0),
(28, 'uzkrz67u', 'hujkzrfuk', '2025-03-06', '2025-03-23', 'private', '2025-03-06 17:05:40', 0),
(29, 'zjrdzt', 'tzdidt', '2025-03-07', '2025-03-19', 'private', '2025-03-06 18:36:52', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tour_attractions`
--

CREATE TABLE `tour_attractions` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `attractions_id` int(11) NOT NULL,
  `attraction_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tour_attractions`
--

INSERT INTO `tour_attractions` (`id`, `tour_id`, `attractions_id`, `attraction_order`) VALUES
(1, 1, 1, NULL),
(2, 1, 6, NULL),
(4, 3, 3, NULL),
(5, 4, 2, NULL),
(6, 5, 7, NULL),
(7, 6, 5, NULL),
(8, 7, 8, NULL),
(9, 8, 9, NULL),
(10, 9, 10, NULL),
(11, 10, 1, NULL),
(12, 10, 6, NULL),
(13, 10, 4, NULL),
(61, 27, 8, NULL),
(62, 27, 9, NULL),
(63, 28, 4, 1),
(64, 28, 6, 2),
(65, 29, 7, 1),
(66, 29, 3, 2),
(67, 29, 9, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `turist_favorites`
--

CREATE TABLE `turist_favorites` (
  `favorite_id` int(11) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `turist_favorites`
--

INSERT INTO `turist_favorites` (`favorite_id`, `id`, `tour_id`) VALUES
(13, 38, 1),
(14, 38, 3),
(15, 38, 7),
(16, 38, 6),
(17, 38, 10);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `activation_token` varchar(64) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(1) DEFAULT 1,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `auth_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `activation_token`, `remember_token`, `created_at`, `updated_at`, `role`, `is_active`, `auth_token`) VALUES
(2, 'Titan Solutions Group', 'org2@example.com', NULL, '$2y$10$qifZJcE2.utQLnen.9fT0ulS7zszQYXvcknMDuwk8ghtfkovGp1oO', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(3, 'Pinnacle Consulting Services', 'org3@example.com', NULL, 'hashedpassword3', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1, NULL),
(4, 'Horizon Development Corporation', 'org4@example.com', NULL, 'hashedpassword4', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(5, 'Silvercrest International', 'org5@example.com', NULL, 'hashedpassword5', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1, NULL),
(6, 'Fortress Management Group', 'org6@example.com', NULL, 'hashedpassword6', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(7, 'Phoenix Global Industries', 'org7@example.com', NULL, 'hashedpassword7', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(8, 'Bluewater Solutions Inc.', 'org8@example.com', NULL, 'hashedpassword8', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1, NULL),
(9, 'Vanguard Technologies Corp.', 'org9@example.com', NULL, 'hashedpassword9', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(10, 'Regal Consulting Group', 'org10@example.com', NULL, 'hashedpassword10', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0, NULL),
(11, 'Global Enterprises Ltd.', 'org1@example.com', NULL, 'hashedpassword1', NULL, NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1, NULL),
(12, 'Kata', 'kataexample@gmail.com', NULL, '$2y$10$BRtUs32QrEU.IdYPdyXUDePcC0xK405f69TUfDgDjvugMFwm6Jide', NULL, NULL, '2025-01-11 12:37:40', '2025-01-11 12:37:40', 1, 0, NULL),
(13, 'Boy', 'example@gmail.com', NULL, '$2y$10$0Y/KlEop49DGXuOyPx/yMukADzRAkpBYwW/rYtj8pBGDBDrX/gWQu', NULL, NULL, '2025-01-11 12:50:40', '2025-01-11 12:50:40', 1, 0, NULL),
(14, 'Peti', 'example1@gmail.com', NULL, '$2y$10$NJc1qDmqZlxyDhAXg.XpZOFHB42ghclhkpendv7jKPwaf...dUTjK', NULL, NULL, '2025-01-11 13:02:19', '2025-01-11 13:02:19', 1, 1, NULL),
(15, 'Endre', 'example2@gmail.com', NULL, '$2y$10$4aTGw/TMQBswk3Lc.ctIGuk0QSUaCRG/q68JVFGbT1JTaMcfPPzZy', NULL, NULL, '2025-01-11 14:03:59', '2025-01-11 14:03:59', 1, 0, NULL),
(16, 'Kata', 'example3@gmail.com', NULL, '$2y$10$SjJL2G5WvKvdX90Rob39COVoWwAeut6odNx7sxHWE6EKyiEi5T/VC', NULL, NULL, '2025-01-11 15:09:51', '2025-01-11 15:09:51', 1, 1, NULL),
(17, 'Example4', 'example4@gmail.com', NULL, '$2y$10$TXTGRYlA.zmIhTVO3vwMTuhn.W0mmk0z1bnawD5vcCs4j7FgmTgz.', NULL, NULL, '2025-01-11 15:11:51', '2025-01-11 15:11:51', 2, 0, NULL),
(38, 'Kinga', 'kingasoros@gmail.com', NULL, '$2y$10$pLEX4mY5jjZJ5CdrctnpL.UCVS08OeLazArnO1lefBDCPE6.5vGxu', NULL, NULL, '2025-01-22 15:58:44', '2025-01-22 15:58:51', 3, 1, 'b00a2576d04d9c8b1ce664508b81e91e0ce336275723b22ad9a349e0c3bb3c28');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attractions_id`),
  ADD KEY `city_name` (`city_name`);

--
-- A tábla indexei `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- A tábla indexei `filter_search_statistics`
--
ALTER TABLE `filter_search_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filter_name` (`filter_name`,`filter_value`);

--
-- A tábla indexei `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`);

--
-- A tábla indexei `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `attractions_id` (`attractions_id`);

--
-- A tábla indexei `turist_favorites`
--
ALTER TABLE `turist_favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `id` (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `attractions`
--
ALTER TABLE `attractions`
  MODIFY `attractions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT a táblához `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `filter_search_statistics`
--
ALTER TABLE `filter_search_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT a táblához `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT a táblához `tour_attractions`
--
ALTER TABLE `tour_attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT a táblához `turist_favorites`
--
ALTER TABLE `turist_favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD CONSTRAINT `tour_attractions_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_attractions_ibfk_2` FOREIGN KEY (`attractions_id`) REFERENCES `attractions` (`attractions_id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `turist_favorites`
--
ALTER TABLE `turist_favorites`
  ADD CONSTRAINT `favorite_tours_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`),
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
