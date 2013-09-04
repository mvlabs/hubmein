Feature: search conference
  In order to refine a list of conferences
  As a visitor
  I need to be able to load filters based on upcoming conferences

  Background: 
    Given I have a list of 3 conferences
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
      | October 2013  | october 2013  |
      | November 2013 | november 2013 |

  Scenario: tags in the form
    Then I select the "topics" I could be able to pick between:
      | text           | value          |
      |                | all            |
      | Zend Framework | Zend Framework |
      | php            | php            |
