DROP TABLE IF EXISTS Director;
DROP TABLE IF EXISTS Sales;
DROP TABLE IF EXISTS MovieGenre;
DROP TABLE IF EXISTS MovieDirector;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS MovieRating;
DROP TABLE IF EXISTS MovieActor;
DROP TABLE IF EXISTS Actor;
DROP TABLE IF EXISTS Movie;
DROP TABLE IF EXISTS MaxPersonID;
DROP TABLE IF EXISTS MaxMovieID;

CREATE TABLE Movie (
    id INT,
    -- every movie must have a title
    title VARCHAR(100) NOT NULL,
    year INT,
    rating VARCHAR(10),
    company VARCHAR(50),
    -- every movie has a unique identification number
    PRIMARY KEY(id)
) ENGINE = INNODB;

CREATE TABLE Actor (
    id INT,
    -- every actor must have a date of birth and name
    last VARCHAR(20) NOT NULL,
    first VARCHAR(20) NOT NULL,
    sex VARCHAR(6),
    dob DATE NOT NULL,
    dod DATE,
    -- every actor has a unique identification number
    PRIMARY KEY(id)
) ENGINE = INNODB;

CREATE TABLE Sales (
    mid INT,
    ticketsSold INT,
    totalIncome INT,
    -- every movie in Sales is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id),
    -- tickets sold and total income must be positive numbers
    CHECK(ticketsSold >= 0 AND totalIncome >= 0)
) ENGINE = INNODB;

CREATE TABLE Director (
    id INT,
    -- every director must have a date of birth and name
    last VARCHAR(20) NOT NULL,
    first VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    dod DATE,
    -- every director has a unique identification number
    PRIMARY KEY(id)
) ENGINE = INNODB;

CREATE TABLE MovieGenre (
    mid INT,
    genre VARCHAR(20),
    -- every movie in MovieGenre is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id)
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
    mid INT,
    -- every movie should have a director
    did INT NOT NULL,
    -- every movie in MovieDirector is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id)
) ENGINE = INNODB;

CREATE TABLE MovieActor (
    mid INT,
    -- every movie should have some actors
    aid INT NOT NULL,
    role VARCHAR(50),
    -- every movie in MovieActor is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id)
) ENGINE = INNODB;

CREATE TABLE MovieRating (
    mid INT,
    imdb INT,
    rot INT,
    -- every movie in MovieRating is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id),
    -- range of imdb rating in database is scaled between 0 and 100
    CHECK(imdb >= 0 AND imdb <= 100),
    -- range of rot rating in database is scaled between 0 and 100
    CHECK(rot >= 0 AND rot <= 100)
) ENGINE = INNODB;

CREATE TABLE Review (
    name VARCHAR(20),
    time TIMESTAMP,
    mid INT,
    rating INT,
    comment VARCHAR(500),
    -- every movie in Review is related to a movie in Movie table
    FOREIGN KEY(mid) REFERENCES Movie(id),
    -- range of reviewer rating is between 0 and 5
    CHECK(rating >= 0 AND rating <= 5)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id INT
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
    id INT
) ENGINE = INNODB;