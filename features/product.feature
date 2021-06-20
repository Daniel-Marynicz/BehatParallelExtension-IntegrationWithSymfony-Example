

Feature:
  This is an example test
  Scenario: New fresh app does not have any products
    Given there are following products:
      | name | price |
    And I am on "/product/"
    Then the data of the "table" table should match:
      | Id               | Name       | Price | actions   |
      | no records found |            |       |           |
  Scenario: App has products
    Given there are following products:
     | id  | name       | price |
     | 123 | Calculator | 14.22 |
     | 456 | Notebook   | 99.99 |
    And I am on "/product/"
    Then the data of the "table" table should match:
      | Id  | Name       | Price | actions   |
      | 123 | Calculator | 14.22 | show edit |
      | 456 | Notebook   | 99.99 | show edit |
