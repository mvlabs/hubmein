<?php
namespace Events\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;
  

use Events\Entity\Region;

/**
 * Region data fixture
 *
 * @author mauilap
 */
class LoadRegionData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        
        $regionDatas = $this->loadFixturesData();
        
        if(sizeof($regionDatas) == 0) {
         
            throw new \LengthException("empty fixture data");
            
        }
        
        foreach ($regionDatas as $regionData) {
            
             $region = new Region();
             $region->setId($regionData['id']);
             $region->setName($regionData['name']);
             $region->setSlug($regionData['slug']);
            
             $manager->persist($region);
             $this->addReference($region->getName(), $region);
        }

        $manager->flush();

    }
   
    private static function loadFixturesData()
    {
        return array(
                   array(
                     "id"=>1,
                     "name"=>"Northern America",
                     "slug"=>"north-america"
                   ),
                   array(
                     "id"=>2,  
                     "name"=>"Southern America",
                     "slug"=>"south-america"
                   ),
                   array(
                     "id"=>3,  
                     "name"=>"Europe",
                     "slug"=>"europe"
                   ),
                   array(
                     "id"=>4,  
                     "name"=>"Oceania",
                     "slug"=>"oceania"
                   ),
                   array(
                       "id"=>5,
                       "name"=>"Africa",
                       "slug"=>"africa"
                   )
            );
                 
    }
}