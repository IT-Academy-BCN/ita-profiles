# Routing conventions
[[Back to index]](./coding-guidelines.md)

- [API Route convention guide](#api-route-convention)
- Model binding

## API Route Convention

- [Introduction](#introduction)
- [Why Consistent API Route Design Matters](#why-consistent-api-route-design-matters)
- [Guidelines for API Route Structure](#guidelines-for-api-route-structure)
- [Best Practices](#best-practices)
- [External Documentation](#external-documentation)

### Introduction
This guide outlines the conventions and best practices for designing API routes, ensuring that all team members adhere to a standardized approach.

### Why Consistent API Route Design Matters

Consistent API route design is crucial for maintaining a seamless and efficient development process. Well-structured and standardized routes enhance the developer experience, improve code maintainability, and ensure scalability. This article outlines the importance of consistency, provides clear guidelines for API route structure, and highlights best practices.

#### Enhanced Developer Experience
Developers benefit from quickly understanding and navigating the API when routes follow familiar patterns. This reduces the learning curve, allowing developers to spend more time building features rather than deciphering routes.

#### Improved Maintainability
A predictable API design leads to better code maintainability. When routes adhere to a standardized pattern, adding new features or modifying existing ones becomes straightforward. This reduces the risk of errors and inconsistencies in the code.

#### Scalability
A well-structured API is crucial for scalability. As the application grows, it can easily accommodate new endpoints and services without becoming unwieldy. This predictability supports smoother integrations and facilitates future expansions.

### Guidelines for API Route Structure

#### Use Clear and Descriptive Naming Conventions
- Nouns for Resources: Use plural nouns to represent resources. For example, /students for a collection of student records.
- Verbs for Actions: Use HTTP methods to define actions. For example, GET /students for fetching data, POST /students for creating a new student.

#### Hierarchical Structure
Organize routes hierarchically to reflect relationships between resources. For example:
- Base Endpoints: /students, /projects.
- Nested Resources: /students/{studentId}/resume, /projects/{projectId}/tasks.


#### Consistent Parameter Naming
Use consistent naming for parameters across different routes. For example, use {studentId} consistently in all routes involving student identification. Additionally, the order of parameters in the route should reflect the logical hierarchy of the resources. For example, placing resume after {studentId} makes sense because the resume is a resource that belongs to a specific student:

    Route::prefix('student/{studentId}/resume')->group(function () {
        Route::get('detail', StudentDetailController::class)->name('student.details');
        // Other routes...

        });

#### Examples of Well-Formatted API Routes

    Route::prefix('student/{studentId}/resume')->group(function () {
        Route::get('detail', StudentDetailController::class)->name('student.details');
        Route::get('projects', StudentProjectsDetailController::class)->name('student.projects');
        Route::get('collaborations', StudentCollaborationController::class)->name('student.collaborations');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('tag.index');
        Route::post('/', [TagController::class, 'store'])->name('tag.create');
        Route::put('/{id}', [TagController::class, 'update'])->name('tag.update');
    });

### Best Practices

#### Versioning
Use versioning in your API to manage changes and updates without breaking existing functionality. For example, prepend routes with the version number: /v1/students, /v2/students.

#### Authentication
Implement secure authentication methods to protect your API. Use token-based authentication (e.g. OAuth) to ensure that only authorized users can access certain endpoints.

#### Utilizing Prefixes
Using prefixes in API routes helps in organizing endpoints logically and hierarchically. Prefixes group related endpoints together, making the API easier to navigate and understand. This practice also helps in managing versioning and authorization, enhancing the overall API structure and usability​

#### Error Handling
Provide meaningful error messages and use standard HTTP status codes to indicate the success or failure of an API request.

- 200 OK: Successful GET request.
- 201 Created: Successful POST request.
- 400 Bad Request: Client error due to invalid input.
- 404 Not Found: Resource not found​.

### External Documentation

https://swagger.io/blog/api-design/the-importance-of-standardized-api-design/

https://blog.postman.com/the-5-dimensions-of-api-consistency/

https://blog.stoplight.io/people-will-love-your-consistent-api-design

https://www.astera.com/type/blog/api-design-best-practices/
