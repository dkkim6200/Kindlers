# Kindlers Volunteer Hour Management System

This project is a web application used to manage volunteer hours of the members for Kindler's Society (NGO for donating English books to the third-world children). The features includes:
* log-in and log-out securely to manage volunteer hours
* view the list of events 
* sign-in and sign-out of volunteer events to automatically track volunteer hours
* create volunteer events (executive-only feature)

Login and sign-up system was implemented with PHP and MySQL, and AJAX to update the volunteer event status.

To access a demo of the web app, go to http://34.69.192.172/login.php. The login credentials are:
* **ID: test**
* **PW: test**

To sign in and sign out of events, use **"John Doe"** as the name for testing.


## Pages

* /index.php
  * Redirects the user to `login.php` if not logged in, or to `volunteer_events.php` if logged in.
  * `$_SESSION["logged_in"]` is used to track the user's login status.
* /login.php
  * A login page for executive members.
  * Presents a login page with username and password fields.
  * Uses prepared SQL statements to prevent SQL injection when checking for the user's credentials.
* /logout.php
  * Sets `$_SESSION["logged_in"]` to false and redirects the user to `login.php`.
* /volunteer_events.php
  * A well-formatted list of volunteer events on the system.
* /event.php/?key={int}
  * Presents time/date and description of the volunteer event.
  * Allows the user to sign-in and sign-out
* /create_event.php
  * Presents a form to create a new volunteer event.

## Database Relations

![Database Relations Diagram](https://github.com/dkkim6200/Kindlers/raw/master/imgs/db-diagram.JPG)

## Classes
* Database
  * Wrapper class for connecting and creating prepared SQL queries
* Event
  * `signIn(User $user)`
    * Creates a new record in table `sign_up` with given user.
  * `signOut(User $user)`
    * Sets `end_time` of the signup record created by `signIn(User $user)`
* User
  * Wrapper class for table `users`
  * `exists`
    * Boolean variable that represents if the user exists in the database.
