<?php

use Behat\Behat\Context\BehatContext;

use Doctrine\ORM\Tools\SchemaTool;

use Doctrine\Common\DataFixtures\Loader,
    Doctrine\Common\DataFixtures\Executor\ORMExecutor,
    Doctrine\Common\DataFixtures\Purger\ORMPurger;
        
use Events\Fixture\LoadRegionData,
    Events\Fixture\LoadCountryData,
    Events\Fixture\LoadTagData;

use Behat\Zf2Extension\Context\Zf2AwareContextInterface;

/* 
 * Create the basic fixture to init test
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class DoctrineFixtureContext extends BehatContext implements Zf2AwareContextInterface{
   
    static $zf2Application;
    
    
    public static function getEntityManager(){
            
       return  self::$zf2Application->getServiceManager()->get('doctrine.entitymanager.orm_default');
               
    }
    
    
    public static function purgeDb(){
               
        $schemaTool = new SchemaTool(self::getEntityManager());
        $schemaTool->dropDatabase();
                       
    }
    
    
    private static function createDb(){
        
        $metaData = self::getEntityManager()->getMetaDataFactory();
        $am_classes = $metaData->getAllMetaData();
            
        $schemaTool = new SchemaTool(self::getEntityManager());;
        $schemaTool->createSchema($am_classes);
        
        self::getEntityManager()->clear();
        
    }
       
    /**
     * @BeforeSuite
     */
    public static function initDB() {
        
        self::purgeDb();
        self::createDb();
         
        $loader = new Loader();
        $loader->addFixture(new LoadRegionData());
        $loader->addFixture(new LoadCountryData());
        $loader->addFixture(new LoadTagData());
        
        $purger = new ORMPurger();
        $executor = new ORMExecutor(self::getEntityManager(),$purger);
        
        $executor->execute($loader->getFixtures());
    }
    
       
    /**
     * @BeforeScenario
     */
    public function clearDb() {
        
        $em = self::getEntityManager();
        $platform = $em->getConnection()->getDatabasePlatform();
        $connection = $em->getConnection();
        $connection->beginTransaction();
               
        try {
           
            $connection->executeUpdate($platform->getTruncateTableSQL("event",true));
            $connection->commit();
            $em->clear();
            
        } catch (\Exception $exception) {
            
            $connection->rollback();
            echo $exception;
            die();
        }
        
    }

    
    public function setZf2App(\Zend\Mvc\Application $zf2Application) {
        
        self::$zf2Application = $zf2Application;
        
    }
    
}

?>

