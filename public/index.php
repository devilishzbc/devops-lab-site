<?php
$config = yaml_parse_file('/opt/app/config/app.yaml');
$dsn = sprintf(
  'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
  $config['db']['host'], $config['db']['port'], $config['db']['name']
);
$user = $config['db']['user'];
$pass = $config['db']['pass'];

try {
  $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
  $rows = $pdo->query("SELECT id,name,role FROM users ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
  http_response_code(500);
  echo "<h1>DB error</h1><pre>".htmlspecialchars($e->getMessage())."</pre>";
  exit;
}
?><!doctype html><meta charset="utf-8"><title>Users</title>
<h1>Users from devops_lab</h1>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Name</th><th>Role</th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?=htmlspecialchars($r['id'])?></td><td><?=htmlspecialchars($r['name'])?></td><td><?=htmlspecialchars($r['role'])?></td></tr>
<?php endforeach; ?>
</table>
