<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Export Journals</title>
    </head>
    <body>
        <h4>Data Nilai Tugas {{ $assignment->name }}</h4>
        <h4>Kelas {{ $assignment->lesson->classroom->name }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Nilai</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignment->marks as $mark)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mark->classroomStudent->student->name }}</td>
                    <td>{{ $mark->score }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($mark->created_at)->format('d-m-Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
