#!/bin/sh

rm /home/kerrywilson/rabbitphp.org/docs/* -Rf

PHP=/usr/local/bin/php
export PHP

/home/kerrywilson/rabbitphp.org/lib/phpdocs/phpdoc -o HTML:frames:DOM/default -ti "rabbitphp.org :: RabbitPHP Framework Documentation" -s on -i *.tpl -d /home/kerrywilson/rabbitphp.org/lib/framework,/home/kerrywilson/rabbitphp.org/lib/plugins -t /home/kerrywilson/rabbitphp.org/docs
