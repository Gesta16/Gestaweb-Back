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
                <td>Código del Recién Nacido</td>
                <td>{{ $dato->cod_recien }}</td>
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
                <td>Tipo de Embarazo</td>
                <td>{{ $dato->tip_embarazo }}</td>
            </tr>
            <tr>
                <td>Número de Nacido</td>
                <td>{{ $dato->num_nacido }}</td>
            </tr>
            <tr>
                <td>Sexo</td>
                <td>{{ $dato->sexo }}</td>
            </tr>
            <tr>
                <td>Peso (gramos)</td>
                <td>{{ $dato->peso }}</td>
            </tr>
            <tr>
                <td>Talla (centímetros)</td>
                <td>{{ $dato->talla }}</td>
            </tr>
            <tr>
                <td>Plan Canguro</td>
                <td>{{ $dato->pla_canguro }}</td>
            </tr>
            <tr>
                <td>IPS Canguro</td>
                <td>{{ $dato->ips_canguro ?? 'No aplica' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="no-data">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>