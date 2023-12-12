<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'first_name',
        'last_name',
        'email_address',
        'password',
        'address',
        'address2',
        'country',
        'city',
        'postal_code',
        'phone_number',
        'role_id',
        'publica', // Agregamos la nueva columna
    ];

    public function insertUser($cedula, $nombre, $apellido, $email, $contrasena, $address, $address2, $country, $city, $zip, $phone, $rol, $publica)
    {
        $data = [
            'id' => $cedula,
            'first_name' => $nombre,
            'last_name' => $apellido,
            'email_address' => $email,
            'password' => $contrasena,
            'address' => $address,
            'address2' => $address2,
            'country' => $country,
            'city' => $city,
            'postal_code' => $zip,
            'phone_number' => $phone,
            'role_id' => $rol,
            'publica' => $publica, // Agregamos la nueva columna
        ];

        $this->insert($data);
        return $this->insertID(); // Devuelve el ID del registro insertado
    }

    public function getUserByEmail($email)
    {
        // Asegúrate de aplicar medidas de seguridad, como usar sentencias preparadas para evitar inyecciones SQL
        $user = $this->where('email_address', $email)->first();

        return $user;
    }

    public function getUser($id)
    {
        $user = $this->where('id', $id)->first();
        return $user;

    }

    public function cambiarEstadoPerfil($userId, $nuevoEstado)
    {
        $this->set(['publica' => $nuevoEstado])->where('id', $userId)->update();
    }
}
