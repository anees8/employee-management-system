# Employee Management

The Employee Management system allows you to efficiently manage employee data. You can add, edit, delete, import, and export employee records using this application.

## Getting Started

### Prerequisites

Ensure you have the following installed:

- PHP
- Composer
- Laravel

### Installation

1. **Clone the Repository**

   Clone the repository using Git:
   ```bash
   git clone [REPOSITORY_URL]


2. **Install Dependencies**
    Navigate to the project directory and install the necessary PHP dependencies:
        cd [PROJECT_DIRECTORY] 
        composer install
    Generate the Laravel application key:
        php artisan key:generate

3. **Configure the Environment**
        cp .env.example .env
    Edit the .env file to set up your database configuration:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password

4. **Run Migrations**
    Set up the database schema by running:
        php artisan migrate

5. **Seed the Database**
    Populate the database with initial data:
        php artisan db:seed

**Accessing the Application**
   **Login Credentials**
    To access the application, use the following credentials:
        Email: admin@example.com
        Password: admin

**Features**
The application supports the following features:

Add Employee: Create new employee records.
Edit Employee: Modify existing employee details.
Delete Employee: Remove employee records.
Import Employees: Import employee data from files.
Export Employees: Export employee data to different formats.

# API Endpoints
1. Fetch a Single Employee Record
    Endpoint: /api/employees
    Method: GET
    Query Parameters:
    register_number (optional): Employee register number to fetch the specific record.
    contact_number (optional): Contact number to fetch the specific record.
    email (optional): Email address to fetch the specific record.
    Description: Fetch a single employee record based on the provided register number, contact number, or email address. At least one of these parameters must be provided.
    Response:
    Success (200 OK): Returns the employee record.
    Error (404 Not Found): If no employee is found with the provided parameters.
    
    GET /api/employees?register_number=EMP001

2. Fetch All Employee Records
    Endpoint: /api/employees/all
    Method: GET
    Description: Fetch a list of all employee records.
    Response:
    Success (200 OK): Returns a list of all employee records.

    GET /api/employees/all

**Troubleshooting**
If you encounter issues:

Verify that your environment variables are correctly set.
Ensure your database server is running and accessible.
Confirm you have the necessary permissions for database operations.
For further assistance, please consult the documentation or reach out for support.