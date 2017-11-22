<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Fila de execuções do site programada
        $schedule->command('queue:work')->everyMinute();
        // Atualiza Ratings dos animes e mangás do site todos os dias.
        $schedule->call(function () {
        DB::table('animes')->join('lista_usuarios_animes','animes.id','=','lista_usuarios_animes.id_anime')
        //->where('animes.id','=', 'lista_usuarios_animes.id_anime')
            ->update([
                'animes.totaln' => DB::raw('(select sum(MiX_lista_usuarios_animes.voto) from MiX_lista_usuarios_animes where 
                MiX_lista_usuarios_animes.id_anime = MiX_animes.id  AND (MiX_lista_usuarios_animes.voto != 0) )')
                ,'animes.totalv' => DB::raw('(select count(voto) from MiX_lista_usuarios_animes where 
                MiX_lista_usuarios_animes.id_anime = MiX_animes.id AND (MiX_lista_usuarios_animes.voto != 0) )')]);
            })->timezone('America/Recife')->dailyAt('04:00'); //daily
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
