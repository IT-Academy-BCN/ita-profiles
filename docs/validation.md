# Validation
[[Back to index]](./coding-guidelines.md)

- [FormRequest Validation best practices](#formrequest-validation-best-practices)

## FormRequest validation best practices

### Use translation files for error messages

In order to maintain a clean separation of concerns and facilitate easier localization management, validation messages should not be defined directly in the FormRequest classes. Instead, all validation messages should be placed in the appropriate language files (located in `lang/{lang}/validation.php`). This ensures that:

- Messages are properly handled by Laravel's built-in localization system.
- It’s easier to manage translations across different languages.
- The application adheres to standard Laravel conventions for handling translations.

For example, instead of defining messages directly in the FormRequest, use the `validation.php` file::

```
// lang/es/validation.php
return [
    'username.required' => 'El username es requerido',
    // Other rules...
];
```
]

### Do not overwrite failedValidation() unless absolutely necessary

Laravel's default implementation of failedValidation() automatically handles validation failures by returning a `422 Unprocessable Entity` response with the errors in a structured JSON format. This behavior is typically sufficient for most use cases, and should not be overwritten unless you have a specific reason to do so.

In most cases, there is no need to customize the response for failed validation. Laravel already provides:

- Standardized Error Handling: The default response structure (with HTTP status code 422) is appropriate for API consumption and conforms to common API practices.
- Consistency: By using the default behavior, we ensure consistency across different FormRequest classes in the application, making the codebase more maintainable and predictable.

If there is a specific need to customize the validation failure response, only then should you override the `failedValidation()` method.
