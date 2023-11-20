-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table car_rent.cars: ~1 rows (approximately)
DELETE FROM `cars`;
INSERT INTO `cars` (`id`, `plat_number`, `merk`, `model`, `color`, `rental_rate`, `created_at`, `updated_at`) VALUES
	(1, 'KH2234YMA', 'Suzuki', 'Suzuki R4', 'Merah', 500000.00, '2023-11-20 00:15:11', '2023-11-20 00:21:42');

-- Dumping data for table car_rent.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping data for table car_rent.migrations: ~8 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_08_28_032958_create_side_bar_menus_table', 1),
	(6, '2023_08_28_033048_create_permission_tables', 1),
	(7, '2023_11_20_062628_create_cars_table', 2),
	(8, '2023_11_20_063910_create_rents_table', 2);

-- Dumping data for table car_rent.model_has_permissions: ~0 rows (approximately)
DELETE FROM `model_has_permissions`;

-- Dumping data for table car_rent.model_has_roles: ~2 rows (approximately)
DELETE FROM `model_has_roles`;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2);

-- Dumping data for table car_rent.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;

-- Dumping data for table car_rent.permissions: ~29 rows (approximately)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'view side_bar_menus', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(2, 'create side_bar_menus', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(3, 'detail side_bar_menus', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(4, 'update side_bar_menus', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(5, 'delete side_bar_menus', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(6, 'view users', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(7, 'create users', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(8, 'detail users', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(9, 'update users', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(10, 'delete users', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(11, 'view roles', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(12, 'create roles', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(13, 'detail roles', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(14, 'update roles', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(15, 'delete roles', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(16, 'view permissions', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(17, 'create permissions', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(18, 'detail permissions', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(19, 'update permissions', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(20, 'delete permissions', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(21, 'view user-group-authorization', 'web', '2023-08-29 00:03:54', '2023-08-29 00:03:54'),
	(22, 'update user-group-authorization', 'web', '2023-08-29 00:31:05', '2023-08-29 00:31:05'),
	(23, 'view kendaraan', 'web', '2023-11-19 23:25:37', '2023-11-19 23:25:37'),
	(24, 'create kendaraan', 'web', '2023-11-19 23:25:37', '2023-11-19 23:25:37'),
	(25, 'detail kendaraan', 'web', '2023-11-19 23:25:37', '2023-11-19 23:25:37'),
	(26, 'update kendaraan', 'web', '2023-11-19 23:25:37', '2023-11-19 23:25:37'),
	(27, 'delete kendaraan', 'web', '2023-11-19 23:25:37', '2023-11-19 23:25:37'),
	(28, 'rent kendaraan', 'web', '2023-11-20 00:22:58', '2023-11-20 00:22:58'),
	(29, 'return kendaraan', 'web', '2023-11-20 00:23:16', '2023-11-20 00:23:16');

-- Dumping data for table car_rent.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping data for table car_rent.rents: ~0 rows (approximately)
DELETE FROM `rents`;
INSERT INTO `rents` (`id`, `car_id`, `user_id`, `rent_start_date`, `rent_end_date`, `status`, `total_rent_fee`, `date_of_return`, `late_fee`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2023-11-20', '2023-11-21', 'ACTIVE', 100000.000000, '0000-00-00', 0.00, NULL, NULL);

-- Dumping data for table car_rent.roles: ~2 rows (approximately)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'web', '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(2, 'Member', 'web', '2023-11-19 23:14:36', '2023-11-19 23:14:36');

-- Dumping data for table car_rent.role_has_permissions: ~30 rows (approximately)
DELETE FROM `role_has_permissions`;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(23, 2),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 2),
	(29, 2);

-- Dumping data for table car_rent.side_bar_menus: ~6 rows (approximately)
DELETE FROM `side_bar_menus`;
INSERT INTO `side_bar_menus` (`id`, `title`, `uri`, `icon`, `permission_name`, `header`, `is_has_data_manipulation`, `created_at`, `updated_at`) VALUES
	(1, 'Menu', 'admin/menu', '<i class="fas fa-bars"></i>', 'view side_bar_menus', NULL, 'YES', '2023-08-29 06:44:08', '2023-08-29 06:44:08'),
	(2, 'Users Management', 'admin/user', '<i class="fas fa-users"></i>', 'view users', NULL, 'YES', '2023-08-29 06:44:08', '2023-08-29 06:44:08'),
	(3, 'User List', 'admin/user', NULL, 'view users', '2', 'YES', '2023-08-29 06:44:08', '2023-08-29 06:44:08'),
	(4, 'User Role/Group', 'admin/role', NULL, 'view roles', '2', 'YES', '2023-08-29 06:44:08', '2023-08-29 06:44:08'),
	(5, 'Permissions', 'admin/permission', NULL, 'view permissions', '2', 'YES', '2023-08-29 06:44:08', '2023-08-29 06:44:08'),
	(6, 'Kendaraan', 'dashboard/kendaraan', '<i class="fas fa-car"></i>', 'view kendaraan', NULL, 'YES', '2023-11-19 23:25:37', '2023-11-19 23:25:37');

-- Dumping data for table car_rent.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `sim_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'uadmin', 'admin@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$vbs8rS8Tv5.wb9f.Z1mN5OIMBvk2VESuG/5tKBEgv5RBGQkxU/Eum', NULL, '2023-08-28 23:30:08', '2023-08-28 23:30:08'),
	(2, 'Samuel Septa Munthe', 'samuelsepta@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$33Ccyp35dIAcYGXeaBlG9uXrdAHRHHF4GmT7NU5xUyopqffjxchoK', NULL, '2023-11-19 23:23:00', '2023-11-19 23:23:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
