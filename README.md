## ABOUT PROJECT

Its a web app to shorten any given url to a small url which can be used anywhere.

## INSTALLATION

To install & run this project, do the following:-
    - Install composer

    - Clone the repository using "git clone https://github.com/abhismart8/url-shortener-web-app.git"

    - Run "composer install" command in your console

    - Create a .env file in your project directory and run "php artisan key:generate" command to generate   the App Key

    - Create a database and put the database details in .env file
    
    - Now, run "php artisan serve" command to run the application

## API's
    1.  Get all links of current user:-
        path - api/v1/urls?apikey=your_api_key
        method - GET
        response(JSON) - all urls data with pagination

    2.  Shorten Url API:-
        path - api/v1/shorten/url?apikey=your_api_key
        method - POST
        request body (JSON) - {
            "url": "any valid url"
        }
        response(JSON) - shorten url data

## APPLICATION LIVE URL
http://url-shortener-web-app-final.herokuapp.com/