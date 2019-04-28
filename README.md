#### Hostable Podcast [![Build Status](https://travis-ci.org/rossboswell/hostable-podcast.svg?branch=master)](https://travis-ci.org/rossboswell/hostable-podcast)

##### Requirements 
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

##### Installation

1. ```$ git clone https://github.com/rossboswell/hostable-podcast.git```
2. ```$ composer install```


##### Linting 
* ```./vendor/bin/phpcs```

##### Tests 
* ```./bin/phpunit```

