<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Using Spreadsheet Data </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <div>
            <table id="tabel-juara">
                @foreach ($result as $r)
                    <tr>
                        @for ($i = 0; $i < $col; $i++)
                            <td>{{ $r[$i] }}</td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        </div>

        <script></script>
    </body>
</html>
