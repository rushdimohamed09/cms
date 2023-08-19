# CMS Page API Test Cases

This repository contains PHPUnit test cases for testing the Page API of your Laravel application. These test cases cover various aspects of the API, including creating, retrieving, updating, and deleting pages.

## Prerequisites

Before running the tests, ensure you have the following prerequisites set up:

- [Composer](https://getcomposer.org/): Dependency manager for PHP.

## Installation

1. **Clone this repository** to your local machine:

   ```bash
   git clone git clone https://github.com/rushdimohamed09/cms.git

2. Running Tests
    To run the test cases, execute the following command from the project directory:
    ```bash
    php artisan test

This will execute all the test cases in the tests/Feature/PageApiTest.php file.

## Test Cases
- testGetPagesCount
   * Description: Checks whether the API returns the correct count of pages.
   * Execution: Sends a GET request to retrieve the pages and asserts that the response contains a JSON count of 0.
- testGetPageById
    * Description: Checks whether the API can retrieve a page by its ID.
    * Execution: Creates a page, sends a GET request to retrieve it by ID, and asserts that the response contains the expected page data.
- testCreatePageAndCheckInsertion
    * Description: Checks the creation of a new page via the API.
    * Execution: Sends a POST request to create a new page, asserts a 201 (Created) status code, and verifies that the created data matches the provided data.
- testUpdatePage
    * Description: Checks the update of a page via the API.
    * Execution: Creates a page, sends a PUT request to update it, and asserts a 200 status code. It also verifies that the updated data matches the provided data.
- testDeletePage
    * Description: Checks the deletion of a page via the API.
    * Execution: Creates a page, sends a DELETE request to delete it, and asserts a 200 status code. It then verifies that the page no longer exists in the database.


## Acknowledgments
Laravel community for the amazing framework. Postman for API testing and documentation.

## Contact

For any questions or inquiries, please contact Your Name.

Rushdi Mohamed