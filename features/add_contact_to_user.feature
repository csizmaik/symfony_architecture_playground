Feature: Conact registration for user
  In order send email for the users
  As a user
  I want to register email contacts for the user

  Scenario: Success registration
    Given an existing user with "norbi" loginname
    When the user registers a "csizmarik.norbert@biztositas.hu" email address for "norbi"
    Then the user "norbi" has a contact "csizmarik.norbert@biztositas.hu"