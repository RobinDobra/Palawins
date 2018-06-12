<?php
namespace Paladins\Palawins\Domain\Repository;

/*
 * This file is part of the Paladins.Palawins package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Paladins\Palawins\Domain\Model\Champion;
use Neos\Flow\Persistence\QueryInterface;


/**
 * @Flow\Scope("singleton")
 */
class ChampionRepository extends Repository
{
    /**
     * Finds posts by the specified blog
     *
     * @param string $filterByNames Array der Championnamen
     * @return QueryResultInterface Die Champions
     */
    public function findByChampionName($filterByNames) {
        $query = $this->createQuery();
        foreach ($filterByNames as $filterByName) {
            $constraint[] = $query->equals('name', $filterByName);
        }
        return
            $query->matching($query->logicalOr($constraint))->execute();
    }
}
