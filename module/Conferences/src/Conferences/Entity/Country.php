<?php

namespace Conferences\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conferences\Entity\Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="Conferences\Entity\Repository\CountryRepository")
 */
class Country
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="country_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string $code
     *
     * @ORM\Column(type="string", length=2, nullable=false)
     */
    private $code;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;
    
    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $slug;
    
    /**
     * @var Conferences\Entity\Region
     *
     * @ORM\ManyToOne(targetEntity="Conferences\Entity\Region", inversedBy="countries",cascade={"persist", "remove"})
     */
    private $region;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @ORM\OneToMany(targetEntity="Conferences\Entity\Conference", mappedBy="country")
     */
    private $conferences;

    public function __construct()
    {
        $this->conferences = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function exchangeArray($data)
    {
        $this->fillWith($data);
    } 
    
    /**
     * 
     * @TOFIX this method should be removed
     */
    public function fillWith($data)
    {
        $this->id   = (isset($data['id'])) ? $data['id'] : null;
        $this->code = (isset($data['code'])) ? $data['code'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->slug = (isset($data['slug'])) ? $data['slug'] : null;
    }

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $slug
     * @return Country
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @param Conferences\Entity\Region $region
     */
    public function setRegion(\Conferences\Entity\Region $region)
    {
        $this->region = $region;
    }
    
    /**
     * @return Conferences\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /*
     * End of entity fields getters / setters
    */
    
    /**
    * @return string
    */
    public function getRegionName()
    {
        return $this->region->getName();
    }
    
    /**
     * @return string
     */
    public function getRegionSlug()
    {
        return $this->region->getSlug();
    }
    
}