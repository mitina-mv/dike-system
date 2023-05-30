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
        <h3>Результаты тестирования: {{ $test->test_name }}</h3>

        @if ($web)
            <a href="<?= route('report.generate_testlog', $testlog->id) ?>" target="_blank"
                rel="noopener noreferrer" class='btn btn-primary'>
                сохранить в PDF
            </a>
        @endif

        <div style="margin-bottom: 15px;">
            <div>
                <b>Студент: </b>{{ $student->user_lastname }} {{ $student->user_firstname }}
                {{ $student->user_patronymic }}
            </div>
            <div>
                <b>Группа: </b>{{ $student->studgroup->studgroup_name }}
            </div>
            <div>
                <b>Дата тестирования: </b> <?= (new DateTime($testlog->testlog_date))->format('Y-m-d H:m') ?>
            </div>
            <div>
                <b>Оценка за тест:
                </b><?= isset($testlog->testlog_mark) ? "{$testlog->testlog_mark} из 100" : 'не сдано' ?>
            </div>

        </div>

        <table>
            @foreach ($questions as $key => $answerlog)
                <tr>
                    <th colspan="3" style="text-align:left; background-color: #ebeced;">
                        {{ $key + 1 }}. {{ $answerlog->question->question_text }}
                    </th>
                </tr>
                <tr>
                    <td>Выбранный ответ</td>
                    <td>Правильный ответ</td>
                    <td>Оценка</td>
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
                                    {{ $answerlog->get_answer->all()->answer_name }}
                                @elseif (isset($testlog->uncorrect_answers) && isset($testlog->uncorrect_answers[$answerlog->question->id]))
                                    {{ $testlog->uncorrect_answers[$answerlog->question->id] }}
                                @else
                                    <span style="color: red;">Нет ответа</span>
                                @endif
                            @break

                            @case('multiple')
                                @if (!empty($answerlog->get_answer->all()))
                                    @foreach ($answerlog->get_answer as $gans)
                                        {{ $gans->answer_name }},
                                    @endforeach
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
                            <td
                                @if ($answerlog->answerlog_mark == 0) style='background-color: #ffbebe;'
                        @elseif ($answerlog->answerlog_mark < $answerlog->question->mark)
                            style='background-color: #fff3be;'
                        @else
                            style='background-color: #bfffbe;' @endif>
                                <b>{{ $answerlog->answerlog_mark }}</b> </td>
                        </tr>
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
