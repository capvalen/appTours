# setup_exe.py
import PyInstaller.__main__
import os

# Obtener la ruta del script principal
script_path = os.path.join(os.getcwd(), "marca.py")

# Configurar opciones de PyInstaller
PyInstaller.__main__.run([
    script_path,
    '--onefile',  # Un solo archivo .exe
    '--noconsole',  # Sin ventana de consola (opcional, si quieres GUI)
    '--name=ProcesadorImagenes',  # Nombre del ejecutable
    '--icon=logo.ico',  # Icono personalizado (opcional)
    '--add-data=logo.png;.',  # Incluir logo.png
    '--add-data=celular.png;.',  # Incluir celular.png
])