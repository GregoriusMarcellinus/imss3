<table>
    <thead>
        <tr>

            <th>Nomor</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Tanggal Masuk</th>
            <th>Status Pegawai</th>
            <th>Rekrutmen</th>
            <th>Domisili</th>
            <th>Rekening Mandiri</th>
            <th>Rekening BSI</th>
            <th>SK Pengangkatan / Kontrak</th>
            <th>Tanggal Pengangkatan / Kontrak</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $key => $d)
            @php
                $data = $d->toArray();
            @endphp
            
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $d->nip }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->tanggal_masuk }}</td>
                <td>{{ $d->status_pegawai }}</td>
                <td>{{ $d->rekrutmen }}</td>
                <td>{{ $d->domisili }}</td>
                <td>{{ $d->rekening_mandiri }}</td>
                <td>{{ $d->rekening_bsi }}</td>
                <td>{{ $d->sk_pengangkatan_atau_kontrak }}</td>
                <td>{{ $d->tanggal_pengangkatan_atau_akhir_kontrak }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>