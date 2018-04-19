Feature:
  As an admin
  In order to manage content of the site
  I need to approve/reject new organizations

  Scenario: Approve new organization
    Given someone just created "Local meetup" organization
    When I approve "Local meetup" organization
    Then "Local meetup" organization is approved

  Scenario: Reject new organization
    Given there is new "Local meetup" organization
    When I approve "Local meetup" organization
    Then "Local meetup" organization is rejected


