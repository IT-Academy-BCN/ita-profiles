# Validation
[[Back to index]](./coding-guidelines.md)

- [FormRequest Validation best practices](#formrequest-validation-best-practices)

## FormRequest validation best practices

### Rely on Laravel's default validation messages when possible

Laravel provides a comprehensive set of default validation messages for all common rules. These messages are:

- Clear and descriptive.
- Automatically localized based on the application’s language settings.

You can use these defaults in most cases without needing to define custom messages in your `FormRequest` classes.

**Example:**

```php
public function rules(): array
{
    return [
        'username' => ['required', 'string', 'min:3'],
        'email' => ['required', 'email', 'unique:users'],
    ];
}
```

In this case, Laravel will use the default messages, such as:
- _"The username field is required."_
- _"The username must be at least 3 characters."_

These messages are defined globally in lang/{lang}/validation.php and will be localized automatically.

### Customizing the error messages

If necessary, you may customize the error messages used by the form request by overriding the `messages` method. This method should return an array of attribute / rule pairs and their corresponding error messages.

Note that custom error messages must not be translated inside the `messages` method.

**Example:**

```php
public function messages(): array
{
    return [
        'username.required' => 'A username is required.',
        'email.required' => 'An email is required.',
    ];
}
```

### Customizing the Validation Attributes

Many of Laravel's built-in validation rule error messages contain an `:attribute` placeholder. If you would like the `:attribute` placeholder of your validation message to be replaced with a custom attribute name, you may specify the custom names by overriding the attributes method. This method should return an array of attribute / name pairs:

```php
public function attributes(): array
{
    return [
        'email' => 'email address',
    ];
}
```

### Specifying custom messages in language files

Laravel's built-in validation rules each have an error message that is located in the application's `lang/en/validation.php` file.
Within the `lang/{lang}/validation.php` file, you will find a translation entry for each validation rule.
You may use this file to translate the messages for the application's language. To learn more about Laravel localization, check out the complete [localization documentation](https://laravel.com/docs/10.x/localization).

### Do not overwrite failedValidation() unless necessary

Laravel's default implementation of failedValidation() automatically handles validation failures by returning a `422 Unprocessable Entity` response with the errors in a structured JSON format. This behavior is typically sufficient for most use cases, and should not be overwritten unless you have a specific reason to do so.

In most cases, there is no need to customize the response for failed validation. Laravel already provides:

- Standardized Error Handling: The default response structure (with HTTP status code 422) is appropriate for API consumption and conforms to common API practices.
- Consistency: By using the default behavior, we ensure consistency across different FormRequest classes in the application, making the codebase more maintainable and predictable.

If there is a specific need to customize the validation failure response, only then should you override the `failedValidation()` method.

**Please also refer to the [Laravel documentation](https://laravel.com/docs/10.x/validation#form-request-validation).**
