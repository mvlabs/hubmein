<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    
    'navigation' => array(
         'default' => array(
             array(
                 'label' => 'UPCOMING EVENTS',
                 'controller' => 'conferences',
                 'params'=>array("hasDate"=>true)
             ),
             array(
                'label' => 'OPEN CFPS',
                 'route' => 'cfps',
                 'params'=>array("hasDate"=>true)
             ),
             array(
                 'label' => 'SUGGEST AN EVENT',
                 'route' => 'conferences/promote',
                 'params'=>array("hasDate"=>false )
             )
         )
     )
    
);

