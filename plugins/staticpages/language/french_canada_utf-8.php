<?php

###############################################################################
# french_canada.php
# This is a french language page for the Geeklog Static Page Plug-in!
# Translation performed by Jean-Francois Allard - jfallard@jfallard.com
# Copyright (c) July 2003
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    newpage => 'Nouvelle page',
    adminhome => 'Entrée - admin',
    staticpages => 'Pages statiques',
    staticpageeditor => 'Éditeur de pages statiques',
    writtenby => 'Écrit par',
    date => 'Dernière mise à jour',
    title => 'Titre',
    content => 'Contenu',
    hits => 'Clicks',
    staticpagelist => 'Liste des pages statiques',
    url => 'URL',
    edit => 'Édition',
    lastupdated => 'Dernière mise à jour',
    pageformat => 'Format des pages',
    leftrightblocks => 'Blocs à gauche et à droite',
    blankpage => 'Nouvelle page vierge',
    noblocks => 'Pas de blocs',
    leftblocks => 'Blocs à gauche',
    addtomenu => 'Ajoutez au menu',
    label => 'Libellé',
    nopages => 'Il n\'y a pas de pages statiques enregistrées dans le système présentement',
    save => 'sauvegarde',
    preview => 'aperçu',
    delete => 'effacer',
    cancel => 'annuler',
    access_denied => 'Acces refusé',
    access_denied_msg => 'Vous essayez d\'accéder illégalement à l\'une des pages administratives relatives aux pages statiques. Veuillez noter que toutes les tentatives illégales en ce sens seront enregistrées',
    all_html_allowed => 'Toutes les balises HTML sont acceptées',
    results => 'Résultats des pages statiques',
    author => 'Auteur',
    no_title_or_content => 'Vous devez au minimum inscrire quelque chose dans les champs <b>titre</b> et <b>contenu</b>.',
    no_such_page_logged_in => 'Désolé '.$_USER['username'].'..',
    no_such_page_anon => 'Prière de vous enregistrer',
    no_page_access_msg => "Ce pourrait être parce que vous ne vous êtes pas enregistré, ou inscrit comme membre de {$_CONF["site_name"]}. Veuillez <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> vous inscrire comme membre</a> de {$_CONF["site_name"]} pour recevoir toutes les permissions nécessaires",
    php_msg => 'PHP: ',
    php_warn => 'Avertissement: le code PHP de votre page sera évalué si vous utilisez cette fonction. Utilisez avec précaution !!',
    exit_msg => 'Type de sortie: ',
    exit_info => 'Activez pour obtenir le message d\'accès requis. Gardez non-sélectionné pour actionner les vérifications et les messages de sécurité normaux.',
    deny_msg => 'L\'accès à cette page est impossible. Soit la page à été déplacée, soit vous n\'avez pas les permissions nécessaires.',
    stats_headline => 'Top-10 des pages statiques les plus fréquentées',
    stats_page_title => 'Titre des pages',
    stats_hits => 'Clics',
    stats_no_hits => 'Il serait possible qu\'il n\'y ait aucune page statique sur ce site, ou alors personne ne les a encore consultées.',
    id => 'Identification',
    duplicate_id => 'L\'identification choisie pour cette page est déjà utilisée par une autre page. Veuillez en choisir une autre.',
    instructions => 'Pour modifier une page statique, cliquez sur son numéro ci-dessous. Pour voir une page statique, cliquez sur le titre de la page. Pour créer une page statique, cliquez sur Nouvelle page ci-dessous. Cliquez sur [C] pour créer une copie de page existante.',
    centerblock => 'Bloc du centre: ',
    centerblock_msg => 'Lorsque sélectionnée, cette page statique sera disposée comme le bloc central de la page d\'index.',
    topic => 'Sujet: ',
    position => 'Position: ',
    all_topics => 'Tout',
    no_topic => 'Page d\'accueil seulement',
    position_top => 'Haut de page',
    position_feat => 'Après les articles',
    position_bottom => 'Bas de page',
    position_entire => 'Page entière',
    head_centerblock => 'Bloc du centre',
    centerblock_no => 'Non',
    centerblock_top => 'Haut',
    centerblock_feat => 'Article principal',
    centerblock_bottom => 'Bas',
    centerblock_entire => 'Bloc entier',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'php_not_activated' => 'The use of PHP in static pages is not activated. Please see the <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">documentation</a> for details.',
    'printable_format' => 'Printable Format'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>