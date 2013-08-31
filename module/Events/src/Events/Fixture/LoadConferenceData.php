<?php
namespace Events\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;
   
use Events\Entity\Event;
/**
 * Doctrine data fixture for the Event
 *
 * @author mauilap
 */
class LoadConferenceData extends AbstractFixture 
{
    
    const GROUP = "group";

    public function load(ObjectManager $manager)
    {
              
        foreach ($this->loadMockConferenceData() as $conferenceData) {
            
            $conference = new Event();
            
            $conference->setTitle($conferenceData['title']);
            $conference->setAbstract($conferenceData['abstract']);
            $conference->setDatefrom( \DateTime::createFromFormat("d/m/Y",$conferenceData['datefrom']) );
            $conference->setDateto( \DateTime::createFromFormat("d/m/Y",$conferenceData['dateto']) );
            $conference->setEarlyBirdUntil($conferenceData['earlybirduntil']);
            $conference->setAddress($conferenceData['address']);
            $conference->setCity($conferenceData['city']);
            $conference->setAveragedayfee($conferenceData['averagedayfee']);
            $conference->setWebsite($conferenceData['website']);
            $conference->setCfpclosingdate($conferenceData['cfpclosingdate']);
            $conference->setHashtag($conferenceData['hashtag']);
            $conference->setContactemail($conferenceData['contactemail']);
            $conference->setTwitteraccount($conferenceData['twitteraccount']);
            $conference->setIsinternational($conferenceData['isinternational']);
            $conference->setSlug($conferenceData['slug']);
            $conference->setDiscountForGroups($conferenceData['discountForGroups']);
            $conference->setDiscountForStudents($conferenceData['discountForStudents']);
            $conference->setIsVisible($conferenceData['isvisible']);
            $conference->setIsFeatured($conferenceData['isfeatured']);
            $conference->setCountry(
                    $manager->getRepository('Events\Entity\Country')->find($conferenceData['country'])
                    );
             
            foreach($conferenceData['tags'] as $tagValue) {
                                              
                $conference->addTag(
                        
                        );
                
            }
            
            $manager->persist($conference);
        }
        

        $manager->flush();

    }

    private function loadMockConferenceData(){
                       
        return array(
                  array(
                    "title"=>"ZendCon Europe 2013",
                    "abstract"=>"Firt Zend european conference",
                    "datefrom"=>"20/11/2013",
                    "dateto"=>"22/11/2013",
                    "earlybirduntil"=>"31/08/2013",
                    "address"=>"rue de Gauce 1809",
                    "city"=>"Paris",
                    "averagedayfee"=>"350",
                    "website"=>"www.zendcomeruope.com",
                    "cfpclosingdate"=>"12/05/2013",
                    "hashtag" => "",
                    "contactemail"=>"zendconeurope@test.com",
                    "twitteraccount"=>"https://twitter.com/zendconeurope",
                    "isinternational"=>true,
                    "slug"=>"zendCon2013",
                    "discountForStudents"=>false,
                    "discountForGroups"=>true,
                    "isvisible"=>true,
                    "isfeatured" =>true,
                    "country" => 3,
                    "tags" =>array(1,2)
                 ),
             array(
                "title"=>"ZendCon 2013",
                "abstract"=>"Worlwide zend conference",
                "datefrom"=>"04/10/2013",
                "dateto"=>"06/10/2013",
                "earlybirduntil"=>"05/10/2013",
                "address"=>"Mocking bird avenue",
                "city"=>"Los Angeles",
                "averagedayfee"=>"300",
                "website"=>"www.zendcon.com",
                "cfpclosingdate"=>"14/05/2013",
                "hashtag" => "",
                "contactemail"=>"zendcon@conf.com",
                "twitteraccount"=>"https://twitter.com/zendcon",
                "isinternational"=>true,
                "slug"=>"zendCon2013",
                "discountForStudents"=>false,
                "discountForGroups"=>true,
                "isvisible"=>true,
                "isfeatured" =>true,
                "country" => array(1),
                "tags" =>array(1,2)

                ),
                              
            );
     }
}
