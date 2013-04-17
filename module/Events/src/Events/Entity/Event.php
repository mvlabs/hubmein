<?php

namespace Events\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events\Entity\Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Events\Entity\Repository\EventRepository")
 *
 */
class Event {

	private static $i_instanced = 1;
	
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="event_id_seq", allocationSize=1, initialValue=1)
	 */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string $abstract
     *
     * @ORM\Column(name="abstract", type="string", length=255, nullable=false)
     */
    private $abstract;

    /**
     * @var \DateTime $datefrom
     *
     * @ORM\Column(name="datefrom", type="datetime", nullable=false)
     */
    private $dateFrom;

    /**
     * @var \DateTime $dateto
     *
     * @ORM\Column(name="dateto", type="datetime", nullable=false)
     */
    private $dateTo;
	
    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var string $venue
     *
     * @ORM\Column(name="venue", type="string", length=255, nullable=false)
     */
    private $venue;

    /**
     * @var string $averagedayfee
     *
     * @ORM\Column(name="averagedayfee", type="integer", nullable=false)
     */
    private $averageDayFee;

    /**
     * @var string $mainsitelink
     *
     * @ORM\Column(name="mainsitelink", type="string", length=255, nullable=false)
     */
    private $mainSiteLink;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;
	
    /**
     * @var boolean $isvisible
     *
     * @ORM\Column(name="isvisible", type="boolean", nullable=true)
     */
    private $isVisible;
    
    /**
     * @var Events\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Events\Entity\Country", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;
	    

    public static function create($am_eventData) {
    	$I_event = new \Events\Entity\Event();
    	$I_event->setId(self::$i_instanced++);
    	foreach ($am_eventData as $s_param => $m_value) {
    		$I_event->$s_param = $m_value;
    	}
    	return $I_event;
    }
    
    private function setId($i_id) {
    	$this->id = $i_id;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set abstract
     *
     * @param text $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Get abstract
     *
     * @return text 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set datefrom
     *
     * @param date $datefrom
     */
    public function setDatefrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * Get datefrom
     *
     * @return date 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateto
     *
     * @param date $dateto
     */
    public function setDateto($dateTo)
    {
        $this->dateTo = $dateTo;
    }

    /**
     * Get earlyBirdUntil
     *
     * @return date 
     */
    public function getEarlyBirdUntil()
    {
        return $this->earlyBirdUntil;
    }
	
	/**
     * Set earlyBirdUntil
     *
     * @param date $earlyBirdUntil
     */
    public function setEarlyBirdUntil($earlyBirdUntil)
    {
        $this->earlyBirdUntil = $earlyBirdUntil;
    }

    /**
     * Get dateto
     *
     * @return date 
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }
	
    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

	 /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set venue
     *
     * @param string $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * Get venue
     *
     * @return string 
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * Set averagedayfee
     *
     * @param integer $averagedayfee
     */
    public function setAveragedayfee($averagedayfee)
    {
        $this->averageDayFee = $averagedayfee;
    }

    /**
     * Get averagedayfee
     *
     * @return integer 
     */
    public function getAveragedayfee()
    {
        return $this->averageDayFee;
    }

    /**
     * Set mainsitelink
     *
     * @param string $mainsitelink
     */
    public function setMainsitelink($mainsitelink)
    {
        $this->mainSiteLink = $mainsitelink;
    }

    /**
     * Get mainsitelink
     *
     * @return string 
     */
    public function getMainsitelink()
    {
        return $this->mainSiteLink;
    }

    /**
     * Set contactemail
     *
     * @param string $contactemail
     */
    public function setContactemail($contactemail)
    {
        $this->contactemail = $contactemail;
    }

    /**
     * Get contactemail
     *
     * @return string 
     */
    public function getContactemail()
    {
        return $this->contactemail;
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
     * Get country slug
     *
     * @return string Returns country slug
     */
    public function getCountryslug()
    {
    	return $this->country->getSlug();
    }
        
    /*
     * Get country name
     * 
     * @return string 
     */
    public function getCountryName() {
    	return $this->country->getName();
    }
    
	
	/**
     * Set isVisible
     *
     * @param boolean $isVisible
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    /**
     * Get isVisible
     *
     * @return boolean 
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
	
    
    public function toArray() {
        
        $as_data = array();
        $as_data['id'] = $this->id;
        $as_data['title'] = $this->title;
        $as_data['abstract'] = $this->abstract;
        $as_data['date_from'] = $this->dateFrom;
        $as_data['date_to'] = $this->dateTo;
        
        return $as_data;
        
    }
    
}