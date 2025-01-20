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
                <td>{{ $dato->cod_doslaboratorio }}</td>
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
                <td>Prueba Oral</td>
                <td>{{ $dato->pru_oral ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Prueba Uno</td>
                <td>{{ $dato->pru_uno }}</td>
            </tr>
            <tr>
                <td>Prueba Dos</td>
                <td>{{ $dato->pru_dos }}</td>
            </tr>
            <tr>
                <td>Fecha de Prueba</td>
                <td>{{ $dato->fec_prueba }}</td>
            </tr>
            <tr>
                <td>Reporte de Citología</td>
                <td>{{ $dato->rep_citologia }}</td>
            </tr>
            <tr>
                <td>Fecha de Citología</td>
                <td>{{ $dato->fec_citologia }}</td>
            </tr>
            <tr>
                <td>IG Toxoplasma</td>
                <td>{{ $dato->ig_toxoplasma }}</td>
            </tr>
            <tr>
                <td>Fecha de Toxoplasma</td>
                <td>{{ $dato->fec_toxoplasma }}</td>
            </tr>
            <tr>
                <td>Prueba de Avidez</td>
                <td>{{ $dato->pru_avidez }}</td>
            </tr>
            <tr>
                <td>Fecha de Avidez</td>
                <td>{{ $dato->fec_avidez }}</td>
            </tr>
            <tr>
                <td>Laboratorio de Toxoplasmosis</td>
                <td>{{ $dato->tox_laboratorio ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Toxoplasmosis</td>
                <td>{{ $dato->fec_toxoplasmosis ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Hemoglobina Gruesa</td>
                <td>{{ $dato->hem_gruesa ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Hemoparásito</td>
                <td>{{ $dato->fec_hemoparasito ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Coombs Cualitativo</td>
                <td>{{ $dato->coo_cualitativo ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Coombs</td>
                <td>{{ $dato->fec_coombs ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Ecografía</td>
                <td>{{ $dato->fec_ecografia ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Edad Gestacional</td>
                <td>{{ $dato->eda_gestacional ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Riesgo Biopsicosocial</td>
                <td>{{ $dato->rie_biopsicosocial }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de VIH</td>
                <td>{{ $dato->reali_prueb_rapi_vih ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de Sífilis</td>
                <td>{{ $dato->real_prueb_trep_rap_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Citología</td>
                <td>{{ $dato->reali_citologia ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de Avidez IG G</td>
                <td>{{ $dato->reali_prueb_avidez_ig_g ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de Toxoplasmosis IG A</td>
                <td>{{ $dato->reali_prueb_toxoplasmosis_ig_a ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de Hemoparásito</td>
                <td>{{ $dato->reali_prueb_hemoparasito ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Coombs Indirecto Cuantitativo</td>
                <td>{{ $dato->reali_prueb_coombis_indi_cuanti ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Ecografía Obstétrica Detallada</td>
                <td>{{ $dato->reali_eco_obste_detalle_anato ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó IGM Toxoplasma</td>
                <td>{{ $dato->real_igm_toxoplasma_2 ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Oral</td>
                <td>{{ $dato->real_prueb_oral ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Oral 1</td>
                <td>{{ $dato->real_prueb_oral_1 ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Oral 2</td>
                <td>{{ $dato->real_prueb_oral_2 ? 'Sí' : 'No' }}</td>
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