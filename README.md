# Portfolio – Mohammed Khalki

PHP (Vercel) · FR/EN · Modules → Ateliers → Correction / Téléchargement · Projets avec tags

## Structure
```
api/data.php      ← SEUL fichier à modifier (contenu)
api/index.php     ← pages (accueil, module, projets) + bascule FR/EN
public/css/style.css   ← design bleu (variables :root en haut)
public/images/photo.jpg ← (optionnel) photo de Mohammed
public/docs/      ← PDF des ateliers/projets
vercel.json       ← routes /, /module, /projets
router.php        ← test en local
```

## Tester en local
    php -S localhost:8000 -t public router.php

## Déployer sur Vercel
Pousser le dossier sur GitHub, puis « Import Project » dans Vercel (aucune config à ajouter).

## Modifier le contenu
- Textes : `api/data.php` (chaîne simple, ou `['fr'=>'…','en'=>'…']` pour le bilingue).
- Ajouter un module / atelier / projet : copier un bloc existant dans le tableau.
- Lien GitHub / PDF vide = bouton « Bientôt ». PDF : `'pdf'=>'/docs/atelier1.pdf'`.
- Photo : déposer `public/images/photo.jpg` (sinon les initiales « MK » s'affichent).
- Couleurs : changer les variables `--a`, `--blue-900`, `--navy` dans `style.css`.
