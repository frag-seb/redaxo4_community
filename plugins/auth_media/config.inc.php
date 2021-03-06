<?php

/**
* Plugin Media-Access
* @author m.lorch[at]it-kult[dot]de Markus Lorch, Jan kristinus
* @author <a href="http://www.it-kult.de">www.it-kult.de</a>
* @version 1.0
* 
*/

$mypage = "auth_media";
$REX['ADDON']['version'][$mypage] = '2.9.1';
$REX['ADDON']['author'][$mypage] = 'Markus Lorch, Jan Kristinus';
$REX['ADDON']['supportpage'][$mypage] = 'www.it-kult.de';
$REX['ADDON']['community']['plugin_auth_media']['xsendfile'] = 0;

// --- DYN
$REX['ADDON']['community']['plugin_auth_media']['auth_active'] = 1;
$REX['ADDON']['community']['plugin_auth_media']['unsecure_fileext'] = "png,jpg,jpeg,gif,ico,css,js,swf";
$REX['ADDON']['community']['plugin_auth_media']['error_article_id'] = 1;
// --- /DYN

## Loading Plugin
include $REX["INCLUDE_PATH"]."/addons/community/plugins/auth_media/classes/class.rex_com_auth_media.inc.php";

if($REX["REDAXO"] && $REX['USER'])
{
  if(isset($I18N) && is_object($I18N))
    $I18N->appendFile($REX['INCLUDE_PATH'].'/addons/community/plugins/auth_media/lang');

  $REX['ADDON']['community']['SUBPAGES'][] = array('plugin.auth_media',$I18N->msg('com_auth_media'));

}

if($REX['ADDON']['community']['plugin_auth_media']['auth_active'])
{

  if(rex_request("rex_com_auth_media_filename","string") != "")
    rex_register_extension('ADDONS_INCLUDED', 'rex_com_auth_media::getMedia');

  // ----- image_manager hack
  $rex_img_file = rex_get('rex_img_file', 'string');
  $rex_img_type = rex_get('rex_img_type', 'string');
  if($rex_img_file != '' && $rex_img_type != '')
  {
    $REX['ADDON']['community']['plugin_auth'] = $ADDONSsic['community']['plugin_auth'];
    include $REX["INCLUDE_PATH"]."/addons/community/plugins/auth/inc/auth.php";
    
    if( ($media = OOMedia::getMediaByFileName($rex_img_file)) && rex_com_auth_media::checkPerm($media) )
    {

    }
    else 
    {
      rex_com_auth_media::forwardErrorPage();
    }
  }

}


