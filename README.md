
# Slim Framework PHP Application

This project is a PHP web application built using the Slim framework. It includes features for user authentication, picture uploading, and API routing, along with error handling and routing.

## Features

- User authentication (registration, login, activation)
- Picture upload functionality
- API routing for user management and static content
- Custom error handling
- Environment configuration with Dotenv
- Dependency Injection with PHP-DI
- Middleware integration

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer for dependency management

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/claserre9/slim-auth-jwt.git
   ```
2. Install dependencies via Composer:
   ```bash
   composer install
   ```
3. Set up your environment variables in a `.env` file based on the example provided.

### Usage

To start the application:

```bash
php -S localhost:8000 -t public
```

Navigate to `http://localhost:8000` in your web browser to use the application.

## Code Structure

- `src/controllers`: Contains controllers such as `UploadController` and `UserController`.
- `src/handlers`: Error handling logic.
- `src/middlewares`: Middleware for authentication and others.
- `config`: Configuration files including container setup.

## Routes

### Authentication Routes

- POST `/auth/register` - User registration
- POST `/auth/login` - User login
- GET `/auth/activate` - User account activation
- GET `/auth/activation/send` - Send activation token
- POST `/auth/password/reset` - Password reset
- POST `/auth/password/confirm` - Password reset confirmation
- GET `/auth/refresh/token` - Token refresh
- GET `/auth/me` - Get logged-in user information

### Upload Route

- POST `/upload/picture` - Endpoint for picture uploads

### Static Content Route

- GET `/static/{path:.+}` - Endpoint for serving static content

### Example Route

```php
$app->post('/upload/picture', [UploadController::class, 'upload'])->add(new AuthMiddleware());
```

## Error Handling

Custom error handling is set up to manage application exceptions and provide useful feedback.

```php
$errorHandler = new HttpErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
$app->addErrorMiddleware(true, true, true)
    ->setDefaultErrorHandler($errorHandler);
```


## Contributing

We welcome contributions to this project! If you would like to contribute, please follow these steps:

1. **Fork the Repository:** Create a copy of this project on your GitHub account by forking it.

2. **Clone the Forked Repository:** Clone the forked repository to your local machine.

    ```bash
    git clone [your-forked-repository-url]
    ```

3. **Create a New Branch:** Create a new branch for your modifications.

    ```bash
    git checkout -b [your-branch-name]
    ```

4. **Make Your Changes:** Implement your changes or improvements in your branch.

5. **Commit and Push Your Changes:** After making changes, commit them to your branch and push them to your fork.

    ```bash
    git commit -am "Add some feature"
    git push origin [your-branch-name]
    ```

6. **Create a Pull Request:** Go to the original repository and create a pull request from your branch. Please provide a clear description of your changes and the purpose of them.

We look forward to your contributions!

## License

This project is licensed under the MIT License.

