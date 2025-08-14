<?php
$db = new SQLite3('tareas.db');
$db->exec("CREATE TABLE IF NOT EXISTS tareas(id INTEGER PRIMARY KEY, tarea TEXT, completada INTEGER)");

if (isset($_POST['nueva_tarea'])) {
    $tarea = $_POST['nueva_tarea'];
    $db->exec("INSERT INTO tareas (tarea, completada) VALUES ('$tarea', 0)");
}
if (isset($_GET['completar'])) {
    $id = $_GET['completar'];
    $db->exec("UPDATE tareas SET completada = 1 WHERE id = $id");
}
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $db->exec("DELETE FROM tareas WHERE id = $id");
}

$result = $db->query("SELECT * FROM tareas");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tareas</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .tarea { background: white; padding: 10px; margin-bottom: 5px; border-radius: 5px; }
        .completada { text-decoration: line-through; color: gray; }
    </style>
</head>
<body>
<h1>Lista de Tareas</h1>
<form method="POST">
    <input type="text" name="nueva_tarea" placeholder="Nueva tarea" required>
    <button type="submit">Agregar</button>
</form>
<hr>
<?php while ($row = $result->fetchArray()): ?>
    <div class="tarea <?php if($row['completada']) echo 'completada'; ?>">
        <?= $row['tarea'] ?>
        <?php if(!$row['completada']): ?>
            <a href="?completar=<?= $row['id'] ?>">✅</a>
        <?php endif; ?>
        <a href="?eliminar=<?= $row['id'] ?>">🗑️</a>
    </div>
<?php endwhile; ?>
</body>
</html>