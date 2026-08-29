-- Sahra: editable Home service capability map
-- Target: MySQL 8+ / MariaDB 10.3+
-- Safe to run more than once. Existing records are matched by the English slug.
-- Run this after the base Laravel tables (`services` and `service_translations`) exist.

SET NAMES utf8mb4;

DELIMITER $$

DROP PROCEDURE IF EXISTS add_service_orbit_column$$
CREATE PROCEDURE add_service_orbit_column(
    IN column_name_value VARCHAR(64),
    IN column_definition_value VARCHAR(1000)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'services'
          AND COLUMN_NAME = column_name_value
    ) THEN
        SET @column_sql = CONCAT(
            'ALTER TABLE `services` ADD COLUMN `',
            REPLACE(column_name_value, '`', '``'),
            '` ',
            column_definition_value
        );
        PREPARE column_statement FROM @column_sql;
        EXECUTE column_statement;
        DEALLOCATE PREPARE column_statement;
    END IF;
END$$

CALL add_service_orbit_column(
    'show_on_services_page',
    'TINYINT(1) NOT NULL DEFAULT 1 AFTER `show_on_home`'
)$$
CALL add_service_orbit_column(
    'home_orbit_group',
    'VARCHAR(20) NULL AFTER `show_on_services_page`'
)$$
CALL add_service_orbit_column(
    'external_url',
    'VARCHAR(500) NULL AFTER `home_orbit_group`'
)$$

DROP PROCEDURE IF EXISTS add_service_orbit_column$$

DROP PROCEDURE IF EXISTS add_service_orbit_index$$
CREATE PROCEDURE add_service_orbit_index()
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM information_schema.STATISTICS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'services'
          AND INDEX_NAME = 'services_home_orbit_index'
    ) THEN
        CREATE INDEX services_home_orbit_index
            ON services (show_on_home, home_orbit_group);
    END IF;
END$$

CALL add_service_orbit_index()$$
DROP PROCEDURE IF EXISTS add_service_orbit_index$$

DROP PROCEDURE IF EXISTS upsert_service_orbit_item$$
CREATE PROCEDURE upsert_service_orbit_item(
    IN slug_value VARCHAR(200),
    IN title_value VARCHAR(200),
    IN group_value VARCHAR(20),
    IN url_value VARCHAR(500),
    IN image_value VARCHAR(500),
    IN sort_value SMALLINT UNSIGNED,
    IN services_page_value TINYINT(1)
)
BEGIN
    DECLARE service_id_value BIGINT UNSIGNED DEFAULT NULL;

    SELECT service_id
      INTO service_id_value
      FROM service_translations
     WHERE locale = 'en'
       AND slug = slug_value
     LIMIT 1;

    IF service_id_value IS NULL THEN
        INSERT INTO services (
            status,
            published_at,
            sort_order,
            show_on_home,
            show_on_services_page,
            home_orbit_group,
            external_url,
            image_path,
            created_at,
            updated_at
        ) VALUES (
            'published',
            NOW(),
            sort_value,
            1,
            services_page_value,
            group_value,
            url_value,
            image_value,
            NOW(),
            NOW()
        );

        SET service_id_value = LAST_INSERT_ID();
    ELSE
        UPDATE services
           SET status = 'published',
               published_at = COALESCE(published_at, NOW()),
               sort_order = sort_value,
               show_on_home = 1,
               show_on_services_page = services_page_value,
               home_orbit_group = group_value,
               external_url = url_value,
               image_path = COALESCE(image_value, image_path),
               deleted_at = NULL,
               updated_at = NOW()
         WHERE id = service_id_value;
    END IF;

    INSERT INTO service_translations (
        service_id,
        locale,
        title,
        slug,
        description,
        features,
        image_alt,
        created_at,
        updated_at
    ) VALUES
        (service_id_value, 'en', title_value, slug_value, NULL, JSON_ARRAY(), IF(image_value IS NULL, NULL, title_value), NOW(), NOW()),
        (service_id_value, 'fa', title_value, slug_value, NULL, JSON_ARRAY(), IF(image_value IS NULL, NULL, title_value), NOW(), NOW()),
        (service_id_value, 'ar', title_value, slug_value, NULL, JSON_ARRAY(), IF(image_value IS NULL, NULL, title_value), NOW(), NOW())
    ON DUPLICATE KEY UPDATE
        title = VALUES(title),
        image_alt = COALESCE(VALUES(image_alt), image_alt),
        updated_at = NOW();
