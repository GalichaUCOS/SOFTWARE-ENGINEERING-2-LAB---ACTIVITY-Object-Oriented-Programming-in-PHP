<?php
class Database {
    protected $pdo;

    public function __construct($host, $dbname, $user, $pass) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // C
    public function create($table, $fields) {
        $columns = implode(',', array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($fields);
        return $this->pdo->lastInsertId();
    }

    // R
    public function read($table, $where = "") {
        $sql = "SELECT * FROM $table";
        if ($where) $sql .= " WHERE $where";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // U
    public function update($table, $fields, $where) {
        $set = '';
        foreach ($fields as $key => $value) {
            $set .= "$key=:$key,";
        }
        $set = rtrim($set, ',');
        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($fields);
    }

    // D
    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        $this->pdo->exec($sql);
    }
}

class Student extends Database {
    public function addStudent($name, $email) {
        return $this->create('students', ['name' => $name, 'email' => $email]);
    }
}

class Attendance extends Database {
    public function addAttendance($student_id, $date, $status) {
        return $this->create('attendance', [
            'student_id' => $student_id,
            'date' => $date,
            'status' => $status
        ]);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>OOP CRUD Example</title>
</head>
<body>
    <h2>Add Student</h2>
    <form method="post">
        Name: <input type="text" name="name" required>
        Email: <input type="email" name="email" required>
        <button type="submit" name="add_student">Add</button>
    </form>

    <h2>Add Attendance</h2>
    <form method="post">
        Student ID: <input type="number" name="student_id" required>
        Date: <input type="date" name="date" required>
        Status: <select name="status">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>
        <button type="submit" name="add_attendance">Add</button>
    </form>

    <h2>Student List</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
        <?php
        $db = new Student('localhost', 'oopcrud', 'root', '');
        if (isset($_POST['add_student'])) {
            $db->addStudent($_POST['name'], $_POST['email']);
        }
        $students = $db->read('students');
        foreach ($students as $student) {
            echo "<tr>
                <td>{$student['id']}</td>
                <td>{$student['name']}</td>
                <td>{$student['email']}</td>
                <td>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='{$student['id']}'>
                        <button type='submit' name='delete_student'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
        if (isset($_POST['delete_student'])) {
            $db->delete('students', "id={$_POST['delete_id']}");
            header("Location: crud.php");
        }
        ?>
    </table>
</body>
</html>