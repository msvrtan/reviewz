Feature:
  In order to have speakers connected to their talks
  As an organizer
  I want to manage claims

  Scenario: Approving a claim sets speaker on the talk
    Given speaker has claimed a talk
    When organizer approves claim
    Then talk has a speaker set


