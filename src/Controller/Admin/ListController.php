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
namespace Module\Guestbook\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;
use Module\Guestbook\Form\SubmitForm;
use Module\Guestbook\Form\SubmitFilter;

class ListController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get info
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $select = $this->getModel('text')->select()->order($order)->offset($offset)->limit($limit);
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
        $select = $this->getModel('text')->select()->columns($count);
        $count = $this->getModel('text')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'list',
                'action' => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('list-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);
    }

    public function updateAction()
    {
        // Get id
        $id = $this->params('id');
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set option
        $option = array(
            'config' => $config,
            'side' => 'admin',
        );
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
                if (empty($values['id'])) {
                    $values['status'] = 1;
                    $values['uid'] = Pi::user()->getId();
                    $values['ip'] = Pi::user()->getIp();
                    //$values['time_create'] = time();
                }
                // Set time
                $values['time_create'] = strtotime($values['time_create']);
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('text')->find($values['id']);
                } else {
                    $row = $this->getModel('text')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Jump
                $message = __('Text data saved successfully.');
                $this->jump(array('action' => 'index'), $message);

            }
        } else {
            if ($id) {
                $text = $this->getModel('text')->find($id)->toArray();
                $text['time_create'] = date("Y/m/d", $text['time_create']);
            } else {
                $text = array();
                $text['time_create'] = date("Y/m/d", time());
            }
            $form->setData($text);
        }
        // Set view
        $this->view()->setTemplate('list-update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Manage text'));
    }

    public function acceptAction()
    {
        // Get id and status
        $module = $this->params('module');
        $id = $this->params('id');
        $status = $this->params('status');
        $return = array();
        // set text
        $text = $this->getModel('text')->find($id);
        // Check
        if ($text && in_array($status, array(1, 2, 3, 4, 5, 6))) {
            // Accept
            $text->status = $status;
            // Save
            if ($text->save()) {
                // Set return
                $return['message'] = sprintf(__('%s text accept successfully'), $text->title);
                $return['ajaxstatus'] = 1;
                $return['id'] = $text->id;
                $return['textstatus'] = $text->status;
            } else {
                $return['message'] = sprintf(__('Error in accept %s text'), $text->title);
                $return['ajaxstatus'] = 0;
                $return['id'] = 0;
                $return['textstatus'] = $text->status;
            }
        } else {
            $return['message'] = __('Please select text');
            $return['ajaxstatus'] = 0;
            $return['id'] = 0;
            $return['textstatus'] = 0;
        }
        return $return;
    }
}
