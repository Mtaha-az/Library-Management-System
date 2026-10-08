<?php
// Run from the command line only:
// php scripts/create_admin.php
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This setup script can only be run from the command line.\n");
}

require_once __DIR__ . '/../includes/db.php';

$db = new db();
$db->setconnection();
$conn = $db->getConnection();

function readSecret(string $prompt): string {
    echo $prompt;
    if (DIRECTORY_SEPARATOR === '\\') {
        // Windows: use PowerShell's secure prompt and return plaintext only in memory.
        $command = 'powershell.exe -NoProfile -Command "$p=Read-Host -AsSecureString; $b=[Runtime.InteropServices.Marshal]::SecureStringToBSTR($p); try {[Runtime.InteropServices.Marshal]::PtrToStringBSTR($b)} finally {[Runtime.InteropServices.Marshal]::ZeroFreeBSTR($b)}"';
        $value = shell_exec($command);
        if ($value === null) {
            exit("Unable to read hidden password. Use a terminal with PowerShell available.\n");
        }
        return rtrim($value, "\r\n");
    }
    $mode = shell_exec('stty -g');
    if ($mode === null || trim($mode) === '') {
        exit("A terminal supporting hidden input is required.\n");
    }
    system('stty -echo');
    try {
        $value = fgets(STDIN);
    } finally {
        system('stty ' . escapeshellarg(trim($mode)));
        echo "\n";
    }
    return rtrim((string)$value, "\r\n");
}

echo "Create LMS administrator\n";
$name = trim(readline("Name: "));
$email = trim(readline("Admin email (must end with @admin.library): "));
$password = readSecret("Password (minimum 8 characters): ");
$confirm = readSecret("Confirm password: ");

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@admin\.library$/i', $email)) {
    exit("Invalid name or admin email.\n");
}
if (strlen($password) < 8) {
    exit("Password must be at least 8 characters.\n");
}
if ($password !== $confirm) {
    exit("Passwords do not match.\n");
}

$check = $conn->prepare("SELECT ID FROM admins WHERE admin_email = ? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
if ($check->get_result()->fetch_assoc()) {
    $check->close();
    $db->closeConnection();
    exit("An administrator with that email already exists.\n");
}
$check->close();

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admins(admin_email, admin_name, admin_password_reg) VALUES(?,?,?)");
$stmt->bind_param("sss", $email, $name, $hash);
$ok = $stmt->execute();
$stmt->close();
$db->closeConnection();

echo $ok ? "Administrator created successfully.\n" : "Unable to create administrator.\n";
?>