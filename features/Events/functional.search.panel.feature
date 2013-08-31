Feature: search conference
  In order to refine a list of conferences
  As a developer
  I need to be able to load filters based on upcoming conferences
  And get a count of conferences related to to filters

  Background: 
    Given I have an american and an european conference

  Scenario: Region based on upcoming conferences
    When I get a region list
    Then I should have a list with:
      | id | name             | slug          |
      | 1  | Northern America | north-america |
      | 3  | Europe           | europe        |

  Scenario: Period based on upcoming conferences
    When I get a period list
    Then I should have a list with:
      | 0              | 1             | 2             |                  
      | September 2013 |October 2013   | November 2013 | 

  Scenario: count conference with 0 params
    And I send a request:
      | topcis | regions | periods |
      |        |         |         |
    When the request is passed to countListByFilter method
    Then I should get "3" as result

  Scenario: count conference with param region
    And I send a request:
      | topic    | region | period        |
      | zend,php | europe | November-2013 |
    When the request is passed to countListByFilter method
    Then I should get "1" as result
  
  Scenario: count conference with param region
    And I send a request:
      | topic       | region | period       |
      | bullshitter | europe | September-2013 |
    When the request is passed to countListByFilter method
    Then I should get "1" as result
