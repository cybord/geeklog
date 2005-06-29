<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-syndication.php                                                       |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun        - dirk AT haun-online DOT de                    |
// |          Michael Jervis   - mike AT fuckingbrit DOT com                   |
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
// $Id: lib-syndication.php,v 1.15 2005/06/29 07:13:22 mjervis Exp $

// set to true to enable debug output in error.log
$_SYND_DEBUG = false;

if (eregi ('lib-syndication.php', $_SERVER['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}

/**
* Check if a feed for all stories needs to be updated.
*
* @param    string   $update_info   list of story ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckAll( $update_info, $limit )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    // get list of topics that anonymous users have access to
    $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );
    $tlist = '';
    for( $i = 1; $i <= $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $tlist .= "'" . $T['tid'] . "'";
        if( $i < $tnumrows )
        {
            $tlist .= ',';
        }
    }
    if( !empty( $tlist ))
    {
        $where .= " AND (tid IN ($tlist))";
    }

    $result = DB_query( "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() $where AND perm_anon > 0 ORDER BY date DESC $limitsql" );
    $nrows = DB_numRows( $result );

    $sids = array ();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $sids[] = $A['sid'];
    }
    $current = implode( ',', $sids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for all stories: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if a feed for stories from a topic needs to be updated.
*
* @param    string   $tid           topic id
* @param    string   $update_info   list of story ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckTopic( $tid, $update_info, $limit )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    $result = DB_query( "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid' AND perm_anon > 0 ORDER BY date DESC $limitsql" );
    $nrows = DB_numRows( $result );

    $sids = array ();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $sids[] = $A['sid'];
    }
    $current = implode( ',', $sids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for topic $tid: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if a feed for the events needs to be updated.
*
* @param    string   $update_info   list of event ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckEvents( $update_info, $limit )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // next xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    $result = DB_query( "SELECT eid FROM {$_TABLES['events']} WHERE perm_anon > 0 AND dateend >= NOW()$where ORDER BY datestart,timestart $limitsql" );
    $nrows = DB_numRows( $result );

    $eids = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $eids[] = $A['eid'];
    }
    $current = implode( ',', $eids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for events: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if the feed contents need to be updated.
*
* @param    string   plugin   plugin name
* @param    int      feed     feed id
* @param    string   topic    "topic" of the feed - plugin specific
* @param    string   limit    number of entries or number of hours
* @return   bool              false = feed has to be updated, true = ok
*
*/
function SYND_feedUpdateCheck( $plugin, $feed, $topic, $update_data, $limit )
{
    $is_current = true;

    switch( $topic )
    {
        case '::all':
        {
            $is_current = SYND_feedUpdateCheckAll( $update_data, $limit );
        }
        break;

        case '::links':
        {
            $is_current = SYND_feedUpdateCheckLinks( $update_data, $limit );
        }
        break;

        case '::events':
        {
            $is_current = SYND_feedUpdateCheckEvents( $update_data, $limit );
        }
        break;

        default:
        {
            $is_current = SYND_feedUpdateChecktopic( $topic, $update_data,
                                                     $limit );
        }
        break;
    }

    return $is_current;
}

/**
* Get content for a feed that holds stories from one topic.
*
* @param    string   $tid      topic id
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to topic
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentPerTopic( $tid, $limit, &$link, &$update, $contentLength )
{
    global $_TABLES, $_CONF, $LANG01;

    $content = array ();
    $sids = array();

    if( DB_getItem( $_TABLES['topics'], 'perm_anon', "tid = '$tid'") >= 2)
    {
        $where = '';
        if( !empty( $limit ))
        {
            if( substr( $limit, -1 ) == 'h' ) // last xx hours
            {
                $limitsql = '';
                $hours = substr( $limit, 0, -1 );
                $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
            }
            else
            {
                $limitsql = ' LIMIT ' . $limit;
            }
        }
        else
        {
            $limitsql = ' LIMIT 10';
        }

        $result = DB_query( "SELECT sid,uid,title,introtext,bodytext,postmode,UNIX_TIMESTAMP(date) AS modified FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid' AND perm_anon > 0 ORDER BY date DESC $limitsql" );

        $nrows = DB_numRows( $result );

        for( $i = 1; $i <= $nrows; $i++ )
        {
            $row = DB_fetchArray( $result );
            $sids[] = $row['sid'];

            $storytitle = stripslashes( $row['title'] );
            $storytext = SYND_truncateSummary( $row['introtext'], $contentLength);
            $fulltext = stripslashes( $row['bodytext'] );
            $fulltext = trim( $fulltext );
            $fulltext = preg_replace( "/(\015)/", "", $fulltext );
            $fulltext = "$storytext\n\n$fulltext";
    
            $storylink = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                       . $row['sid'] );
    
            $content[] = array( 'title'  => $storytitle,
                                'summary'   => $storytext,
                                'text'   => $fulltext,
                                'link'   => $storylink,
                                'uid'    => $row['uid'],
                                'author' => COM_getDisplayName( $row['uid'] ),
                                'date'   => $row['modified'],
                                'format' => $row['postmode']
                              );
        }
    }

    $link = $_CONF['site_url'] . '/index.php?topic=' . $tid;
    $update = implode( ',', $sids );

    return $content;
}

/**
* Get content for a feed that holds all stories.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @param    int      $contentLength Length of summary to allow.
* @return   array              content of the feed
*
*/
function SYND_getFeedContentAll( $limit, &$link, &$update, $contentLength )
{
    global $_TABLES, $_CONF, $LANG01;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    // get list of topics that anonymous users have access to
    $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );
    $tlist = '';
    for( $i = 1; $i <= $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $tlist .= "'" . $T['tid'] . "'";
        if( $i < $tnumrows )
        {
            $tlist .= ',';
        }
    }
    if( !empty( $tlist ))
    {
        $where .= " AND (tid IN ($tlist))";
    }

    $result = DB_query( "SELECT sid,uid,title,introtext,bodytext,postmode,UNIX_TIMESTAMP(date) AS modified FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() $where AND perm_anon > 0 ORDER BY date DESC $limitsql" );

    $content = array();
    $sids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $sids[] = $row['sid'];

        $storytitle = stripslashes( $row['title'] );
        
        $storytext = SYND_truncateSummary($row['introtext'], $contentLength);

        $fulltext = stripslashes( $row['bodytext'] );
        $fulltext = trim( $fulltext );
        $fulltext = preg_replace( "/(\015)/", "", $fulltext );
        $fulltext = "$storytext\n\n$fulltext";

        $storylink = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                   . $row['sid'] );

        
        $content[] = array( 'title'  => $storytitle,
                            'summary'   => $storytext,
                            'text'   => $fulltext,
                            'link'   => $storylink,
                            'uid'    => $row['uid'],
                            'author' => COM_getDisplayName( $row['uid'] ),
                            'date'   => $row['modified'],
                            'format' => $row['postmode']
                          );
    }

    $link = $_CONF['site_url'];
    $update = implode( ',', $sids );

    return $content;
}

