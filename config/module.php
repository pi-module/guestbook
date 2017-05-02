<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    // Module meta
    'meta' => array(
        'title' => _a('Guest book'),
        'description' => _a('Guest book'),
        'version' => '0.0.2',
        'license' => 'New BSD',
        'logo' => 'image/logo.png',
        'readme' => 'docs/readme.txt',
        'demo' => 'http://pialog.org',
        'icon' => 'fa-book',
    ),
    // Author information
    'author' => array(
        'Name' => 'Hossein Azizabadi',
        'email' => 'azizabadi@faragostaresh.com',
        'website' => 'http://pialog.org',
        'credits' => 'Pi Engine Team'
    ),
    // resource
    'resource' => array(
        'database' => 'database.php',
        'config' => 'config.php',
        'permission' => 'permission.php',
        'block' => 'block.php',
        'page' => 'page.php',
        'navigation' => 'navigation.php',
    )
);