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
                <td>Código de Finalización</td>
                <td>{{ $dato->cod_finalizacion }}</td>
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
                <td>Código de Terminación</td>
                <td>{{ $dato->cod_terminacion }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Fecha del Evento</td>
                <td>{{ $dato->fec_evento }}</td>
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