# Database Class Documentation

This documentation explains the functionality of the `Database` class, which provides a simplified interface for interacting with a MySQL database using PDO. The class includes features like query type detection, public ID validation, and auto-generation of unique IDs for `INSERT` operations.

---

## Class Overview

The `Database` class is designed to:

- Establish a database connection using the `PDO` library.
- Support CRUD operations (INSERT, UPDATE, DELETE, SELECT) with query type detection.
- Automatically handle the generation of unique public IDs during `INSERT` operations.
- Validate the existence of public_id during `UPDATE`, `DELETE`, and `SELECT` operations.

---

## Constructor

```php
public function __construct(string $unixSocket, string $dbname, string $user)
```

Initializes a new `Database` instance and sets up a PDO connection.

### Parameters:

- `unixSocket`: The Unix socket path for the database connection.
- `dbname`: The name of the database.
- `user`: The database username.

### Error Handling:

If the connection fails, the constructor catches the exception and prints an error code and message before terminating the script.

---

## Query Execution Methods

### Query Preparation

```php
public function query(string $query)
```

Prepares a SQL query for execution and determines its type.

### Query Type Detection

The type of query (INSERT, UPDATE, DELETE, SELECT) is determined by extracting the first word of the SQL string. The detected type is stored in the private `$queryType` property.

---

### Execute

```php
public function execute($params = [])
```

Executes a prepared query. Depending on the query type, additional checks and modifications are performed:

1. **INSERT Queries:**

   - Automatically generate a public_id if not provided in the `$params`.

2. **UPDATE, DELETE, and SELECT Queries:**
   - Validate the existence of the public_id in the database.

---

## Query Type Helpers

### `isInsertQuery`

```php
private function isInsertQuery(): bool
```

Returns `true` if the query type is `INSERT`.

### `isUpdateQuery`

```php
private function isUpdateQuery(): bool
```

Returns `true` if the query type is `UPDATE`.

### `isDeleteQuery`

```php
private function isDeleteQuery(): bool
```

Returns `true` if the query type is `DELETE`.

### `isSelectQuery`

```php
private function isSelectQuery(): bool
```

Returns `true` if the query type is `SELECT`.

---

## Public ID Handling

### Generate Public ID for INSERT

```php
public function handleInsertParams(array $params): array
```

Ensures that a public_id is included in the parameters for an `INSERT` query. If not provided, it generates a unique ID using the `NanoIdGenerator` class.

### Validate Public ID for Other Operations

```php
private function validatePublicIdExists(string $publicId, string $table = 'users', string $column = 'public_id'): void
```

Checks whether the provided public_id exists in the specified table and column. Throws an exception if the ID is not found.

---

## Unique ID Validation

```php
public function isUniquePublicId(string $id, string $table = 'users', string $column = 'public_id'): bool
```

Determines whether a given public_id is unique by querying the database.

### SQL Injection Prevention

Table and column names are sanitized using a regular expression to allow only alphanumeric characters and underscores.

### Query Example:

```sql
SELECT COUNT(*) FROM users WHERE public_id = :id
```

If the count is `0`, the ID is considered unique.

---

## Fetch Methods

### `fetchAll`

```php
public function fetchAll()
```

Fetches all rows from the executed query as an associative array.

### `fetch`

```php
public function fetch()
```

Fetches a single row from the executed query as an associative array.

### `fetchOrAbort`

```php
public function fetchOrAbort()
```

Fetches a single row, and aborts the script if no result is found.

---

## Example Usage

### Insert Operation

```php
$db = new Database('/path/to/socket', 'dbname', 'user');
$db->query('INSERT INTO users (name, email, public_id) VALUES (:name, :email, :public_id)')
   ->execute(['name' => 'John Doe', 'email' => 'john.doe@example.com']);
```

If public_id is not provided, it will be generated automatically.

### Update Operation

```php
$db->query('UPDATE users SET name = :name WHERE public_id = :public_id')
   ->execute(['name' => 'Jane Doe', 'public_id' => 'some-public-id']);
```

If the public_id does not exist, an exception will be thrown.

### Select Operation

```php
$result = $db->query('SELECT * FROM users WHERE public_id = :public_id')
              ->execute(['public_id' => 'some-public-id'])
              ->fetch();
```

### Delete Operation

```php
$db->query('DELETE FROM users WHERE public_id = :public_id')
   ->execute(['public_id' => 'some-public-id']);
```

---

## Notes

- **Security:** Always validate and sanitize user input to prevent SQL injection.
- **Extensibility:** This class can be extended to handle additional query types or logging mechanisms.
- **Error Handling:** The class uses exceptions for handling validation and query execution errors.
