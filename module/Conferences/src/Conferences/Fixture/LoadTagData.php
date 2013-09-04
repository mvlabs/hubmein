<?php
namespace Conferences\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;
  

use Conferences\Entity\Tag;

/**
 * Region data fixture
 *
 * @author mauilap
 */
class LoadTagData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        
        $tagDatas = $this->loadFixturesData();
        
        if(sizeof($tagDatas) == 0) {
         
            throw new \LengthException("empty fixture data");
            
        }
        
        foreach ($tagDatas as $tagData) {
            
             $tag = new Tag();
             $tag->setName($tagData['name']);
                         
             $manager->persist($tag);
             $this->setReference($tag->getName(), $tag);
        }

        $manager->flush();

    }
   
    private static function loadFixturesData()
    {
        return array(
                   array(
                     "id"=>1,
                     "name"=>"Zend Framework",
                   ),
                   array(
                     "id"=>2,  
                     "name"=>"php"
                   ),
                   array(
                     "id"=>3,  
                     "name"=>"agile"
                   ),
                   array(
                     "id"=>4,  
                     "name"=>"bullshitter"
                   )
                   
            );
                 
    }
}
