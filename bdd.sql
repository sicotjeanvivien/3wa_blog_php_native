CREATE TABLE `user` (
    `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `lastname` varchar(255),
    `firstname` varchar(255),
    `username` varchar(50),
    `password` varchar(255)
);

CREATE TABLE `article` (
    `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `title` varchar(255),
    `content` longtext,
    `date_published` datetime,
    `user_id` int
);

CREATE TABLE `category` (
    `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `name` varchar(255)
);

CREATE TABLE `article_category` (`article_id` int, `category_id` int);

CREATE TABLE `comment` (
    `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `content` varchar(255),
    `user_id` int,
    `article_id` int
);

ALTER TABLE
    `article_category`
ADD
    FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE
    `article_category`
ADD
    FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

ALTER TABLE
    `article`
ADD
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE
    `comment`
ADD
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE
    `comment`
ADD
    FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

INSERT INTO
    category(name)
VALUES
    ("category1"),
    ("category2"),
    ("category3");

INSERT INTO
    user(`lastname`, `firstname`, `username`, `password`)
VALUES
    (
        "Doe",
        "John",
        "admin",
        "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMQPQp."
    );

INSERT INTO
    article(title, content, date_published, user_id)
VALUES(
        "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
        "2022-06-15 00:00:00",
        1
    ),
    (
        "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
        "2022-06-15 00:00:00",
        1
    ),
    (
        "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
        "2022-06-15 00:00:00",
        1
    );

INSERT INTO
    article_category(article_id, category_id)
VALUES
    (1, 2),
    (1, 3),
    (2, 1),
    (2, 3),
    (3, 2);

-- SELECT article de user_id 1
SELECT * FROM article WHERE user_id = 1;

-- SELECT article de category_id 2
SELECT  * FROM article 
JOIN article_category
WHERE article_category.category_id = 1;

-- SELECT article de id 3

SELECT * FROM article WHERE id = 3;
/* 2022-06-15 14:02:47 [2 ms] */ 
SELECT  title as titre, user.username as username 
FROM article 
JOIN user;
/* 2022-06-15 14:03:35 [1 ms] */ 
SELECT  title as titre, user.username as username, article.id as id
FROM article 
JOIN user;

SELECT * FROM article WHERE id IN (1,3);

SELECT * FROM article WHERE title LIKE "%ma%";

SELECT * FROM article WHERE title LIKE "%a%";

SELECT * FROM article WHERE title LIKE "%fa%";

SELECT * FROM article WHERE title IS NOT NULL;

SELECT * FROM article WHERE `title` = null ;

SELECT * FROM article WHERE title IS NOT NULL;

UPDATE article SET title = null WHERE id = 1;

SELECT * FROM article WHERE title IS NOT NULL;



ALTER TABLE article ADD image VARCHAR ;
