# Utilisation du SuperOt
*Auteur : Benoit Bouchaud*

Le site superOt à pour vocation de rester un builder pour les sites raccourci.
Il doit rester le plus général possible tout en servant de modèle avancé pour simplifier l'intégration des sites.


## Thèmes

SuperOt est composé de 2 thèmes : le **woody-theme** et le **site-theme**
### Base Theme
Il est le thème parent du **site-theme** et ne doit **JAMAIS** être activé ou modifié lors de l'intégration d'un site.
Il doit absoluement être le thème activé si vous voulez apporter des modifications aux champs ACF partagés sur les sites
Il a son propre dépot : [git@gitlab.raccourci.dev:wordpress-plugins/woody-theme.git](git@gitlab.raccourci.dev:wordpress-plugins/woody-theme.git)
Il est basé sur le framework **foundation6** (https://foundation.zurb.com/sites/docs/)
### Site Theme
C'est le thème qui doit être activé lors de l'intégration d'un site
Il n'est que l'extension du **woody-theme** et ne doit comporter que les modifications spécifique au site en cours d'intégration. Pour une modification générale, passer sur le site superOt
**Important** : utiliser le site-theme sur SuperOt pour faire du js ou du css

## Groupes de champs ACF
L'architecture des pages de superOt est basée sur le plugin ACF Pro, qui nous permet de créer des groupes de champs de différents types, affichés sur les pages en fonctions de paramètres (type de page, modèle de page, taxonomie, ...)
[Plus d'infos sur ACF Pro](https://www.advancedcustomfields.com/pro/)
### Synchronisation
Lors de la première installation de votre site, synchroniser les groupes de champs en allant sur /wp/wp-admin/edit.php?post_type=acf-field-group, onglet synchroniser.
Synchronisez les champs dont vous avez besoin pour votre site.
La synchronisation se fait grâce au dossier acf-json présent dans le woody-theme. Ce dossier est mis à jour à chaque modification des groupes de champ.
**Important** : vous ne devez **JAMAIS** modifier un groupe de champ lorsque le **site-theme** est activé => ces modifications seront écrasées lors des synchronisations futures.
### Actions / Filtres
Le plugin ACF fournit énormément de méthodes pour surcharger les champs et paramètres de base.
### Création de groupes / Nomenclature
Les slugs (noms systèmes) des champs sont conçus pour matcher avec la libraire Woody (templates twig, voir le paragaphe Woody, the templating factory).
#### Voici la nomenclature à respecter lors de la création de champs :
|Champ|Slug  |
|--|--|
|Titre|``title``|
|Slogan|``slogan``|
|Texte de contenu|``text``|
|Images de galerie|``gallery_items``|
|Image|``img``|
|Format d'image|``img_size``|
|Afficher en plein écran|``display_fullwidth``|
|Lien / Bouton|``link``|
|Séléction de contenu|``content_selection``|
|Vidéo|``movie``|
|Fichier|``file``|
|Nom / Libellé|``label``|
|Auteur / Signature|``signature``|
|Iframe / Code html|``html_code``|
|Modèle/ Template woody des **blocks**|``woody_tpl``|
|Modèle/ Template woody des **cartes**|``woody_card_tpl``|
|Modèle/ Template woody des **grilles**|``woody_grid_tpl``|
|Champ répéteur|``repeater``|



[Voir les ressources](https://www.advancedcustomfields.com/resources/)

### Pages d'options
Le plugin permet aussi de créer des pages d'options (administration) en utilisant ses propres champs grâce aux fonctions ``acf_add_options_page`` et ``acf_add_options_sub_page``.
https://www.advancedcustomfields.com/resources/options-page/

## Timber => the Twig option
SuperOt utilise le plugin [**Timber**](https://github.com/timber/timber) qui nous permet d'écrire nos templates en [Twig](https://twig.symfony.com/doc/2.x/).
Les fichiers page.php, front-page.php, ... ne sont donc pas destinés au templating mais à la création des contextes Twig

## Woody, the templating factory
Woody est une librairie basée sur le framework Foundation6 qui fournit des "parts" de templates twig.
La librairie évolue régulièrement pour fournir de nouvelles mises en page aux éléments des sites.
### Créer un nouveau template Woody
Les templates Woody sont rangés en différentes catégories et doivent respecter une arborescence et une nomenclature bien précise, détaillée ci-dessous.
#### Blocks

>  Ils correspondent aux layouts du champ flexible ACF "Element de
> contenu".

 1 block = 1 dossier **layout_slug** contenant y dossiers **tpl_x** contenant eux même **layout_slug.tpl_x.tiwg** + **thumbnail.tpl_x.jpg**
#### Cards

> Ce sont les vignettes de listes

1 card = 1 dossier **tpl_x** contenant **card.tpl_x.tiwg** + **thumbnail.tpl_x.jpg**
#### Grids

> Ce sont les grilles de mise en pages utilisées pour les listes de
> **cards**, les éléments de **blocks**, les éléments de page d'accueil, ...

1 card = 1 dossier **tpl_x** contenant **grid.tpl_x.tiwg** + **thumbnail.tpl_x.jpg**
