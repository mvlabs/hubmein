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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="country_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string $code
     *
     * @ORM\Column(name="code", type="string", length=2, nullable=false)
     */
    private $code;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;
    
    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=100, nullable=false)
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
    
    public function fillWith($data)
    {
        $this->id   = (isset($data['id'])) ? $data['id'] : null;
        $this->code = (isset($data['code'])) ? $data['code'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->slug = (isset($data['slug'])) ? $data['slug'] : null;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Country
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set region
     *
     * @param Conferences\Entity\Region $region
     */
    public function setRegion(\Conferences\Entity\Region $region)
    {
        $this->region = $region;
    }
    
    /**
     * Get region
     *
     * @return Conferences\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /*
     * End of entity fields getters / setters
    */
    
    /*
     * Get region name
    *
    * @return string
    */
    public function getRegionName()
    {
        return $this->region->getName();
    }
    
}