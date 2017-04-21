<?php
// Routes
namespace Test;

require __DIR__ . '/../classes/IngestEngine.php';
require __DIR__ . '/../classes/DataEngine.php';

$app->get('/ingest', function ($request, $response) {
    $this->logger->addInfo("ingest requested");
    $todoIngest = new IngestEngine($this->db);
    $result = $todoIngest->getTodos();

    return $this->renderer->render($response, "ingest.phtml", ["result" => $result]);
});

$app->get('/clear', function ($request, $response) {
    $this->logger->addInfo("clear requested");
    $todoClear = new DataEngine($this->db);
    $result = $todoClear->clearTodos();

    return $this->renderer->render($response, "clear.phtml", ["result" => $result]);
});

$app->get('/view', function ($request, $response) {
    $this->logger->addInfo("view requested");
    $todoView = new DataEngine($this->db);
    $result = $todoView->viewTodos();

    return $this->renderer->render($response, "view.phtml", ["result" => $result]);
});

$app->get('/view/profanity', function ($request, $response) {
    $this->logger->addInfo("view profanity requested");
    $todoView = new DataEngine($this->db);
    $result = $todoView->viewProfanity();

    return $this->renderer->render($response, "viewprofanity.phtml", ["result" => $result]);
});

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
