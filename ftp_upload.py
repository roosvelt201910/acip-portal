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
    """Sube un directorio completo recursivamente"""
    # Asegurar que el directorio remoto existe
    parts = remote_dir.strip('/').split('/')
    current = ""
    for part in parts:
        current += "/" + part
        try:
            ftp.mkd(current)
            print(f"  📂 Creado: {current}")
        except:
            pass # Ya existe o error

    try:
        ftp.cwd(remote_dir)
    except:
        return

    uploaded = 0
    failed = 0

    for entry in os.listdir(local_dir):
        if should_exclude(entry): continue
        
        local_path = os.path.join(local_dir, entry)
        remote_path = f"{remote_dir}/{entry}"
        
        if os.path.isdir(local_path):
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
    print("🚀 ACIP Portal - Despliegue Profesional cPanel")
    print("=" * 60)
    print(f"Servidor: {FTP_HOST}")
    print(f"Usuario:  {FTP_USER}")
    print("=" * 60)
    
    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE
    
    try:
        ftp = ftplib.FTP_TLS(context=ctx)
        ftp.connect(FTP_HOST, FTP_PORT, timeout=30)
        ftp.login(FTP_USER, FTP_PASS)
        ftp.prot_p()
        print("✅ Conectado y autenticado\n")

        # 1. Subir TODO el proyecto dentro de public_html para asegurar funcionamiento
        print("📤 Subiendo proyecto a /public_html...")
        
        # Carpetas de sistema
        for folder in ['app', 'config', 'includes', 'storage']:
            local_path = os.path.join(LOCAL_ROOT, folder)
            if os.path.exists(local_path):
                upload_directory(ftp, local_path, f"/public_html/{folder}")

        # Contenido de public (assets, etc)
        public_local_path = os.path.join(LOCAL_ROOT, 'public')
        if os.path.exists(public_local_path):
            for entry in os.listdir(public_local_path):
                if should_exclude(entry): continue
                local_entry_path = os.path.join(public_local_path, entry)
                if os.path.isdir(local_entry_path):
                    upload_directory(ftp, local_entry_path, f"/public_html/{entry}")
                else:
                    upload_file(ftp, local_entry_path, f"/public_html/{entry}")

        print("\n" + "=" * 60)
        print("🎉 ¡Despliegue completado en public_html!")
        print("🌐 Revisa: https://iespacip.edu.pe")
        print("=" * 60)
        
        ftp.quit()
        
    except Exception as e:
        print(f"\n❌ Error: {e}")
        sys.exit(1)


if __name__ == "__main__":
    main()
