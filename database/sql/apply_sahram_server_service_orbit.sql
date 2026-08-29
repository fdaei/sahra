-- Exact update for the supplied sahram_db.sql (MySQL 8.0.46)
-- Paste this whole file into phpMyAdmin > sahram_db > SQL and click Go.
-- It preserves all current content and can safely be run more than once.

SET NAMES utf8mb4;
SET time_zone = '+00:00';
START TRANSACTION;

-- Remove the leftover routine found in the server dump. It is not needed.
DROP PROCEDURE IF EXISTS upsert_service_orbit_item;

-- Existing full Services-page records.
UPDATE services
SET show_on_home = 1,
    show_on_services_page = 1,
    home_orbit_group = 'active',
    external_url = 'https://www.ramotion.com/branding/',
    sort_order = 0,
    updated_at = NOW()
WHERE id = 1;

UPDATE services
SET show_on_home = 0,
    show_on_services_page = 1,
    home_orbit_group = NULL,
    external_url = NULL,
    updated_at = NOW()
WHERE id IN (2, 3, 4);

-- Home capability-map records. IDs 5-19 are free in the supplied dump.
INSERT INTO services
    (id, status, published_at, sort_order, show_on_home, show_on_services_page, home_orbit_group, external_url, icon, image_path, created_at, updated_at, deleted_at)
VALUES
    (5,  'published', NOW(), 1,  1, 0, 'active',  'https://www.ramotion.com/design-systems/',       NULL, 'projects/kerman-motors.webp', NOW(), NOW(), NULL),
    (6,  'published', NOW(), 2,  1, 0, 'active',  'https://www.ramotion.com/app-design/',           NULL, 'projects/cheshmeh.webp', NOW(), NOW(), NULL),
    (7,  'published', NOW(), 3,  1, 0, 'active',  'https://www.ramotion.com/brand-strategy/',       NULL, 'posts/brand-direction.webp', NOW(), NOW(), NULL),
    (8,  'published', NOW(), 4,  1, 0, 'active',  'https://www.ramotion.com/ui-ux-design/',          NULL, 'projects/fakhar-clinic.webp', NOW(), NOW(), NULL),
    (9,  'published', NOW(), 5,  1, 0, 'active',  'https://www.ramotion.com/web-design/',            NULL, 'projects/baghche.webp', NOW(), NOW(), NULL),
    (10, 'published', NOW(), 6,  1, 0, 'active',  'https://www.ramotion.com/web-app-development/',  NULL, 'projects/plus-protein.webp', NOW(), NOW(), NULL),
    (11, 'published', NOW(), 7,  1, 0, 'brand',   NULL, NULL, NULL, NOW(), NOW(), NULL),
    (12, 'published', NOW(), 8,  1, 0, 'brand',   NULL, NULL, NULL, NOW(), NOW(), NULL),
    (13, 'published', NOW(), 9,  1, 0, 'brand',   NULL, NULL, NULL, NOW(), NOW(), NULL),
    (14, 'published', NOW(), 10, 1, 0, 'brand',   NULL, NULL, NULL, NOW(), NOW(), NULL),
    (15, 'published', NOW(), 11, 1, 0, 'product', NULL, NULL, NULL, NOW(), NOW(), NULL),
    (16, 'published', NOW(), 12, 1, 0, 'product', NULL, NULL, NULL, NOW(), NOW(), NULL),
    (17, 'published', NOW(), 13, 1, 0, 'product', NULL, NULL, NULL, NOW(), NOW(), NULL),
    (18, 'published', NOW(), 14, 1, 0, 'product', NULL, NULL, NULL, NOW(), NOW(), NULL),
    (19, 'published', NOW(), 15, 1, 0, 'product', NULL, NULL, NULL, NOW(), NOW(), NULL)
ON DUPLICATE KEY UPDATE
    status = VALUES(status),
    published_at = COALESCE(services.published_at, VALUES(published_at)),
    sort_order = VALUES(sort_order),
    show_on_home = VALUES(show_on_home),
    show_on_services_page = VALUES(show_on_services_page),
    home_orbit_group = VALUES(home_orbit_group),
    external_url = VALUES(external_url),
    image_path = COALESCE(VALUES(image_path), services.image_path),
    deleted_at = NULL,
    updated_at = NOW();

-- New records receive editable defaults in all three locales. Existing rows
-- are updated by (service_id, locale), so rerunning this does not duplicate data.
INSERT INTO service_translations
    (service_id, locale, title, slug, description, features, image_alt, created_at, updated_at)
