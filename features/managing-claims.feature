@talk
Feature:
  As a organizer
  In order to connect speakers to a talk
  I need to approve or reject claims

  Background:
    Given there is a "Local meetup" organization
    And "Alex Smith" is organizer
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And there is a talk "Something about nothing"
    And there is a claim by "Jo Johnson" on "Something about nothing" talk

  Scenario: List of pending claims
    Given I'am logged in as "Alex Smith"
    When I look at "Something about nothing" talk
    Then I should see "Jo Johnson" having a pending claim

  Scenario: By accepting claim, speaker is connected to a talk
    Given I'am logged in as "Alex Smith"
    When I approve a pending claim on "Something about nothing"
    Then "Jo Johnson" is speaker on "Something about nothing"

  Scenario: By accepting claims, there will be no pending claims on the talk
    Given I'am logged in as "Alex Smith"
    When I approve a pending claim on "Something about nothing"
    Then there should be no pending claims on "Something about nothing" talk

  Scenario: Claims can be rejected
    Given I'am logged in as "Alex Smith"
    When I reject a pending claim on "Something about nothing"
    Then the claim should be marked as rejected

