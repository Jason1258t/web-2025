<!DOCTYPE html>
<html>

<head>
    <title>Цифра в слово</title>
</head>

<body>
    <form>
        Введите цифру (0-9):
        <input type="number" name="digit" min="0" max="9" required>
        <input type="submit" value="Преобразовать">
    </form>

    <?php
    $words = [
        0 => "Ноль",
        1 => "Один",
        2 => "Два",
        3 => "Три",
        4 => "Четыре",
        5 => "Пять",
        6 => "Шесть",
        7 => "Семь",
        8 => "Восемь",
        9 => "Девять",
    ];

    $digit = (int) ($_POST["digit"] ?? -1);

    echo "<p>Результат: ";
    echo isset($words[$digit])
        ? $words[$digit]
        : "error";
    echo "</p>";
    ?>
</body>

</html>