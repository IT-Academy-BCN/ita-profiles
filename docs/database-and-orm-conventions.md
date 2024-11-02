# Database and ORM conventions
[[Back to index]](./coding-guidelines.md)

- [Eloquent conventions](#eloquent-model-conventions)
- [Eloquent relationships](#eloquent-relationships)
- Model binding
- Migrations and schema conventions
- Factory conventions

## Eloquent Model Conventions

### Table Names

By convention, the "snake case", plural name of the class will be used as the table name unless another name is explicitly specified. So, in this case, Eloquent will assume the Flight model stores records in the flights table, while an AirTrafficController model would store records in an air_traffic_controllers table.

If your model's corresponding database table does not fit this convention, you may manually specify the model's table name by defining a table property on the model.

### Primary Keys

Eloquent will also assume that each model's corresponding database table has a primary key column named id.

## Eloquent Relationships

### Many to Many Relationships

#### Table Structure

To define this relationship, three database tables are needed: users, roles, and role_user. The role_user table is derived from the alphabetical order of the related model names and contains user_id and role_id columns. This table is used as an intermediate table linking the users and roles.

## Model Binding

--

## Migrations and schema conventions

--

## Factory conventions

--
