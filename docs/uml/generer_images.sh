#!/bin/bash
# Script de génération des images UML pour ElPapiro E-commerce
# Utilise l'API PlantUML en ligne pour convertir les fichiers .puml en images

echo "🚀 Génération des diagrammes UML ElPapiro..."
echo "=================================================="

# Créer le dossier images s'il n'existe pas
mkdir -p images

# Fonction pour encoder en base64 et compresser pour PlantUML
generate_image() {
    local puml_file=$1
    local output_name=$2
    
    if [ ! -f "$puml_file" ]; then
        echo "⚠️ Fichier non trouvé: $puml_file"
        return 1
    fi
    
    echo "📝 Traitement de $puml_file..."
    
    # Encoder le fichier pour l'API PlantUML (méthode simple)
    # Note: Cette méthode utilise l'endpoint text de PlantUML
    local url="http://www.plantuml.com/plantuml/png"
    
    # Utiliser curl pour poster le contenu
    if curl -s -X POST \
        -H "Content-Type: text/plain" \
        --data-binary "@$puml_file" \
        "$url" \
        -o "images/${output_name}.png"; then
        echo "✅ Généré: images/${output_name}.png"
        return 0
    else
        echo "❌ Erreur lors de la génération de $puml_file"
        return 1
    fi
}

# Liste des diagrammes à générer
declare -A diagrams=(
    ["diagramme_classes.puml"]="01_diagramme_classes"
    ["diagramme_sequence_checkout.puml"]="02_sequence_checkout"
    ["diagramme_sequence_authentification.puml"]="03_sequence_authentification"
    ["diagramme_sequence_panier.puml"]="04_sequence_panier"
    ["diagramme_composants.puml"]="05_diagramme_composants"
    ["diagramme_activite_ecommerce.puml"]="06_activite_ecommerce"
    ["diagramme_cas_utilisation.puml"]="07_cas_utilisation"
    ["diagramme_etats_commande.puml"]="08_etats_commande"
)

# Compteurs
success_count=0
total_count=${#diagrams[@]}

# Générer chaque diagramme
for puml_file in "${!diagrams[@]}"; do
    output_name="${diagrams[$puml_file]}"
    if generate_image "$puml_file" "$output_name"; then
        ((success_count++))
    fi
done

echo "=================================================="
echo "📊 Résultat: $success_count/$total_count diagrammes générés"
echo "📁 Images sauvegardées dans: $(pwd)/images/"

if [ $success_count -eq $total_count ]; then
    echo "🎉 Tous les diagrammes ont été générés avec succès!"
else
    echo "⚠️ Certains diagrammes n'ont pas pu être générés."
    echo "💡 Vérifiez votre connexion internet et l'accessibilité de plantuml.com"
fi

echo ""
echo "📖 Instructions d'utilisation :"
echo "1. Les images sont dans le dossier 'images/'"
echo "2. Utilisez-les directement dans votre rapport"
echo "3. Format PNG haute résolution"
echo "4. Nommage ordonné pour faciliter l'insertion"