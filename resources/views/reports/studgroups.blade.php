<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Результаты тестирования</title>
</head>

<body>
    @if (isset($error))
        {{ $error }}
    @else
        @if ($web)
            <a href="<?= route('report.generate_studgroups', [$test->id, $date]) ?>" target="_blank" rel="noopener noreferrer"
                class='btn btn-primary'>
                сохранить в PDF
            </a>
        @endif
        <h3>Результаты тестирования по тесту: {{ $test->test_name }} за <?= (new DateTime($date))->format('Y-m-d H:m') ?></h3>

        <div style='margin-bottom: 16px;'>
            <div style="margin-bottom: 6px;">
                <b>Назначил: </b>{{ Auth::user()->user_lastname }} {{ Auth::user()->user_firstname }}
                {{ Auth::user()->user_patronymic }}
            </div>

            <div style="margin-bottom: 6px;">
                <b>Дисциплина: </b>{{ $discipline->discipline_name }}
            </div>

            <div style="margin-bottom: 6px;">
                <b>Порог прохождения: </b> 53 балла
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ФИО студента</th>
                    <th>Оценка</th>
                    <th>Сдано / не сдано</th>
                </tr>
            </thead>
            @foreach ($studgroups as $studgroup)
                <tr>
                    <th colspan="3" style="text-align:left; background-color: #ebeced;">
                        {{ $studgroup['name'] }}
                    </th>
                </tr>
                @foreach ($studgroup['users'] as $user)
                    <tr>
                        <td>{{ $user['full_name'] }}</td>
                        <td>{{ $user['mark'] }}</td>

                        @if($user['mark'] >= 53)
                            <td style="background-color: #bfffbe;">Сдано</td>
                        @else
                        <td style="background-color: #ffbebe;">Не сдано</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </table>
    @endif
</body>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* внешние границы таблицы серого цвета толщиной 1px */
    table {
        border: 1px solid grey;
        border-collapse: collapse;
        width: 100%;
    }

    /* границы ячеек тела таблицы */
    th,
    td {
        border: 1px solid grey;
        padding: 8px;
    }

    a.btn.btn-primary {
        display: block;
        position: absolute;
        padding: 10px 16px;
        background: #2c7dff;
        text-decoration: none;
        top: 0;
        right: 0;
        color: #fff;
    }
</style>
</html>