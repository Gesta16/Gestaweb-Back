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
                <td>Código de Seguimiento Complementario</td>
                <td>{{ $dato->cod_segcomplementario }}</td>
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
                <td>Código de Sesiones</td>
                <td>{{ $dato->cod_sesiones }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Fecha de Nutrición</td>
                <td>{{ $dato->fec_nutricion }}</td>
            </tr>
            <tr>
                <td>Fecha de Ginecología</td>
                <td>{{ $dato->fec_ginecologia }}</td>
            </tr>
            <tr>
                <td>Fecha de Psicología</td>
                <td>{{ $dato->fec_psicologia }}</td>
            </tr>
            <tr>
                <td>Fecha de Odontología</td>
                <td>{{ $dato->fec_odontologia ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Inasistencia a Seguimiento</td>
                <td>{{ $dato->ina_seguimiento ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Causa de Inasistencia</td>
                <td>{{ $dato->cau_inasistencia ?? 'No aplica' }}</td>
            </tr>
            <tr>
                <td>Asistió a Nutricionista</td>
                <td>{{ $dato->asistio_nutricionista ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Asistió a Ginecología</td>
                <td>{{ $dato->asistio_ginecologia ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Asistió a Psicología</td>
                <td>{{ $dato->asistio_psicologia ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td>Asistió a Odontología</td>
                <td>{{ $dato->asistio_odontologia ? 'Sí' : 'No' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>