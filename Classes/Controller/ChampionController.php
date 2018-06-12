<?php
namespace Paladins\Palawins\Controller;

/*
 * This file is part of the Paladins.Palawins package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Paladins\Palawins\Domain\Model\Champion;
use \Paladins\Palawins\Domain\Repository;
use Neos\Flow\Persistence\QueryInterface;
class ChampionController extends ActionController
{

    /**
     * @Flow\Inject
     * @var Repository\ChampionRepository
     */
    protected $championRepository;

    /**
     * @param string $sort Optional
     * @param string $filter Optional
     * @return void
     */
    public function indexAction($sort = 'mostSuccessfulDown', $filter = NULL)
    {
        // Falls eine Sortierung mitgegeben wurde
        if ($sort != NULL) {
            // Nimmt z.B. mostPopularDown entgegen, dieser String wird zunächst
            // nach der Sortierrichtung (up oder down) durchsucht
            $indexUp = strpos($sort, 'Up');
            $indexDown = strpos($sort, 'Down');
            $rank = 1;
            
            //Falls ein 'Up' im Wort gefunden wurde
            if ($indexUp == True ) {
                //Die Property wird nun zugeschnitten, z.B.: mostPopularUp zu mostPopular
                $orderedBy = substr($sort, 0, $indexUp);
                $this->championRepository->setDefaultOrderings(array($orderedBy => QueryInterface::ORDER_ASCENDING ));
                
                
            }
            //Falls ein 'Down' im Wort gefunden wurde
            elseif ($indexDown == True) {
                $orderedBy = substr($sort, 0, $indexDown);
                $this->championRepository->setDefaultOrderings(array($orderedBy => QueryInterface::ORDER_DESCENDING )); 
                
            }
            //Falls weder 'Up' noch 'Down' gefunden wurden, muss es sich um ein Eintrag im Suchfeld handeln

        }
        
        
        
        $champions = $this->championRepository->findAll();
        
        if ($filter != NULL) {
            //$testString = 'Maeve, Barik, Strix';
            $filter = str_replace (" ", "", $filter);
            $filter = explode(",", $filter);
            //$champions =$this->championRepository->findByName('barik');
            //$this->view->assign('champions', $champions );
            $champions =$this->championRepository->findByChampionName($filter);
        }
        
        $this->view->assign('champions', $champions );
 
        
    }
        
}
 