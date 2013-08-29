<?php

namespace Events\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Events\Entity\Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Events\Entity\Repository\EventRepository")
 *
 */
class Event {

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
    private $datefrom;

    /**
     * @var \DateTime $dateto
     *
     * @ORM\Column(name="dateto", type="datetime", nullable=false)
     */
    private $dateto;
    
    /**
     * @var date $earlybirduntil
     *
     * @ORM\Column(name="earlybirduntil", type="datetime", nullable=true)
     */
    private $earlybirduntil;
    
    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;
	
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
     * @ORM\Column(name="averagedayfee", type="integer", nullable=true)
     */
    private $averagedayfee;

    /**
     * @var string $website
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=false)
     */
    private $website;
    
    /**
     * @var date $cfpclosingdate
     *
     * @ORM\Column(name="cfpClosingDate", type="datetime", nullable=true)
     */
    private $cfpclosingdate;
    
    /**
     * @var string $hashtag
     *
     * @ORM\Column(name="hashTag", type="string", length=30, nullable=true)
     */
    private $hashtag;
    
    /**
     * @var string $joindinid
     *
     * @ORM\Column(name="joindinId", type="string", length=100, nullable=true)
     */
    private $joindinid;
    
    /**
     * @var string $contactemail
     *
     * @ORM\Column(name="contactEmail", type="string", length=100, nullable=true)
     */
    private $contactemail;
    
    /**
     * @var string $twitteraccount
     *
     * @ORM\Column(name="twitteraccount", type="string", length=50, nullable=true)
     */
    private $twitteraccount;
    
    /**
     * @var date $publicationDate
     *
     * @ORM\Column(name="publicationDate", type="date", nullable=false)
     */
    private $publicationdate;
    
