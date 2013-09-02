Feature: search conference
  In order to refine a list of conferences
  As a developer
  I need to be able to load filters based on upcoming conferences
  And get a count of conferences related to to filters

  Background: 
    Given I have a list of 2 conferences

  Scenario: Region based on upcoming conferences
    When I get a region list
    Then I should have a list with:
      | id | name             | slug          |
      | 1  | Northern America | north-america |
      | 3  | Europe           | europe        |

  Scenario: Period based on upcoming conferences
    When I get a period list
    Then I should have a list with:
      | 0              | 1             |
      | September 2013 |October 2013   |

  
  Scenario: count existent conference which valid param
    And I send a request:
      | tags    | region | period        |
      | Zend Framework,php | north-america | October-2013 |
    When the request is passed to countListByFilter method
    Then I should get "1" as result
  
  Scenario: count existent conference which invalid param
    And I send a request:
      | tags       | region | period       |
      | bullshitter | north-america | September-2013 |
    When the request is passed to countListByFilter method
    Then I should get "0" as result
