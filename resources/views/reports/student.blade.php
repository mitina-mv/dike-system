<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Результаты студента</title>
</head>

<body>
    @if (isset($error))
        {{ $error }}
    @else
        <h2>Результаты тестирования: {{ $test->test_name }}</h2>

        @if ($web)
            <a href="<?= route('report.generate_testlog', $testlog->id) ?>" target="_blank" rel="noopener noreferrer"
                class='btn btn-primary'>
                сохранить в PDF
            </a>
        @endif

        <div style="margin-bottom: 15px;">
            <div style="margin-bottom: 6px;">
                <b>Студент: </b>{{ $student->user_lastname }} {{ $student->user_firstname }}
                {{ $student->user_patronymic }}
            </div>
            <div style="margin-bottom: 6px;">
                <b>Группа: </b>{{ $student->studgroup->studgroup_name }}
            </div>
            <div style="margin-bottom: 6px;">
                <b>Дата тестирования: </b> <?= (new DateTime($testlog->testlog_date))->format('Y-m-d H:m') ?>
            </div>
            <div style="margin-bottom: 6px;">
                <b>Оценка за тест:
                </b><?= isset($testlog->testlog_mark) ? "{$testlog->testlog_mark} из 100" : '<b style="color: red;">не сдано</b>' ?>
            </div>

        </div>

        <table>
            <thead>
                <tr>
                    <th>Выбранный ответ</th>
                    <th>Правильный ответ</th>
                    <th>Стоимость ответа</th>
                    <th>Оценка</th>
                </tr>
            </thead>
            @php
                $uncorrect = json_decode($testlog->uncorrect_answers, true);
            @endphp

            @foreach ($questions as $key => $answerlog)
                <tr>
                    <th colspan="4" style="text-align:left; background-color: #ebeced;">
                        {{ $key + 1 }}. {{ $answerlog->question->question_text }}
                    </th>
                </tr>
                <tr>
                    <td>
                        @php
                            $type = json_decode($answerlog->question->question_settings, false)->type;
                        @endphp

                        {{-- вывод ответа студента --}}
                        @switch($type)
                            @case('text')
                                @if (!empty($answerlog->get_answer->all()))
                                    {{ $answerlog->get_answer->all()[0]->answer_name }}
                                @elseif (isset($uncorrect) 
                                    && isset($uncorrect[$answerlog->question->id])
                                )
                                    {{ $uncorrect[$answerlog->question->id] }}
                                @else
                                    <span style="color: red;">Нет ответа</span>
                                @endif
                            @break

                            @case('multiple')
                                @if (!empty($answerlog->get_answer->all()))
                                    @php
                                        $ans = [];
                                        foreach ($answerlog->get_answer as $gans) {
                                            $ans[] = $gans->answer_name;
                                        }
                                        $str = implode(' & ', $ans);
                                    @endphp

                                    {{ $str }}
                                @else
                                    <span style="color: red;">Нет ответа</span>
                                @endif
                            @break

                            @case('single')
                            @default
                                @if (!empty($answerlog->get_answer->all()))
                                    {{ $answerlog->get_answer[0]->answer_name }}
                                @else
                                    <span style="color: red;">Нет ответа</span>
                                @endif
                            @endswitch
                        </td>
                        <td>
                        {{-- вывод правильных ответов --}}
                            @switch($type)
                                @case('text')
                                    @php
                                        $ans = [];
                                        foreach ($answerlog->question->correct_answers as $gans) {
                                            $ans[] = $gans->answer_name;
                                        }
                                        $str = implode(' / ', $ans);
                                    @endphp

                                    {{ $str }}
                                @break

                                @case('multiple')
                                    @php
                                        $ans = [];
                                        foreach ($answerlog->question->correct_answers as $gans) {
                                            $ans[] = $gans->answer_name;
                                        }
                                        $str = implode(' & ', $ans);
                                    @endphp

                                    {{ $str }}
                                @break

                                @case('single')

                                    @default
                                        {{ $answerlog->question->correct_answers[0]->answer_name }}
                                @endswitch
                            </td>
                            <td>
                                {{ $answerlog->question->mark }}
                            </td>
                            <td
                                @if ($answerlog->answerlog_mark == 0) 
                                    style='background-color: #ffbebe;'
                                @elseif ($answerlog->answerlog_mark < $answerlog->question->mark)
                                    style='background-color: #fff3be;'
                                @else
                                    style='background-color: #bfffbe;' 
                                @endif
                            >
                                <b>{{ $answerlog->answerlog_mark }}</b>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        <table>
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
