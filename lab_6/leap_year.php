<!DOCTYPE html>
<html>

<head>
    <title>Проверка високосного года</title>
</head>

<body>
    <h2>Проверка года на високосность</h2>

    <form>
        Введите год:
        <input type="number" name="year" min="1" max="30000" required>
        <input type="submit" value="Проверить">
    </form>

    <?php
    $_POST = (int) $_POST["year"];

    function isLeapYear($year)
    {
        return ($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0;
    }

    echo "<h3>Результат:</h3>";
    echo isLeapYear($year) ? "YES" : "NO";
    ?>
</body>

</html>