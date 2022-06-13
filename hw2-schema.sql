--
-- Database: `homework`
--

CREATE DATABASE IF NOT EXISTS `homework`;
USE `homework`;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE users(
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstName varchar(255) not null,
  lastName varchar(255) not null,
  username varchar(16) not null unique,
  email varchar(255) not null unique,
  password varchar(255) not null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) engine='InnoDB';

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE likes(
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED not null,
  anime_id BIGINT UNSIGNED not null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_likes_user(user_id),
  unique(user_id,anime_id),
  FOREIGN KEY(user_id) REFERENCES users(id) on delete cascade
) engine='InnoDB';

DELIMITER //
CREATE TRIGGER delete_likes_of_deleted_user
BEFORE DELETE ON users
FOR EACH ROW
BEGIN
  IF EXISTS(SELECT user_id FROM likes where user_id=OLD.id) 
  THEN DELETE FROM likes WHERE user_id=OLD.id;
  END IF;
END//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `animes`
--

DROP TABLE IF EXISTS `animes`;
CREATE TABLE animes(
  id BIGINT not null PRIMARY KEY, 
  n_likes integer UNSIGNED not null,
  n_comments integer UNSIGNED not null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) engine='InnoDB';

DELIMITER //
CREATE TRIGGER insert_updatelikes_anime 
AFTER INSERT ON likes 
FOR EACH ROW
BEGIN
  IF EXISTS(SELECT id FROM animes where id=NEW.anime_id) 
    THEN UPDATE animes SET n_likes = n_likes + 1 WHERE id=NEW.anime_id;
  ELSE INSERT INTO animes(id,n_likes,n_comments) VALUES(NEW.anime_id,1,0);
  END IF;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER delete_updatelikes_anime 
AFTER DELETE ON likes 
FOR EACH ROW
BEGIN
  UPDATE animes SET n_likes = n_likes - 1 WHERE id=OLD.anime_id;
END//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE comments(
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  user_id BIGINT UNSIGNED not null,
  anime_id integer UNSIGNED not null,
  content TEXT not null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_comment_user(user_id),
  FOREIGN KEY(user_id) REFERENCES users(id) on delete cascade
) engine='InnoDB';

DELIMITER //
CREATE TRIGGER delete_comments_of_deleted_user
BEFORE DELETE ON users
FOR EACH ROW
BEGIN
  IF EXISTS(SELECT user_id FROM comments where user_id=OLD.id) 
  THEN DELETE FROM comments WHERE user_id=OLD.id;
  END IF;
END//
DELIMITER ; 

DELIMITER //
CREATE TRIGGER insert_updatecomments_anime 
AFTER INSERT ON comments 
FOR EACH ROW
BEGIN
  IF EXISTS(SELECT id FROM animes where id=NEW.anime_id) 
    THEN UPDATE animes SET n_comments = n_comments + 1 WHERE id=NEW.anime_id;
  ELSE INSERT INTO animes(id,n_likes,n_comments) VALUES(NEW.anime_id,0,1);
  END IF;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER delete_updatecomments_anime 
AFTER DELETE ON comments 
FOR EACH ROW
BEGIN
  UPDATE animes SET n_comments = n_comments - 1 WHERE id=OLD.anime_id;
END//
DELIMITER ;