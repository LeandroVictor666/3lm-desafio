<?php

namespace Controllers;

use Support\Template;


class ControllerBase
{
    protected Template $template;

    public function __construct(string $dir)
    {
        $this->template = new Template($dir);
    }

    protected function getApiResponse(string $message, bool $isError)
    {
        return json_encode([
            "message" => $message,
            "isError" => $isError
        ]);
    }
    protected function getBodyRequest(): array
    {
        return json_decode(file_get_contents("php://input"), true);
    }
}
