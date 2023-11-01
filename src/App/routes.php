
<?php

use Pecee\SimpleRouter\SimpleRouter;
use Controllers\MeuController;

try {
    SimpleRouter::setDefaultNamespace("Controllers");

    #                       VIEW ROUTES
    SimpleRouter::get("/", "ReportsController@index");

    SimpleRouter::get("/registerrole", "RoleController@index");;
    SimpleRouter::get("/viewroles", "RoleController@viewRoles");
    SimpleRouter::get("/updaterole/{id}", "RoleController@updateRoleView");
    SimpleRouter::get("/confirmdeleterole/{id}", "RoleController@confirmDeleteRoleView");

    SimpleRouter::get("/registeremployee", 'EmployeeController@index');
    SimpleRouter::get("/seeemployees", "EmployeeController@seeEmployeesView");
    SimpleRouter::get("/editemployee/{id}", "EmployeeController@editEmployeeView");
    SimpleRouter::get("deleteemployee/{id}", "EmployeeController@deleteEmployeeView");

    #                       API ROUTES 
    SimpleRouter::post("/api/registernewrole", "RoleController@registerNewRole");
    SimpleRouter::post("/api/updaterole/{id}", "RoleController@updateRole");
    SimpleRouter::delete("/api/deleterole/{id}", "RoleController@deleteRole");

    SimpleRouter::post("/api/registeremployeer", "EmployeeController@registerEmployee");
    SimpleRouter::patch("/api/editemployee/{id}", "EmployeeController@editEmployee");
    SimpleRouter::delete("/api/deleteemployee/{id}", "EmployeeController@deleteEmployee");

    SimpleRouter::start();
} catch (Exception $err) {
    error_log("A ERROR OCURRED, ERROR_MSG: $err");
    echo json_encode([
        "message" => "Route Not Found",
        "isError" => true
    ]);
}
