
CREATE DATABASE Forum CHARACTER SET utf8 COLLATE utf8_general_ci;
USE Forum;

CREATE TABLE users(
	Id INT UNSIGNED UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Username VARCHAR(50) NOT NULL UNIQUE,
	Password CHAR(100) NOT NULL,
	Email VARCHAR(70),
	FullName VARCHAR(100),
    IsAdmin BOOL
);

CREATE TABLE tags(
	Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Title VARCHAR(100) NOT NULL    
);

CREATE TABLE categories(
	Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Title VARCHAR(100) NOT NULL
);

CREATE TABLE questions(
	Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Title VARCHAR(100) NOT NULL,
    Content VARCHAR(500) NOT NULL,
    Date DATETIME NOT NULL,
    Counter LONG NOT NULL,
    Category INT UNSIGNED NOT NULL,
    User INT UNSIGNED NOT NULL,
    
    FOREIGN KEY(Category) REFERENCES categories(Id),
    FOREIGN KEY(User) REFERENCES users(Id)
);

CREATE TABLE questions_tags(
	questionId INT UNSIGNED NOT NULL,
	tagId INT UNSIGNED NOT NULL,
    
    PRIMARY KEY(questionId,tagId),
	FOREIGN KEY(questionId) REFERENCES questions(Id),
    FOREIGN KEY(tagId) REFERENCES tags(Id)
);

CREATE TABLE answers(
	Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Content VARCHAR(500) NOT NULL,
    Date DATETIME NOT NULL,
    Question INT UNSIGNED NOT NULL,
    AuthorName VARCHAR(100) NOT NULL,    
    AuthorEmail VARCHAR(100) NOT NULL,
    
    FOREIGN KEY(Question) REFERENCES questions(Id)
);

INSERT INTO users (Username, Password, Email, FullName, IsAdmin) 
VALUES ("admin", "admin", "admin@abv.bg", "First Admin", true);

INSERT INTO tags (Title) 
VALUES ("C#"),
("Java"),
("Exam"),
("Homework"),
("MySQL");

INSERT INTO categories (Title) 
VALUES ("Level 1"),
("Level 2"),
("Level 3");

INSERT INTO questions (Title, Content, Date, Counter, Category, User) 
VALUES ("Homework MySQL Problem 2", "Помогнете ми дава грешка..", NOW(), 0, 3, 1),
("Exam 25.04.2015 JavaScript", "Много як изпит имам 500 точки", NOW(), 0, 2, 1);

INSERT INTO questions_tags (questionId, tagId) 
VALUES (1,4),
(1,5),
(2,3);

INSERT INTO answers(Content, Date, Question, AuthorName, AuthorEmail) 
VALUES ("Дай да видим код", NOW(), 1, "Пешо",""),
("Рестартирай си Workbench", NOW(), 1, "Goshko", "gosho@abv.bg");