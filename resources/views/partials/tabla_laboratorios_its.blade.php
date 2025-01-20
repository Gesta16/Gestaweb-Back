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
                <td>Código de ITS</td>
                <td>{{ $dato->cod_its }}</td>
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
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Código de VDRL</td>
                <td>{{ $dato->cod_vdrl }}</td>
            </tr>
            <tr>
                <td>Código de RPR</td>
                <td>{{ $dato->cod_rpr ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>ELISA VIH</td>
                <td>{{ $dato->eli_vih }}</td>
            </tr>
            <tr>
                <td>Fecha de Prueba de VIH</td>
                <td>{{ $dato->fec_vih }}</td>
            </tr>
            <tr>
                <td>Fecha de VDRL</td>
                <td>{{ $dato->fec_vdrl }}</td>
            </tr>
            <tr>
                <td>Fecha de RPR</td>
                <td>{{ $dato->fec_rpr ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Recibió Tratamiento</td>
                <td>{{ $dato->rec_tratamiento }}</td>
            </tr>
            <tr>
                <td>Recibió Tratamiento la Pareja</td>
                <td>{{ $dato->rec_pareja }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba ELISA VIH</td>
                <td>{{ $dato->reali_prueb_elisa_vih ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba No Treponémica VDRL</td>
                <td>{{ $dato->reali_prueb_no_trepo_vdrl_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba No Treponémica RPR</td>
                <td>{{ $dato->reali_prueb_no_trepo_rpr_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>