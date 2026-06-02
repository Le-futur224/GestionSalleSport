<?php

abstract class BaseController
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../views/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/footer.php';
    }

    protected function redirect(string $url, string $message = '', string $type = 'success'): void
    {
        if ($message !== '') {
            $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        }
        header('Location: ' . $url);
        exit;
    }

    protected function post(string $key, $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}