VALUES
    (5, 'en', 'Design systems', 'design-systems', NULL, '[]', 'Design systems', NOW(), NOW()),
    (5, 'fa', 'Design systems', 'design-systems', NULL, '[]', 'Design systems', NOW(), NOW()),
    (5, 'ar', 'Design systems', 'design-systems', NULL, '[]', 'Design systems', NOW(), NOW()),
    (6, 'en', 'App design', 'app-design', NULL, '[]', 'App design', NOW(), NOW()),
    (6, 'fa', 'App design', 'app-design', NULL, '[]', 'App design', NOW(), NOW()),
    (6, 'ar', 'App design', 'app-design', NULL, '[]', 'App design', NOW(), NOW()),
    (7, 'en', 'Brand strategy', 'brand-strategy', NULL, '[]', 'Brand strategy', NOW(), NOW()),
    (7, 'fa', 'Brand strategy', 'brand-strategy', NULL, '[]', 'Brand strategy', NOW(), NOW()),
    (7, 'ar', 'Brand strategy', 'brand-strategy', NULL, '[]', 'Brand strategy', NOW(), NOW()),
    (8, 'en', 'UI/UX design', 'ui-ux-design', NULL, '[]', 'UI/UX design', NOW(), NOW()),
    (8, 'fa', 'UI/UX design', 'ui-ux-design', NULL, '[]', 'UI/UX design', NOW(), NOW()),
    (8, 'ar', 'UI/UX design', 'ui-ux-design', NULL, '[]', 'UI/UX design', NOW(), NOW()),
    (9, 'en', 'Web design', 'web-design', NULL, '[]', 'Web design', NOW(), NOW()),
    (9, 'fa', 'Web design', 'web-design', NULL, '[]', 'Web design', NOW(), NOW()),
    (9, 'ar', 'Web design', 'web-design', NULL, '[]', 'Web design', NOW(), NOW()),
    (10, 'en', 'Web App development', 'web-app-development', NULL, '[]', 'Web App development', NOW(), NOW()),
    (10, 'fa', 'Web App development', 'web-app-development', NULL, '[]', 'Web App development', NOW(), NOW()),
    (10, 'ar', 'Web App development', 'web-app-development', NULL, '[]', 'Web App development', NOW(), NOW()),
    (11, 'en', 'Printing services', 'printing-services', NULL, '[]', NULL, NOW(), NOW()),
    (11, 'fa', 'Printing services', 'printing-services', NULL, '[]', NULL, NOW(), NOW()),
    (11, 'ar', 'Printing services', 'printing-services', NULL, '[]', NULL, NOW(), NOW()),
    (12, 'en', 'Packaging design', 'packaging-design', NULL, '[]', NULL, NOW(), NOW()),
    (12, 'fa', 'Packaging design', 'packaging-design', NULL, '[]', NULL, NOW(), NOW()),
    (12, 'ar', 'Packaging design', 'packaging-design', NULL, '[]', NULL, NOW(), NOW()),
    (13, 'en', 'PR Campaigns', 'pr-campaigns', NULL, '[]', NULL, NOW(), NOW()),
    (13, 'fa', 'PR Campaigns', 'pr-campaigns', NULL, '[]', NULL, NOW(), NOW()),
    (13, 'ar', 'PR Campaigns', 'pr-campaigns', NULL, '[]', NULL, NOW(), NOW()),
    (14, 'en', 'Video productions', 'video-productions', NULL, '[]', NULL, NOW(), NOW()),
    (14, 'fa', 'Video productions', 'video-productions', NULL, '[]', NULL, NOW(), NOW()),
    (14, 'ar', 'Video productions', 'video-productions', NULL, '[]', NULL, NOW(), NOW()),
    (15, 'en', 'Data science', 'data-science', NULL, '[]', NULL, NOW(), NOW()),
    (15, 'fa', 'Data science', 'data-science', NULL, '[]', NULL, NOW(), NOW()),
    (15, 'ar', 'Data science', 'data-science', NULL, '[]', NULL, NOW(), NOW()),
    (16, 'en', 'Production planning', 'production-planning', NULL, '[]', NULL, NOW(), NOW()),
    (16, 'fa', 'Production planning', 'production-planning', NULL, '[]', NULL, NOW(), NOW()),
    (16, 'ar', 'Production planning', 'production-planning', NULL, '[]', NULL, NOW(), NOW()),
    (17, 'en', 'GTM strategy', 'gtm-strategy', NULL, '[]', NULL, NOW(), NOW()),
    (17, 'fa', 'GTM strategy', 'gtm-strategy', NULL, '[]', NULL, NOW(), NOW()),
    (17, 'ar', 'GTM strategy', 'gtm-strategy', NULL, '[]', NULL, NOW(), NOW()),
    (18, 'en', 'SMM', 'smm', NULL, '[]', NULL, NOW(), NOW()),
    (18, 'fa', 'SMM', 'smm', NULL, '[]', NULL, NOW(), NOW()),
    (18, 'ar', 'SMM', 'smm', NULL, '[]', NULL, NOW(), NOW()),
    (19, 'en', 'Product writing', 'product-writing', NULL, '[]', NULL, NOW(), NOW()),
    (19, 'fa', 'Product writing', 'product-writing', NULL, '[]', NULL, NOW(), NOW()),
    (19, 'ar', 'Product writing', 'product-writing', NULL, '[]', NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    title = VALUES(title),
    image_alt = VALUES(image_alt),
    updated_at = NOW();

-- Mark the matching Laravel migration as applied because these columns already
-- exist in the supplied server database. This prevents a later migrate command
-- from attempting to add them again.
INSERT INTO migrations (migration, batch)
SELECT '2026_08_29_000001_make_home_service_orbit_editable',
       4
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1
    FROM migrations
    WHERE migration = '2026_08_29_000001_make_home_service_orbit_editable'
);

COMMIT;

-- Expected result: active=7, brand=4, product=5.
SELECT home_orbit_group, COUNT(*) AS item_count
FROM services
WHERE show_on_home = 1
GROUP BY home_orbit_group
ORDER BY home_orbit_group;
