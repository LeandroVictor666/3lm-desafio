<?php

namespace Controllers;

use Support\Template;
use Controllers\ControllerBase;
use Models\EmployeeModel;

class EmployeeController extends ControllerBase
{
    private RoleController $roleController;
    public function __construct()
    {
        parent::__construct("App/View/EmployeeView/");
        $this->roleController = new RoleController();
    }

    private function getRoles()
    {
        return $this->roleController->getAllRoles();
    }

    private function getRoleById(int $id)
    {
        return $this->roleController->getRoleById($id);
    }

    public function index()
    {
        echo $this->template->render('RegisterEmployee/RegisterEmployee.html', [
            "assets_dir" => "App/View/EmployeeView/RegisterEmployee/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "roles_data" => $this->getRoles()
        ]);
        return;
    }

    public function seeEmployeesView()
    {
        echo $this->template->render("SeeEmployees/SeeEmployees.html", [
            "assets_dir" => "App/View/EmployeeView/SeeEmployees/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "employees_data" => $this->getEmployees()
        ]);
    }

    public function editEmployeeView(int $id)
    {
        $employee_data = $this->getEmployeeById($id);
        echo $this->template->render("EditEmployee/EditEmployee.html", [
            "employee_data" => $employee_data,
            "employee_role_data" => $this->getRoleById($employee_data["role_id"]),
            "all_roles" => $this->getRoles(),
            "assets_dir" => "App/View/EmployeeView/EditEmployee/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
        ]);
    }

    public function deleteEmployeeView(int $id)
    {
        $employeeData = $this->getEmployeeById($id);
        echo $this->template->render("DeleteEmployee/DeleteEmployee.html", [
            "assets_dir" => "App/View/EmployeeView/DeleteEmployee/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "employee_data" => $employeeData,
            "employee_role_data" => $this->getRoleById($employeeData["role_id"])
        ]);
        return;
    }

    public function getEmployees(): array | null | bool
    {
        $employeeModel = new EmployeeModel();
        return $employeeModel->getAllEmployees();
    }

    public function getEmployeeById(int $id): array | null | bool
    {
        $employeeModel = new EmployeeModel();
        return $employeeModel->getEmployeeById($id);
    }



    public function editEmployee(int $id)
    {
        $bodyReq = $this->getBodyRequest();

        $name = $bodyReq["name"];
        $lastName = $bodyReq["lastName"];
        $roleId = $bodyReq["role"];
        $birthday = $bodyReq["birthday"];
        $salary = $bodyReq["salary"];

        $employeeModel = new EmployeeModel();
        $queryResult = $employeeModel->updateEmployeeById($id, $name, $lastName, $roleId, $birthday, $salary);
        if ($queryResult === false) {
            http_response_code(400);
            echo $this->getApiResponse("Não foi possivel atualizar as informações do funcionário, tente novamente ou contate um admnistrador.", true);
            return;
        }
        echo $this->getApiResponse("Dados do funcionario atualizados com sucesso.", false);
        http_response_code(200);
        return;
    }

    public function registerEmployee()
    {
        $data = $this->getBodyRequest();
        $name = $data["name"];
        $lastName = $data["lastName"];
        $roleId = $data["roleId"];
        $birthday = $data["birthday"];
        $salary = $data["salary"];

        $employeeModel = new EmployeeModel();
        $queryResult = $employeeModel->registerNewEmployee($name, $lastName, $roleId, $birthday, $salary);
        if ($queryResult === false) {
            echo $this->getApiResponse("Falha ao cadastrar novo funcionario, por favor, tente novamente mais tarde ou contate um admnistrador", true);
            http_response_code(400);
            return;
        }
        echo $this->getApiResponse("Funcionario Cadastrado Com Sucesso!", false);
        http_response_code(200);
        return;
    }

    public function deleteEmployee(int $id)
    {
        $employeeModel = new EmployeeModel();
        $employeeModel->deleteEmployeeById($id);
        if ($employeeModel === false) {
            echo $this->getApiResponse("Não foi possivel deletar o funcionario do banco de dados, tente novamente ou contate um admnistrador.", true);
            return;
        }
        echo $this->getApiResponse("Funcionario Deletado Com Sucesso!", false);
        return;
    }
}
