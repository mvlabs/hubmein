<?php
namespace Events\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;
  

use Application\Entity\Role;

/**
 * Region data fixture
 *
 * @author mauilap
 */
class LoadRoleData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        
        $countryDatas = $this->loadFixturesData();
        
        if(sizeof($countryDatas) == 0) {
         
            throw new \LengthException("empty fixture data");
            
        }
        
        foreach ($countryDatas as $countryData) {
            
             $role = new Role();
             $role->setId($countryData['id']);
             $role->setName($countryData['name']);
             $manager->persist($role);
            
        }

        $manager->flush();

    }
   
    private static function loadFixturesData()
    {
        return array(
                   array(
                       "id"=>"admin",
                       "name"=>"Admin",
                   ),
                   array(
                     "id"=>"guest",
                     "name"=>"Guest",
                   ),
                  );
                 
    }
}
