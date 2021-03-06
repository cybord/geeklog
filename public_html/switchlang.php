<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | switchlang.php                                                            |
// |                                                                           |
// | Switch the user's language                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
// |          based on earlier works by Euan McKay and LWC                     |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: switchlang.php,v 1.4 2008/09/14 09:17:41 dhaun Exp $

require_once 'lib-common.php';

/**
* Switch language in a URL.
*
* @param    string  $url        current URL
* @param    string  $newLang    new language to switch to
* @param    string  $oldLang    old, i.e. current language
* @return   string              new URL after the language switch
*/
function switch_language($url, $newLang, $oldLang)
{
    global $_CONF;

    if (empty($newLang) || empty($oldLang) || (strlen($newLang) !== strlen($oldLang))) {
        return $url;
    }

    $lang_len = strlen($oldLang);
    $url_rewrite = false;
    $q = false;

    if ($_CONF['url_rewrite']) {
        // check for "rewritten" URLs with a '?', e.g. search query highlighting
        $q = strpos($url, '?');
        if (($q === false) || (substr($url, $q - 4, 4) !== '.php')) {
            $url_rewrite = true;
        }
    }

    if ($url_rewrite) {
        $the_url = ($q === false) ? $url : substr($url, 0, $q);

        // for "rewritten" URLs we assume that the first parameter after
        // the script name is the ID, e.g. /article.php/story-id-here_en
        $changed = false;
        $p = explode('/', $the_url);
        $parts = count($p);
        for ($i = 0; $i < $parts; $i++) {
            if (substr($p[$i], -4) === '.php') {
                // found the script name - assume next parameter is the ID
                // There is a langID somewhere after the script name (it may no longer be next with url_rewrite enabled, etc..)
                for ($j = $i; $j < $parts; $j++) { 
                    if (isset($p[$j + 1])) { 
                        if (substr($p[$j + 1], -($lang_len + 1)) === '_' . $oldLang) { 
                            $p[$j + 1] = substr_replace($p[$j + 1], $newLang, -$lang_len); 
                            $changed = true; 
                            break; 
                        } 
                    } 
                }
                break;
            }
        }

        if ($changed) {
            // merge the pieces back together
            $url = ($q === false)
                ? implode('/', $p)
                : implode('/', $p) . substr($url, $q);
        }

        $retval = $url;
    } else { // URL contains '?' or '&'
        $url = explode('&', $url);
        $urlPart = $url[0];
        if (count($url) > 1) {
            array_shift($url);
            $extra_vars = '&' . implode('&', $url);
        } else {
            $extra_vars = '';
        }

        if (substr($urlPart, -($lang_len + 1)) === '_' . $oldLang) {
            $urlPart = substr_replace($urlPart, $newLang, -$lang_len);
        }

        $retval = $urlPart . $extra_vars;
    }

    return $retval;
}

// MAIN
$ret_url = '';
if (isset($_SERVER['HTTP_REFERER']) &&
    (strpos($_SERVER['HTTP_REFERER'], $_CONF['site_url']) !== false)) {
    $ret_url = $_SERVER['HTTP_REFERER'];
}

// if not allowed, just ignore and return
if ($_CONF['allow_user_language'] == 1) {
    COM_setArgNames(array('lang'));

    $lang = strtolower(COM_applyFilter(COM_getArgument('lang')));
    $lang = preg_replace('/[^a-z0-9\-_]/', '', $lang);
    $oldLang = COM_getLanguageId();

    // Code provided by hiroron
    if ($lang === $oldLang) {
        $langFromUrl = COM_getLanguageFromURL($ret_url);
        $oldLang = empty($langFromUrl) ? $oldLang : $langFromUrl;
    }

    // do we really have a new language to switch to?
    if (!empty($lang) && array_key_exists($lang, $_CONF['language_files'])) {
        // does such a language file exist?
        $langFile = $_CONF['language_files'][$lang];

        if (is_file($_CONF['path_language'] . $langFile . '.php')) {
            // Set the language cookie.
            // Mainly used for anonymous users so the rest of their session
            // will remain in the selected language
            setcookie(
                $_CONF['cookie_language'], $langFile, time() + 31536000, 
                $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']
            );

            // if user is not anonymous, store the preference in the database
            if (!COM_isAnonUser()) {
                DB_query("UPDATE {$_TABLES['users']} SET language = '" . DB_escapeString($langFile) . "' WHERE uid = {$_USER['uid']}");
            }
        }
    }

    // Change the language ID if needed
    if (!empty($ret_url) && !empty($lang) && !empty($oldLang)) {
        $ret_url = switch_language($ret_url, $lang, $oldLang);
    }
}

// if the user didn't come from our site, send them to our index page
if (empty($ret_url)) {
    $ret_url = $_CONF['site_url'] . '/';
}

header("Location: $ret_url");
