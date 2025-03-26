<!DOCTYPE html>
<html>

<head>
    <title>Знак зодиака</title>
</head>

<body>
    <form method="POST">
        Введите дату (ДД.ММ.ГГГГ):
        <input type="text" name="date"
            pattern="\d{2}\.\d{2}\.\d{4}"
            placeholder="01.01.2000" required>
        <input type="submit" value="Узнать">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = $_POST["date"] ?? "";

        function simpleParse($input)
        {
            try {
                $parts = explode(".", $input);
                $day = (int) ($parts[0] ?? 0);
                $month = (int) ($parts[1] ?? 0);
                $year = (int) ($parts[2] ?? 2000);

                return new DateTime("$year-$month-$day");
            } catch (Exception $e) {
                return null;
            }
        }

        function timestampParse($input)
        {
            try {
                return new DateTime($input);
            } catch (Exception $e) {
                return null;
            }
        }

        try {
            $date = simpleParse($input);
            if (!$date instanceof DateTime) {
                $date = timestampParse($input);
            }
        } catch (Exception $e) {
            $date = new DateTime(); // или другое значение по умолчанию
        }



        $day = $date->format('d');
        $month = $date->format('M');

        $zodiac = [
            ["Козерог", [12, 22], [1, 19]],
            ["Водолей", [1, 20], [2, 18]],
            ["Рыбы", [2, 19], [3, 20]],
            ["Овен", [3, 21], [4, 19]],
            ["Телец", [4, 20], [5, 20]],
            ["Близнецы", [5, 21], [6, 20]],
            ["Рак", [6, 21], [7, 22]],
            ["Лев", [7, 23], [8, 22]],
            ["Дева", [8, 23], [9, 22]],
            ["Весы", [9, 23], [10, 22]],
            ["Скорпион", [10, 23], [11, 21]],
            ["Стрелец", [11, 22], [12, 21]],
        ];

        $result = "Неверная дата";
        foreach ($zodiac as $sign) {
            if (
                ($month == $sign[1][0] && $day >= $sign[1][1]) ||
                ($month == $sign[2][0] && $day <= $sign[2][1])
            ) {
                $result = $sign[0];
                break;
            }
        }

        echo "<h3>Результат: $result <br/> $date</h3>";
    } ?>
</body>

</html>