END$$

START TRANSACTION$$

-- The four original full-page services stay on the Services page. Only
-- Branding also participates in the Home capability map by default.
UPDATE services AS s
JOIN service_translations AS st ON st.service_id = s.id
   SET s.show_on_home = 0,
       s.show_on_services_page = 1,
       s.home_orbit_group = NULL,
       s.external_url = NULL,
       s.updated_at = NOW()
 WHERE st.locale = 'en'
   AND st.slug IN (
       'content-production',
       'marketing-design',
       'social-media-support'
   )$$

CALL upsert_service_orbit_item('branding', 'Branding', 'active', 'https://www.ramotion.com/branding/', 'services/branding.webp', 0, 1)$$
CALL upsert_service_orbit_item('design-systems', 'Design systems', 'active', 'https://www.ramotion.com/design-systems/', 'projects/kerman-motors.webp', 1, 0)$$
CALL upsert_service_orbit_item('app-design', 'App design', 'active', 'https://www.ramotion.com/app-design/', 'projects/cheshmeh.webp', 2, 0)$$
CALL upsert_service_orbit_item('brand-strategy', 'Brand strategy', 'active', 'https://www.ramotion.com/brand-strategy/', 'posts/brand-direction.webp', 3, 0)$$
CALL upsert_service_orbit_item('ui-ux-design', 'UI/UX design', 'active', 'https://www.ramotion.com/ui-ux-design/', 'projects/fakhar-clinic.webp', 4, 0)$$
CALL upsert_service_orbit_item('web-design', 'Web design', 'active', 'https://www.ramotion.com/web-design/', 'projects/baghche.webp', 5, 0)$$
CALL upsert_service_orbit_item('web-app-development', 'Web App development', 'active', 'https://www.ramotion.com/web-app-development/', 'projects/plus-protein.webp', 6, 0)$$

CALL upsert_service_orbit_item('printing-services', 'Printing services', 'brand', NULL, NULL, 7, 0)$$
CALL upsert_service_orbit_item('packaging-design', 'Packaging design', 'brand', NULL, NULL, 8, 0)$$
CALL upsert_service_orbit_item('pr-campaigns', 'PR Campaigns', 'brand', NULL, NULL, 9, 0)$$
CALL upsert_service_orbit_item('video-productions', 'Video productions', 'brand', NULL, NULL, 10, 0)$$

CALL upsert_service_orbit_item('data-science', 'Data science', 'product', NULL, NULL, 11, 0)$$
CALL upsert_service_orbit_item('production-planning', 'Production planning', 'product', NULL, NULL, 12, 0)$$
CALL upsert_service_orbit_item('gtm-strategy', 'GTM strategy', 'product', NULL, NULL, 13, 0)$$
CALL upsert_service_orbit_item('smm', 'SMM', 'product', NULL, NULL, 14, 0)$$
CALL upsert_service_orbit_item('product-writing', 'Product writing', 'product', NULL, NULL, 15, 0)$$

COMMIT$$

DROP PROCEDURE IF EXISTS upsert_service_orbit_item$$

DELIMITER ;

-- Verification:
SELECT home_orbit_group, COUNT(*) AS item_count
FROM services
WHERE show_on_home = 1
GROUP BY home_orbit_group
ORDER BY home_orbit_group;

