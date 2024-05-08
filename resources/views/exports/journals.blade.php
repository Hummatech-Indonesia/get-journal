<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Export Journals</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Kelas</th>
                    <th>Mapel</th>
                    <th>Sakit</th>
                    <th>Izin</th>
                    <th>Alpha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($journals as $journal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $journal->title }}</td>
                    <td>{{ $journal->description }}</td>
                    <td>{{ $journal->classroom->name }}</td>
                    <td>{{ $journal->lesson->name }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