/**
* Get content for a feed that holds all events.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentEvents( $limit, &$link, &$update )
{
    global $_TABLES, $_CONF, $LANG01;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // next xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    $result = DB_query( "SELECT eid,owner_id,title,description FROM {$_TABLES['events']} WHERE perm_anon > 0 AND dateend >= NOW()$where ORDER BY datestart,timestart $limitsql" );

    $content = array();
    $eids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $eids[] = $row['eid'];

        $eventtitle = stripslashes( $row['title'] );
        $eventtext = SYND_truncateSummary( $row['description'], $contentLength);
        $eventlink  = $_CONF['site_url'] . '/calendar_event.php?eid='
                    . $row['eid'];

        // Need to reparse the date from the event id
        $myyear = substr( $row['eid'], 0, 4 );
        $mymonth = substr( $row['eid'], 4, 2 );
        $myday = substr( $row['eid'], 6, 2 );
        $myhour = substr( $row['eid'], 8, 2 );
        $mymin = substr( $row['eid'], 10, 2 );
        $mysec = substr( $row['eid'], 12, 2 );
        $newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
        $creationtime = strtotime( $newtime );

        $content[] = array( 'title'  => $eventtitle,
                            'summary'   => $eventtext,
                            'link'   => $eventlink,
                            'uid'    => $row['owner_id'],
                            'author' => COM_getDisplayName( $row['owner_id'] ),
                            'date'   => $creationtime,
                            'format' => 'plaintext'
                          );
    }

    $link = $_CONF['site_url'] . '/calendar.php';
    $update = implode( ',', $eids );

    return $content;
}

/**
* Update a feed.
* Re-written by Michael Jervis (mike AT fuckingbrit DOT com)
* to use the new architecture
*
* @param   int   $fid   feed id
*
*/
function SYND_updateFeed( $fid )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $result = DB_query( "SELECT * FROM {$_TABLES['syndication']} WHERE fid = $fid");
    $A = DB_fetchArray( $result );
    if( $A['is_enabled'] == 1 )
    {
        // Import the feed handling classes:
        require_once( $_CONF['path_system']
                      . '/classes/syndication/parserfactory.class.php' );
        require_once( $_CONF['path_system']
                      . '/classes/syndication/feedparserbase.class.php' );

        // Load the actual feed handlers:
        $factory = new FeedParserFactory( $_CONF['path_system']
                                          . '/classes/syndication/' );
        $format = explode( '-', $A['format'] );
        $feed = $factory->writer( $format[0], $format[1] );

        if( $feed )
        {
            $feed->encoding = $A['charset'];
            $feed->lang = $A['language'];

            if( $A['type'] == 'geeklog' )
            {
                if( $A['topic'] == '::all')
                {
                    $content = SYND_getFeedContentAll( $A['limits'], $link,
                                                       $data, $A['content_length'] );
                }
                elseif( $A['topic'] == '::links')
                {
                    $content = SYND_getFeedContentLinks( $A['limits'], $link,
                                                         $data, $A['content_length'] );
                }
                elseif( $A['topic'] == '::events')
                {
                    $content = SYND_getFeedContentEvents( $A['limits'], $link,
                                                          $data, $A['content_length'] );
                }
                else // feed for a single topic only
                {
                    $content = SYND_getFeedContentPerTopic( $A['topic'],
                            $A['limits'], $link, $data, $A['content_length'] );
                }
            }
            else
            {
                $content = PLG_getFeedContent( $A['type'], $fid, $link, $data );
                // can't randomly change the api to send a max length, so
                // fix it here:
                if ($A['content_length'] != 1)
                {
                    $count = count( $content );
                    for( $i = 0; $i < $count; $i++ )
                    {
                        $content[i]['summary'] = SYND_truncateSummary( 
                                    $content[i]['text'], $A['content_length'] );
                    }
                }
            }
            if( empty( $link ))
            {
                $link = $_CONF['site_url'];
            }

            $feed->title = $A['title'];
            $feed->description = $A['description'];
            $feed->feedlogo = $link.$A['feedlogo'];
            $feed->sitelink = $link;
            $feed->copyright = 'Copyright ' . strftime( '%Y' ) . ' '
                             . $_CONF['site_name'];
            $feed->sitecontact = $_CONF['site_mail'];
            $feed->system = 'Geeklog ' . VERSION;
            $feed->articles = $content;

            if( !empty( $A['filename'] ))
            {
                $filename = $A['filename'];
            }
            else
            {
                $pos = strrpos( $_CONF['rdf_file'], '/' );
                $filename = substr( $_CONF['rdf_file'], $pos + 1 );
            }
            $path = $_CONF['rdf_file'];
            $pos = strrpos( $path, '/' );
            $path = substr( $path, 0, $pos + 1 );
            $filename = $path . $filename;
            $feed->createFeed( $filename );
        }
        else
        {
            COM_errorLog( "Unable to get a feed writer for {$format[0]} version {$format[1]}.", 1);
        }

        if( empty( $data ))
        {
            $data = 'NULL';
        }
        else
        {
            $data = "'" . $data . "'";
        }

        if ($_SYND_DEBUG)
        {
            COM_errorLog ("update_info for feed $fid is $data", 1);
        }

        DB_query( "UPDATE {$_TABLES['syndication']} SET updated = NOW(), update_info = $data WHERE fid = $fid");
    }
}

function SYND_truncateSummary($text, $length)
{
    if ($length == 0)
    {
        return '';
    } else {
        $text = stripslashes( $text );
        $text = trim( $text );
        $text = preg_replace( "/(\015)/", "", $text );
        if (($length > 1) && (strlen( $text ) > $length))
        {
            $text = substr($text, 0, $length - 3).'...';
        }
        // Check if we broke html tag and storytext is now something
        // like "blah blah <a href= ...". Delete "<*" if so.
        if (strrpos($storytext, "<") > strrpos($storytext, ">")) {
            $storytext = substr ($storytext, 0, strrpos($storytext, "<") - 1)
                . " ...";
         }
        return $text;
    }
}

?>
