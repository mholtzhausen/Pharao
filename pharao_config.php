<?php
/**
 * Set the base folder for the phar libraries.
 */
Pharao::setBaseFolder('phar/');

/**
 * Adding all containers and giving them archive names 
 */
Pharao::addPhar("lib",'_dev/lib/');
Pharao::addPhar("api",'_dev/api/');

?> 