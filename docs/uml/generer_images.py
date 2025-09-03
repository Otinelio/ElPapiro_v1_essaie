#!/usr/bin/env python3
"""
Script de génération automatique des images UML pour ElPapiro E-commerce
Utilise l'API PlantUML pour convertir les fichiers .puml en images PNG

Usage: python generer_images.py
"""

import os
import requests
import base64
import zlib
from pathlib import Path

def encode_plantuml(puml_content):
    """Encode le contenu PlantUML pour l'API"""
    # Compression zlib + base64 encoding pour PlantUML
    compressed = zlib.compress(puml_content.encode('utf-8'))
    encoded = base64.b64encode(compressed).decode('ascii')
    
    # Conversion en format PlantUML (remplacements spéciaux)
    encoded = encoded.replace('+', '-').replace('/', '_')
    return encoded

def generate_diagram_image(puml_file, output_dir):
    """Génère une image PNG à partir d'un fichier .puml"""
    
    # Lire le contenu du fichier
    with open(puml_file, 'r', encoding='utf-8') as f:
        puml_content = f.read()
    
    # Encoder pour l'API PlantUML
    encoded = encode_plantuml(puml_content)
    
    # URL de l'API PlantUML
    url = f"http://www.plantuml.com/plantuml/png/{encoded}"
    
    try:
        # Requête vers l'API
        response = requests.get(url, timeout=30)
        response.raise_for_status()
        
        # Nom du fichier de sortie
        base_name = Path(puml_file).stem
        output_file = output_dir / f"{base_name}.png"
        
        # Sauvegarder l'image
        with open(output_file, 'wb') as f:
            f.write(response.content)
        
        print(f"✅ Généré: {output_file}")
        return True
        
    except requests.RequestException as e:
        print(f"❌ Erreur pour {puml_file}: {e}")
        return False

def main():
    """Génère toutes les images UML"""
    
    # Dossiers
    current_dir = Path(__file__).parent
    output_dir = current_dir / "images"
    
    # Créer le dossier de sortie
    output_dir.mkdir(exist_ok=True)
    
    # Liste des fichiers .puml
    puml_files = [
        "diagramme_classes.puml",
        "diagramme_sequence_checkout.puml", 
        "diagramme_sequence_authentification.puml",
        "diagramme_sequence_panier.puml",
        "diagramme_composants.puml",
        "diagramme_activite_ecommerce.puml",
        "diagramme_cas_utilisation.puml",
        "diagramme_etats_commande.puml"
    ]
    
    print("🚀 Génération des diagrammes UML ElPapiro...")
    print("=" * 50)
    
    success_count = 0
    total_count = len(puml_files)
    
    # Générer chaque diagramme
    for puml_file in puml_files:
        file_path = current_dir / puml_file
        
        if file_path.exists():
            if generate_diagram_image(file_path, output_dir):
                success_count += 1
        else:
            print(f"⚠️ Fichier non trouvé: {puml_file}")
    
    print("=" * 50)
    print(f"📊 Résultat: {success_count}/{total_count} diagrammes générés")
    print(f"📁 Images sauvegardées dans: {output_dir}")
    
    if success_count == total_count:
        print("🎉 Tous les diagrammes ont été générés avec succès!")
    else:
        print("⚠️ Certains diagrammes n'ont pas pu être générés.")
        print("💡 Vérifiez votre connexion internet et l'accessibilité de plantuml.com")

if __name__ == "__main__":
    main()