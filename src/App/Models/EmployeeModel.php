<?php

namespace Models;

use Core\SqlConnection;
use Exception;
use PDO;

class EmployeeModel
{
    private PDO $pdoInstance;
    public function __construct()
    {
        $this->pdoInstance = SqlConnection::getPdo();
    }

    public function registerNewEmployee(string $name, string $lastName, int $roleId, $birthday, int $salary): array | bool
    {
        try {
            $query = $this->pdoInstance->prepare("INSERT INTO employees (name, last_name, role_id, birthday, salary) VALUES (:pName, :pLastName, :pRoleId, :pBirthday, :pSalary)");
            $query->bindParam(":pName", $name, PDO::PARAM_STR);
            $query->bindParam(":pLastName", $lastName, PDO::PARAM_STR);
            $query->bindParam(":pRoleId", $roleId, PDO::PARAM_INT);
            $query->bindParam(":pBirthday", $birthday, PDO::PARAM_STR);
            $query->bindParam(":pSalary", $salary, PDO::PARAM_STR);
            return $query->execute();
        } catch (Exception $err) {
            error_log("REGISTER EMPLOYEER ERROR: $err");
            return false;
        }
    }

    public function getAllEmployees(): array | bool | null
    {
        try {
            $query = $this->pdoInstance->prepare("SELECT * FROM employees");
            $query->execute();
            $employees = $query->fetchAll();
            return $employees;
        } catch (Exception $err) {
            return null;
        }
    }

    public function getEmployeeById(int $id): array | null | false
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("SELECT * FROM employees WHERE id = :pId");
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            $queryStatement->execute();
            return $queryStatement->fetch();
        } catch (Exception $err) {
            return false;
        }
    }

    public function updateEmployeeById(int $id, $name, $lastName, $roleId, $birthday, $salary): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("UPDATE employees SET name = :pName, last_name = :pLastName, role_id = :pRoleId, birthday = :pBirthday, salary = :pSalary WHERE id = :pId");
            $queryStatement->bindParam(":pName", $name, PDO::PARAM_STR);
            $queryStatement->bindParam(":pLastName", $lastName, PDO::PARAM_STR);
            $queryStatement->bindParam(":pRoleId", $roleId, PDO::PARAM_INT);
            $queryStatement->bindParam(":pBirthday", $birthday, PDO::PARAM_STR);
            $queryStatement->bindParam(":pSalary", $salary, PDO::PARAM_INT);
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            error_log("FAILED TO UPDATE EMPLOYEE DATA, ERROR: $err");
            return false;
        }
    }

    public function deleteEmployeeById(int $id): bool
    {
        try {
            $queryStatement = $this->pdoInstance->prepare("DELETE FROM employees WHERE id = :pId");
            $queryStatement->bindParam(":pId", $id, PDO::PARAM_INT);
            return $queryStatement->execute();
        } catch (Exception $err) {
            error_log("ERROR WHEN DELETING EMPLOYEE FROM DATABASE, ERROR_MESSAGE: $err");
            return false;
        }
    }
}
