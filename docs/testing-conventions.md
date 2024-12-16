# Testing conventions
[[Back to index]](./coding-guidelines.md)

- [General guideline](#general-guidelines)
- [Avoid Testing Laravel's Native Features](#avoid-testing-laravels-native-features)
- [Creating tests](#creating-tests)
- [Code coverage](#code-coverage)

## General guidelines

Tests are written in PHPUnit. The PHPUnit configuration is in `phpunit.xml`.

Tests are located in `tests/Unit` and `tests/Feature`.

Methods name should follow the conventions:
- `testCanDoSomething()`
- `testCanDoSomethingWhenSomethingElse()`
- `testCannotDoSomething()`
- `testCannotDoSomethingWhenSomethingElse()`

Tests should implement the DatabaseTransactions trait.

Don't assert json messages as they could change in the future.

## Avoid testing Laravel's native features

In this project, we adhere to the principle of not testing functionalities that are native to Laravel, such as the framework's ability to return a 422 Unprocessable Entity response for validation errors. This is because Laravel's core functionalities are already thoroughly tested by the framework's maintainers.

Instead, we focus our testing efforts where they provide the most value:

- Validation Rules: For custom validation logic, use unit tests to ensure your rules work as expected. This allows you to isolate and verify your logic without relying on the framework's feature tests.
- Feature Tests: Reserve feature tests for scenarios where application-specific behavior needs to be validated. Avoid duplicating tests for Laravel's core functionalities.
By doing this, we maintain a lean and efficient test suite while trusting the reliability of the Laravel framework.

## Creating tests

To create a new test case, use the `make:test` Artisan command. By default, tests will be placed in the `tests/Feature` directory:

```
php artisan make:test UserTest
```
If you would like to create a test within the tests/Unit directory, you may use the --unit option when executing the make:test command:

```
php artisan make:test UserTest --unit
```
More on testing at: https://laravel.com/docs/10.x/testing

## Code coverage

Our PhpUnit configuration is set to generate html code coverage reports by default.
Each time a test is run, code coverage is saved to `./tests/coverage`.

If you wish to ignore code coverage configuration, you can use the `--no-coverage` option when running the test command.

The code coverage report can be found in `./tests/coverage/index.html`. As it's not located under public directory, you will need to open it with the integrated browser of your IDE (if you have one) or locally, using the absolute path:

`file:///absolute/path/to/tests/coverage/index.html`

For mor convienience, you can use the following commands in your terminal from the root directory of the project:

_For macOS or Linux:_
```
open ./tests/coverage/index.html
```

_For Windows:_
```
start ./tests/coverage/index.html
```
