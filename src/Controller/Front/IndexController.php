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
use Module\Guestbook\Form\SubmitForm;
use Module\Guestbook\Form\SubmitFilter;
use Zend\Db\Sql\Predicate\Expression;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get uid
        $uid = Pi::user()->getId();
        // Get info
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($config['show_perpage']);
        $offset = (int)($page - 1) * $config['show_perpage'];
        $where = array('status' => 1);
        $select = $this->getModel('text')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('text')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['time_create_view'] = _date($row->time_create, array('pattern' => 'yyyy/MM/dd'));
            $list[$row->id]['text_description'] = Pi::service('markup')->render($list[$row->id]['text_description'], 'html', 'text');
            $list[$row->id]['avatar'] = Pi::service('user')->avatar($row->uid, 'normal' , array(
                'alt' => $row->name,
                'class' => 'img-circle'
            ));
        }
        // Set paginator
        $count = array('count' => new Expression('count(*)'));
        $select = $this->getModel('text')->select()->columns($count)->where($where);
        $count = $this->getModel('text')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'index',
                'action' => 'index',
            )),
        ));
        // Set option
        $option = array(
            'config' => $config,
            'side' => 'front',
        );
        // Set form
        $form = new SubmitForm('submit', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        $form->setAttribute('action', Pi::url($this->url('', array(
            'controller' => 'submit',
            'action' => 'index',
        ))));
        if ($uid > 0) {
            $fields = array(
                'id', 'identity', 'name', 'email'
            );
            $user = Pi::user()->get($uid, $fields);
            $values = array(
                'uid' => $uid,
                'name' => $user['name'],
                'email' => $user['email'],
            );
            $form->setData($values);
        }
        // Set view
        $this->view()->setTemplate('list');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);
        $this->view()->assign('page', $page);
        $this->view()->assign('form', $form);
    }
}