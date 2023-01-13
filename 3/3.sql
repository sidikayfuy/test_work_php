CREATE TABLE IF NOT EXISTS `tests` (
                         `id` bigint UNSIGNED NOT NULL,
                         `script_name` varchar(25) NOT NULL,
                         `start_time` int NOT NULL,
                         `end_time` int NOT NULL,
                         `result` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;