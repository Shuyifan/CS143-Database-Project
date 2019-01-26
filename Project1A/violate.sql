-- Cannot drop table Movie since MovieGenre and some other tables references Movie table
DROP TABLE Movie;

-- Cannot set id to NULL since id is the primary key
INSERT INTO Actor
	VALUES(NULL, 'John', 'Johnson', 'male', '1968-09-14', NULL);

-- Cannot set imdb rating more tan 100
UPDATE MovieRating
	SET imdb = 102;