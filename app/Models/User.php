<?php

namespace Mini\Models;

use Mini\Core\Model;
use Mini\Core\Database;
use PDO;

class User extends Model
{
    private $email;
    private $password;
    private $first_name;
    private $last_name;
    private $role;

    // Getters and Setters
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Active Record Methods

    public static function findByEmail(string $email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function find($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public function save()
    {
        $pdo = Database::getPDO();
        if ($this->id) {
            return false;
        }

        $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, role) VALUES (:email, :password, :first_name, :last_name, :role)");
        $res = $stmt->execute([
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'role' => $this->role ?? 'user'
        ]);

        if ($res) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }
    public static function count()
    {
        $pdo = Database::getPDO();
        return (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
