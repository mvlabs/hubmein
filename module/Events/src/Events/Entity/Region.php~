<?php

namespace Events\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events\Entity\Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="Events\Entity\Repository\RegionRepository")
 */
class Region
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;
	
	/**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=100, nullable=true)
     */
    private $slug;
	
	/**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @ORM\OneToMany(targetEntity="Country", mappedBy="region")
     */
    private $countries;

    public function __construct()
    {
        $this->countries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * Get countries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCountries()
    {
        return $this->countries;
    }
	

    /**
     * Set id
     *
     * @param integer $id
     * @return Region
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Add countries
     *
     * @param \Events\Entity\Country $countries
     * @return Region
     */
    public function addCountrie(\Events\Entity\Country $countries)
    {
        $this->countries[] = $countries;
    
        return $this;
    }

    /**
     * Remove countries
     *
     * @param \Events\Entity\Country $countries
     */
    public function removeCountrie(\Events\Entity\Country $countries)
    {
        $this->countries->removeElement($countries);
    }
}