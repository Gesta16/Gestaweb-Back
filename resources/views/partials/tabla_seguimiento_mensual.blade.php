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
                <td>Código de Seguimiento</td>
                <td>{{ $dato->cod_seguimiento }}</td>
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
                <td>Código de Riesgo</td>
                <td>{{ $dato->cod_riesgo }}</td>
            </tr>
            <tr>
                <td>Código de Controles</td>
                <td>{{ $dato->cod_controles }}</td>
            </tr>
            <tr>
                <td>Código de Diagnóstico</td>
                <td>{{ $dato->cod_diagnostico }}</td>
            </tr>
            <tr>
                <td>Código de Medición</td>
                <td>{{ $dato->cod_medicion }}</td>
            </tr>
            <tr>
                <td>Proceso Gestativo ID</td>
                <td>{{ $dato->proceso_gestativo_id }}</td>
            </tr>
            <tr>
                <td>Fecha de Consulta</td>
                <td>{{ $dato->fec_consulta }}</td>
            </tr>
            <tr>
                <td>Edad Gestacional</td>
                <td>{{ $dato->edad_gestacional }} semanas</td>
            </tr>
            <tr>
                <td>Altura Uterina (CMS)</td>
                <td>{{ $dato->alt_uterina }}</td>
            </tr>
            <tr>
                <td>Trimestre Gestacional</td>
                <td>
                    @if ($dato->trim_gestacional == 1)
                        Primer Trimestre
                    @elseif ($dato->trim_gestacional == 2)
                        Segundo Trimestre
                    @elseif ($dato->trim_gestacional == 3)
                        Tercer Trimestre
                    @else
                        No especificado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Peso [KG]</td>
                <td>{{ $dato->peso }}</td>
            </tr>
            <tr>
                <td>Talla [Metros]</td>
                <td>{{ $dato->talla }}</td>
            </tr>
            <tr>
                <td>Índice de Masa Corporal (IMC)</td>
                <td>{{ $dato->imc }}</td>
            </tr>
            <tr>
                <td>Tensión Arterial Sistólica (TAS)</td>
                <td>{{ $dato->ten_arts }}</td>
            </tr>
            <tr>
                <td>Tensión Arterial Diastólica (TAD)</td>
                <td>{{ $dato->ten_artd }}</td>
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