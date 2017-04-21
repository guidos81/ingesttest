This project is built on the Slim Framework, details to install it are below.

# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can also run this command. 

	php composer.phar start

Run this command to run the test suite

	php composer.phar test

That's it! Now go build something cool.

# Further installation instructions from Guy Taylor

Once the framework is installed you'll need to add the newly created project folder to git and link it to my repository: https://github.com/guidos81/ingesttest

Once you're all synced up you should gain a classes directory, extra templates and a few other changes in /src. 

My database connections are stored in /src/settings.php, update these with your local database details.

I created a table in a new schema called ingesttest, sql for that new table is:

CREATE TABLE `ingesttest`.`todos` (
  `userId` INT NOT NULL,
  `id` INT NOT NULL,
  `title` VARCHAR(100) NULL,
  `completed` TINYINT NOT NULL DEFAULT 0,
  `warning` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`userId`, `id`));

I created an array constant for badwords to check against, this is in /public/index.php. You can add extra words in and they'll be picked up on a database clear and reload.

# Using the app

You can start the app from your project folder on the command line using:

    php -S 0.0.0.0:8080 -t public public/index.php

Which will allow you to access the site from http://localhost:8080/, however you'll need to use a route to do anything, there is no default homepage yet.

There are 4 routes in the app, each with a different purpose

1. /ingest will ingest the json file to the database and provide a screen to indicate success or a reason for failure. Each entry is unique however and it will not overwrite existing entries with matching userId and Id.

2. /clear will remove all entries from the database and provides a screen indicating success or failure.

3. /view will show all todos in a format as requested in the spec.

4. /view/profanity will show all todos featuring profanity in the title, as requested in the spec.