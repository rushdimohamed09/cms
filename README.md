# Laravel CRUD API for CMS (Content Management System)

A simple Laravel-based CRUD (Create, Read, Update, Delete) API for managing pages with a nested page structure.

## Getting Started

### Prerequisites

- PHP (7.4+)
- Composer
- Laravel CLI
- MySQL

### Installing

1. Clone the repository:

   ```bash
   git clone https://github.com/rushdimohamed09/cms.git

2. cd cms

3. log to you database and create a database
    ```bash
   create database cms;

4. cp .env.example .env
    - Change database configurations on .env 
    ```bash
    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password

5. Composer Install 
    ```bash
    composer install

6. Generate key
    - php artisan key:generate

7. Run migrations
    - php artisan migrate

8. Start the Backend
    - php artisan serve

9. The API will be available at http://127.0.0.1:8000.

## API Endpoints
1. **GET**    /token - Generate token to execute the apis.
2. **GET**    /pages - List all pages.
3. **GET**    /pages/{id} - Get a page by ID.
4. **POST**   /pages - Create a new page.
5. **PUT**    /pages/{id} - Update a page by ID.
6. **DELETE** /pages/{id} - Delete a page by ID.

### API Documentation
For detailed API documentation and examples, import the provided Postman collection and environment variables from the postman directory into [postman](https://github.com/rushdimohamed09/cms/blob/main/postman) for testing and exploration.

### TDD
To check the TDD documentation and what it covers please read the [README_TDD.md](https://github.com/rushdimohamed09/cms/blob/main/README_TDD.md) file.


## Acknowledgments
Laravel community for the amazing framework. Postman for API testing and documentation.

## Contact

For any questions or inquiries, please contact Your Name.

Rushdi Mohamed