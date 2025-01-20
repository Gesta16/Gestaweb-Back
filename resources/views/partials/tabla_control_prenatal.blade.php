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
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Edad Gestacional</td>
                <td>{{ $dato->edad_gestacional }}</td>
            </tr>
            <tr>
                <td>Trimestre de Ingreso</td>
                <td>{{ $dato->trim_ingreso }}</td>
            </tr>
            <tr>
                <td>Fecha de Menstruación</td>
                <td>{{ $dato->fec_mestruacion }}</td>
            </tr>
            <tr>
                <td>Fecha de Parto</td>
                <td>{{ $dato->fec_parto }}</td>
            </tr>
            <tr>
                <td>Embarazo Planeado</td>
                <td>{{ $dato->emb_planeado ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Fecha de Anticonceptivo</td>
                <td>{{ $dato->fec_anticonceptivo ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Consulta</td>
                <td>{{ $dato->fec_consulta }}</td>
            </tr>
            <tr>
                <td>Fecha de Control</td>
                <td>{{ $dato->fec_control }}</td>
            </tr>
            <tr>
                <td>Riesgo Reproductivo</td>
                <td>{{ $dato->ries_reproductivo }}</td>
            </tr>
            <tr>
                <td>Fecha de Asesoría</td>
                <td>{{ $dato->fac_asesoria }}</td>
            </tr>
            <tr>
                <td>Usuario que Solicitó</td>
                <td>{{ $dato->usu_solicito }}</td>
            </tr>
            <tr>
                <td>Fecha de Terminación</td>
                <td>{{ $dato->fec_terminacion ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Período Intergenésico</td>
                <td>{{ $dato->per_intergenesico ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Recibió Atención Preconcepcional</td>
                <td>{{ $dato->recibio_atencion_preconcep ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Asistió a Control Prenatal</td>
                <td>{{ $dato->asis_consul_control_precon ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Asistió a Asesoría IVE</td>
                <td>{{ $dato->asis_asesoria_ive ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Tuvo Embarazos Anteriores</td>
                <td>{{ $dato->tuvo_embarazos_antes ? 'Sí' : 'No' }}</td>
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