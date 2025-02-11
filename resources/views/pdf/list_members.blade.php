<style>
    body { font-family: DejaVu Sans, sans-serif; }
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg th{font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
    .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
    .tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<?php $line = 1; ?>
<table class="tg">
    <tr>
        <th class="tg-c3ow">№</th>
        <th class="tg-c3ow">ПІБ / Назва групи</th>
        <th class="tg-c3ow">Кількість учасників</th>
        <th class="tg-c3ow">ІНН учасника</th>
        <th class="tg-c3ow">Номер свідотства про народження учасника</th>
        <th class="tg-c3ow">Домашня адреса учасника</th>
    </tr>
    @foreach ($data as $item)
        @if($item['application_type_id'] == 1 || $item['application_type_id'] == 2)
        <tr>
            <td class="tg-0pky">{{ $line++ }}</td>
            <td class="tg-0pky">
                @foreach ($item['soloDuet'] as $soloDuet)
                    {{ $soloDuet['surname'] }} {{ $soloDuet['name'] }} {{ $soloDuet['patronymic'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">{{ count($item['soloDuet']) }}</td>
            <td class="tg-0pky">
                @foreach ($item['soloDuet'] as $soloDuet)
                    {{ $soloDuet['parent_name'] }} {{ $soloDuet['parent_surname'] }} {{ $soloDuet['parent_patronymic'] }} {{ $soloDuet['in'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">
                @foreach ($item['soloDuet'] as $soloDuet)
                    {{ $soloDuet['passport_data'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">
                @foreach ($item['soloDuet'] as $soloDuet)
                    {{ $soloDuet['member_address'] }} <br>
                @endforeach
            </td>
        </tr>
        @else
        <tr>
            <td class="tg-0pky">{{ $line++ }}</td>
            <td class="tg-0pky">
                {{ $item['group']['name'] }} Керівник: <br>
                @foreach ($item['teachers'] as $teachers)
                    {{ $teachers['teacher_surname'] }} {{ $teachers['teacher_name'] }} {{ $teachers['teacher_patronymic'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">{{ $item['group']['count_people'] }}</td>

            <td class="tg-0pky">
                @foreach ($item['teachers'] as $teachers)
                    {{ $teachers['teacher_in'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">
                @foreach ($item['teachers'] as $teachers)
                    {{ $teachers['teacher_passport_data'] }} <br>
                @endforeach
            </td>
            <td class="tg-0pky">
                @foreach ($item['teachers'] as $teachers)
                    {{ $teachers['teacher_address'] }} <br>
                @endforeach
            </td>

        </tr>
        @endif
    @endforeach
</table>
