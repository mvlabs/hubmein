Feature: search conference
  In order to refine a list of conferences
  As a visitor
  I need to be able to load filters based on upcoming conferences

  Background: 
    Given I have an american and an european conference
    When I am on the home page

  Scenario: region in the form
    Then I select the "regions" I could be able to pick between:
      | text             | value         |
      | All regions      | *             |
      | Northern America | north-america |
      | Europe           | europe        |

  Scenario: period in the form
    Then I select the "periods" I could be able to pick between:
      | text          | value         |
      | All periods   | *             |
      | October 2013  | October 2013  |
      | November 2013 | November 2013 |

  Scenario: tags in the form
    Then I select the "topics" I could be able to pick between:
      | text           | value          |
      |                | all            |
      | Zend Framework | Zend Framework |
      | php            | php            |
