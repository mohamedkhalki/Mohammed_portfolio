# Atelier 6 — PHP, MySQL (Aiven) et Cloudinary

## Inclus dans ce portfolio

- `/atelier?m=m02&a=sprint3` : présentation de l'atelier 6 dans le Portfolio V5 Glass.
- `/atelier6` : démonstration publique (uniquement des données fictives, aucune donnée privée).
- `/atelier6?mode=admin` : formulaire d'enregistrement et liste MySQL, réservé à l'administrateur.
- `api/atelier6.php` : backend PHP, authentification HTTP Basic, validation des fichiers (JPG/PNG/WEBP, 3 Mo), envoi Cloudinary, enregistrement MySQL par requête préparée.
- `public/css/atelier6.css` : styles propres à l'atelier (le CSS du portfolio n'est pas changé).

## Sécurité AVANT le déploiement

**Révoquez et renouvelez la clé secrète API Cloudinary et le mot de passe Aiven transmis avec les fichiers sources.** Ne les publiez pas dans GitHub, les ZIP de partage ou les captures d'écran. Les fichiers `config.local.php` et `cloudinary.local.php` sont ignorés par Git et sont absents des archives distribuées.

### Connexion locale (Windows / WAMP)

Copiez uniquement sur votre ordinateur, dans la **racine du portfolio**, vos fichiers locaux `config.local.php` et `cloudinary.local.php`, mis à jour avec vos **nouveaux** identifiants. Assurez-vous que le chemin `ssl_ca` vers le certificat Aiven existe et que `curl` et `fileinfo` sont activés.

Dans CMD :

```cmd
cd /d "%USERPROFILE%\Desktop\Mohammed_portfolio-git"
set ATELIER6_LOCAL_DEV=1
"C:\wamp64\bin\php\php8.3.28\php.exe" -S 127.0.0.1:8000 -t public router.php
```

Ouvrez `http://127.0.0.1:8000/atelier6?mode=admin` pour tester localement. L'accès en écriture n'est autorisé sans mot de passe que depuis `localhost` / `127.0.0.1` sur le serveur de développement ; pas sur le site public.

### Configuration Vercel (Production / Preview)

Dans le projet Vercel, allez dans **Settings > Environment Variables** et définissez :

| Variable | Rôle |
|---|---|
| `ATELIER6_ADMIN_PASSWORD` | Mot de passe d'administration fort (au moins 16 caractères) |
| `ATELIER6_DB_HOST` | Host MySQL Aiven |
| `ATELIER6_DB_PORT` | Port Aiven |
| `ATELIER6_DB_NAME` | Nom de la base, ex. `atelier6_stagiaires` |
| `ATELIER6_DB_USER` | Nom d'utilisateur Aiven |
| `ATELIER6_DB_PASSWORD` | Nouveau mot de passe Aiven |
| `ATELIER6_DB_CA_BASE64` | Certificat CA Aiven (`ca.pem`) encodé en Base64 |
| `ATELIER6_CLOUD_NAME` | Cloud name Cloudinary |
| `ATELIER6_CLOUD_KEY` | Clé API Cloudinary |
| `ATELIER6_CLOUD_SECRET` | Nouveau secret API Cloudinary |

Pour encoder la CA sous Windows, sans la partager dans le chat :

```cmd
powershell -NoProfile -Command "[Convert]::ToBase64String([IO.File]::ReadAllBytes('%USERPROFILE%\Desktop\ca\ca.pem')) | Set-Clipboard"
```

Collez le contenu du presse-papiers comme valeur de `ATELIER6_DB_CA_BASE64` dans Vercel. Après avoir enregistré les variables, redéployez. Accédez ensuite à `/atelier6?mode=admin` avec le nom d'utilisateur **admin** et votre mot de passe d'administration (via HTTPS). Les données personnelles des stagiaires ne sont pas affichées dans la démonstration publique.

La configuration doit être vérifiée sur votre déploiement ; cette livraison n'affirme pas qu'un accès à Aiven ou un téléversement Cloudinary a été testé depuis Vercel.

**Avant de publier**, obtenez le consentement des personnes pour les données et images utilisées. Préférez des données fictives pour une démonstration de cours.
