<?php
namespace App\Providers;

use App\Models\seguridad\Boton;
use App\Models\seguridad\Modulo;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	public function register() {
		//
	}
	public function boot() {
		if (env('FORCE_HTTPS', false)) {URL::forceScheme('https');}

		Carbon::setLocale(config('app.locale'));
		setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');

		View::composer(['layouts.sidebar'], function ($view) {
			$view->with('menu', (new Modulo)->menu());
		});

		View::composer(['extras.botones'], function ($view) {
			$view->with('boton', Boton::where("es_boton", true)->orderBy("orden", "ASC")->get());
		});

		View::composer(['extras.cabecera'], function ($view) {
			$view->with('btn_filtro', Boton::where('funcion', "filtro")->first());
		});
	}
}
