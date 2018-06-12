<?php
namespace Paladins\Palawins\Domain\Model;

/*
 * This file is part of the Paladins.Palawins package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

use Paladins\Palawins\Domain\Repository;

/**
 * @Flow\Entity
 */
class Champion
{
    /**
     * @var string
     * @ORM\Column(length=3)
     */
    protected $rank;
      
    /**
     * @var string
     * @ORM\Column(length=80)
     */
    protected $name;

    /**
     * @var string
     * @Flow\Validate(type="Text")
     * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
     * @ORM\Column(length=80)
     */
    protected $mostPopular;
    
    /**
     * @var string
     * @Flow\Validate(type="Text")
     * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
     * @ORM\Column(length=80)
     */
    protected $mostSuccessful;

    /**
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param string $rank
     * @return void
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
    
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
        /**
     * @return string
     */
    public function getMostPopular()
    {
        return $this->mostPopular;
    }

    /**
     * @param string $mostPopular
     * @return void
     */
    public function setMostPopular($mostPopular)
    {
        $this->mostPopular = $mostPopular;
    }
    
    /**
     * @return string
     */
    public function getMostSuccessful()
    {
        return $this->mostSuccessful;
    }

    /**
     * @param string $mostSuccessful
     * @return void
     */
    public function setMostSuccessful($mostSuccessful)
    {
        $this->mostSuccessful = $mostSuccessful;
    }
    
}
