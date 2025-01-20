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
                <td>{{ $dato->cod_laboratorio }}</td>
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
                <td>Código de Hemoclasificación</td>
                <td>{{ $dato->cod_hemoclasifi }}</td>
            </tr>
            <tr>
                <td>Código de Antibiograma</td>
                <td>{{ $dato->cod_antibiograma ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Fecha de Hemoclasificación</td>
                <td>{{ $dato->fec_hemoclasificacion }}</td>
            </tr>
            <tr>
                <td>Laboratorio de Hemograma</td>
                <td>{{ $dato->hem_laboratorio }}</td>
            </tr>
            <tr>
                <td>Fecha de Hemograma</td>
                <td>{{ $dato->fec_hemograma }}</td>
            </tr>
            <tr>
                <td>Glicemia</td>
                <td>{{ $dato->gli_laboratorio }}</td>
            </tr>
            <tr>
                <td>Fecha de Glicemia</td>
                <td>{{ $dato->fec_glicemia }}</td>
            </tr>
            <tr>
                <td>Antígeno</td>
                <td>{{ $dato->ant_laboratorio }}</td>
            </tr>
            <tr>
                <td>Fecha de Antígeno</td>
                <td>{{ $dato->fec_antigeno }}</td>
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
                <td>Urocultivo</td>
                <td>{{ $dato->uro_laboratorio }}</td>
            </tr>
            <tr>
                <td>Fecha de Urocultivo</td>
                <td>{{ $dato->fec_urocultivo }}</td>
            </tr>
            <tr>
                <td>Fecha de Antibiograma</td>
                <td>{{ $dato->fec_antibiograma ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>IG Rubéola</td>
                <td>{{ $dato->ig_rubeola ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Rubéola</td>
                <td>{{ $dato->fec_rubeola ?? 'No aplica' }}</td>
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
                <td>IGM Toxoplasma</td>
                <td>{{ $dato->igm_toxoplamas ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de IGM Toxoplasma</td>
                <td>{{ $dato->fec_igmtoxoplasma ?? 'No aplica' }}</td>
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
                <td>Prueba de Antígenos</td>
                <td>{{ $dato->pru_antigenos }}</td>
            </tr>
            <tr>
                <td>Fecha de Antígenos</td>
                <td>{{ $dato->fec_antigenos }}</td>
            </tr>
            <tr>
                <td>ELISA Recombinante</td>
                <td>{{ $dato->eli_recombinante }}</td>
            </tr>
            <tr>
                <td>Fecha de ELISA Recombinante</td>
                <td>{{ $dato->fec_recombinante }}</td>
            </tr>
            <tr>
                <td>Coombs Cuantitativo</td>
                <td>{{ $dato->coo_cuantitativo }}</td>
            </tr>
            <tr>
                <td>Fecha de Coombs</td>
                <td>{{ $dato->fec_coombs }}</td>
            </tr>
            <tr>
                <td>Fecha de Ecografía</td>
                <td>{{ $dato->fec_ecografia }}</td>
            </tr>
            <tr>
                <td>Edad Gestacional</td>
                <td>{{ $dato->eda_gestacional }}</td>
            </tr>
            <tr>
                <td>Riesgo Biopsicosocial</td>
                <td>{{ $dato->rie_biopsicosocial }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de VIH</td>
                <td>{{ $dato->real_prueb_rapi_vih ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Rápida de Sífilis</td>
                <td>{{ $dato->reali_prueb_trepo_rapid_sifilis ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Urocultivo</td>
                <td>{{ $dato->realizo_urocultivo ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Antibiograma</td>
                <td>{{ $dato->realizo_antibiograma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba ELISA Anti-Total</td>
                <td>{{ $dato->real_prueb_eliza_anti_total ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba ELISA Anti-Recombinante</td>
                <td>{{ $dato->real_prueb_eliza_anti_recomb ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba Coombs Indirecto Cuantitativo</td>
                <td>{{ $dato->real_prueb_coombis_indi_cuanti ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Ecografía Obstétrica</td>
                <td>{{ $dato->real_eco_obste_tamizaje ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Hemograma</td>
                <td>{{ $dato->real_hemograma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Glicemia</td>
                <td>{{ $dato->real_glicemia ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de Antígenos</td>
                <td>{{ $dato->real_antigenos ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de IG Toxoplasma</td>
                <td>{{ $dato->real_ig_toxoplasma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de IGM Toxoplasma</td>
                <td>{{ $dato->real_igm_toxoplasma ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de IG Rubéola</td>
                <td>{{ $dato->real_ig_rubeola ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Realizó Prueba de Hemoparásito</td>
                <td>{{ $dato->real_hemoparasito ? 'Sí' : 'No' }}</td>
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