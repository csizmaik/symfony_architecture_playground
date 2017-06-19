Feature: Exception transformation to array
  In order to use an exception in a REST endpoint
  As a developer
  I want to transform the exception data to an array

  Scenario: Basic Exception transformation
    Given an "Exception" instance exception
    When we transform it an array
    Then we get an array with basic exception informations