<?php

namespace Controllers;

use Models\EmployeeModel;

class ReportsController extends ControllerBase
{
    private $jasperReportsController;
    public function __construct()
    {
        parent::__construct("App/View/ReportsView");
        $reportPath = $this->getSrcBasePath() . "/Core/Resources/Reports/";
        $this->jasperReportsController = new JasperReportController($reportPath, "3LMReport");
    }

    public function index()
    {
        $reportFrame = "Core/Resources/Reports/3LMReport.pdf";
        echo $this->template->render("SeeReports/Reports.html", [
            "assets_dir" => "App/View/ReportsView/SeeReports/assets",
            "style_base" => "App/View/Layouts/styles/mainstyle.css",
            "report_frame" => $reportFrame,
            "birthdayEmployees" => $this->getBirthdaysEmployees(),
        ]);
    }

    private function getSrcBasePath(int $levels = 2)
    {
        return dirname(__DIR__, $levels);
    }

    private function getEmployees()
    {
        $employeeModel = new EmployeeModel();
        return $employeeModel->getAllEmployees();
    }


    private function getBirthdaysEmployees(): array
    {
        $employees = $this->getEmployees();
        $employeeBirthday = [];
        foreach ($employees as $employee) {
            $birthdayDate = $employee["birthday"];
            $actualDate = date("Y-m-d");

            $actualDateDay = strtolower(date("d", strtotime($actualDate)));
            $birthdayDay = strtolower(date("d", strtotime($birthdayDate)));

            $actualDateMonth = strtolower(date("m", strtotime($actualDate)));
            $birthdayMonth = strtolower(date("m", strtotime($birthdayDate)));

            if ($actualDateDay !== $birthdayDay || $actualDateMonth !== $birthdayMonth)
                continue;

            array_push($employeeBirthday, $employee);
        }
        return $employeeBirthday;
    }
}
