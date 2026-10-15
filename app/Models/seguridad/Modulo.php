<?php
namespace App\Models\seguridad;

use App\Models\configuracion\Sede;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class Modulo extends Model {
	use SoftDeletes;

	protected $table      = "seguridad.modulo";
	protected $primaryKey = "id";

	protected $fillable = [
		"deleted_at",
		"idempresa",
		"idpadre",
		"descripcion",
		"abreviatura",
		"url",
		"orden",
		"icono",
		"accesos_directo",
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function padre() {
		return $this->belongsTo(Modulo::class, "idpadre");
	}

	public function sede() {
		return $this->belongsTo(Sede::class, 'idempresa');
	}

	//--------------------------------------------------------------------------------------- Menu
	public function getModulo($idpadre = null, $idrole = null, $idempresa = null, $opcion = null) {
		$data  = [];
		$query = static::select("modulo.*")
			->join("seguridad.accesos as a", "a.idmodulo", "modulo.id")
			->whereNull("a.deleted_at")
			->where("a.idrole", $idrole)
			->where("a.idempresa", $idempresa)
			->where("modulo.idpadre", $idpadre)
			->orderBy("modulo.orden")->get();

		if ($opcion == "urls"):
			$urls = "";
			foreach ($query as $item):
				$urls .= $item->url . "|" . $this->getModulo($item->id, $idrole, $idempresa, "urls");
			endforeach;
			return $urls;
		endif;

		foreach ($query as $item):
			$index = true;
			if ($item->idpadre != null AND $item->url != "#"):
				if ($this->getComprobarPermiso($item->url, "index", $idempresa, $idrole) == false):
					$index = false;
				endif;
			endif;

			$value                = [];
			$value['index']       = $index;
			$value['id']          = $item->id;
			$value['idpadre']     = $item->idpadre;
			$value['text']        = $item->descripcion;
			$value['abreviatura'] = $item->abreviatura;
			$value['icon']        = $item->icono;
			$value['url']         = $item->url;
			$value['submenu']     = $this->getModulo($item->id, $idrole, $idempresa);
			$value['urls']        = $this->getModulo($item->id, $idrole, $idempresa, "urls");
			$data[]               = $value;
		endforeach;
		return $data;

	}

	public static function menu() {
		$data      = [];
		$idrole    = auth()->user()->idrole;
		$idempresa = auth()->user()["persona"]->idempresa;
		$query     = static::select("modulo.id", "modulo.descripcion", "modulo.icono")
			->join("seguridad.accesos as a", "a.idmodulo", "modulo.id")
			->whereNull("a.deleted_at")->whereNull("modulo.idpadre")
			->where("a.idrole", $idrole)
			->where("modulo.idempresa", $idempresa)
			->groupBy("modulo.id", "modulo.descripcion", "modulo.icono")
			->orderBy("modulo.orden")->get();

		foreach ($query as $key => $item):
			$value            = [];
			$value['text']    = $item->descripcion;
			$value['icono']   = $item->icono;
			$value['submenu'] = $item->getModulo($item->id, $idrole, $idempresa);
			$value['urls']    = $item->getModulo($item->id, $idrole, $idempresa, "urls");
			$data[]           = $value;
		endforeach;

		if (count($data) == 1):
			if (count($data[0]["submenu"]) == 0):
				return [];
			endif;
		endif;
		return $data;
	}

	//--------------------------------------------------------------------------------------- Accesos
	public function getComprobarPermiso($url = null, $boton = null, $idempresa = null, $idrole = null) {
		$query = Permission::select('r_p.*')
			->join('seguridad.role_permisos as r_p', 'seguridad.permisos.id', '=', 'r_p.permission_id')
			->where('seguridad.permisos.name', $boton . "-" . $url . "_" . $idempresa . "_" . $idrole)
			->where('r_p.role_id', $idrole)->first();
		if ($query):
			return true;
		endif;
		return false;
	}

	public function getTraerFunciones($idmodulo = null, $url = null, $idempresa = null, $idrole = null, $idpadre = null) {
		$children = [];
		foreach (Boton_modulo::with('boton')->where("idmodulo", $idmodulo)->get() as $key => $item):
			$value         = [];
			$value['id']   = "f-" . $idmodulo . "-" . $item["boton"]->funcion . "-" . $idpadre;
			$value['text'] = $item["boton"]->descripcion;
			$value['icon'] = ($item["boton"]->icono == null) ? "fe fe-code" : $item["boton"]->icono;

			if ($idrole != null):
				$value['state']['selected'] = $this->getComprobarPermiso($url, $item["boton"]->funcion, $idempresa, $idrole);
				$value['state']['opened']   = $this->getComprobarPermiso($url, $item["boton"]->funcion, $idempresa, $idrole);
			endif;
			$children[] = $value;
		endforeach;
		return $children;
	}

	public function getTraerModulos($idpadre = null, $idempresa = null, $idrole = null) {
		$children = [];
		foreach (static::where("idpadre", $idpadre)->where("idempresa", $idempresa)->get() as $key => $item):
			$value         = [];
			$value['id']   = "m-" . $item->id;
			$value['text'] = $item->descripcion;
			if ($idrole != null):
				$value['state']['opened'] = true;
			endif;

			if ($this->getTraerModulos($item->id, $idempresa, $idrole) == null):
				$value['children'] = $this->getTraerFunciones($item->id, $item->url, $idempresa, $idrole, $idpadre);
			else:
				$value['children'] = $this->getTraerModulos($item->id, $idempresa, $idrole);
			endif;

			$children[] = $value;
		endforeach;

		if (count($children) == 0):
			return false;
		endif;
		return $children;
	}

	public static function acceso_modulos($idempresa, $idpadre, $idrole) {
		$data = [];
		foreach (static::where("id", $idpadre)->where("idempresa", $idempresa)->orderBy("orden")->get() as $item):
			$value                    = [];
			$value['id']              = "p-" . $item->id;
			$value['text']            = $item->descripcion;
			$value['icon']            = $item->icono;
			$value['state']['opened'] = true;
			$value['children']        = $item->getTraerModulos($item->id, $idempresa, $idrole);
			$data[]                   = $value;
		endforeach;

		if (count($data) == 0):
			return [];
		endif;
		return $data;
	}
}
