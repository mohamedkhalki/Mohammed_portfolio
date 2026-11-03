# Atelier 6 — Projet original corrigé

Le dossier original `atelier-stagiaires.zip` a été inspecté. Il a été corrigé dans `public/ateliers/m02/stagiaires-demo/atelier6-stagiaires-corrige.zip` (code uniquement, sans identifiants ni Git interne).

Les problèmes corrigés comprennent :
- `photo` / `date_inscription` remplacés par `photo_url` / `created_at`, conformément à la base MySQL créée.
- Connexion PDO SSL compatible PHP 8.3, avec CA Aiven.
- Inscriptions et affichage des données réelles réservés à l'administrateur.
- Formulaire de démonstration publiquement **modifiable**, mais sans transfert de données personnelles ni photo.
- Frontend et backend séparés pour éviter l'exposition de fichiers privés.

Aucun secret n'est intégré. Changez les mots de passe ou tokens déjà partagés avant de déployer.

Le Portfolio V5 Glass garde ses CSS et ses ateliers précédents. La nouvelle démonstration n'effectue aucun enregistrement MySQL réel; seules les actions authentifiées de l'administrateur le font, après configuration.
