# 📋 DIAGRAMME DE CAS D'UTILISATION - ElPapiro E-commerce

## 🎯 **DESCRIPTION GÉNÉRALE**

Le diagramme de cas d'utilisation identifie **tous les acteurs** du système ElPapiro et leurs **interactions avec les fonctionnalités**. Il présente une vue d'ensemble des **34 cas d'utilisation** organisés en **7 modules fonctionnels** avec **4 types d'acteurs** et leurs **permissions hiérarchiques**.

---

## 👥 **ACTEURS DU SYSTÈME**

### **1. Visiteur (Non connecté)**
- **Rôle :** Utilisateur anonyme naviguant sur le site
- **Permissions :** Consultation, recherche, panier temporaire
- **Objectif :** Découverte produits + conversion en client

### **2. Client Connecté (User)**
- **Rôle :** Utilisateur inscrit et authentifié
- **Permissions :** Hérite du Visiteur + commandes + profil
- **Objectif :** Achat et suivi de commandes

### **3. Employé (Staff)**
- **Rôle :** Personnel de l'entreprise
- **Permissions :** Hérite du Client + gestion opérationnelle
- **Objectif :** Traitement des commandes et gestion quotidienne

### **4. Administrateur (Admin)**
- **Rôle :** Gestionnaire système complet
- **Permissions :** Hérite du Staff + administration complète
- **Objectif :** Configuration système et supervision

---

## 🔧 **MODULES FONCTIONNELS DÉTAILLÉS**

### **📦 MODULE CATALOGUE (5 cas d'utilisation)**
```
UC01 - Naviguer Catalogue
UC02 - Rechercher Produits  
UC03 - Filtrer par Catégorie
UC04 - Voir Détail Produit
UC05 - Consulter Stock
```
**Acteurs concernés :** Tous (public)

### **🛒 MODULE PANIER (5 cas d'utilisation)**
```
UC06 - Ajouter au Panier
UC07 - Modifier Quantité
UC08 - Supprimer du Panier  
UC09 - Vider Panier
UC10 - Gérer Favoris
```
**Acteurs concernés :** Visiteur (session) + Client (BDD)

### **🔐 MODULE AUTHENTIFICATION (5 cas d'utilisation)**
```
UC11 - S'inscrire
UC12 - Se Connecter
UC13 - Se Déconnecter
UC14 - Réinitialiser Mot de Passe
UC15 - Gérer Profil
```
**Acteurs concernés :** Visiteur → Client

### **📋 MODULE COMMANDE (5 cas d'utilisation)**
```
UC16 - Passer Commande
UC17 - Choisir Mode Paiement
UC18 - Suivre Commandes
UC19 - Annuler Commande
UC20 - Confirmer Réception
```
**Acteurs concernés :** Client connecté

### **⚙️ MODULE GESTION PRODUITS (5 cas d'utilisation)**
```
UC21 - Créer Produit
UC22 - Modifier Produit
UC23 - Supprimer Produit
UC24 - Gérer Stock
UC25 - Gérer Catégories
```
**Acteurs concernés :** Staff + Admin

### **📊 MODULE GESTION COMMANDES (4 cas d'utilisation)**
```
UC26 - Traiter Commandes
UC27 - Valider Paiement
UC28 - Gérer Livraisons
UC29 - Générer Rapports
```
**Acteurs concernés :** Staff + Admin

### **🔧 MODULE ADMINISTRATION (5 cas d'utilisation)**
```
UC30 - Gérer Personnels
UC31 - Configurer Système
UC32 - Gérer Publicités
UC33 - Analyser Statistiques
UC34 - Sauvegarder Données
```
**Acteurs concernés :** Admin uniquement

### **🌐 SERVICES SYSTÈME (4 cas d'utilisation)**
```
UC35 - Traiter Paiement CinetPay
UC36 - Envoyer Email Confirmation
UC37 - Envoyer Notification WhatsApp
UC38 - Gérer Sessions Panier
```
**Acteurs concernés :** Système automatique

---

## 🔗 **RELATIONS ENTRE CAS D'UTILISATION**

### **Relations Include (<<include>>)**
- **UC16 (Passer Commande)** include :
  - UC35 (Traiter Paiement)
  - UC36 (Envoyer Email)
  - UC37 (Envoyer WhatsApp)
  - UC38 (Gérer Sessions)

