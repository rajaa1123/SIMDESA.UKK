#!/usr/bin/env python3
"""
SIMDESA Digital Signature Generator
Generates RSA digital signatures with QR codes for Kepala Desa approval
"""
# pip install qrcode[pil] cryptography
import qrcode
import base64
import datetime
import json
import os
import sys
import argparse
from pathlib import Path
from cryptography.hazmat.primitives import hashes, serialization
from cryptography.hazmat.primitives.asymmetric import padding, rsa


def ensure_keys_exist(private_key_path):
    """Generate RSA keys if they don't exist"""
    if not os.path.exists(private_key_path):
        print(f"Generating new RSA key pair at {private_key_path}...", file=sys.stderr)
        
        # Generate new RSA private key
        private_key = rsa.generate_private_key(
            public_exponent=65537,
            key_size=2048
        )
        
        # Save private key
        os.makedirs(os.path.dirname(private_key_path), exist_ok=True)
        with open(private_key_path, "wb") as f:
            f.write(private_key.private_bytes(
                encoding=serialization.Encoding.PEM,
                format=serialization.PrivateFormat.PKCS8,
                encryption_algorithm=serialization.NoEncryption()
            ))
        
        # Save public key
        public_key = private_key.public_key()
        public_key_path = private_key_path.replace('_private.pem', '_public.pem')
        with open(public_key_path, "wb") as f:
            f.write(public_key.public_bytes(
                encoding=serialization.Encoding.PEM,
                format=serialization.PublicFormat.SubjectPublicKeyInfo
            ))
        
        print(f"Keys generated successfully!", file=sys.stderr)
    else:
        print(f"Using existing keys at {private_key_path}", file=sys.stderr)


def ttd_digital_qr(surat_id: str, kades_nik: str, kades_name: str,
                   private_key_path: str = "storage/keys/kades_private.pem",
                   output_dir: str = "storage/app/public/qr"):
    """
    Menandatangani surat secara digital lalu menghasilkan QR-Code
    yang berisi signature + metadata.
    
    Args:
        surat_id: ID permohonan/surat
        kades_nik: NIK Kepala Desa
        kades_name: Nama Kepala Desa
        private_key_path: Path to private key
        output_dir: Output directory for QR codes
    
    Returns:
        dict: Contains signature, qr_path, and timestamp
    """
    # Ensure keys exist
    ensure_keys_exist(private_key_path)
    
    os.makedirs(output_dir, exist_ok=True)

    # 1. Load private key Kades
    with open(private_key_path, "rb") as f:
        private_key = serialization.load_pem_private_key(f.read(), password=None)

    # 2. Buat payload (minimal data agar QR tetap kecil)
    payload = {
        "surat_id": str(surat_id),
        "nik": kades_nik,
        "nama": kades_name,
        "timestamp": datetime.datetime.utcnow().isoformat() + "Z"
    }
    payload_bytes = json.dumps(payload, sort_keys=True).encode()

    # 3. Tanda-tangan digital
    signature = private_key.sign(
        payload_bytes,
        padding.PSS(
            mgf=padding.MGF1(hashes.SHA256()),
            salt_length=padding.PSS.MAX_LENGTH
        ),
        hashes.SHA256()
    )

    # 4. Gabungkan payload + signature lalu base64 agar QR-nya kecil
    bundle = {
        "p": payload,
        "s": base64.b64encode(signature).decode()
    }
    qr_data = base64.b64encode(json.dumps(bundle).encode()).decode()

    # 5. Generate QR Code
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_L,
        box_size=10,
        border=4,
    )
    qr.add_data(qr_data)
    qr.make(fit=True)
    
    img = qr.make_image(fill_color="black", back_color="white")
    qr_filename = f"{surat_id}_ttd.png"
    qr_path = os.path.join(output_dir, qr_filename)
    img.save(qr_path)

    # Return as JSON for PHP to parse
    result = {
        'signature': bundle['s'],
        'qr_path': f'qr/{qr_filename}',
        'timestamp': payload['timestamp'],
        'success': True
    }
    
    # Output JSON to stdout (PHP will read this)
    print(json.dumps(result))
    return result


def main():
    """Main entry point for command line usage"""
    parser = argparse.ArgumentParser(
        description='Generate digital signature with QR code for SIMDESA'
    )
    parser.add_argument('--surat_id', required=True, help='ID Permohonan/Surat')
    parser.add_argument('--nik', required=True, help='NIK Kepala Desa')
    parser.add_argument('--nama', required=True, help='Nama Kepala Desa')
    parser.add_argument('--private_key', default='storage/keys/kades_private.pem',
                       help='Path to private key (default: storage/keys/kades_private.pem)')
    parser.add_argument('--output_dir', default='storage/app/public/qr',
                       help='Output directory for QR codes')
    
    args = parser.parse_args()
    
    try:
        result = ttd_digital_qr(
            surat_id=args.surat_id,
            kades_nik=args.nik,
            kades_name=args.nama,
            private_key_path=args.private_key,
            output_dir=args.output_dir
        )
        sys.exit(0)  # Success
    except Exception as e:
        error_result = {
            'success': False,
            'error': str(e)
        }
        print(json.dumps(error_result))
        sys.exit(1)  # Error


if __name__ == '__main__':
    main()
