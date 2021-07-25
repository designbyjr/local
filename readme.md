# Welcome to Lokalise!
All your localisation needs in a neat and tidy API Bundle.

## Prerequisites Before install

 - Apache with PHP 7.4 or greater.
 - Install Yaml Extension Via PERL for PHP for YAML support.
 - Mysql server

**Installing YAML on Mac**
Make sure you have PHP installed also and on the command line globally before doing the following.
If you have homebrew installed you can follow the instructions below. Otherwise install homebrew  [here](https://brew.sh/) Then follow instructions below.

In terminal run 
`brew install libyaml`
This will install the yaml libary but not with PHP.
Make note of the final install path of this install, it should look like this:

    /usr/local/Cellar/libyaml/0.2.5
Now run
	

    pecl install yaml
An option appears "Please provide the prefix of libyaml installation [autodetect]"

Now paste in the install path and hit enter.

You may need to check your PHP INI file to see if yaml.so is enabled.

**Installing YAML on Windows**
Make sure you have PHP installed also and on the command line globally before doing the following.

Check to see if PERL is installed first.

Open the command line and type `perl` hit enter.

If installed it will return a command message back.
Otherwise install perl [here](https://www.perl.org/get.html)

If Installed then run

    pecl install yaml
This should install yaml to PHP, make sure that your PHP INI file has the extension enabled before continuing.

## Installing the code

Open the directory of lokalise and you should see the composer.json file is in the same directory.
Make sure you have composer installed otherwise install it [here](https://getcomposer.org/download/).
To Install run if installed globally:

    php composer install
    
Or run locally:
	

    php composer.phar install

Now open the .env file and configure the database to a new database schema.
Updating the following below.

    DB_HOST=HOSTADDRESS  
    DB_PORT=HOSTPORT  
    DB_DATABASE=DB_SCHEMA_NAME 
    DB_USERNAME=SCHEMA_USERNAME  
    DB_PASSWORD=USERNAMES_PASSWORD

Now run in the command line inside project folder:

    php artisan migrate --seed
    
It may take some time to seed the database with 20 keys each with 5 translations.
*If this fails, run:*
	

    php artisan migrate:fresh --seed

Finally you will be required to install passport to generate client keys.
Run:
	

    passport:install

Below is an example of what is generated
![Result](https://i.ibb.co/1rVgW2f/Screenshot-2021-07-25-at-21-36-50.png)
You will need the Client ID 2 and the client secret to access the  API to create a BEARER TOKEN.

You can use postman as an HTTP client. In the body section of the request. You will need to point to 

`http://{YOURLOCALDOMAIN}/oauth/token`

Below is an example setup of what you need to aquire the token
![enter image description here](https://i.ibb.co/gZTY5d4/Screenshot-2021-07-25-at-21-39-57.png)

The usernames are the emails generated, you can inspect the mysql database for these.
Please note the usernames and emails have numbers, they are always the same. ie test3@lokalise.com is lokalise3 as a password.

**Using the bearer token**
Go to the authenication section of your HTTP Client and select the bearer token option, now copy the bearer token and paste it into your next request.
For example
GET  {YOURLOCALDOMAIN}/api/languages/list
This will return the list of languages.

## Importance of key in url

**{key}** in all routes refers to the **key id** that must be passed in on some routes.

Authorisation for read and write is done via polices and the users own read-only or read-write permissions.

## To create a key:

	
**POST**    api/keys/make
**json:**	

    {
    "text":"new english sentance to translate",
    "key_name":"Key Name Goes here"
    }
It will return the key and all 5 languages.


## List Keys,Languages
**GET**
    api/keys/list
    api/keys/retrieve/{key}
    api/languages/list

## Update Key Name
**PUT**
    api/keys/rename/{key}
    **JSON:**
  

     {
        "key_name":"Key Name Goes here"
       }
       
## Update Translation

    api/keys/translation/{key}
    
This allows you to update the translation, you are required to send a json **PUT** with a json structure like this:

    {"text":"new text you want to update"}
    
## DELETE Key 
**DELETE**
	api/keys/delete/{key}

This will also delete all translations realted to this key.

## EXPORT ZIP
**DELETE**
	api/keys/export

This will return a datastream with a zip file, you may need to save the stream as a file from your client.
If not you can access the new zip in the root of the project.
The name of the file is "translations.zip"
