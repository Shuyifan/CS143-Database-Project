CS143 Project 1A
------------------------------------------------------------------------------------------------------------------------------
create.sql

Create the tables in MySQL. It also check the constraints, making sure every constraints are hold.

Here are the list of all the table:

Movie(id, title, year, rating, company)
Actor(id, last, first, sex, dob, dod)
Sales(mid, ticketsSold, totalIncome)
Director(id, last, first, dob, dod)
MovieGenre(mid, genre)
MovieDirector(mid, did)
MovieActor(mid, aid, role)
MovieRating(mid, imdb, rot)
Review(name, time, mid, rating, comment)
MaxPersonID(id)
MaxMovieID(id)
------------------------------------------------------------------------------------------------------------------------------
load.sql

A MySQL script that loads all our provided data into the created tables.
------------------------------------------------------------------------------------------------------------------------------
queries.sql

A MySQL script that contains the following MySQL script:
- Find the names of all the actors in the movie 'Die Another Day'
- Find the count of all the actors who acted in multiple movies
- Find the title of movies that sell more than 1,000,000 tickets
- Find the names of movies that has IMDb rating larger than 8 but sell less than 250000 tickets
- Find the genre that has most movies
- Find the average tickets sold for each genre
------------------------------------------------------------------------------------------------------------------------------
query.php

Building a web query interface, which allow users to enter a MySQL query and see the output result.
------------------------------------------------------------------------------------------------------------------------------
violate.sql

A MySQL script that contains the operation violates the constraint.