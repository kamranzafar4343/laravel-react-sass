Laravel sass react project(steps):

Created migrations
Created models
Database seeders(dummy values to start)
User observer to give user by default 10 credits (only for testing purpose -> optional)
Php artisan migrate:fresh  - -seed

Feature1controller(used feature resource inside controller -> because it secures sensitive info)
Feature resource 
Pages/Feature1/Index.jsx
Components/Feature.jsx

 Change in resources/js/Layout/AuthenticatedLayout.jsx
Added feature 1 and feature 2 buttons with Dashboard button (also in mobile view)

 Made Feature2Controller (duplicate feature1 -> controller, index.jsx and do necessary changes in it)

Added (user credit + coin image, Get More button in resources/js/Layout/AuthenticatedLayout.jsx)




Created credit controller
Added some functions(index function, webhook for stripe)

Setup test account on stripe
Install stripe cli in your system from their website and setup environment variables
Setup stripe test account and setup

Copy secret key from stripe test dashboard and Paste in .env at last of file
STRIPE_SECRET_KEY = ???

And then get the webhook key by running this command in you vs code terminal 

stripe listen --forward-to http://127.0.0.1:8000/buy-credits/webhook

STRIPE_WEBHOOK_KEY  ==  ???

And then setup this key in ur .env 
whsec_c0422222222222222222343243243243243243205e………

  Open CreditController.php and add 
   
