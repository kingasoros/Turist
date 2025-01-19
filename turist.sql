-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jan 19. 16:18
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
  `interest` enum('Családbarát','Kalandturizmus','Kultúra és művészetek','Gasztronómia','Történelem','Sport') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `attractions`
--

INSERT INTO `attractions` (`attractions_id`, `city_name`, `name`, `description`, `address`, `created_by`, `image`, `created_at`, `type`, `interest`) VALUES
(1, 'Szabadka', 'Raichle-palota', 'A szecesszió egyik legszebb példája Vajdaságban.', 'Raichle utca 4.', 'Admin', 'Raichle.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Családbarát'),
(2, 'Zenta', 'Zentai csata emlékmű', 'A híres 1697-es zentai csata emlékére épült.', 'Fő tér 1.', 'Admin', 'Zenta_emlekmu.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem'),
(3, 'Újvidék', 'Petrovaradini erőd', 'Egyik legjobb állapotban megmaradt barokk kori erődítmény.', 'Petrovaradin', 'Admin', 'Petrovaradin.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem'),
(4, 'Palics', 'Palicsi tó', 'Híres üdülőhely, a tó és környező parkjai.', 'Palics', 'Admin', 'Palics.jpg', '2024-12-10 14:03:17', 'Természeti látnivalók', 'Családbarát'),
(5, 'Magyarkanizsa', 'Termálfürdő', 'Híres gyógyfürdő, kellemes kikapcsolódásra.', 'Fürdő utca 2.', 'Admin', 'Magyarkanizsa_furdo.jpg', '2024-12-10 14:03:17', 'Szórakoztató helyek', 'Családbarát'),
(6, 'Szabadka', 'Zsinagóga', 'A világ egyik legszebb szecessziós zsinagógája.', 'Zsinagóga tér', 'Admin', 'Szabadka_zsinagoga.jpg', '2024-12-10 14:03:17', 'Vallási helyek', 'Családbarát'),
(7, 'Óbecse', 'Fantast kastély', 'Különleges kastély egy szép park közepén.', 'Óbecse', 'Admin', 'Fantast.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem'),
(8, 'Újvidék', 'Duna-part', 'Kiváló sétahely gyönyörű kilátással a Dunára.', 'Duna-part', 'Admin', 'Ujvidek_duna.jpg', '2024-12-10 14:03:17', 'Természeti látnivalók', 'Családbarát'),
(9, 'Szenttamás', 'Gazdag Árpád-ház templom', 'Történelmi jelentőségű templom.', 'Fő tér', 'Admin', 'Szenttamas.jpg', '2024-12-10 14:03:17', 'Vallási helyek', 'Kultúra és művészetek'),
(10, 'Verbász', 'Verbászi kastély', 'Gyönyörű, klasszicista stílusú kastély.', 'Verbász', 'Admin', 'Verbasz_kastely.jpg', '2024-12-10 14:03:17', 'Történelmi helyek', 'Történelem');

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
(1, 'city', 'Palics', 11),
(3, 'type', 'Történelmi helyek', 5),
(4, 'interest', 'Történelem', 8),
(6, 'type', 'Szórakoztató helyek', 10),
(7, 'city', 'Óbecse', 13),
(11, 'city', 'Szabadka', 18),
(12, 'city', 'Verbász', 11),
(25, 'city', 'Szenttamás', 15),
(27, 'interest', 'Kultúra és művészetek', 9),
(31, 'type', 'Vallási helyek', 9),
(34, 'Város', 'Magyarkanizsa', 10),
(35, 'Város', 'Újvidék', 12),
(36, 'type', 'Természeti látnivalók', 8),
(37, 'interest', 'Családbarát', 10);

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
-- Tábla szerkezet ehhez a táblához `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `tour_name` varchar(255) NOT NULL,
  `tour_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('private','public') DEFAULT 'private',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tours`
--

INSERT INTO `tours` (`tour_id`, `tour_name`, `tour_description`, `price`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'Szabadka szecessziós túra', 'Ismerd meg Szabadka építészeti csodáit.', 5000.00, '2024-01-15', '2024-01-20', 'public', '2024-12-10 14:04:07'),
(2, 'Palicsi tó túra', 'Kellemes séta a Palicsi tó körül.', 3000.00, '2024-02-10', '2024-02-15', 'private', '2024-12-10 14:04:07'),
(3, 'Petrovaradini erőd túra', 'Fedezd fel a híres Petrovaradini erődöt.', 6000.00, '2024-03-05', '2024-03-10', 'public', '2024-12-10 14:04:07'),
(4, 'Zentai csata nyomában', 'Látogatás a Zentai csata emlékműhöz.', 4000.00, '2024-04-20', '2024-04-25', 'public', '2024-12-10 14:04:07'),
(5, 'Óbecsei kastélyok', 'Kastélyok és parkok Óbecsén.', 7000.00, '2024-05-10', '2024-05-15', 'public', '2024-12-10 14:04:07'),
(6, 'Magyarkanizsa termál túra', 'Pihenés és fürdőzés Magyarkanizsán.', 4500.00, '2024-06-15', '2024-06-20', 'public', '2024-12-10 14:04:07'),
(7, 'Duna-parti séta', 'Séta a Duna-parton Újvidéken.', 2500.00, '2024-07-25', '2024-07-30', 'public', '2024-12-10 14:04:07'),
(8, 'Szenttamás történelmi túra', 'Látogatás templomokhoz és emlékhelyekhez.', 5500.00, '2024-08-30', '2024-09-05', 'public', '2024-12-10 14:04:07'),
(9, 'Kastélyok Vajdaságban', 'Kastélylátogatás különböző városokban.', 8000.00, '2024-09-15', '2024-09-20', 'public', '2024-12-10 14:04:07'),
(10, 'Szabadkai városnézés', 'Szabadka főbb nevezetességei.', 5000.00, '2024-10-10', '2024-10-15', 'public', '2024-12-10 14:04:07');

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
(3, 2, 4, NULL),
(4, 3, 3, NULL),
(5, 4, 2, NULL),
(6, 5, 7, NULL),
(7, 6, 5, NULL),
(8, 7, 8, NULL),
(9, 8, 9, NULL),
(10, 9, 10, NULL),
(11, 10, 1, NULL),
(12, 10, 6, NULL),
(13, 10, 4, NULL);

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
(9, 26, 1),
(10, 26, 2),
(11, 26, 3);

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(1) DEFAULT 1,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `is_active`) VALUES
(2, 'Titan Solutions Group', 'org2@example.com', NULL, '$2y$10$qifZJcE2.utQLnen.9fT0ulS7zszQYXvcknMDuwk8ghtfkovGp1oO', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(3, 'Pinnacle Consulting Services', 'org3@example.com', NULL, 'hashedpassword3', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1),
(4, 'Horizon Development Corporation', 'org4@example.com', NULL, 'hashedpassword4', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(5, 'Silvercrest International', 'org5@example.com', NULL, 'hashedpassword5', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1),
(6, 'Fortress Management Group', 'org6@example.com', NULL, 'hashedpassword6', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(7, 'Phoenix Global Industries', 'org7@example.com', NULL, 'hashedpassword7', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(8, 'Bluewater Solutions Inc.', 'org8@example.com', NULL, 'hashedpassword8', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1),
(9, 'Vanguard Technologies Corp.', 'org9@example.com', NULL, 'hashedpassword9', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(10, 'Regal Consulting Group', 'org10@example.com', NULL, 'hashedpassword10', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 0),
(11, 'Global Enterprises Ltd.', 'org1@example.com', NULL, 'hashedpassword1', NULL, '2024-12-16 20:45:56', '2024-12-16 20:45:56', 2, 1),
(12, 'Kata', 'kataexample@gmail.com', NULL, '$2y$10$BRtUs32QrEU.IdYPdyXUDePcC0xK405f69TUfDgDjvugMFwm6Jide', NULL, '2025-01-11 12:37:40', '2025-01-11 12:37:40', 1, 0),
(13, 'Boy', 'example@gmail.com', NULL, '$2y$10$0Y/KlEop49DGXuOyPx/yMukADzRAkpBYwW/rYtj8pBGDBDrX/gWQu', NULL, '2025-01-11 12:50:40', '2025-01-11 12:50:40', 1, 0),
(14, 'Peti', 'example1@gmail.com', NULL, '$2y$10$NJc1qDmqZlxyDhAXg.XpZOFHB42ghclhkpendv7jKPwaf...dUTjK', NULL, '2025-01-11 13:02:19', '2025-01-11 13:02:19', 1, 1),
(15, 'Endre', 'example2@gmail.com', NULL, '$2y$10$4aTGw/TMQBswk3Lc.ctIGuk0QSUaCRG/q68JVFGbT1JTaMcfPPzZy', NULL, '2025-01-11 14:03:59', '2025-01-11 14:03:59', 1, 0),
(16, 'Kata', 'example3@gmail.com', NULL, '$2y$10$SjJL2G5WvKvdX90Rob39COVoWwAeut6odNx7sxHWE6EKyiEi5T/VC', NULL, '2025-01-11 15:09:51', '2025-01-11 15:09:51', 1, 1),
(17, 'Example4', 'example4@gmail.com', NULL, '$2y$10$TXTGRYlA.zmIhTVO3vwMTuhn.W0mmk0z1bnawD5vcCs4j7FgmTgz.', NULL, '2025-01-11 15:11:51', '2025-01-11 15:11:51', 2, 0),
(26, 'Kinga', 'kingasoros@gmail.com', NULL, '$2y$10$xhTrSYv4C.T3Acr349kP6eIlCNNDWKyl4LZvKwfApAiAPZpi6wN2q', NULL, '2025-01-12 15:31:41', '2025-01-12 15:31:50', 3, 1);

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
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `attractions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT a táblához `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `filter_search_statistics`
--
ALTER TABLE `filter_search_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `tour_attractions`
--
ALTER TABLE `tour_attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT a táblához `turist_favorites`
--
ALTER TABLE `turist_favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
