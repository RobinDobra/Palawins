<?php
namespace Paladins\Palawins\Controller;

use Neos\Flow\Annotations as Flow;

class StandardController extends \Neos\Flow\Mvc\Controller\ActionController
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('foos', array('bar', 'baz'));
        $this->view->assign('championName', 'Androxus');
        $this->view->assign('championMostPopular', '59,2%');
        $this->view->assign('championMostSuccessful', '63,2%');
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