    /**
     * @var boolean $isInternational
     *
     * @ORM\Column(name="isInternational", type="boolean", nullable=false)
     */
    private $isinternational;
    
    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=100, nullable=true)
     */
    private $slug;
    
    /**
     * @var boolean $discountForStudents
     *
     * @ORM\Column(name="discountForStudents", type="boolean", nullable=false)
     */
    private $discountForStudents;
    
    /**
     * @var boolean $discountForGroups
     *
     * @ORM\Column(name="discountForGroups", type="boolean", nullable=false)
     */
    private $discountForGroups;
    
    /**
     * @var boolean $isVisible
     *
     * @ORM\Column(name="isVisible", type="boolean", nullable=false)
     */
    private $isVisible;
    
    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(name="isFeatured", type="boolean", nullable=true)
     */
    private $isFeatured = false;
    

    /**
     * @var Events\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Events\Entity\Country", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Events\Entity\Tag", mappedBy="events")
     */
    private $tags;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * Get country slug
     *
     * @return string Returns country slug
     */
    public function getCountryslug()
    {
        if (!($this->country instanceof Country)) {
            return '';
        } 

        return $this->country->getSlug();
                    
    }
        
    /*
     * Get country name
     * 
     * @return string 
     */
    public function getCountryName() 
    {
        if (!($this->country instanceof Country)) {
            return 'n.a.';
        }
        
        return $this->country->getName();
    }
    
    /*
     * Get region name
     *
     * @return string
     */
    public function getRegionName()
    {
        if (!($this->country instanceof Country)) {
            return '';
        }
    
        return $this->country->getRegionName();
    }


    /*
     * Start of doctrine generated getters / setters
    */

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
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
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
     * @param string $abstract
     * @return Event
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    
        return $this;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set datefrom
     *
     * @param \DateTime $datefrom
     * @return Event
     */
    public function setDatefrom($datefrom)
    {
        $this->datefrom = $datefrom;
    
        return $this;
    }

    /**
     * Get datefrom
     *
     * @return \DateTime 
     */
    public function getDatefrom()
    {
        return $this->datefrom;
    }

    /**
     * Set dateto
     *
     * @param \DateTime $dateto
     * @return Event
     */
    public function setDateto($dateto)
    {
        $this->dateto = $dateto;
    
        return $this;
    }

    /**
     * Get dateto
     *
     * @return \DateTime 
     */
    public function getDateto()
    {
        return $this->dateto;
    }

    /**
     * Set earlyBirdUntil
     *
     * @param \DateTime $earlyBirdUntil
     * @return Event
     */
    public function setEarlybirduntil($earlyBirdUntil)
    {
        $this->earlybirduntil = $earlyBirdUntil;
    
        return $this;
    }

    /**
     * Get earlyBirdUntil
     *
     * @return \DateTime 
     */
    public function getEarlybirduntil()
    {
        return $this->earlybirduntil;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
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
     * Set city
     *
     * @param string $city
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
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
     * Set venue
     *
     * @param string $venue
     * @return Event
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    
        return $this;
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
     * @return Event
     */
    public function setAveragedayfee($averagedayfee)
    {
        $this->averagedayfee = $averagedayfee;
    
        return $this;
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
     * Set cfpclosingdate
     *
     * @param \DateTime $cfpclosingdate
     * @return Event
     */
    public function setCfpclosingdate($cfpclosingdate)
    {
        $this->cfpclosingdate = $cfpclosingdate;
    
        return $this;
    }

    /**
     * Get cfpclosingdate
     *
     * @return \DateTime 
     */
    public function getCfpclosingdate()
    {
        return $this->cfpclosingdate;
    }

    /**
     * Set hashtag
     *
     * @param string $hashtag
     * @return Event
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;
    
        return $this;
    }

    /**
     * Get hashtag
     *
     * @return string 
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set joindinid
     *
     * @param string $joindinid
     * @return Event
     */
    public function setJoindinid($joindinid)
    {
        $this->joindinid = $joindinid;
    
        return $this;
    }

    /**
     * Get joindinid
     *
     * @return string 
     */
    public function getJoindinid()
    {
        return $this->joindinid;
    }

    /**
     * Set contactemail
     *
     * @param string $contactemail
     * @return Event
     */
    public function setContactemail($contactemail)
    {
        $this->contactemail = $contactemail;
    
        return $this;
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
     * Set publicationdate
     *
     * @param \DateTime $publicationdate
     * @return Event
     */
    public function setPublicationdate($publicationdate)
    {
        $this->publicationdate = $publicationdate;
    
        return $this;
    }

    /**
     * Get publicationdate
     *
     * @return \DateTime 
     */
    public function getPublicationdate()
    {
        return $this->publicationdate;
    }

    /**
     * Set isinternational
     *
     * @param boolean $isinternational
     * @return Event
     */
    public function setIsinternational($isinternational)
    {
        $this->isinternational = $isinternational;
    
        return $this;
    }

    /**
     * Get isinternational
     *
     * @return boolean 
     */
    public function getIsinternational()
    {
        return $this->isinternational;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Event
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
     * Set discountForStudents
     *
     * @param boolean $discountForStudents
     * @return Event
     */
    public function setDiscountForStudents($discountForStudents)
    {
        $this->discountForStudents = $discountForStudents;
    
        return $this;
    }

    /**
     * Get discountForStudents
     *
     * @return boolean 
     */
    public function getDiscountForStudents()
    {
        return $this->discountForStudents;
    }

    /**
     * Set discountForGroups
     *
     * @param boolean $discountForGroups
     * @return Event
     */
    public function setDiscountForGroups($discountForGroups)
    {
        $this->discountForGroups = $discountForGroups;
    
        return $this;
    }

    /**
     * Get discountForGroups
     *
     * @return boolean 
     */
    public function getDiscountForGroups()
    {
        return $this->discountForGroups;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     * @return Event
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    
        return $this;
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

    /**
     * Set isFeatured
     *
     * @param boolean $isFeatured
     * @return Event
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;
    
        return $this;
    }

    /**
     * Get isFeatured
     *
     * @return boolean 
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }

    /**
     * Set country
     *
     * @param \Events\Entity\Country $country
     * @return Event
     */
    public function setCountry(\Events\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Events\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Event
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }
        
    /**
     * Set twitteraccount
     *
     * @param string $twitteraccount
     * @return Event
     */
    public function setTwitteraccount($twitteraccount)
    {
        $this->twitteraccount = $twitteraccount;
    
        return $this;
    }

    /**
     * Get twitteraccount
     *
     * @return string 
     */
    public function getTwitteraccount()
    {
        return $this->twitteraccount;
    }

    /**
     * Add tags
     *
     * @param Collection $tags
     */
    public function addTags(Collection $tags)
    {
        foreach ($tags as $tag) {
            $tag->addEvent($this);
            $this->tags->add($tag);
        }
    }

    /**
     * Remove tags
     *
     * @param Collection $tags
     */
    public function removeTags(Collection $tags)
    {
        foreach ($tags as $tag) {
            $tag->removeEvent($this);
            $this->tags->removeElement($tag);
        }
    }

    /**
     * Get tags
     *
     * @return array List of tag values
     */
    public function getTags()
    {
        
        return $this->tags;
        
    }
}