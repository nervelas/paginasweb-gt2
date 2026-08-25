-- ---------------------------------------------------------------------------
-- paginasweb.gt — Esquema de base de datos (MySQL 5.7+ / MariaDB 10.3+)
-- Codificación utf8mb4 para soportar tildes y emojis sin problemas.
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS settings (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  setting_key   VARCHAR(100) NOT NULL,
  setting_value LONGTEXT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_settings_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name                 VARCHAR(120) NOT NULL,
  email                VARCHAR(190) NOT NULL,
  password_hash        VARCHAR(255) NOT NULL,
  role                 VARCHAR(20) NOT NULL DEFAULT 'admin',
  active               TINYINT(1) NOT NULL DEFAULT 1,
  must_change_password TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at        DATETIME NULL,
  created_at           DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS login_attempts (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email      VARCHAR(190) NOT NULL,
  ip         VARCHAR(45) NOT NULL,
  success    TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY ix_attempts_lookup (created_at, success)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pages (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug             VARCHAR(160) NOT NULL,
  name             VARCHAR(160) NOT NULL,
  h1               VARCHAR(200) NOT NULL,
  intro            TEXT NULL,
  meta_title       VARCHAR(190) NOT NULL,
  meta_description VARCHAR(320) NOT NULL,
  canonical        VARCHAR(255) NULL,
  robots_index     TINYINT(1) NOT NULL DEFAULT 1,
  og_image         VARCHAR(255) NULL,
  template         VARCHAR(60) NOT NULL DEFAULT 'generic',
  sort_order       INT NOT NULL DEFAULT 0,
  visible          TINYINT(1) NOT NULL DEFAULT 1,
  updated_at       DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_pages_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS page_sections (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  page_id    INT UNSIGNED NOT NULL,
  block_type VARCHAR(40) NOT NULL DEFAULT 'rich_text',
  eyebrow    VARCHAR(120) NULL,
  heading    VARCHAR(220) NULL,
  subheading VARCHAR(320) NULL,
  body       LONGTEXT NULL,
  image      VARCHAR(255) NULL,
  image_alt  VARCHAR(220) NULL,
  cta_text   VARCHAR(120) NULL,
  cta_url    VARCHAR(255) NULL,
  extra      LONGTEXT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  visible    TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  KEY ix_sections_page (page_id, sort_order),
  CONSTRAINT fk_sections_page FOREIGN KEY (page_id) REFERENCES pages (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS services (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug         VARCHAR(120) NOT NULL,
  name         VARCHAR(160) NOT NULL,
  short_name   VARCHAR(80) NOT NULL,
  tagline      VARCHAR(240) NULL,
  summary      TEXT NULL,
  icon         VARCHAR(60) NULL,
  page_slug    VARCHAR(160) NULL,
  sort_order   INT NOT NULL DEFAULT 0,
  visible      TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_services_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS plans (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  service_id      INT UNSIGNED NULL,
  name            VARCHAR(160) NOT NULL,
  badge           VARCHAR(60) NULL,
  price           DECIMAL(10,2) NULL,
  price_text      VARCHAR(60) NULL,
  price_strike    DECIMAL(10,2) NULL,
  period          VARCHAR(40) NOT NULL DEFAULT 'al año',
  price_note      VARCHAR(240) NULL,
  initial_payment DECIMAL(10,2) NULL,
  balance_payment DECIMAL(10,2) NULL,
  features        LONGTEXT NULL,
  cta_text        VARCHAR(120) NULL,
  cta_url         VARCHAR(255) NULL,
  featured        TINYINT(1) NOT NULL DEFAULT 0,
  sort_order      INT NOT NULL DEFAULT 0,
  visible         TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  KEY ix_plans_service (service_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS portfolio (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(160) NOT NULL,
  domain      VARCHAR(190) NOT NULL,
  url         VARCHAR(255) NOT NULL,
  sector      VARCHAR(120) NULL,
  description VARCHAR(400) NULL,
  image       VARCHAR(255) NULL,
  image_alt   VARCHAR(220) NULL,
  sort_order  INT NOT NULL DEFAULT 0,
  visible     TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_portfolio_domain (domain)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug        VARCHAR(120) NOT NULL,
  name        VARCHAR(160) NOT NULL,
  description VARCHAR(400) NULL,
  sort_order  INT NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categories_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug             VARCHAR(190) NOT NULL,
  title            VARCHAR(240) NOT NULL,
  excerpt          VARCHAR(400) NULL,
  body             LONGTEXT NULL,
  image            VARCHAR(255) NULL,
  image_alt        VARCHAR(220) NULL,
  category_id      INT UNSIGNED NULL,
  author           VARCHAR(120) NULL,
  published_at     DATETIME NULL,
  updated_at       DATETIME NULL,
  meta_title       VARCHAR(190) NULL,
  meta_description VARCHAR(320) NULL,
  robots_index     TINYINT(1) NOT NULL DEFAULT 1,
  visible          TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_posts_slug (slug),
  KEY ix_posts_pub (visible, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS faqs (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  page_slug  VARCHAR(160) NOT NULL,
  question   VARCHAR(320) NOT NULL,
  answer     TEXT NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  visible    TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  KEY ix_faqs_page (page_slug, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS testimonials (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name       VARCHAR(160) NOT NULL,
  company    VARCHAR(160) NULL,
  role       VARCHAR(160) NULL,
  quote      TEXT NOT NULL,
  image      VARCHAR(255) NULL,
  source_url VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  visible    TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS media (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  filename   VARCHAR(255) NOT NULL,
  path       VARCHAR(255) NOT NULL,
  alt        VARCHAR(220) NULL,
  mime       VARCHAR(80) NULL,
  width      INT NULL,
  height     INT NULL,
  filesize   INT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS menu_items (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  location   VARCHAR(40) NOT NULL DEFAULT 'header',
  label      VARCHAR(120) NOT NULL,
  url        VARCHAR(255) NOT NULL,
  parent_id  INT UNSIGNED NULL,
  rel        VARCHAR(60) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  visible    TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  KEY ix_menu_location (location, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS messages (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name       VARCHAR(160) NOT NULL,
  email      VARCHAR(190) NULL,
  phone      VARCHAR(60) NULL,
  service    VARCHAR(120) NULL,
  message    TEXT NULL,
  page       VARCHAR(255) NULL,
  ip         VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  status     VARCHAR(20) NOT NULL DEFAULT 'nuevo',
  created_at DATETIME NOT NULL,
  read_at    DATETIME NULL,
  PRIMARY KEY (id),
  KEY ix_messages_status (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS redirects (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  source      VARCHAR(255) NOT NULL,
  destination VARCHAR(255) NOT NULL,
  status_code INT NOT NULL DEFAULT 301,
  hits        INT NOT NULL DEFAULT 0,
  created_at  DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_redirects_source (source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
