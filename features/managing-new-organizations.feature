@organization
Feature:
  As an admin
  In order to manage content of the site
  I need to approve/reject new organizations

  Scenario: Approve new organization
    Given new "New York Developer Ninjas" organization was created
    When I approve "New York Developer Ninjas" organization
    Then "New York Developer Ninjas" organization is approved

  Scenario: Reject new organization
    Given new "New York Developer Ninjas" organization was created
    When I reject "New York Developer Ninjas" organization
    Then "New York Developer Ninjas" organization is rejected

  Scenario: Rejecting organization will remove all members from it
    Given there is new "Local meetup" organization with 2 members
    When I approve "Local meetup" organization
    Then "Local meetup" organization has no members


