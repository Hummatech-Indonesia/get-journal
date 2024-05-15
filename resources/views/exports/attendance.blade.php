<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Export Journals</title>
    </head>
    <body>
        <h4>Data Absensi</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classroomStudents as $classroomStudent)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $classroomStudent->student->name }}</td>
                    <td>{{ $mark->score }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
