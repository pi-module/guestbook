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
use Zend\InputFilter\InputFilter;
use Module\System\Validator\UserEmail as UserEmailValidator;

class SubmitFilter extends InputFilter
{
    public function __construct($option = array())
    {
        // id
        $this->add(array(
            'name' => 'id',
            'required' => false,
        ));
        // title
        /* $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        )); */
        // email
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators'    => array(
                array(
                    'name'      => 'EmailAddress',
                    'options'   => array(
                        'useMxCheck'        => false,
                        'useDeepMxCheck'    => false,
                        'useDomainCheck'    => false,
                    ),
                ),
                new UserEmailValidator(array(
                    'blacklist'         => false,
                    'check_duplication' => false,
                )),
            ),
        ));
        // name
        $this->add(array(
            'name' => 'name',
            'required' => true,
        ));
        // phone
        /* $this->add(array(
            'name' => 'phone',
            'required' => false,
        )); */
        // text_description
        $this->add(array(
            'name' => 'text_description',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        ));
        // time_create
        if ($option['side'] == 'admin') {
            $this->add(array(
                'name' => 'time_create',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    new \Module\Guestbook\Validator\TimeCreate,
                ),
            ));
        }
    }
}