<?php

namespace Controllers;

abstract class ApiController
{
    /**
     * Retourne un fichier json au client
     * @param array $data
     * @return void
     */
    protected function json(array $data): void
    {
        header('Content-type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function error(string $message, int $statusCode): void
    {
        header('HTTP/1.1 ' . $statusCode);
        $this->json([
            "error" => $message,
            "ok" => false
        ]);
    }
}