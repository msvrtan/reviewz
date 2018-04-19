Feature:
  As a user
  In order to start new community events
  I need to first create an organization

  Scenario: Create an organization
    Given I'am logged in as "Alex Smith"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York", "USA"
    Then there is new "Local meetup" organization
