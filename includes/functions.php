<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function money(float|string $amount): string
{
    return '৳ ' . number_format((float) $amount, 2);
}

function pretty_date(string $date): string
{
    return date('M d, Y', strtotime($date));
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function verify_csrf(): void
{
    $token = $_POST['_csrf'] ?? '';
    if (!hash_equals($_SESSION['_csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Your form session expired. Please go back and try again.');
    }
}

function validate_transaction(array $input): array
{
    $type = $input['type'] ?? '';
    $amount = $input['amount'] ?? '';
    $date = $input['transaction_date'] ?? '';
    $note = trim($input['note'] ?? '');
    $errors = [];

    if (!in_array($type, ['Income', 'Expense'], true)) {
        $errors[] = 'Please select a valid transaction type.';
    }
    if (!is_numeric($amount) || (float) $amount <= 0) {
        $errors[] = 'Please enter a valid amount.';
    }
    $dateObject = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateObject || $dateObject->format('Y-m-d') !== $date) {
        $errors[] = 'Please enter a valid date.';
    }
    if (strlen($note) > 255) {
        $errors[] = 'The note must be 255 characters or fewer.';
    }

    return [$errors, [
        'type' => $type,
        'amount' => number_format((float) $amount, 2, '.', ''),
        'transaction_date' => $date,
        'note' => $note,
    ]];
}

function sum_by_type(PDO $pdo, int $userId, string $type, ?string $from = null, ?string $to = null): float
{
    $sql = 'SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE user_id = :user_id AND type = :type';
    $params = ['user_id' => $userId, 'type' => $type];
    if ($from !== null) {
        $sql .= ' AND transaction_date >= :from_date';
        $params['from_date'] = $from;
    }
    if ($to !== null) {
        $sql .= ' AND transaction_date < :to_date';
        $params['to_date'] = $to;
    }
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    return (float) $statement->fetchColumn();
}

function period_totals(PDO $pdo, int $userId, string $from, string $to): array
{
    $income = sum_by_type($pdo, $userId, 'Income', $from, $to);
    $expense = sum_by_type($pdo, $userId, 'Expense', $from, $to);
    return ['income' => $income, 'expense' => $expense, 'balance' => $income - $expense];
}

function archive_completed_years(PDO $pdo, int $userId): void
{
    $currentYear = (int) date('Y');
    $statement = $pdo->prepare('SELECT DISTINCT YEAR(transaction_date) AS transaction_year FROM transactions WHERE user_id = :user_id AND YEAR(transaction_date) < :current_year');
    $statement->execute(['user_id' => $userId, 'current_year' => $currentYear]);
    $insert = $pdo->prepare('INSERT INTO yearly_archive (user_id, year, total_income, total_expense, total_balance) VALUES (:user_id, :year, :income, :expense, :balance) ON DUPLICATE KEY UPDATE total_income = VALUES(total_income), total_expense = VALUES(total_expense), total_balance = VALUES(total_balance)');
    foreach ($statement as $row) {
        $year = (int) $row['transaction_year'];
        $totals = period_totals($pdo, $userId, $year . '-01-01', ($year + 1) . '-01-01');
        $insert->execute(['user_id' => $userId, 'year' => $year, 'income' => $totals['income'], 'expense' => $totals['expense'], 'balance' => $totals['balance']]);
    }
}
