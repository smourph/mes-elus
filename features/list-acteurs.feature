@product @list-acteurs
Feature:
    In order to know acteurs
    As a client
    I want to see the acteurs list

    Background:
        Given the fixtures file "list-acteurs.yaml" is loaded

    Scenario: List all acteurs
        When I send a "GET" request to "/acteurs/"
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON nodes should be equal to:
            | root[0].uid | PA1  |
            | root[1].uid | PA2  |
            | root[2].uid | PA3  |
            | root[3].uid | PA4  |
            | root[4].uid | PA5  |
            | root[5].uid | PA6  |
            | root[6].uid | PA7  |
            | root[7].uid | PA8  |
            | root[8].uid | PA9  |
            | root[9].uid | PA10 |
        And the JSON should be valid according to the schema "tests/Fixtures/list-acteurs-schema.json"
