<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Зарегистрированные клиенты</title>
    <style>
        .stats { background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .filter-form { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>
    <h1>Список клиентов спортзала</h1>

    <?php
    require_once "db.php";
    require_once "GymRegistration.php";
    
    $gym = new GymRegistration($pdo);
    
    // Определяем, активен ли фильтр
    $filterActive = isset($_GET['filter']) && $_GET['filter'] === 'adults';
    
    // Получаем данные в зависимости от фильтра
    if ($filterActive) {
        $registrations = $gym->getAdults(18);
        $filterText = " (только совершеннолетние, 18+)";
    } else {
        $registrations = $gym->getAll();
        $filterText = "";
    }
    
    // Получаем статистику
    $totalCount = $gym->getTotalCount();
    $adultsCount = $gym->getAdultsCount(18);
    ?>

    <!-- Блок статистики -->
    <div class="stats">
        <h3>📊 Статистика</h3>
        <p><strong>Всего клиентов:</strong> <?= $totalCount ?></p>
        <p><strong>Совершеннолетних (18+):</strong> <?= $adultsCount ?></p>
        <p><strong>Несовершеннолетних:</strong> <?= $totalCount - $adultsCount ?></p>
    </div>

    <!-- Форма фильтра -->
    <div class="filter-form">
        <h3>🔍 Фильтр записей</h3>
        <form method="GET" action="">
            <?php if ($filterActive): ?>
                <p>Сейчас показаны только клиенты <strong>старше 18 лет</strong>.</p>
                <button type="submit" name="filter" value="all">Показать всех</button>
            <?php else: ?>
                <p>Показаны все клиенты.</p>
                <button type="submit" name="filter" value="adults">Показать только совершеннолетних (18+)</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- Таблица с записями -->
    <h3>Список записей<?= $filterText ?></h3>
    <?php if (empty($registrations)): ?>
        <p>Записей не найдено.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th><th>Имя</th><th>Дата рождения</th><th>Возраст</th>
                <th>Тариф</th><th>Тренер</th><th>Время</th><th>Дата регистрации</th><th>Действия</th>
            </tr>
            <?php foreach ($registrations as $reg): 
                // Рассчитываем возраст на основе даты рождения
                $birthDate = new DateTime($reg['birth_date']);
                $today = new DateTime();
                $age = $birthDate->diff($today)->y;
            ?>
                <tr>
                    <td><?= $reg['id'] ?></td>
                    <td><?= htmlspecialchars($reg['name']) ?></td>
                    <td><?= $reg['birth_date'] ?></td>
                    <td><?= $age ?> лет</td>
                    <td><?= htmlspecialchars($reg['tariff']) ?></td>
                    <td><?= $reg['personal_trainer'] ? '✅ Да' : '❌ Нет' ?></td>
                    <td><?= htmlspecialchars($reg['visit_time']) ?></td>
                    <td><?= $reg['created_at'] ?></td>
                    <td>
                        <form action='delete.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='<?= $reg['id'] ?>'>
                            <button onclick='return confirm("Удалить запись?")'>🗑️ Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <p><a href="form.html">➕ Новая регистрация</a></p>
</body>
</html>
