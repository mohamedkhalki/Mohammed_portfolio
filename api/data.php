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
  'github' => '',   // ex: 'https://github.com/votre-compte'
  'email'  => '',   // ex: 'mohammed@example.com' (laisser vide = non affiché)

  'titre' => ['fr' => 'Développement Web', 'en' => 'Web Development'],
  'bio'   => [
    'fr' => 'Étudiant en développement digital, passionné par la création de sites et d’applications web.',
    'en' => 'Digital development student, passionate about building websites and web applications.',
  ],

  'skills' => ['HTML','CSS','Bootstrap','JavaScript','POO','PHP','MySQL','Python','Git','GitHub'],

  'modules' => [
    [
      'titre' => ['fr' => 'Titre du module 1', 'en' => 'Module 1 title'],
      'tags'  => ['HTML','CSS'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1', 'en' => 'Workshop 1'], 'git' => '', 'pdf' => ''],
        ['titre' => ['fr' => 'Atelier 2', 'en' => 'Workshop 2'], 'git' => '', 'pdf' => ''],
      ],
    ],
    [
      'titre' => ['fr' => 'Titre du module 2', 'en' => 'Module 2 title'],
      'tags'  => ['JavaScript','Git'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1', 'en' => 'Workshop 1'], 'git' => '', 'pdf' => ''],
      ],
    ],
    [
      'titre' => ['fr' => 'Titre du module 3', 'en' => 'Module 3 title'],
      'tags'  => ['PHP','MySQL'],
      'ateliers' => [
        ['titre' => ['fr' => 'Atelier 1', 'en' => 'Workshop 1'], 'git' => '', 'pdf' => ''],
      ],
    ],
  ],

  'projets' => [
    [
      'titre' => ['fr' => 'Projet 1', 'en' => 'Project 1'],
      'desc'  => ['fr' => 'Description à venir.', 'en' => 'Description coming soon.'],
      'tags'  => ['PHP','MySQL'], 'git' => '', 'pdf' => '',
    ],
    [
      'titre' => ['fr' => 'Projet 2', 'en' => 'Project 2'],
      'desc'  => ['fr' => 'Description à venir.', 'en' => 'Description coming soon.'],
      'tags'  => ['HTML','CSS','JavaScript'], 'git' => '', 'pdf' => '',
    ],
  ],
];
