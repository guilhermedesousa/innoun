<?php

$errors = [];

if (isset($exception)) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    if (get_class($exception) === 'Exceptions\ValidationException') {
        $errors = $exception->getErrors();
    }
}

$alertType = '';

if (isset($message) && $message['type'] === 'error') {
    $alertType = 'danger';
} else {
    $alertType = 'success';
}
?>

<?php if (isset($message)): ?>
    <div class="my-3 alert alert-<?= $alertType ?>" role="alert">
        <?= $message['message'] ?>
    </div>
<?php endif; ?>