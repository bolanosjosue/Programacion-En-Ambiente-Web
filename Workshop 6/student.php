<?php
require 'functions.php';

class Student {
    private $id;
    private $name;
    private $lastname;
    private $cedula;
    private $age;

    // Constructor
    public function __construct($id, $name, $lastname, $cedula, $age) {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->cedula = $cedula;
        $this->age = $age;
    }

    // Métodos para acceder a los atributos (getters)
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getAge() {
        return $this->age;
    }
}

class OptenerEstudiantes {
    private $connection;

    public function __construct() {
        $this->connection = $this->getConnection();
    }

    private function getConnection() {
        return getConnection();
    }

    public function getStudents($limit) {
        $query = "SELECT * FROM students LIMIT $limit";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Error al obtener datos: " . mysqli_error($this->connection));
        }

        $students = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $student = new Student($row['id'], $row['name'], $row['lastname'], $row['cedula'], $row['age']);
            $students[] = $student;
        }

        return $students;
    }

    public function mostrarEstudiantes($limit) {
        $students = $this->getStudents($limit);

        foreach ($students as $student) {
            echo "{$student->getId()}, {$student->getName()}, {$student->getLastname()}, {$student->getCedula()}, {$student->getAge()}\n";
        }
    }
}

if (isset($argv[1])) {
    $limit = (int) $argv[1];

    if ($limit > 0) {
        $optenerEstudiantes = new OptenerEstudiantes();
        $optenerEstudiantes->mostrarEstudiantes($limit);
    } else {
        echo "El número de registros debe ser mayor que 0.\n";
    }
} else {
    echo "Por favor, especifique el número de registros a mostrar.\n";
}
?>
