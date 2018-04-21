@event
Feature:
  As a organizer
  In order to track event attendance
  I need to mark member as attended during meetup

  Background:
    Given there is a "Local meetup" organization
    And "Alex Smith" is organizer
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And "Jordan Johnson" RSVPed yes to event

  Scenario: Organizers have expected attendance list
    Given I'am logged in as "Alex Smith"
    When I look at expected attendees
    Then I should see "Jordan Johnson" in the list

  Scenario: Mark member as attended
    Given I'am logged in as "Alex Smith"
    When I mark "Jordan Johnson" as attended
    Then "Jordan Johnson" is marked as attended

  Scenario: Marked member will not show in expected attendance list
    Given I'am logged in as "Alex Smith"
    When I mark "Jordan Johnson" as attended
    Then "Jordan Johnson" is marked as attended
