<?php
$profile = [
 'first'=>'Mohammed','last'=>'Khalki','name'=>'Mohammed Khalki',
 'city'=>'Tanger, Maroc','photo'=>'/images/photo-clean.png',
 'github'=>'https://github.com/mohamedkhalki',
 'email'=>'',
 'linkedin'=>'',
];

$projects = [
 ['name'=>'TaxiFinder','type'=>'Application web','desc'=>'Plateforme de recherche de taxis avec réservation, profils conducteurs et expérience utilisateur simple.','stack'=>['HTML','CSS','JavaScript','Node.js'],'demo'=>'','github'=>'','number'=>'01'],
 ['name'=>'Maktabat Iqra','type'=>'Site web','desc'=>'Site vitrine pour une librairie avec catalogue organisé et interface claire.','stack'=>['HTML','CSS','JavaScript'],'demo'=>'','github'=>'','number'=>'02'],
 ['name'=>'Portfolio personnel','type'=>'Portfolio','desc'=>'Site personnel pour présenter mes projets, compétences et ateliers de formation.','stack'=>['PHP','CSS','JavaScript'],'demo'=>'','github'=>'','number'=>'03'],
];

$skills = [
 ['name'=>'Front-end','stack'=>'HTML · CSS · JavaScript · Bootstrap'],
 ['name'=>'Back-end','stack'=>'PHP · Node.js · Python'],
 ['name'=>'Base de données','stack'=>'MySQL · SQL · Modélisation'],
 ['name'=>'Outils','stack'=>'Figma · UML · Git · GitHub'],
];

