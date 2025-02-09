DROP TABLE IF EXISTS notes;

DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  id BIGSERIAL PRIMARY KEY,
  public_id VARCHAR(12),
  name VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  email TEXT NOT NULL,
  password TEXT NOT NULL,
  email_verified BOOLEAN NOT NULL DEFAULT FALSE,
  refresh_token TEXT NOT NULL,
  created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
  CONSTRAINT idx_public_id UNIQUE (public_id)
);

CREATE TABLE IF NOT EXISTS notes (
  id BIGSERIAL PRIMARY KEY,
  public_id VARCHAR(12) NOT NULL,
  title TEXT NOT NULL,
  user_id BIGINT NOT NULL,
  description VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  thumbnail_url TEXT,
  thumbnail_path TEXT,
  featured_image_url TEXT,
  featured_image_path TEXT,
  created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
  FOREIGN KEY (user_id) REFERENCES users (id)
);
