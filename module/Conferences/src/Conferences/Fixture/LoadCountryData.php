<?php
namespace Conferences\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;
  

use Conferences\Entity\Country;

/**
 * Region data fixture
 *
 * @author mauilap
 */
class LoadCountryData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        
        $countryDatas = $this->loadFixturesData();
        
        if(sizeof($countryDatas) == 0) {
         
            throw new \LengthException("empty fixture data");
            
        }
        
        foreach ($countryDatas as $countryData) {
            
             $country = new Country();
             $country->setCode($countryData['code']);
             $country->setRegion(
                     $this->getReference($countryData['region'])
                     ); 
             $country->setName($countryData['name']);
             $country->setSlug($countryData['slug']);
            
             $manager->persist($country);
             $this->addReference($country->getName(), $country);
        }

        $manager->flush();

    }
   
    private static function loadFixturesData()
    {
        return array(
                   array(
                     "id"=>1,
                     "region"=>"Northern America",
                     "code"=>"US",
                     "name"=>"USA",
                     "slug"=>"usa"
                   ),
                   array(
                     "id"=>2,  
                     "region"=>"Southern America",
                     "code"=>"AR",
                     "name"=>"Argentina",
                     "slug"=>"argentina"
                   ),
                   array(
                     "id"=>3,  
                     "region"=>"Europe",
                     "code"=>"FR",
                     "name"=>"France",
                     "slug"=>"france"
                   ),
                   array(
                     "id"=>4,  
                     "region"=>"Europe",
                     "code"=>"IT",
                     "name"=>"Italy",
                     "slug"=>"italy"
                   ),
                   array(
                     "id"=>5,  
                     "region"=>"Oceania",
                     "code"=>"AU",
                     "name"=>"Australia",
                     "slug"=>"australia"
                   ),
                   array(
                       "id"=>6,
                       "region"=>"Africa",
                       "code"=>"AL",
                       "name"=>"Algeria",
                       "slug"=>"algeria"
                   )
            );
                 
    }
}
