@event
Feature:
  As an organizer
  In order to ..
  I need to first create an event

  Background:
    Given there is "My organization"
    And "Alex Smith" is organizer of "My organization"

  Scenario: Create an event
    Given I'am "Alex Smith"
    When I create "Some event" event for organization "My organization" with date "2018-04-24", description "Event description" in "Katran klub" venue
    Then there is new "Some event" for organization "My organization"



