### Hostable Podcast

##### Installation

1. ```$ git clone https://github.com/rossboswell/hostable-podcast.git```
3. ```$ ./bin/install```


##### Linting 
1. ```vendor/bin/phpstan analyse -l 7 -c extension.neon src tests```
2. ```./vendor/bin/phpmd src text cleancode,unusedcode,naming,codesize,design,controversial```   
3. ```./vendor/bin/phpcs```
4. ``./node_modules/.bin/eslint assets``
5. `` ./node_modules/.bin/stylelint assets/``