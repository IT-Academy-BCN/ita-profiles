# Error handling
[[Back to index]](./coding-guidelines.md)

- [Error handling best practices](#error-handling-best-practices)

## Error handling best practices

### Leverage Laravel's default error handling

Laravel comes with a robust and comprehensive error handling system that captures exceptions, logs them, and provides detailed responses in development while showing generic error messages in production. To maintain simplicity and leverage this built-in functionality:

- Do not use try-catch blocks by default. Let Laravel handle exceptions whenever possible.
- Focus on writing clean, predictable code that avoids unnecessary exception handling at the application level.

This approach ensures consistency across the codebase, reduces boilerplate, and avoids re-implementing error handling logic that Laravel already provides.

### Use try-catch only when justified

There are cases where explicit exception handling is necessary, such as:

- Third-party API Calls: Wrapping calls in try-catch to handle network timeouts or specific API errors gracefully.
- Critical Logic: Protecting sensitive operations to ensure proper rollback or recovery mechanisms.
- Custom Exceptions: When you need to handle custom exceptions differently from Laravel’s default behavior.

### Global exception handling

For custom application-level error handling, use Laravel's Handler class located in `app/Exceptions/Handler.php`. This centralizes error management and keeps individual classes clean from unnecessary error-handling logic.

### Summary

- Avoid try-catch blocks by default.
- Use try-catch only for justified cases such as API calls, critical logic, or specific exceptions.
- Rely on Laravel's default error handling for most scenarios.
- Customize global error handling in `Handler.php` when necessary.

By following these guidelines, you maintain a clean, predictable, and consistent error-handling strategy throughout the application.