$modules = [
 'm01' => [
   'code'=>'M01',
   'title'=>'Préparer un projet web',
   'subtitle'=>'Conception & modélisation',
   'intro'=>'Analyse, UML, Figma et préparation d’un projet avant le développement.',
   'groups'=>[
      ['label'=>'Travaux préparatoires','items'=>[
        ['id'=>'uml-exercices','type'=>'Exercices','title'=>'Travaux pratiques UML','summary'=>'Repérer les acteurs, les fonctionnalités et les relations avant de dessiner les diagrammes.','source'=>'https://portfoliofs202.vercel.app/docs/UMLTPs.pdf','deliverables'=>['Diagrammes réalisés par vous','Courte explication des choix de modélisation'],'steps'=>['Analyser le besoin','Choisir les diagrammes utiles','Dessiner vos schémas'],'demo'=>'','submission'=>''],
        ['id'=>'immobilier','type'=>'Atelier','title'=>'Gestion d’une société immobilière','summary'=>'Étude UML d’un système immobilier avec différents diagrammes à préparer.','source'=>'https://portfoliofs202.vercel.app/docs/UML_gestion_immobilier.pdf','deliverables'=>['Diagramme de classes','Cas d’utilisation','Séquences','Activités','Compte rendu PDF'],'steps'=>['Lire l’énoncé','Préparer les diagrammes','Assembler le rendu final'],'demo'=>'','submission'=>''],
        ['id'=>'figma','type'=>'Atelier','title'=>'Initiation Figma','summary'=>'Découverte de Figma et création de premières maquettes d’interface.','source'=>'https://portfoliofs202.vercel.app/docs/Figma.pptx','deliverables'=>['Lien Figma','Captures d’écran','Prototype si demandé'],'steps'=>['Créer les frames','Dessiner les interfaces','Partager le fichier'],'demo'=>'','submission'=>''],
        ['id'=>'quickannonce','type'=>'Mini-projet','title'=>'Application de petites annonces','summary'=>'Préparer l’identité, la structure et le prototype d’une application web.','source'=>'https://portfoliofs202.vercel.app/docs/quickannonces.pdf','deliverables'=>['Maquettes','Modèle de données','Présentation du projet'],'steps'=>['Définir le besoin','Préparer la structure','Finaliser la présentation'],'demo'=>'','submission'=>''],
      ]],
   ],
 ],
 'm02' => [
   'code'=>'M02',
   'title'=>'Gestion de projets & versioning',
   'subtitle'=>'Planification, Agile, Git',
   'intro'=>'Les 7 ateliers liés à la planification, à Agile Scrum, à Git/GitHub et aux outils d’intégration.',
   'groups'=>[
     ['label'=>'Les 7 ateliers','items'=>[
      ['id'=>'gantt','type'=>'Atelier 01','title'=>'Méthodes classiques : PERT & Gantt','summary'=>'Planifier un projet, organiser les tâches et construire un diagramme clair.','source'=>'https://portfoliofs202.vercel.app/docs/At1_gestionprojet.pdf','deliverables'=>['Liste des tâches','PERT','Gantt','Chemin critique'],'steps'=>['Lister les tâches','Identifier les dépendances','Construire PERT et Gantt'],'demo'=>'','submission'=>''],
      ['id'=>'agile','type'=>'Atelier 02','title'=>'Agile Scrum & Sprint','summary'=>'Comprendre les rôles Agile et construire un backlog et un sprint.','source'=>'https://portfoliofs202.vercel.app/docs/At2_gestionprojet.pdf','deliverables'=>['User stories','Product backlog','Sprint backlog'],'steps'=>['Étudier Agile','Créer le backlog','Planifier le sprint'],'demo'=>'','submission'=>''],
      ['id'=>'git-basics','type'=>'Atelier 03','title'=>'Les bases de Git','summary'=>'Initialiser un dépôt, enregistrer des versions et suivre l’historique.','source'=>'https://portfoliofs202.vercel.app/docs/At3_git.pdf','deliverables'=>['Dépôt local','Commits','Historique git'],'steps'=>['Créer un dépôt','Ajouter des fichiers','Faire des commits'],'demo'=>'','submission'=>''],
      ['id'=>'github-team','type'=>'Atelier 04','title'=>'GitHub : travail collaboratif','summary'=>'Travailler en branches et proposer des modifications via Pull Request.','source'=>'https://portfoliofs202.vercel.app/docs/At4_github.pdf','deliverables'=>['Dépôt GitHub','Branches','Pull Requests'],'steps'=>['Créer le dépôt','Travailler en branches','Fusionner les changements'],'demo'=>'','submission'=>''],
      ['id'=>'git-efm','type'=>'Atelier 05','title'=>'Entraînement Git type EFM','summary'=>'S’exercer sur des manipulations Git pour renforcer les bases.','source'=>'https://portfoliofs202.vercel.app/docs/At5_github.pdf','deliverables'=>['Captures des commandes','Notes personnelles'],'steps'=>['Lire les questions','Tester les commandes','Vérifier les résultats'],'demo'=>'','submission'=>''],
      ['id'=>'sprint3','type'=>'Atelier 06','title'=>'Prérequis Sprint 3 : PHP, MySQL & Cloudinary','summary'=>'Préparer une application avec formulaire, base de données et gestion d’images.','source'=>'https://portfoliofs202.vercel.app/docs/At6_github.pdf','deliverables'=>['Formulaire','Backend PHP','Connexion BD','Gestion images'],'steps'=>['Créer le formulaire','Connecter la base','Tester les flux'],'demo'=>'','submission'=>''],
      ['id'=>'sonarqube','type'=>'Atelier 07','title'=>'GitLab CI/CD & SonarQube Cloud','summary'=>'Découvrir l’analyse qualité et documenter les résultats d’une pipeline.','source'=>'https://portfoliofs202.vercel.app/docs/At7_gitlab_sonarqube.pdf','deliverables'=>['Pipeline','Dashboard SonarQube','Compte rendu'],'steps'=>['Configurer le projet','Lancer l’analyse','Documenter les résultats'],'demo'=>'','submission'=>''],
     ]],
   ],
 ],
];

function allAteliers(array $module): array {
  $out = [];
  foreach($module['groups'] as $group){
    foreach($group['items'] as $item){ $out[] = $item; }
  }
  return $out;
}
