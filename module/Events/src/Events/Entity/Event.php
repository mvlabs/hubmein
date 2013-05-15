<?php

namespace Events\Entity;

/**
 * Events\Entity\Event
 *
 */
class Event {

	/**
	 * @var integer $id
	 */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $abstract
     */
    private $abstract;

    /**
     * @var \DateTime $datefrom
     */
    private $datefrom;

    /**
     * @var \DateTime $dateto
     */
    private $dateto;
	
    /**
     * @var string $city
     */
    private $city;

    /**
     * @var string $venue
     */
    private $venue;

    /**
     * @var string $averagedayfee
     */
    private $averagedayfee;

    /**
     * @var string $mainsitelink
     */
    private $mainsitelink;
    
    /**
     * @var integer $country_id
     */
    private $country_id;
	
    
    public function exchangeArray($data)
    {
        $this->fillWith($data);
    } 
    
    public static function createFromArray($data) {
        $event = new Event();
        $event->fillWith($data);
    
        return $event;
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
        $this->datefrom = $dateFrom;
    }

    /**
     * Get datefrom
     *
     * @return date 
     */
    public function getDateFrom()
    {
        return substr($this->datefrom, 0, 10);
    }

    /**
     * Set dateto
     *
     * @param date $dateto
     */
    public function setDateto($dateTo)
    {
        $this->dateto = $dateTo;
    }

    /**
     * Get dateto
     *
     * @return date 
     */
    public function getDateTo()
    {
        return substr($this->dateto, 0, 10);
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
        $this->averagedayfee = $averagedayfee;
    }

    /**
     * Get averagedayfee
     *
     * @return integer 
     */
    public function getAveragedayfee()
    {
        return $this->averagedayfee;
    }

    /**
     * Set mainsitelink
     *
     * @param string $mainsitelink
     */
    public function setMainsitelink($mainsitelink)
    {
        $this->mainsitelink = $mainsitelink;
    }

    /**
     * Get mainsitelink
     *
     * @return string 
     */
    public function getMainsitelink()
    {
        return $this->mainsitelink;
    }

    
    /**
     * Get country slug
     *
     * @return string Returns country slug
     */
    public function getCountryslug()
    {
        return 'n.a.';
    }
        
    /*
     * Get country name
     * 
     * @return string 
     */
    public function getCountryName() 
    {
        return 'n.a.';
    }

	
    public function fillWith($data){
        
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->abstract = (isset($data['abstract'])) ? $data['abstract'] : null;
        $this->country_id = (isset($data['country'])) ? $data['country'] : null;
        $this->datefrom = (isset($data['datefrom'])) ? $data['datefrom'] : null;
        $this->dateto = (isset($data['dateto'])) ? $data['dateto'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->venue = (isset($data['venue'])) ? $data['venue'] : null;
        $this->averagedayfee = (is_numeric($data['averagedayfee'])) ? $data['averagedayfee'] : null;
        $this->mainsitelink = (isset($data['mainsitelink'])) ? $data['mainsitelink'] : null;
                
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
}
