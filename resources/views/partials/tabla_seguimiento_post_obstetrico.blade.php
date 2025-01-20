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
                <td>Código de Evento</td>
                <td>{{ $dato->cod_evento }}</td>
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
                <td>Código de Método</td>
                <td>{{ $dato->cod_metodo }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gest_id }}</td>
            </tr>
            <tr>
                <td>Condición de Egreso</td>
                <td>{{ $dato->con_egreso }}</td>
            </tr>
            <tr>
                <td>Fecha de Fallecimiento</td>
                <td>{{ $dato->fec_fallecimiento ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Fecha de Planificación</td>
                <td>{{ $dato->fec_planificacion }}</td>
            </tr>
            <tr>
                <td>Recibió Asesoría Anticonceptiva</td>
                <td>{{ $dato->recib_aseso_anticonceptiva ? 'Sí' : 'No' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>