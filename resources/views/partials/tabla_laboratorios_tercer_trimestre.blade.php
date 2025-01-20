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
                <td>Código de Laboratorio</td>
                <td>{{ $dato->cod_treslaboratorio }}</td>
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
                <td>Hemograma</td>
                <td>{{ $dato->hemograma ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Hemograma</td>
                <td>{{ $dato->fec_hemograma ?? 'No aplica' }}</td>
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
                <td>Prueba de Sífilis</td>
                <td>{{ $dato->pru_sifilis }}</td>
            </tr>
            <tr>
                <td>Fecha de Prueba de Sífilis</td>
                <td>{{ $dato->fec_sifilis }}</td>
            </tr>
            <tr>
                <td>IG Toxoplasma</td>
                <td>{{ $dato->ig_toxoplasma ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Toxoplasma</td>
                <td>{{ $dato->fec_toxoplasma ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Cultivo Rectal</td>
                <td>{{ $dato->cul_rectal ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Fecha de Cultivo Rectal</td>
                <td>{{ $dato->fec_rectal }}</td>
            </tr>
            <tr>
                <td>Fecha de Perfil Biofísico</td>
                <td>{{ $dato->fec_biofisico ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Edad Gestacional</td>
                <td>{{ $dato->edad_gestacional ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Riesgo Biopsicosocial</td>
                <td>{{ $dato->rie_biopsicosocial }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de VIH</td>
                <td>{{ $dato->reali_prueb_rapi_vih_3 ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de Sífilis</td>
                <td>{{ $dato->reali_prueb_trepo_rapi_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de IGM Toxoplasma</td>
                <td>{{ $dato->reali_prueb_igm_toxoplasma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Cultivo Rectal/Vaginal</td>
                <td>{{ $dato->reali_prueb_culti_rect_vagi ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Perfil Biofísico</td>
                <td>{{ $dato->reali_prueb_perfil_biofisico ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Hemograma</td>
                <td>{{ $dato->reali_hemograma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Fecha de Creación</td>
                <td>{{ $dato->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>