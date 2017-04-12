Feature: Api
  In order to access and use the Api
  As a web user
  I need to be able to authenticate and send Jwt Tokens


  Scenario: accessing an open endpoint
    Given I send a GET request to "/entry"
    Then I should get Status Code 200
    And I should get the Json Content

    """
    {
    "app": "symfony"
    }
    """


  Scenario: accessing a protected endpoint without credentials
    Given I send a GET request to "/api/authenticated"
    Then I should get Status Code 401
    And I should get the Json Content

    """
    {
      "detail":"Not privileged to request the resource.",
      "status":401,
      "type":"about:blank",
      "title":"Unauthorized"
     }
    """

  @auth_error
  Scenario: Invalid credentials
    Given I authenticate with username:"Foo1" and pass:"bariooo1"
    And I should get the Json Content

    """
    {
      "detail":"Invalid credentials.",
      "status":401,
      "type":"about:blank",
      "title":"Unauthorized"
     }
    """

  @auth
  Scenario: Getting Token
    Given I authenticate with username:"Foo1" and pass:"bariooo"
    And I succesfully authenticate and have token
    And I send a GET request to "/api/authenticated"
    Then I should get Status Code 200
    And I should get the Json Content

    """
    {
      "I_am":"token_protected"
     }
    """


  @auth_preassuming_authentication
  Scenario: Getting Token
    Given I am authenticated for the API
    And I send a GET request to "/api/authenticated"
    Then I should get Status Code 200
    And I should get the Json Content

    """
    {
      "I_am":"token_protected"
     }
    """


