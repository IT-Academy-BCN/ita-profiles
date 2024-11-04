# Testing conventions
[[Back to index]](./coding-guidelines.md)

- [General guideline](#general-guidelines)
- [Creating tests](#creating-tests)
- [Code coverage](#code-coverage)

## General guidelines

Tests are written in PHPUnit. The PHPUnit configuration is in `phpunit.xml`.

Tests are written in `tests/Unit` and `tests/Feature`.

Methods name should follow the conventions:
- `testCanDoSomething()`
- `testCanDoSomethingWhenSomethingElse()`
- `testCannotDoSomething()`
- `testCannotDoSomethingWhenSomethingElse()`

Tests should implement the DatabaseTransactions trait.

Don't assert json messages as they could change in the future.

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

The code coverage report can be found in `./tests/coverage/index.html`.

To open the report in your browser, run in the terminal:

_For macOs or Linux:_
```shell
open ../tests/coverage/index.html
```

_For Windows:_
```shell
start ../tests/coverage/index.html
```
