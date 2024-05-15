<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Export Journals</title>
    </head>
    <body>
        <h4>Data Jurnal Kelas {{ $journals[0]->classroom->name }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
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
                    <td>
                        {{ \Carbon\Carbon::parse($journal->date)->format('d-m-Y') }}
                    </td>
                    <td>{{ $journal->lesson->name }}</td>
                    <td>
                        @forelse($journal->sick as $sick)
                        {{ $sick->profile->name }}
                        @empty - @endforelse
                    </td>
                    <td>
                        @forelse($journal->permit as $permit)
                        {{ $permit->profile->name }}
                        @empty - @endforelse
                    </td>
                    <td>
                        @forelse($journal->alpha as $alpha)
                        {{ $alpha->profile->name }}
                        @empty - @endforelse
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
