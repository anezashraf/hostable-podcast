# Hostable Podcast [![Build Status](https://travis-ci.org/rossboswell/hostable-podcast.svg?branch=master)](https://travis-ci.org/rossboswell/hostable-podcast)

#### Requirements 
* Mac or Linux (possibly partially works on windows, but windows is not supported)
* Php Version 7.2 or Higher 
* Php Extensions 
    *  Ctype
    *  iconv
    *  JSON
    *  PCRE
    *  Session
    *  SimpleXML
    *  Tokenizer
* Within the project's root directory, the `var/cache`, `var/log` and `var/data` directories must be read/writable
* Nodejs (necessary for webpack)
* Npm

#### Installation

1. ```$ git clone https://github.com/rossboswell/hostable-podcast.git```
2. ```$ composer install```

#### Usage
##### 1.  Creating an episode

`$ php bin/console episode:create`

This command takes the below possible options 
1. `--title=${someValue}` The title of the episode
2. `--description=${sodescriptionmeValue}` A brief description of what the episode is about
3. `--slug=${someValue}` The url slug of the episode's webpage
4. `--image=${someValue}` The image of the specific episode (overwrites the podcast image in the rss feed)
5. `--enclosure=${someValue}` The downloadable media (for now, this can only be mp3/mp4)

**Example**:
* `$ php bin/console episode:create --title=FirstEpisode --description="the first ever episode" --enclosure=http://some_s3_link` 
* `$ php bin/console episode:create --slug=coolbeans --description="the second ever episode" --enclosure=http://some_s3_link` 

##### 2.  Amending an episode

`$ php bin/console episode:update`

This command takes the below possible options 
1. `--title=${someValue}` The title of the episode
2. `--description=${sodescriptionmeValue}` A brief description of what the episode is about
3. `--slug=${someValue}` The url slug of the episode's webpage
4. `--image=${someValue}` The image of the specific episode (overwrites the podcast image in the rss feed)
5. `--enclosure=${someValue}` The downloadable media (for now, this can only be mp3/mp4)

The `id` or episode number must be the first argument before the options.

**Example**:
* `$ php bin/console episode:update 3 --title=FirstEpisode --description="the first ever episode" --enclosure=http://some_s3_link` 
* `$ php bin/console episode:update 4 --slug=coolbeans --description="the second ever episode" --enclosure=http://some_s3_link` 

##### 3.  Updating settings

`$ php bin/console setting:update`

The first argument will need to be the setting `key`. The possible keys are shown below

* itunes (the link behind the itunes icon)
* mode (determines whether the site is online or offline)
* facebook (the link behind the facebook icon)
* twitter (the link behind the twitter icon)

This command takes the below possible options 
1. `--value=${someValue}` the value of the setting key

**Example**:
* `$ php bin/console setting:update facebook --value=http://facebook.com/some_facebook_page_blah_blah`

##### 3.  Bring the site online or offline

`$ php bin/console mode`

The first argument could either be `online` or `offline`

This command takes no options 

**Example**:
* `$ php bin/console mode online`
* `$ php bin/console mode offline # send a http code of 503 when request is sent`


##### Linting 
* ```./vendor/bin/phpcs```

##### Tests 
* ```./bin/phpunit```

