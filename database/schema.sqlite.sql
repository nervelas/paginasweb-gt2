-- paginasweb.gt — Esquema SQLite (generado por tools/mysql-to-sqlite-schema.php)

CREATE TABLE IF NOT EXISTS settings (
  id            INTEGER PRIMARY KEY AUTOINCREMENT,
  setting_key   TEXT NOT NULL,
  setting_value TEXT NULL,
  UNIQUE (setting_key)
);

CREATE TABLE IF NOT EXISTS users (
  id                   INTEGER PRIMARY KEY AUTOINCREMENT,
  name                 TEXT NOT NULL,
  email                TEXT NOT NULL,
  password_hash        TEXT NOT NULL,
  role                 TEXT NOT NULL DEFAULT 'admin',
  active               INTEGER NOT NULL DEFAULT 1,
  must_change_password INTEGER NOT NULL DEFAULT 1,
  last_login_at        TEXT NULL,
  created_at           TEXT NOT NULL,
  UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS login_attempts (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  email      TEXT NOT NULL,
  ip         TEXT NOT NULL,
  success    INTEGER NOT NULL DEFAULT 0,
  created_at TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS pages (
  id               INTEGER PRIMARY KEY AUTOINCREMENT,
  slug             TEXT NOT NULL,
  name             TEXT NOT NULL,
  h1               TEXT NOT NULL,
  intro            TEXT NULL,
  meta_title       TEXT NOT NULL,
  meta_description TEXT NOT NULL,
  canonical        TEXT NULL,
  robots_index     INTEGER NOT NULL DEFAULT 1,
  og_image         TEXT NULL,
  template         TEXT NOT NULL DEFAULT 'generic',
  sort_order       INTEGER NOT NULL DEFAULT 0,
  visible          INTEGER NOT NULL DEFAULT 1,
  updated_at       TEXT NOT NULL,
  UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS page_sections (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  page_id    INTEGER NOT NULL,
  block_type TEXT NOT NULL DEFAULT 'rich_text',
  eyebrow    TEXT NULL,
  heading    TEXT NULL,
  subheading TEXT NULL,
  body       TEXT NULL,
  image      TEXT NULL,
  image_alt  TEXT NULL,
  cta_text   TEXT NULL,
  cta_url    TEXT NULL,
  extra      TEXT NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  visible    INTEGER NOT NULL DEFAULT 1,
  FOREIGN KEY (page_id) REFERENCES pages (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS services (
  id           INTEGER PRIMARY KEY AUTOINCREMENT,
  slug         TEXT NOT NULL,
  name         TEXT NOT NULL,
  short_name   TEXT NOT NULL,
  tagline      TEXT NULL,
  summary      TEXT NULL,
  icon         TEXT NULL,
  page_slug    TEXT NULL,
  sort_order   INTEGER NOT NULL DEFAULT 0,
  visible      INTEGER NOT NULL DEFAULT 1,
  UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS plans (
  id              INTEGER PRIMARY KEY AUTOINCREMENT,
  service_id      INTEGER NULL,
  name            TEXT NOT NULL,
  badge           TEXT NULL,
  price           REAL NULL,
  price_text      TEXT NULL,
  price_strike    REAL NULL,
  period          TEXT NOT NULL DEFAULT 'al año',
  price_note      TEXT NULL,
  initial_payment REAL NULL,
  balance_payment REAL NULL,
  features        TEXT NULL,
  cta_text        TEXT NULL,
  cta_url         TEXT NULL,
  featured        INTEGER NOT NULL DEFAULT 0,
  sort_order      INTEGER NOT NULL DEFAULT 0,
  visible         INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS portfolio (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  name        TEXT NOT NULL,
  domain      TEXT NOT NULL,
  url         TEXT NOT NULL,
  sector      TEXT NULL,
  description TEXT NULL,
  image       TEXT NULL,
  image_alt   TEXT NULL,
  sort_order  INTEGER NOT NULL DEFAULT 0,
  visible     INTEGER NOT NULL DEFAULT 1,
  UNIQUE (domain)
);

CREATE TABLE IF NOT EXISTS categories (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  slug        TEXT NOT NULL,
  name        TEXT NOT NULL,
  description TEXT NULL,
  sort_order  INTEGER NOT NULL DEFAULT 0,
  UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS posts (
  id               INTEGER PRIMARY KEY AUTOINCREMENT,
  slug             TEXT NOT NULL,
  title            TEXT NOT NULL,
  excerpt          TEXT NULL,
  body             TEXT NULL,
  image            TEXT NULL,
  image_alt        TEXT NULL,
  category_id      INTEGER NULL,
  author           TEXT NULL,
  published_at     TEXT NULL,
  updated_at       TEXT NULL,
  meta_title       TEXT NULL,
  meta_description TEXT NULL,
  robots_index     INTEGER NOT NULL DEFAULT 1,
  visible          INTEGER NOT NULL DEFAULT 1,
  UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS faqs (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  page_slug  TEXT NOT NULL,
  question   TEXT NOT NULL,
  answer     TEXT NOT NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  visible    INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS testimonials (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  name       TEXT NOT NULL,
  company    TEXT NULL,
  role       TEXT NULL,
  quote      TEXT NOT NULL,
  image      TEXT NULL,
  source_url TEXT NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  visible    INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS media (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  filename   TEXT NOT NULL,
  path       TEXT NOT NULL,
  alt        TEXT NULL,
  mime       TEXT NULL,
  width      INTEGER NULL,
  height     INTEGER NULL,
  filesize   INTEGER NULL,
  created_at TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS menu_items (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  location   TEXT NOT NULL DEFAULT 'header',
  label      TEXT NOT NULL,
  url        TEXT NOT NULL,
  parent_id  INTEGER NULL,
  rel        TEXT NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  visible    INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS messages (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  name       TEXT NOT NULL,
  email      TEXT NULL,
  phone      TEXT NULL,
  service    TEXT NULL,
  message    TEXT NULL,
  page       TEXT NULL,
  ip         TEXT NULL,
  user_agent TEXT NULL,
  status     TEXT NOT NULL DEFAULT 'nuevo',
  created_at TEXT NOT NULL,
  read_at    TEXT NULL
);

CREATE TABLE IF NOT EXISTS redirects (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  source      TEXT NOT NULL,
  destination TEXT NOT NULL,
  status_code INTEGER NOT NULL DEFAULT 301,
  hits        INTEGER NOT NULL DEFAULT 0,
  created_at  TEXT NOT NULL,
  UNIQUE (source)
);

CREATE INDEX IF NOT EXISTS ix_attempts_lookup ON login_attempts (created_at, success);
CREATE INDEX IF NOT EXISTS ix_sections_page ON page_sections (page_id, sort_order);
CREATE INDEX IF NOT EXISTS ix_plans_service ON plans (service_id, sort_order);
CREATE INDEX IF NOT EXISTS ix_posts_pub ON posts (visible, published_at);
CREATE INDEX IF NOT EXISTS ix_faqs_page ON faqs (page_slug, sort_order);
CREATE INDEX IF NOT EXISTS ix_menu_location ON menu_items (location, sort_order);
CREATE INDEX IF NOT EXISTS ix_messages_status ON messages (status, created_at);
