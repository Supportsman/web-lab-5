<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Зарегистрированные клиенты</title>
</head>
<body>
    <h1>Список клиентов спортзала</h1>
    <?php
    require_once "db.php";
    require_once "GymRegistration.php";
    
    $gym = new GymRegistration($pdo);
    $registrations = $gym->getAll();
    
    if (empty($registrations)) {
        echo "<p>Пока нет зарегистрированных клиентов.</p>";
    } else {
        echo "<table border='1' cellpadding='8'><tr>
                <th>ID</th><th>Имя</th><th>Дата рождения</th><th>Тариф</th>
                <th>Тренер</th><th>Время</th><th>Дата регистр.</th><th>Действия</th></tr>";
        
        foreach ($registrations as $reg) {
            echo "<tr>
                    <td>{$reg['id']}</td>
                    <td>{$reg['name']}</td>
                    <td>{$reg['birth_date']}</td>
                    <td>{$reg['tariff']}</td>
                    <td>" . ($reg['personal_trainer'] ? 'Да' : 'Нет') . "</td>
                    <td>{$reg['visit_time']}</td>
                    <td>{$reg['created_at']}</td>
                    <td>
                        <form action='delete.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$reg['id']}'>
                            <button onclick='return confirm(\"Удалить?\")'>Удалить</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
    <p><a href="form.html">Новая регистрация</a></p>
</body>
</html>
