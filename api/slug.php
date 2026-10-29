<?php
/**
 * Utilidades de slug para la columna `tours`.`url`.
 * Se incluye desde actualizarTours.php, guardarTours.php y guardarPaquete.php
 * para que la url se genere SIEMPRE con las mismas reglas.
 */

if (!function_exists('generarSlug')) {

	/**
	 * Convierte el nombre de un tour/paquete en un slug para la columna `url`.
	 *   "link de vacaciones"      -> "link-de-vacaciones"
	 *   'link de "vaciones"?'     -> "link-de-vaciones"
	 *   "Tour (2 días) - ¡Cusco!" -> "tour-2-dias-cusco"
	 */
	function generarSlug($texto) {

		// 1. Símbolos que se OMITEN del todo (se borran, no dejan guion)
		$omitir = [
			'?', '(', ')', "'", '"', '¡', '!', '¿',
			',', '.', ':', ';', '/', '\\',
			'*', '+', '@', '#', '%', '&', '=', '<', '>',
			'[', ']', '{', '}', '|', '~', '^', '`',
			'“', '”', '‘', '’', '´', '¨', '·', '…'
		];

		$slug = str_replace($omitir, '', (string) $texto);

		// 2. Tildes / diéresis / ñ
		$acentos = [
			'á'=>'a', 'à'=>'a', 'ä'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a',
			'é'=>'e', 'è'=>'e', 'ë'=>'e', 'ê'=>'e',
			'í'=>'i', 'ì'=>'i', 'ï'=>'i', 'î'=>'i',
			'ó'=>'o', 'ò'=>'o', 'ö'=>'o', 'ô'=>'o', 'õ'=>'o',
			'ú'=>'u', 'ù'=>'u', 'ü'=>'u', 'û'=>'u',
			'ç'=>'c', 'ñ'=>'n',
			'Á'=>'a', 'À'=>'a', 'Ä'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Å'=>'a',
			'É'=>'e', 'È'=>'e', 'Ë'=>'e', 'Ê'=>'e',
			'Í'=>'i', 'Ì'=>'i', 'Ï'=>'i', 'Î'=>'i',
			'Ó'=>'o', 'Ò'=>'o', 'Ö'=>'o', 'Ô'=>'o', 'Õ'=>'o',
			'Ú'=>'u', 'Ù'=>'u', 'Ü'=>'u', 'Û'=>'u',
			'Ç'=>'c', 'Ñ'=>'n'
		];

		$slug = strtolower(strtr($slug, $acentos));

		// 3. Todo lo que no sea letra o número -> un solo guion
		//    (los espacios caen acá: "link de vacaciones" -> "link-de-vacaciones")
		$slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

		// 4. Sin guiones sobrantes en los extremos
		return trim($slug, '-');
	}
}

if (!function_exists('urlUnica')) {

	/**
	 * Devuelve una url libre para `tours`.`url`.
	 *
	 * Se cuentan las url repetidas que ya existen (la propia y sus variantes
	 * url-1, url-2, ...) y, si hay alguna, se devuelve url + '-' + cantidad:
	 *   existe 1 previa  -> "tour-cusco-1"
	 *   existen 3 previas -> "tour-cusco-3"
	 * Si no existe ninguna, se devuelve la url tal cual ("tour-cusco").
	 *
	 * $idExcluir   = id del tour que se está editando (así no se cuenta a sí mismo).
	 *                Al CREAR se pasa 0 para que cuente todos los repetidos.
	 * $soloVisible = true cuenta únicamente los registros con `visible` = 1
	 *                (los que ya ocupan una url publicada).
	 * $urlActual   = url que YA tiene el tour que se edita. Si sigue siendo válida
	 *                para la base, se conserva (así al re-guardar no se renumera).
	 *
	 *   crear:      urlUnica($db, $url, 0,           true)
	 *   actualizar: urlUnica($db, $url, $idDelTour,  true, $urlQueYaTenia)
	 */
	function urlUnica(PDO $db, $slug, $idExcluir = 0, $soloVisible = false, $urlActual = '') {

		// Solo cuentan la url exacta y sus numeradas (url-1, url-2...),
		// no otras url que empiecen igual (ej: "tour-cusco-magico")
		$patron = '/^' . preg_quote($slug, '/') . '(-[0-9]+)?$/';

		// ── 1. Si el tour ya tenía una url válida para esta base, se conserva ──
		//    (evita renumerar cuando se guarda sin cambiar el nombre)
		if ($urlActual !== '' && preg_match($patron, (string) $urlActual)) {

			// Otro registro visible no puede tener ya esa misma url
			$duplicado = $db->prepare(
				"SELECT COUNT(*) FROM `tours` WHERE `url` = ? AND `id` <> ?"
				. ($soloVisible ? " AND `visible` = 1" : "") . ";"
			);
			$duplicado->execute([ $urlActual, $idExcluir ]);

			if ((int) $duplicado->fetchColumn() === 0) return $urlActual;
		}

		// ── 2. Contar las url repetidas que ya existen ──
		$sql = $db->prepare(
			"SELECT `url` FROM `tours`
			 WHERE `id` <> ? AND ( `url` = ? OR `url` LIKE ? )"
			. ($soloVisible ? " AND `visible` = 1" : "")
		);
		$sql->execute([ $idExcluir, $slug, $slug . '-%' ]);

		$existentes = [];
		foreach ($sql->fetchAll(PDO::FETCH_COLUMN) as $urlExistente) {
			if (preg_match($patron, (string) $urlExistente)) {
				$existentes[] = $urlExistente;
			}
		}

		// Si no existe ninguna repetida, se usa la url como está
		if (count($existentes) === 0) return $slug;

		// url + '-' + cantidad de repetidas (y si esa ya está tomada, se sigue)
		$n         = count($existentes);
		$candidato = $slug . '-' . $n;

		while (in_array($candidato, $existentes, true)) {
			$candidato = $slug . '-' . (++$n);
		}

		return $candidato;
	}
}
