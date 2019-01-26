-- the names of all the actors in the movie 'Die Another Day'.
-- the names are in the format <firstname> <lastname> separated by a single space
SELECT CONCAT(first, ' ', last)
FROM Actor AS a JOIN MovieActor AS ma ON a.id = ma.aid JOIN Movie AS m ON ma.mid = m.id
WHERE m.title = 'Die Another Day';

-- the count of all the actors who acted in multiple movies
SELECT COUNT(*)
FROM (
      SELECT aid
      FROM MovieActor
      GROUP BY aid
      HAVING COUNT(*) > 1
     ) ma;

-- the title of movies that sell more than 1,000,000 tickets.
SELECT title
FROM Movie AS m JOIN Sales AS s on m.id = s.mid
WHERE s.ticketsSold > 1000000;

-- the names of movies that has IMDb rating larger than 8 but sell less than 250000 tickets
SELECT m.title
FROM Movie AS m JOIN Sales AS s on m.id = s.mid JOIN MovieRating AS mr on m.id = mr.mid
WHERE mr.imdb > 8 AND s.ticketsSold < 250000;

-- the genre that has most movies
SELECT genre
FROM MovieGenre
GROUP BY genre
HAVING COUNT(*) >= ALL(
                        SELECT COUNT(*)
                        FROM MovieGenre
                        GROUP BY genre
                      );

-- Find the average tickets sold for each genre
SELECT AVG(ticketsSold) 
FROM MovieGenre AS g JOIN Sales AS s ON s.mid = g.mid
GROUP BY g.genre;
