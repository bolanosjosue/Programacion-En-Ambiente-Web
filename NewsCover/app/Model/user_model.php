<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertUser($cedula, $nombre, $apellido, $email, $contrasena, $address, $address2, $country, $city, $zip, $phone, $rol) {
        // Asegúrate de aplicar medidas de seguridad, como usar sentencias preparadas para evitar inyecciones SQL
        $query = "INSERT INTO user (id, first_name, last_name, email_address, password, address, address2, country, city, postal_code, phone_number, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        
        // En PDO, simplemente pasamos los valores al método execute
        $stmt->execute([$cedula, $nombre, $apellido, $email, $contrasena, $address, $address2, $country, $city, $zip, $phone, $rol]);
        
        return $stmt->rowCount() > 0; // Verifica si se insertó al menos una fila
    }

    public function getUserByEmail($email) {
        // Asegúrate de aplicar medidas de seguridad, como usar sentencias preparadas para evitar inyecciones SQL
        $query = "SELECT * FROM user WHERE email_address = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
  
}
?>
