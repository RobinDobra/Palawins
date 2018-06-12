<?php
namespace Paladins\Palawins\Controller;

/*
 * This file is part of the Paladins.Palawins package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Paladins\Palawins\Domain\Model\Impressum;

class ImpressumController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Paladins\Palawins\Domain\Repository\ImpressumRepository
     */
    protected $impressumRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('impressums', $this->impressumRepository->findAll());
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Impressum $impressum
     * @return void
     */
    public function showAction(Impressum $impressum)
    {
        $this->view->assign('impressum', $impressum);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Impressum $newImpressum
     * @return void
     */
    public function createAction(Impressum $newImpressum)
    {
        $this->impressumRepository->add($newImpressum);
        $this->addFlashMessage('Created a new impressum.');
        $this->redirect('index');
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Impressum $impressum
     * @return void
     */
    public function editAction(Impressum $impressum)
    {
        $this->view->assign('impressum', $impressum);
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Impressum $impressum
     * @return void
     */
    public function updateAction(Impressum $impressum)
    {
        $this->impressumRepository->update($impressum);
        $this->addFlashMessage('Updated the impressum.');
        $this->redirect('index');
    }

    /**
     * @param \Paladins\Palawins\Domain\Model\Impressum $impressum
     * @return void
     */
    public function deleteAction(Impressum $impressum)
    {
        $this->impressumRepository->remove($impressum);
        $this->addFlashMessage('Deleted a impressum.');
        $this->redirect('index');
    }
}
