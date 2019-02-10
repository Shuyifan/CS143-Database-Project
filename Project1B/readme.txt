CS143 Project 1B
------------------------------------------------------------------------------------------------------------------------------
We worked as a team and split the work as follows: 
I worked on the five input pages. My partner, yifan worked on the search page and detailed actor information and movie information pages. Yifan recorded the video and I did the work for submission, including integrate our pages together.
------------------------------------------------------------------------------------------------------------------------------
index.php

This page serves as the homepage and provides some simple guides to visitors.
------------------------------------------------------------------------------------------------------------------------------
add_actor_director.php

Let users add either an actor or a director to the database. The form includes:

Type: Actor or Director
First Name
Last Name
Gender: Male, Female or Transgender
Date of Birth
Date of Death
------------------------------------------------------------------------------------------------------------------------------
add_movie.php

Let users add a new movie to the database. The form includes:

Title
Year
MPAA Rating: G, NC-17, PG, PG-13, R
Company
Genre

In this page, we do not provide the functionality to add actor or director to the movie. Instead, we have two separate pages to serve this functionality.
------------------------------------------------------------------------------------------------------------------------------
add_comments.php

Let users add new comments to the movie. The form includes:

User Name
Movie: Any movie in the database
Rating: from 5 to 1
Comment
------------------------------------------------------------------------------------------------------------------------------
add_movieactor.php

Let users add a new actor to a movie, including the movie user just added. The form includes:

First Name
Last Name
Movie: Any movie in the database
Role in the movie
------------------------------------------------------------------------------------------------------------------------------
add_moviedirector.php

Let users add a new director to a movie, including the movie user just added. The form includes:

First Name
Last Name
Movie: Any movie in the database
------------------------------------------------------------------------------------------------------------------------------
search.php

Let users search a movie or an actor with keywords. For actor, we examine first name and last name; for movie, we examine title. The search supports multiword search with a checkbox checked. We interpret space as AND relation.
After you search for something, you will get to either an actor page or a movie page described below.
------------------------------------------------------------------------------------------------------------------------------
actor.php

This page shows detailed actor information, including:

Actor's basic information: Actor ID, Name, Sex, Date of Birth, Date of Dead
The movies the actor was in: Title, Year, Actor Name, Actor Role, Rating, Produce Company

The movies also have link to the detailed movie information page.
------------------------------------------------------------------------------------------------------------------------------
movie.php

This page shows detailed movie information, including:

Movie's basic information: Title, Year, MPAA Rating, Produce Company, Director, Genre, IMDB Score, ROT Score
List of Actors in this movie: Name, Role
Average Rating from users
Comments of users
Add Comment which takes user to add comments page.

The actors also have link to the detailed actor information page.
------------------------------------------------------------------------------------------------------------------------------
main.css

A CSS file that styles a little bit of pages.
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