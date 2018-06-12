<?php
namespace Paladins\Palawins\Command;


use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Paladins\Palawins\Domain\Model\Champion;
use Paladins\Palawins\Domain\Repository\ChampionRepository;
use Neos\Flow\Persistence\PersistenceManagerInterface;
/**
 * @Flow\Scope("singleton")
 */
class ChampionCommandController extends CommandController {
    
         /**
         * @Flow\Inject
         * @var ChampionRepository
         */
        protected $championRepository;
        
        /**
        * @Flow\Inject
        * @var PersistenceManagerInterface
        */
        protected $persistenceManager;
        
        /**
         * An example command
         *
         * The comment of this command method is also used for Flow's help screens. The first line should give a very short
         * summary about what the command does. Then, after an empty line, you should explain in more detail what the command
         * does. You might also give some usage example.
         *
         * It is important to document the parameters with param tags, because that information will also appear in the help
         * screen.
         * 
         * Falls reset nicht mit angegeben wurde, wird es automatisch auf FALSE gesetzt
         *
         *param string $requiredArgument This argument is required
         * @param boolean $reset This argument is optional
         * @return void
         */
    
    
        public function parseChampionsCommand($reset = TRUE) {
            if ($reset) {
                $this->championRepository->removeAll();
                
            }
   
            // Legt den Startwert für den Champion fest, um eine Nummerierung vornehmen zu können
            $rank = 1;
            
            // liest die Hauptseite mit allen Championnamen ein
            $pageChampionOverview = file_get_contents('http://paladins.guru/builds');
            $offsetEndOfChampion = 0;
            while ($offsetEndOfChampion != -1) { 
            // Beginn des Championnamens 
            $searchFor = '/builds/';
            $startOfChampion = strpos ( $pageChampionOverview , $searchFor);
            $offsetStartOfChampion = $startOfChampion + 8;

            // Alles vor dem Namen des Champions wird abgeschnitten, um das Leerzeichen nach dem Namen zu ermitteln
            $pageChampionOverview = substr ($pageChampionOverview, $offsetStartOfChampion);
            
            // Wir suchen das erste Auftreten eines Leerzeichens nach /builds/<Champion>
            //Dafür wird zunächst alles unnötige vor dem derzeitigen Champion abgeschnitten
            $searchFor = ' ';
            $endOfChampion = strpos ( $pageChampionOverview , $searchFor);
            $offsetEndOfChampion = $endOfChampion -1;
            
            // Der Championname wird ermittelt
            $championName = substr($pageChampionOverview, 0, $offsetEndOfChampion);
            // Der Championname wird einer neuen Tabellenzeile zugewiesen
            // Das letzte Aufkommen von /guides/ am Ende der HTML-Seite wird durch
            // die If-Abfrage abgefangen, das es keinen Champion enthält
            
            $championRow;
            
            // durch die If-Abfrage werden ungewollte Textfragmente abgefangen, da nicht alle Vorkommen von
            // http://paladins.guru/builds/... valide Championnamen sind
            if ($championName != "guides/" && strlen($championName) > 0 && strlen($championName < 81) && !strpos($championName, 'class') ) {
            
                // Liest alle HTML-Unterseiten der Champions ein
                $pageChampionSpecific = file_get_contents('http://paladins.guru/builds/'.$championName);

                //$this->outputLine('%s', [$pageChampionSpecific]);

                // ### %mostPopular ### 
                // findet die Winrate des meistgespielt Loadouts eines Champions heraus
                $searchFor = 'Win Rate: ';
                $startOfMostPopular = strpos ( $pageChampionSpecific , $searchFor);
                $offsetStartOfMostPopular = $startOfMostPopular + 10;

                $searchFor = '% -';
                $endOfMostPopular = strpos ( $pageChampionSpecific , $searchFor);
                $offsetEndOfMostPopular = $endOfMostPopular;

                $lengthMostPopular= $offsetEndOfMostPopular - $offsetStartOfMostPopular;

                $mostPopular= substr($pageChampionSpecific, $offsetStartOfMostPopular, $lengthMostPopular);

                $this->outputLine('%s', [$mostPopular]);

                // ### %mostSuccessful ###
                // findet die Winrate des erfolgreichsten Loadouts eines Champions heraus
                $searchFor = 'label-success';
                $startOfMostSuccessful = strpos ( $pageChampionSpecific , $searchFor);
                $offsetStartOfMostSuccessful = $startOfMostSuccessful + 15;

                $searchFor = '%</span> ';
                $endOfMostSuccessful = strpos ( $pageChampionSpecific , $searchFor);
                $offsetEndOfMostSuccessful = $endOfMostSuccessful;

                $lengthMostSuccessful= $offsetEndOfMostSuccessful - $offsetStartOfMostSuccessful;

                $MostSuccessful= substr($pageChampionSpecific, $offsetStartOfMostSuccessful, $lengthMostSuccessful);

                $this->outputLine('%s', [$MostSuccessful]);

                
                
                
                // Legt einen neuen Champion an (welcher später eine Tabellenzeile repräsentieren wird)
                // und weißt ihm die Daten zu. Am Ende wird das Objekt in die Datenbankebene persistiert
                $championRow = new Champion();
                $championName = ucFirst($championName);
                $championRow->setRank($rank);
                $championRow->setName($championName);
                $championRow->setMostPopular($mostPopular);
                $championRow->setMostSuccessful($MostSuccessful);
                $this->championRepository->add($championRow);
                $this->persistenceManager->persistAll();
                $rank = $rank + 1;
                } 

            }

            
        }
}