## Quiz

Pour installer le projet, suivre les étapes suivantes :

# Installation 

- Démarrer Laragon

- Créer une base de données nommée tp-quiz

- Créer le token jWT_SECRET

- Mettre à jour le fichier .env avec les informations de la base de données et le token

- Ouvrir le terminal de commande dans le dossier racine du projet et effectuer la commande suivante : php artisan migrate

- Récupérer le dossier front de Dmitrii : https://gitlab.bzctoons.net/kopenkinda/front-tp-api

- Dans le dossier front, ouvrir le fichier src/api.js et remplacer la BASE_URL par l'url de l'API

- Dans le dossier front, effectuer npm run dev et ouvrir http://localhost:3000

# Utilisation

Le User 1 sera l'administrateur.

Le site permet :

Pour le visiteur non administrateur :
- La page d'accueil affiche la liste des quizzes disponibles
- En cliquant dessus on peut accéder au quiz.
- Chaque quiz comporte des questions.
- Chaque question comporte une seule bonne réponse que l'utilisateur doit cocher.
- Le score est visible sous forme de pourcentage en allant sur l'onglet Scores.

Pour l'administrateur :
- Dans l'onglet "Admin Panel", il peut :
- créer des quizzes (publiés ou pas),
- ajouter des questions ainsi que des réponses,
- chaque bonne réponse fait gagner des points que l'administrateur peu définir.

- L'admin a accès aux scores de chaque participant pour chacun des quizz via l'onglet Scores.