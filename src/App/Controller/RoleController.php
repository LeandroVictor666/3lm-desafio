<?php

namespace Controllers;

use Models\RoleModel;

class RoleController extends ControllerBase
{
    public function __construct()
    {
        parent::__construct("App/View/RoleView");
    }

    public function index()
    {
        echo $this->template->render("RegisterRoleView/RegisterRole.html", [
            "assets_dir" => "App/View/RoleView/RegisterRoleView/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
        ]);
    }
    public function viewRoles()
    {
        echo $this->template->render("SeeRolesView/SeeRoles.html", [
            "assets_dir" => "App/View/RoleView/SeeRolesView/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "roles_data" => $this->getAllRoles(),
        ]);
    }
    public function updateRoleView(int $id)
    {
        echo $this->template->render("UpdateRoleView/UpdateRole.html", [
            "assets_dir" => "App/View/RoleView/UpdateRoleView/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "role_data" => $this->getRoleById($id)
        ]);
    }

    public function updateRole(int $id)
    {
        $roleModel = new RoleModel;
        $checkIfRoleExists = $roleModel->getRoleById($id);
        if ($checkIfRoleExists == null) {
            echo $this->getApiResponse("A identificação deste cargo não existe.", true);
            return;
        }


        $bodyReq = $this->getBodyRequest();
        if (!isset($bodyReq["name"]) && isset($bodyReq["description"])) {
            $description = $bodyReq["description"];
            $queryResult = $roleModel->updateDescriptionName($id, $description);
            if ($queryResult === false) {
                echo $this->getApiResponse("Falha ao atualizar descrição do cargo, por favor, tente novamente", true);
                return;
            }
        } else if (!isset($bodyReq["description"]) && isset($bodyReq["name"])) {
            $name = $bodyReq["name"];
            $queryResult = $roleModel->updateRoleName($id, $name);
            if ($queryResult === false) {
                echo $this->getApiResponse("Falha ao atualizar nome do cargo, por favor, tente novamente", true);
                return;
            }
        } else {
            $name = $bodyReq["name"];
            $description = $bodyReq["description"];
            $queryResult = $roleModel->updateRole($id, $name, $description);
            if ($queryResult === false) {
                echo $this->getApiResponse("Ocorreu um erro ao atualizar o cargo, por favor, tente novamente.", true);
                return;
            }
        }
        echo $this->getApiResponse("O Cargo foi atualizado corretamente.", false);
        return;
    }

    public function confirmDeleteRoleView(int $id)
    {
        echo $this->template->render("ConfirmDeleteRoleView/ConfirmDeleteRole.html", [
            "assets_dir" => "App/View/RoleView/ConfirmDeleteRoleView/assets/",
            "css_base" => "App/View/Layouts/styles/mainstyle.css",
            "role_data" => $this->getRoleById($id)
        ]);
    }

    public function deleteRole(int $id)
    {
        $roleModel = new RoleModel();
        $queryResult = $roleModel->deleteRoleById($id);
        if ($queryResult === false) {
            echo $this->getApiResponse("Deletar Cargo falhou, por favor, tente novamente.\n\n(Delete TODOS os funcionarios que possuam este cargo, e tente novamente.)", true);
            return;
        }
        echo $this->getApiResponse("Cargo Deletado Com Sucesso!", false);
        return;
    }

    public function getAllRoles()
    {
        $roleModel = new RoleModel();
        return $roleModel->getAllRoles();
    }

    public function getRoleByName($name): array | false
    {
        $roleModel = new RoleModel();
        $role = $roleModel->getRoleByName($name);
        if ($role == null) {
            return false;
        }
        return $role;
    }

    public function getRoleById(int $id): array | false
    {
        $roleModel = new RoleModel();
        $role = $roleModel->getRoleById($id);
        if ($role == null) {
            return false;
        }
        return $role;
    }

    public function registerNewRole()
    {
        $params = $this->getBodyRequest();
        $name = filter_var($params["name"]);
        if ($name === false || empty($name)) {
            echo $this->getApiResponse("Por favor, preencha o campo 'Nome Do Cargo' corretamente.", true);
            return;
        }
        $description = filter_var($params["description"]);
        if ($description === false || empty($description)) {
            echo $this->getApiResponse("Por favor, preencha o campo 'Descrição Do Cargo' corretamente.", true);
            return;
        }
        if ($this->getRoleByName($name) !== false) {
            echo $this->getApiResponse("Falha ao registrar o novo cargo, esse cargo ja existe.", true);
            return;
        }
        $roleModel = new RoleModel();
        $queryResult = $roleModel->insertNewRole($name, $description);
        if ($queryResult === false) {
            echo $this->getApiResponse("Falha ao registrar o novo cargo, por favor, contate o administrador.", true);
            return;
        }
        echo $this->getApiResponse("Cargo Registrado Com Sucesso!", false);
        return;
    }
}
