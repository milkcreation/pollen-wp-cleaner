<?php

return [
    /**
     * Personnalisation de l'entrée de menu "Wordpress" de la barre d'administration.
     * @var array
     */
    'admin_bar_menu_logo'                     => [],

    /**
     * Personnalisation du texte du pied de page de l'interface d'administration.
     * @var string
     */
    'admin_footer_text'                       => '',

    /**
     * Désactivation de la prise en charge des commentaires.
     * @var bool
     */
    'disable_comment'                         => false,

    /**
     * Désactivation de la prise en charge de l'intégration des contenus fournis par les service tiers (Youtube, Facebook, Twitter ...)
     * @var bool
     */
    'disable_embed'                           => false,

    /**
     * Désactivation de la prise en charge de l'affichage des Emojis.
     * @var bool
     */
    'disable_emoji'                           => false,

    /**
     * Désactivation de la prise en charge des meta tags de Wordpress.
     * @var bool
     */
    'disable_meta_tag'                        => false,

    /**
     * Désactivation du type de post article (post).
     * @var bool
     */
    'disable_post'                            => false,

    /**
     * Désactivation de la prise en charge de la categorie du type de post article (post).
     * @var bool
     */
    'disable_post_category'                   => false,

    /**
     * Désactivation de la prise en charge des mot-clefs (etiquette) du type de post article (post).
     * @var bool
     */
    'disable_post_tag'                        => false,

    /**
     * Désactivation de la prise en charge de préchargement des librairies CDN.
     * @var bool
     */
    'disable_dns_prefetch'                    => false,

    /**
     * Désactivation de la prise en charge de l'Api Rest Wordpress (webservices).
     * @var bool
     */
    'disable_rest_api'                        => false,

    /**
     * Nettoyage des entrées de menu de la barre d'administration.
     * ex. ['wp_logo', 'about', 'wporg', 'documentation', 'support-forums', 'feedback', 'site-name', 'view-site',
     * 'updates', 'comments', 'new-content', 'my-account', 'disable_post', 'disable_post_category', 'disable_post_tag',
     * 'disable_comment']
     * @var string[]
     */
    'remove_admin_bar_menu'                   => [],

    /**
     * Suppression des éléments du tableau de bord.
     * ex. ['recent_comments', 'incoming_links', 'plugins', 'recent_drafts', 'activity', 'primary', 'secondary',
     * 'right_now', 'quick_press']
     * @var string[]
     */
    'remove_dashboard_meta_box'               => [],

    /**
     * Suppression des banières de présentation du tableau de bord.
     * ex. ['try_gutenberg', 'welcome']
     * @var string[]
     */
    'remove_dashboard_panel'                  => [],

    /**
     * Suppression des boîtes de saisie du type de post article (post).
     * ex. ['authordiv' => 'normal', 'commentstatusdiv' => 'normal', 'commentsdiv' => 'normal',
     * 'pageparentdiv' => 'side', 'postcustom' => 'normal', postimagediv' => 'normal', 'revisionsdiv' => 'normal',
     * 'slugdiv' => 'normal', 'submitdiv' => 'side']
     * @var array
     */
    'remove_meta_box_post'                    => [],

    /**
     * Suppression des boîtes de saisie du type de post page.
     * ex. ['authordiv' => 'normal', 'commentstatusdiv' => 'normal', 'commentsdiv' => 'normal',
     * 'pageparentdiv' => 'side', 'postcustom' => 'normal', 'postimagediv' => 'normal', 'revisionsdiv' => 'normal',
     * 'slugdiv' => 'normal', 'submitdiv' => 'side']
     * @var array
     */
    'remove_meta_box_page'                    => [],

    /**
     * Suppression des boîtes de saisie d'un type de {{post_type}}.
     * ex. ['authordiv' => 'normal', 'commentstatusdiv' => 'normal', 'commentsdiv' => 'normal',
     * 'pageparentdiv' => 'side', 'postcustom' => 'normal', 'postimagediv' => 'normal', 'revisionsdiv' => 'normal',
     * 'slugdiv' => 'normal', 'submitdiv' => 'side']
     *
     * @var array
     */
    'remove_meta_box_{{ post_type }}'         => [],

    /**
     * Nettoyage des entrées de menu de l'interface d'administration.
     * ex. ['dashboard', 'posts', 'media', 'pages', 'comments', 'appearence', 'plugins', 'users', 'tools', 'settings']
     * alt. ['index.php', 'edit.php', 'upload.php', 'edit.php?post_type=page', 'edit-comments.php', 'themes.php',
     * 'plugins.php', 'users.php', 'tools.php', 'options-general.php']
     * @var string[]
     */
    'remove_menu'                             => [],

    /**
     * Suppression de support des fonctionnalités du type de post article (post).
     * ex. ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions',
     * 'post-formats']
     * @var string[]
     */
    'remove_support_post'                     => [],

    /**
     * Suppression de support des fonctionnalités du type de post page.
     * ex. ['title', 'editor', 'author', 'thumbnail', 'page-attributes', 'custom-fields', 'comments', 'revisions']
     * @var string[]
     */
    'remove_support_page'                     => [],

    /**
     * Suppression de support des fonctionnalités d'un type de post {{post_type}}.
     * ex. ['title', 'editor']
     * @var string[]
     */
    'remove_support_{{ post_type }}'          => [],

    /**
     * Nettoyage des entrées de menu de l'interface d'administration.
     * ex. ['pages', 'calendar', 'archives', 'links', 'meta', 'search', 'text', 'categories', 'recent posts',
     * 'recent comments', 'rss', 'tag cloud', 'nav menu']
     * @var string[]
     */
    'unregister_widget'                       => [],

    /**
     * Désactivation de taxonomie(s) pour un type de post {{post_type}}.
     * @var string[]
     */
    'unregister_taxonomy_for_{{ post_type }}' => ['taxonomy1', 'taxonomy2'],

    /**
     * @todo
     * -----------------------------------------------------------------------------------------------------------------
     */
    # Mise à jour automatique du coeur de Wordpress
    # true (defaut tous ) | 'all' | [ 'dev', 'minor', 'major' ]
    # dev   : autorise la montée en version de développement (ex : 3.7-alpha-25000 -> 3.7-alpha-25678 -> 3.7-beta1 -> 3.7-beta2)
    # minor : autorise la montée en sous version (ex : 3.7.0 -> 3.7.1 -> 3.7.2 -> 3.7.4)
    # major : autorise la montée en version (ex : 3.7.0 -> 3.8.0 -> 3.9.1 )
    # @todo
    //auto_update_core:             true

    # Envoi d'un mail d'alerte à l'administrateur
    # @todo
    //auto_core_update_send_email:  true

    # Mise à jour automatique des plugins de Wordpress
    # @todo
    //auto_update_plugin:           true

    # Mise à jour automatique des themes de Wordpress
    # @todo
    //auto_update_theme:            true

    # Mise à jour automatique des themes de Wordpress
    # @todo
    //auto_update_translation:      true
];