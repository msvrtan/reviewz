@organization
Feature:
  As a user
  In order to start new community events
  I need to first create an organization

  Background:
    Given "Alex Smith" has a free acoount
    And "John Johnson" has a paid account
    And "Mary Popins" has a paid account with all 5 slots taken

  Scenario: Users with free accounts cant open organization
    Given I'am logged in as "Alex Smith"
    When I try to create an organization
    Then I will be asked for my credit card details

  Scenario: Users with paid accounts that have used up slots cant open organization
    Given I'am logged in as "Mary Popins"
    When I try to create an organization
    Then I will be asked to upgrade my account to bigger plan

  Scenario: Create an organization
    Given I'am logged in as "John Johnson"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York", "USA"
    Then there is new "Local meetup" organization

  Scenario: User that created new organization will be founder of the organization
    Given I'am logged in as "John Johnson"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York", "USA"
    Then "John Johnson" is founder of "Local meetup" organization

  Scenario: User that created new organization is automatically an organizer
    Given I'am logged in as "John Johnson"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York", "USA"
    Then "John Johnson" is organizer of "Local meetup" organization

