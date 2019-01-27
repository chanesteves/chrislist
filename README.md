---------------------------------
-- APP NAME: ChrisList
---------------------------------
-- CREATED BY: Christian Esteves
---------------------------------


DESCRIPTION: A simple to-do app

------------------------------
---------- FEATURES ----------
------------------------------

1. Easy-to-use to-do list
2. Multiple to-do list management
3. Activity Tracking
4. Printing of to-do list
5. Authentication
6. Change password & upload photo

------------------------------
-------- INSTALLATION --------
------------------------------

1. Create an empty database for the application.

2. Generate a new application key.
	2.i. Inside the project directory, run the ff. command:

		php artisan key:generate

3. Configure the .env file.
	3.i. Set the APP_URL to "http:://localhost:8000". This URL is authorized to use the Google+ API. Otherwise, you may also create your own Google API credentials (please see https://developers.google.com/identity/protocols/OAuth2) and use it in the "google" variable in config/services.php.
	3.ii. Set up the connection to the database you created.
	3.iii. Once done editing the .env file, run the following command:

		php artisan config:cache

4. Inside the project directory, run the following command:
	
		composer install

5. Run the migrations.

		php artisan migrate --path=database/migrations/create
