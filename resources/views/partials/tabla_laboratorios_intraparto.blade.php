<table>
    <thead>
        <tr>
            <th>Campo</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($datos as $dato)
            <tr>
                <td>Código de Intraparto</td>
                <td>{{ $dato->cod_intraparto }}</td>
            </tr>
            <tr>
                <td>ID del Operador</td>
                <td>{{ $dato->id_operador }}</td>
            </tr>
            <tr>
                <td>ID del Usuario</td>
                <td>{{ $dato->id_usuario }}</td>
            </tr>
            <tr>
                <td>Código de VDRL</td>
                <td>{{ $dato->cod_vdrl }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Prueba de Sífilis</td>
                <td>{{ $dato->pru_sifilis }}</td>
            </tr>
            <tr>
                <td>Fecha de Prueba de Sífilis</td>
                <td>{{ $dato->fec_sifilis }}</td>
            </tr>
            <tr>
                <td>Fecha de VDRL</td>
                <td>{{ $dato->fec_vdrl }}</td>
            </tr>
            <tr>
                <td>Recibió Tratamiento para Sífilis</td>
                <td>{{ $dato->rec_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Fecha de Tratamiento</td>
                <td>{{ $dato->fec_tratamiento ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Prueba de VIH</td>
                <td>{{ $dato->pru_vih }}</td>
            </tr>
            <tr>
                <td>Fecha de Prueba de VIH</td>
                <td>{{ $dato->fec_vih }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de Sífilis</td>
                <td>{{ $dato->reali_prueb_trepo_rapi_sifilis_intra ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba No Treponémica VDRL</td>
                <td>{{ $dato->reali_prueb_no_trepo_vdrl_sifilis_intra ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de VIH</td>
                <td>{{ $dato->reali_prueb_rapi_vih ? 'Sí' : 'No' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>