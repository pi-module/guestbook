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
namespace Module\Guestbook\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;
use Module\Guestbook\Form\SubmitForm;
use Module\Guestbook\Form\SubmitFilter;

class SubmitController extends ActionController
{
    public function indexAction()
    {
        // Get uid
        $uid = Pi::user()->getId();
        // Set option
        $option = array();
        // Set form
        $form = new SubmitForm('submit', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new SubmitFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // Set values
                $values['status'] = 2;
                $values['uid'] = $uid;
                $values['ip'] = Pi::user()->getIp();
                $values['time_create'] = time();
                // Save
                $row = $this->getModel('text')->createRow();
                $row->assign($values);
                $row->save();
                // Jump
                $message = __('Your text submitd and will be publish after review');
                $this->jump(array('controller' => 'index', 'action' => 'index'), $message);
            }
        } elseif ($uid > 0) {
            $fields = array(
                'id', 'identity', 'name', 'email'
            );
            $user = Pi::user()->get($uid, $fields);
            $user['uid'] = $uid;
            $user['name'] = sprintf('%s ( %s )', $user['name'], $user['identity']);
            $form->setData($user);
        }
        // Set view
        $this->view()->setTemplate('submit');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Submit new text'));
    }
}