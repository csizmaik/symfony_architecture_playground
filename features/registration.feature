Feature: User registration
  In order remeber my data and to protect it with username and password
  As a user
  I want to register a new account

  Rules:
  - Name is required for the registration
  - Loginname must be a valid email address
  - Password can't be empty
  - If a loginname is reserved it can't be registered again

  Scenario: Success registration
    Given no user with loginname "csizmarik.norbert@gmail.com" exists
    When the user tries to register with name "Csizmarik" "Norbert", email "csizmarik.norbert@gmail.com" and password "secret"
    Then the user with login name "csizmarik.norbert@gmail.com" created