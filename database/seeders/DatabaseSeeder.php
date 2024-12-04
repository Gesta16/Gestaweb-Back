<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartamentoSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(RegimenSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(PoblacionDiferencialSeeder::class);
        $this->call(MetodoFracasoSeeder::class);
        $this->call(RiesgoSeeder::class);
        $this->call(TipoDmSeeder::class);
        $this->call(BiologicoSeeder::class);
        $this->call(HemoclasificacionSeeder::class);
        $this->call(AntibiogramaSeeder::class);
        $this->call(PruebaNoTreponemicaVDRLSeeder::class);
        $this->call(PruebaNoTreponemicaRPRSeeder::class);
        $this->call(NumeroControlesSeeder::class);
        $this->call(DiagnosticoNutricionalMesSeeder::class);
        $this->call(FormaMedicionEdadGestacionalSeeder::class);
        $this->call(NumSesionesCursoPaternidadMaternidadSeeder::class);
        $this->call(TerminacionGestacionSeeder::class);
        $this->call(MetodoAnticonceptivoSeeder::class);
        $this->call(MortalidadPerinatalSeeder::class);
        $this->call(PruebaNoTreponemicaRecienNacidoSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EpsPruebaSeeder::class);











    }
}
