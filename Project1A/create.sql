DROP TABLE IF EXISTS Movie;
CREATE TABLE Movie (
    id INT,
    title VARCHAR(100),
    year INT,
    rating VARCHAR(10),
    company VARCHAR(50),
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS Actor;
CREATE TABLE Actor (
    id INT,
    last VARCHAR(20),
    first VARCHAR(20),
    sex VARCHAR(6),
    dob DATE,
    dod DATE
);

DROP TABLE IF EXISTS Sales;
CREATE TABLE Sales (
    mid INT,
    ticketsSold INT,
    totalIncome INT
);

DROP TABLE IF EXISTS Director;
CREATE TABLE Director (
    id INT,
    last VARCHAR(20),
    first VARCHAR(20),
    dob DATE,
    dod DATE
);

DROP TABLE IF EXISTS MovieGenre;
CREATE TABLE MovieGenre (
    mid INT,
    genre VARCHAR(20)
);

DROP TABLE IF EXISTS MovieDirector;
CREATE TABLE MovieDirector (
    mid INT,
    did INT
);

DROP TABLE IF EXISTS MovieActor;
CREATE TABLE MovieActor (
    mid INT,
    aid INT,
    role VARCHAR(50)
);

DROP TABLE IF EXISTS MovieRating;
CREATE TABLE MovieRating (
    mid INT,
    imdb INT,
    rot INT
);

DROP TABLE IF EXISTS Review;
CREATE TABLE Review (
    name VARCHAR(20),
    time TIMESTAMP,
    mid INT,
    rating INT,
    comment VARCHAR(500)
);

DROP TABLE IF EXISTS MaxPersonID;
CREATE TABLE MaxPersonID (
    id INT
);

DROP TABLE IF EXISTS MaxMovieID;
CREATE TABLE MaxMovieID (
    id INT
);