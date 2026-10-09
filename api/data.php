<?php
/*
 * SEUL FICHIER À MODIFIER pour le contenu.
 * - Les textes peuvent être une simple chaîne ('Texte') ou bilingues ['fr'=>'…','en'=>'…'].
 * - "git" = lien GitHub complet. "pdf" = lien ou fichier, ex: '/docs/atelier1.pdf'
 *   (mettre le fichier dans public/docs/). Laisser vide '' = bouton « Bientôt ».
 */
return [
  'nom'    => 'Mohammed Khalki',
  'age'    => 19,
  'ville'  => 'Tanger',
  'github' => 'https://github.com/mohamedkhalki',
  'email'  => '',   // ex: 'mohammed@example.com' (laisser vide = non affiché)

  'titre' => ['fr' => 'Développement Web', 'en' => 'Web Development'],
  'bio'   => [
    'fr' => 'Étudiant en développement digital, passionné par la création de sites et d’applications web.',
    'en' => 'Digital development student, passionate about building websites and web applications.',
  ],

  'skills' => ['HTML','CSS','Bootstrap','JavaScript','POO','PHP','MySQL','Python','Node.js','Git','GitHub'],

  // TODO : remplacer les titres des modules et ateliers par les vrais noms de la formation
  // Pour chaque atelier : 'git' => lien du dépôt GitHub, 'pdf' => '/docs/nom.pdf' (fichier dans public/docs/)
  'modules' => [
    [
      'titre' => ['fr' => 'Module 1 : Pages web (HTML/CSS)', 'en' => 'Module 1: Web pages (HTML/CSS)'],
      'tags'  => ['HTML','CSS','Bootstrap'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1 : Structure d’une page HTML', 'en' => 'Workshop 1: HTML page structure'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 2 : Mise en forme avec CSS', 'en' => 'Workshop 2: Styling with CSS'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 3 : Mise en page responsive avec Bootstrap', 'en' => 'Workshop 3: Responsive layout with Bootstrap'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 4 : Formulaire d’inscription', 'en' => 'Workshop 4: Registration form'], 'git' => '', 'pdf' => ''],
      ],
    ],
    [
      'titre' => ['fr' => 'Module 2 : JavaScript et Git', 'en' => 'Module 2: JavaScript and Git'],
      'tags'  => ['JavaScript','Git','GitHub'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1 : Variables, conditions et fonctions', 'en' => 'Workshop 1: Variables, conditions and functions'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 2 : Manipulation du DOM', 'en' => 'Workshop 2: DOM manipulation'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 3 : Versionner avec Git et GitHub', 'en' => 'Workshop 3: Version control with Git and GitHub'], 'git' => '', 'pdf' => ''],
      ],
    ],
    [
      'titre' => ['fr' => 'Module 3 : Bases de données (M106)', 'en' => 'Module 3: Databases (M106)'],
      'tags'  => ['MySQL','Merise','SQL'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1 : Conception Merise (MCD et MLD)', 'en' => 'Workshop 1: Merise design (ERD and logical model)'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 2 : Création de la base (DDL et DCL)', 'en' => 'Workshop 2: Creating the database (DDL and DCL)'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 3 : Requêtes SELECT', 'en' => 'Workshop 3: SELECT queries'], 'git' => '', 'pdf' => ''],
      ],
    ],
    [
      'titre' => ['fr' => 'Module 4 : PHP et MySQL', 'en' => 'Module 4: PHP and MySQL'],
      'tags'  => ['PHP','MySQL'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1 : Connexion PHP / MySQL', 'en' => 'Workshop 1: PHP / MySQL connection'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 2 : Authentification (login)', 'en' => 'Workshop 2: Authentication (login)'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 3 : InfoShop, gestion de produits (CRUD)', 'en' => 'Workshop 3: InfoShop, product management (CRUD)'], 'git' => '', 'pdf' => ''],
      ],
    ],
  ],

  'projets' => [
    [
      'titre' => ['fr' => 'TaxiFinder (TaxiGo)', 'en' => 'TaxiFinder (TaxiGo)'],
      'desc'  => [
        'fr' => 'Application web de réservation de taxis pour Tanger (petits et grands taxis) : carte en temps réel, chat, notation des chauffeurs, partage de course, assistant IA, tableau de bord admin et interface multilingue (AR, FR, EN, ES, DE).',
        'en' => 'Ride-hailing web app for Tangier (petit and grand taxis): live map, chat, driver ratings, shared rides, AI assistant, admin dashboard and a multilingual interface (AR, FR, EN, ES, DE).',
      ],
      'tags'  => ['Node.js','Express','MongoDB','Socket.IO','Leaflet','JWT','Groq AI'],
      'git'   => '', 'pdf' => '',
    ],
    [
      'titre' => ['fr' => 'Maktabat Iqra', 'en' => 'Maktabat Iqra'],
      // TODO : adapter la description et les technologies à ton vrai projet
      'desc'  => [
        'fr' => 'Site web de la librairie « Iqra » : catalogue de livres et gestion des produits.',
        'en' => 'Website for the “Iqra” bookstore: book catalogue and product management.',
      ],
      'tags'  => ['HTML','CSS','JavaScript'],
      'git'   => '', 'pdf' => '',
    ],
  ],
];
