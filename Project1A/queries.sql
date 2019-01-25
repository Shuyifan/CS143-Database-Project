--  Give me the names of all the actors in the movie 'Die Another Day'.

SELECT CONCAT(a.first, ' ', a.last) 
FROM Actor AS a, 
    (
    SELECT aid
    FROM Movie AS m, MovieActor AS ma
    WHERE m.id = ma.mid AND m.title = 'Die Another Day'
    ) AS ma
WHERE a.id = ma.aid;

-- Give me the count of all the actors who acted in multiple movies.

SELECT COUNT(aid)
FROM 
    (
        SELECT aid, COUNT(mid) AS num
        FROM MovieActor 
        GROUP BY mid
    ) AS ma
WHERE ma.num > 1;

-- Give me the title of movies that sell more than 1,000,000 tickets.

SELECT DISTINCT title
FROM Movie AS m, Sales AS s
WHERE m.id = s.mid AND s.ticketsSold > 1000000;

-- Find the movie name with the most totalIncome

SELECT title
FROM Movie AS m, 
    (
        SELECT a.mid
        FROM Sales AS a
        WHERE a.totalIncome >=
        (
            SELECT MAX(totalIncome)
            FROM Sales
        )
    ) AS s
WHERE m.id = s.mid;

-- Find the average tickets sold for each genre

SELECT AVG(ticketsSold) 
FROM MovieGenre AS g, Sales AS s
WHERE s.mid = g.mid
GROUP BY g.genre;