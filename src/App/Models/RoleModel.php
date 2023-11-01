<?php

namespace Models;

use Core\SqlConnection;
use Exception;
use PDO;

class RoleModel
{
    private PDO $pdoInstance;
    public function __construct()
    {
        $this->pdoInstance = SqlConnection::getPdo();
    }

    public function getRoleByName(string $name)
    {
        $queryStatement = $this->pdoInstance->prepare("SELECT * FROM roles WHERE name = :pName");
        $queryStatement->bindParam(":pName", $name, PDO::PARAM_STR);
        $queryStatement->execute();
        return $queryStatement->fetch();
    }

    public function getRoleById(int $id)
    {
        $queryStatement = $this->pdoInstance->prepare("SELECT * FROM roles WHERE id = :pId");
        $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
        $queryStatement->execute();
        return $queryStatement->fetch();
    }



    public function getAllRoles()
    {
        $queryStatement = $this->pdoInstance->prepare("SELECT * FROM roles ORDER BY id ASC");
        $queryStatement->execute();
        return $queryStatement->fetchAll();
    }

    public function insertNewRole(string $name, string $description): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("INSERT INTO roles (name, description) VALUES (:pName, :pDescription)");
            $queryStatement->bindParam(":pName", $name, PDO::PARAM_STR);
            $queryStatement->bindParam(":pDescription", $description, PDO::PARAM_STR);
            return $queryStatement->execute();
        } catch (Exception $err) {
            return false;
        }
    }


    public function updateRoleName(int $id, string $newName): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("UPDATE roles SET name = :pName WHERE id = :pId");
            $queryStatement->bindParam(":pName", $newName, PDO::PARAM_STR);
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            return false;
        }
    }

    public function updateDescriptionName(int $id, string $newDescription): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("UPDATE roles SET description = :pDescription WHERE id = :pId");
            $queryStatement->bindParam(":pDescription", $newDescription, PDO::PARAM_STR);
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            return false;
        }
    }

    public function updateRole(int $id, string $name, string $description): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("UPDATE roles SET name = :pName, description = :pDescription WHERE id = :pId");
            $queryStatement->bindParam(":pName", $name, PDO::PARAM_STR);
            $queryStatement->bindParam(":pDescription", $description, PDO::PARAM_STR);
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            return false;
        }
    }

    public function deleteRoleById(int $id)
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("DELETE FROM roles WHERE id = :pId");
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            error_log("FAILURE IN DELETE ROLE QUERY: $err");
            return false;
        }
    }
}
