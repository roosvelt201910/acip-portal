#!/usr/bin/env python3
"""
Script de subida FTP para ACIP Portal
Sube todos los archivos del proyecto al servidor vía FTPS explícito
"""

import ftplib
import os
import sys
import ssl
from pathlib import Path

# Configuración FTP
FTP_HOST = "ftp.iespacip.edu.pe"
FTP_PORT = 21
FTP_USER = "master@iespacip.edu.pe"
FTP_PASS = "5dU3r6mC6km(ivTp"
REMOTE_ROOT = ""  # La raíz FTP YA ES public_html en cPanel

# Directorio local del proyecto
LOCAL_ROOT = Path(__file__).parent

# Archivos/carpetas a EXCLUIR de la subida
EXCLUDE = {
    ".git", ".DS_Store", "ftp_upload.py", ".gitignore",
    "__pycache__", ".idea", ".vscode", "node_modules",
    "*.log", ".ftpquota"
}

def should_exclude(name):
    """Verifica si un archivo/carpeta debe excluirse"""
    if name in EXCLUDE:
        return True
    if name.startswith('.'):
        return True
    return False

def make_remote_dir(ftp, remote_dir):
    """Crea directorio remoto si no existe"""
    try:
        ftp.mkd(remote_dir)
        print(f"  📁 Creado: {remote_dir}")
    except ftplib.error_perm as e:
        if "550" in str(e):  # Ya existe
            pass
        else:
            print(f"  ⚠️  No se pudo crear {remote_dir}: {e}")

def upload_file(ftp, local_path, remote_path):
    """Sube un archivo al servidor FTP"""
    try:
        with open(local_path, 'rb') as f:
            ftp.storbinary(f'STOR {remote_path}', f)
        size = os.path.getsize(local_path)
        print(f"  ✅ {remote_path} ({size/1024:.1f} KB)")
        return True
    except Exception as e:
        print(f"  ❌ Error subiendo {remote_path}: {e}")
        return False

def upload_directory(ftp, local_dir, remote_dir):
    """Sube recursivamente un directorio"""
    # Crear directorio remoto
    make_remote_dir(ftp, remote_dir)
    
    uploaded = 0
    failed = 0
    
    try:
        entries = sorted(os.listdir(local_dir))
    except PermissionError:
        return 0, 0
    
    for entry in entries:
        if should_exclude(entry):
            print(f"  ⏭️  Saltando: {entry}")
            continue
        
        local_path = os.path.join(local_dir, entry)
        remote_path = f"{remote_dir}/{entry}"
        
        if os.path.isdir(local_path):
            print(f"\n📂 Procesando carpeta: {remote_path}")
            u, f = upload_directory(ftp, local_path, remote_path)
            uploaded += u
            failed += f
        else:
            if upload_file(ftp, local_path, remote_path):
                uploaded += 1
            else:
                failed += 1
    
    return uploaded, failed

def main():
    print("=" * 60)
    print("🚀 ACIP Portal - Subida FTP")
    print("=" * 60)
    print(f"Servidor: {FTP_HOST}:{FTP_PORT}")
    print(f"Usuario:  {FTP_USER}")
    print(f"Destino:  {REMOTE_ROOT}")
    print(f"Origen:   {LOCAL_ROOT}")
    print("=" * 60)
    
    # Crear contexto SSL para FTPS explícito
    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE  # Ignorar cert inválido del servidor
    
    print("\n🔌 Conectando al servidor FTP...")
    
    try:
        ftp = ftplib.FTP_TLS(context=ctx)
        ftp.connect(FTP_HOST, FTP_PORT, timeout=30)
        print(f"✅ Conectado: {ftp.getwelcome()[:60]}")
        
        ftp.login(FTP_USER, FTP_PASS)
        ftp.prot_p()  # Proteger canal de datos con TLS
        print("✅ Autenticado correctamente\n")
        
        # Verificar directorio destino
        try:
            ftp.cwd(REMOTE_ROOT)
            print(f"✅ Directorio destino: {REMOTE_ROOT}")
        except ftplib.error_perm:
            print(f"⚠️  {REMOTE_ROOT} no existe, usando raíz /")
            REMOTE_ROOT_USED = "/"
        
        print("\n📤 Iniciando subida de archivos...\n")
        
        total_up, total_fail = upload_directory(ftp, str(LOCAL_ROOT), REMOTE_ROOT)
        
        print("\n" + "=" * 60)
        print(f"✅ Subidos:  {total_up} archivos")
        print(f"❌ Fallidos: {total_fail} archivos")
        print("=" * 60)
        
        ftp.quit()
        print("\n🎉 ¡Subida completada!")
        
    except ftplib.all_errors as e:
        print(f"\n❌ Error FTP: {e}")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Error inesperado: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()
