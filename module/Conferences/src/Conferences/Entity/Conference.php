<?php

namespace Conferences\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Conferences\Entity\Conference
 *
 * @ORM\Table(name="conference")
 * @ORM\Entity(repositoryClass="Conferences\Entity\Repository\ConferenceRepository")
 *
 */
class Conference {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="event_id_seq", allocationSize=1, initialValue=1)
	 */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string $abstract
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $abstract;

    /**
     * @var \DateTime $datefrom
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $datefrom;

    /**
     * @var \DateTime $dateto
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $dateto;
    
    /**
     * @var date $earlybirduntil
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $earlybirduntil;
    
    /**
     * @var string $address
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $address;
	
    /**
     * @var string $city
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var string $venue
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $venue;

    /**
     * @var string $averagedayfee
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $averagedayfee;

    /**
     * @var string $website
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $website;
    
    /**
     * @var date $cfpclosingdate
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $cfpclosingdate;
    
    /**
     * @var string $hashtag
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $hashtag;
    
    /**
     * @var string $joindinid
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $joindinid;
    
    /**
     * @var string $contactemail
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contactemail;
    
    /**
     * @var string $twitteraccount
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $twitteraccount;
    
    /**
     * @var date $publicationDate
     *
     * @ORM\Column(type="date", nullable=false)
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
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @var int $countryId
     */
    private $countryId;
    
    /**
     * @var Conferences\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Conferences\Entity\Country", inversedBy="conferences")
     */
    private $country;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Conferences\Entity\Tag", inversedBy="conferences")
     * @ORM\JoinTable(name="tag_conference")
     */
    private $tagsObjects;
    
    /**
     * @var array $tags
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
        
    /**
     * @return string 
     */
    public function getCountryName() 
    {
        if (!($this->country instanceof Country)) {
            return 'n.a.';
        }
        
        return $this->country->getName();
    }
    
    /**
     * @return string
     */
    public function getRegionSlug()
    {
        if (!($this->country instanceof Country)) {
            return '';
        }
    
        return $this->country->getRegionSlug();
        
    }
    
    /**
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
     * @param string $datefrom
     * @return Event
     */
    public function setDateFrom($datefrom) 
    {
        $this->datefrom = new \DateTime($datefrom);
        
        return $this;
    }
    
    /**
     * Set datefrom
     *
     * @param \DateTime $datefrom
     * @return Event
     */
    public function setDatefromObject(\DateTime $datefrom)
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
     * @param string $dateto
     * @return Event
     */
    public function setDateto($dateto) 
    {
        $this->dateto = new \DateTime($dateto);
        
        return $this;
    }
    
    /**
     * Set dateto
     *
     * @param \DateTime $dateto
     * @return Event
     */
    public function setDatetoObject(\DateTime $dateto)
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
     * @param string $earlyBirdUntil
     * @return Event
     */
    public function setEarlybirduntil($earlyBirdUntil) 
    {
        $this->earlybirduntil = new \DateTime($earlyBirdUntil);
        
        return $this;
    }
    
    /**
     * Set earlyBirdUntil
     *
     * @param \DateTime $earlyBirdUntil
     * @return Event
     */
    public function setEarlybirduntilObject(\DateTime $earlyBirdUntil)
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
     * @param string $cfpclosingdate
     * @return Event
     */
    public function setCfpclosingdate($cfpclosingdate) 
    {
        $this->cfpclosingdate = new \DateTime($cfpclosingdate);
        
        return $this;
    }
    
    /**
     * Set cfpclosingdate
     *
     * @param \DateTime $cfpclosingdate
     * @return Event
     */
    public function setCfpclosingdateObject(\DateTime $cfpclosingdate)
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
     * @param string $publicationdate
     * @return Event
     */
    public function setPublicationdate($publicationdate) 
    {
        $this->publicationdate = new \DateTime($publicationdate);
        
        return $this;
    }
    
    /**
     * Set publicationdate
     *
     * @param \DateTime $publicationdate
     * @return Event
     */
    public function setPublicationdateObject(\DateTime $publicationdate)
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
    
    public function setCountry($countryId) {
        $this->countryId = $countryId;
    }
    
    public function getCountry() {
        return $this->countryId;
    }

    /**
     * Set country
     *
     * @param \Conferences\Entity\Country $country
     * @return Event
     */
    public function setCountryObject(\Conferences\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Conferences\Entity\Country 
     */
    public function getCountryObject()
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
            $tag->addConference($this);
            $this->tagsObjects->add($tag);
        }
    }
    
    //@TOFIX added for testing purpose need explanation
    /**
     * Add tags
     *
     * @param Collection $tags
     */
    public function addTag(Tag $tag)
    {
        $this->tagsObjects[] = $tag;
        
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
            $this->tagsObjects->removeElement($tag);
        }
    }

    /**
     * Get tags
     *
     * @return array List of tag values
     */
    public function getTagsObjects()
    {
        
        return $this->tagsObjects;
        
    }
    
    public function setTags($tags) {
        $this->tags = $tags;
    }
    
    /**
     * Get tags
     *
     * @return array of tag keys / values
     */
    public function getTags()
    {
        $tags = array();
        if (null != $this->tagsObjects) {
            foreach($this->tagsObjects as $tag) {
                $tags[] = $tag->getId();
            }
        }
        
        return $tags;
        
    }
    
}