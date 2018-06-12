<?php
namespace Paladins\Palawins\Controller;

/*
 * This file is part of the Paladins.Palawins package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Paladins\Palawins\Domain\Model\Datenschutz;

class DatenschutzController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Paladins\Palawins\Domain\Repository\DatenschutzRepository
     */
    protected $datenschutzRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('datenschutzs', $this->datenschutzRepository->findAll());
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Datenschutz $datenschutz
     * @return void
     */
    public function showAction(Datenschutz $datenschutz)
    {
        $this->view->assign('datenschutz', $datenschutz);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Datenschutz $newDatenschutz
     * @return void
     */
    public function createAction(Datenschutz $newDatenschutz)
    {
        $this->datenschutzRepository->add($newDatenschutz);
        $this->addFlashMessage('Created a new datenschutz.');
        $this->redirect('index');
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Datenschutz $datenschutz
     * @return void
     */
    public function editAction(Datenschutz $datenschutz)
    {
        $this->view->assign('datenschutz', $datenschutz);
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Datenschutz $datenschutz
     * @return void
     */
    public function updateAction(Datenschutz $datenschutz)
    {
        $this->datenschutzRepository->update($datenschutz);
        $this->addFlashMessage('Updated the datenschutz.');
        $this->redirect('index');
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Datenschutz $datenschutz
     * @return void
     */
    public function deleteAction(Datenschutz $datenschutz)
    {
        $this->datenschutzRepository->remove($datenschutz);
        $this->addFlashMessage('Deleted a datenschutz.');
        $this->redirect('index');
    }
}
