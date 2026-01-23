import os
import sys
import glob
from PIL import Image

def resource_path(relative_path):
	if hasattr(sys, '_MEIPASS'):
		base_path = sys._MEIPASS
	else:
		base_path = os.path.dirname(os.path.abspath(__file__))

	return os.path.join(base_path, relative_path)

def agregarMarca():
	carpeta_raiz = resource_path('.')
	ruta_logo = resource_path("logo.png")
	ruta_celular = resource_path( "celular.png")
	carpeta_sin_marca = resource_path( "sinmarca")
	carpeta_marcados = resource_path( "marcados")
	print(ruta_logo)
	# Crear carpeta de salida si no existe
	os.makedirs(carpeta_marcados, exist_ok=True)

	# Verificar que existan las imágenes de marca
	if not os.path.exists(ruta_logo):
		print(f"Error: No se encontró logo.png en {carpeta_raiz}")
		input('Presione enter para salir...')
		return
	if not os.path.exists(ruta_celular):
		print(f"Error: No se encontró celular.png en {carpeta_raiz}")
		input('Presione enter para salir...')
		return

	# Cargar imágenes de marca
	try:
		logo = Image.open(ruta_logo).convert("RGBA")
		celular = Image.open(ruta_celular).convert("RGBA")
	except Exception as e:
		print(f"Error cargando imágenes de marca: {e}")
		return

 # Obtener lista de imágenes en la carpeta sinmarca
	extensiones = ['*.jpg', '*.jpeg', '*.png', '*.JPG', '*.JPEG', '*.PNG']
	archivos_imagen = []

	for extension in extensiones:
		archivos_imagen.extend(glob.glob(os.path.join(carpeta_sin_marca, extension)))
		
	if not archivos_imagen:
		print(f"No se encontraron imágenes en {carpeta_sin_marca}")
		input('Presione enter para salir...')
		return
	
	archivos_imagen = list(set(archivos_imagen))

	print(f"Procesando {len(archivos_imagen)} imágenes...")
	
	for ruta_imagen in archivos_imagen:
		try:
			# Abrir imagen base
			imagen_base = Image.open(ruta_imagen).convert("RGBA")
			ancho_base, alto_base = imagen_base.size
			
			# Redimensionar marcas proporcionalmente
			tamaño_max_logo = min(ancho_base, alto_base) // 4
			tamaño_max_celular = min(ancho_base, alto_base) // 4
			
			# Redimensionar logo manteniendo aspecto
			if logo.width > tamaño_max_logo:
				ratio = tamaño_max_logo / logo.width
				nuevo_ancho = int(logo.width * ratio)
				nuevo_alto = int(logo.height * ratio)
				logo_resized = logo.resize((nuevo_ancho, nuevo_alto), Image.Resampling.LANCZOS)
			else:
				logo_resized = logo.copy()
			
			# Redimensionar celular manteniendo aspecto
			if celular.width > tamaño_max_celular:
				ratio = tamaño_max_celular / celular.width
				nuevo_ancho = int(celular.width * ratio)
				nuevo_alto = int(celular.height * ratio)
				celular_resized = celular.resize((nuevo_ancho, nuevo_alto), Image.Resampling.LANCZOS)
			else:
				celular_resized = celular.copy()
			
			# Crear una copia de la imagen base
			imagen_con_marcas = imagen_base.copy()
			
			# Pegar logo en esquina superior izquierda (10px de margen)
			posicion_logo = (20, 20)
			imagen_con_marcas.paste(logo_resized, posicion_logo, logo_resized)
			
			# Pegar celular en esquina inferior derecha (20px de margen)
			pos_x = ancho_base - celular_resized.width - 20
			pos_y = alto_base - celular_resized.height - 20
			posicion_celular = (pos_x, pos_y)
			imagen_con_marcas.paste(celular_resized, posicion_celular, celular_resized)
			
			# Convertir a RGB si es necesario para guardar como WebP
			if imagen_con_marcas.mode == 'RGBA':
				fondo = Image.new('RGB', imagen_con_marcas.size, (255, 255, 255))
				fondo.paste(imagen_con_marcas, mask=imagen_con_marcas.split()[3])
				imagen_con_marcas = fondo
			
			# Generar nombre de archivo de salida
			nombre_archivo = os.path.splitext(os.path.basename(ruta_imagen))[0]
			ruta_salida = os.path.join(carpeta_marcados, f"{nombre_archivo}.webp")
			
			# Guardar como WebP
			imagen_con_marcas.save(ruta_salida, 'WEBP', quality=90)
			
			print(f"✓ Procesado: {os.path.basename(ruta_imagen)} -> {nombre_archivo}.webp")
				
		except Exception as e:
			print(f"✗ Error procesando {os.path.basename(ruta_imagen)}: {e}")
			input("\nPresiona Enter para salir...")


	print(f"\n¡Proceso completado!")
	input("\nPresiona Enter para salir...")
	#print(f"Imágenes guardadas en: {carpeta_marcados}")





#funcion main	
if __name__ == "__main__":
	os.system('clear')

	print(' ============================================')
	print('    PROCESADOR DE IMAGENES CON MARCAS')
	print(' ============================================')
	agregarMarca()