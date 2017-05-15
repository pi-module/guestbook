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
namespace Module\Guestbook\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class SubmitForm extends BaseForm
{
    public function __construct($name = null, $option = array())
    {
        $this->option = $option;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new SubmitFilter($this->option);
        }
        return $this->filter;
    }

    public function init()
    {
        // id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // title
        /* $this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => __('Title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => true,
            )
        )); */
        // Email
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => __('Email'),
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => true,
            )
        ));
        // name
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => __('Name'),
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => true,
            )
        ));
        // phone
        /* $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => __('Phone'),
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => false,
            )
        )); */
        // text_description
        $this->add(array(
            'name' => 'text_description',
            'options' => array(
                'label' => __('Text'),
            ),
            'attributes' => array(
                'type' => 'textarea',
                'rows' => '5',
                'cols' => '40',
                'required' => true,
            )
        ));
        // captcha
        if (Pi::user()->getId() == 0) {
            $captchaMode = $this->option['config']['captcha'];
            if($captchaElement = Pi::service('form')->getReCaptcha($captchaMode)){
                $this->add($captchaElement);
            }
        }
        // security
        $this->add(array(
            'name' => 'security',
            'type' => 'csrf',
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
                'class' => 'btn btn-primary',
            )
        ));
    }
}