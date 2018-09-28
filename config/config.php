<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    'category' => array(
        array(
            'title' => _a('Admin'),
            'name' => 'admin'
        ),
        array(
            'title' => _a('Show'),
            'name' => 'show'
        ),
        array(
            'title'  => _a('Form'),
            'name'   => 'form'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category' => 'admin',
            'title' => _a('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 50
        ),
        // Show
        'show_perpage' => array(
            'category' => 'show',
            'title' => _a('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 5
        ),
        'show_form' => array(
            'category' => 'show',
            'title' => _a('Show submit form on list page'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 1
        ),
        // form
        'captcha'  => array(
            'title'         => _t('Use CAPTCHA'),
            'description'   => _t('Captcha just use for guest'),
            'edit'          => array(
                'type'      => 'select',
                'options'   => array(
                    'options'       => array(
                        0       => _t('No captcha'),
                        1       => _t('Standard captcha'),
                        2       => _t('New re-captcha'),
                    ),
                ),
            ),
            'value'         => 0,
            'filter'        => 'int',
            'category'      => 'form',
        ),
        // Texts
        'text_description_index' => array(
            'category' => 'head_meta',
            'title' => _a('Description for index page'),
            'description' => '',
            'edit' => 'textarea',
            'filter' => 'string',
            'value' => ''
        ),
    ),
);