- **UC06 (Ajouter Panier)** include :
  - UC38 (Gérer Sessions)

- **UC12 (Se Connecter)** include :
  - UC38 (Transfert Panier)

### **Relations Extend (<<extend>>)**
- **UC06 (Ajouter Panier)** extend UC12 (Se Connecter)
  - *Condition :* Si utilisateur non connecté
  
- **UC16 (Passer Commande)** extend UC15 (Gérer Profil)
  - *Condition :* Mise à jour informations client
  
- **UC18 (Suivre Commandes)** extend UC20 (Confirmer Réception)
  - *Condition :* Si commande livrée

---

## 📊 **MATRICE DES PERMISSIONS**

| Cas d'Utilisation | Visiteur | Client | Staff | Admin |
|-------------------|----------|--------|-------|-------|
| **Catalogue (UC01-05)** | ✅ | ✅ | ✅ | ✅ |
| **Panier (UC06-10)** | ✅ | ✅ | ✅ | ✅ |
| **Auth (UC11-15)** | ✅ | ✅ | ✅ | ✅ |
| **Commande (UC16-20)** | ❌ | ✅ | ✅ | ✅ |
| **Gestion Produits (UC21-25)** | ❌ | ❌ | ✅ | ✅ |
| **Gestion Commandes (UC26-29)** | ❌ | ❌ | ✅ | ✅ |
| **Administration (UC30-34)** | ❌ | ❌ | ❌ | ✅ |

---

## 🚀 **GÉNÉRATION DE L'IMAGE**

### **ÉTAPES SIMPLES :**

1. **Aller sur :** https://www.plantuml.com/plantuml/uml/

2. **Choisir une version :**
   - **Version Détaillée :** Copier le contenu de `diagramme_cas_utilisation_detaille.puml`
   - **Version Simple :** Copier le contenu de `diagramme_cas_utilisation_simple.puml`

3. **Coller** dans l'éditeur PlantUML

4. **Cliquer** "Submit"

5. **Télécharger** l'image PNG (haute résolution)

6. **Nommer** : `diagramme_cas_utilisation.png`

---

## 📝 **ANALYSE POUR VOTRE RAPPORT**

### **Points Clés à Mentionner :**

#### **🎯 Couverture Fonctionnelle**
- **34 cas d'utilisation** couvrent l'intégralité du système
- **7 modules** organisent logiquement les fonctionnalités
- **4 acteurs** avec permissions granulaires

#### **🏗️ Architecture Scalable**
- **Héritage des rôles** : Permissions croissantes
- **Modularité** : Ajout facile de nouveaux modules
- **Services externes** : Intégrations découplées

#### **🔒 Sécurité Intégrée**
- **Contrôle d'accès** : Chaque UC a ses acteurs autorisés
- **Authentification** : Module dédié avec réinitialisation
- **Audit trail** : Traçabilité des actions par rôle

#### **🌐 Intégrations Métier**
- **Paiement** : CinetPay intégré au processus commande
- **Communication** : Email + WhatsApp automatisés
- **Multi-canal** : Support visiteurs + clients connectés

---

## 🎓 **UTILISATION EN SOUTENANCE**

### **Présentation Orale :**

1. **Commencer** par les acteurs (4 types + hiérarchie)
2. **Présenter** les modules (7 groupes fonctionnels)
3. **Expliquer** les relations include/extend
4. **Détailler** la matrice des permissions
5. **Conclure** sur la couverture complète

### **Questions Probables :**
- **"Pourquoi cette organisation modulaire ?"**
  → Facilite maintenance et évolution
  
- **"Comment gérez-vous les permissions ?"**
  → Middleware Laravel + héritage des rôles
  
- **"Quelles sont les intégrations externes ?"**
  → CinetPay (paiement) + WhatsApp (notifications)

### **Points de Différenciation :**
- **Panier intelligent** (connecté/invité)
- **Notifications multi-canal** (Email + WhatsApp)
- **Gestion stock temps réel**
- **Interface multi-rôles** (3 dashboards)

---

## ✨ **VALEUR AJOUTÉE**

Ce diagramme démontre :
- **Vision globale** du système
- **Analyse fonctionnelle** complète  
- **Maîtrise UML** professionnelle
- **Conception orientée utilisateur**

**🎉 Parfait pour impressionner votre jury de soutenance !**