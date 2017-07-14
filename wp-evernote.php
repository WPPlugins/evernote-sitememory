<?php
/*
 Plugin Name: Evernote Site Memory
 Plugin URI: http://chensd.com/plugins/
 Version: v0.9.0
 Author: SidCN
 Description: Add a Evernote Site Memory button at the end of every post, it can help you visitors clips you post to evernote easily and quickly
 Author URI: http://chensd.com
 */
if(!(class_exists('clsWPEvernote')))
{
	class clsWPEvernote
	{
		function AddButton($PostContent)
		{
			if(is_single())
			{
				$Current_Category = single_cat_title("", false);
				$CurrentWPEOption = array();
				$CurrentWPEOption = get_option('WP_Evernote_Options');
				if(!isset($CurrentWPEOption))
				{
					$CurrentWPEOption = $this->getWPEoption();
				}
				$post_ID = get_the_ID();
				$post_tags = wp_get_post_tags($post_ID);
				$display_or_not = false;
				foreach($post_tags as $tags)
				{
					if($CurrentWPEOption['CtrlTag'] == $tags->name && $CurrentWPEOption['enable'] == 'true')
					{
						$display_or_not = true;
					}
				}
				if($display_or_not)
				{
					$ButtonCode = '<script type="text/javascript" src="';
					$ButtonCode .= get_option('siteurl') . '/wp-content/plugins/wp-evernote/res/noteit.js';
					$ButtonCode .= '"></script>';
					$ButtonCode .= '<a href="#" onclick="Evernote.doClip({styling:\'';
					$ButtonCode .= $CurrentWPEOption['Styling'];
					$ButtonCode .= '\',contentId:\'';
					$ButtonCode .= $CurrentWPEOption['ContentToClip'];
					$ButtonCode .= '\',providerName:\'';
					$ButtonCode .= $CurrentWPEOption['SiteName'];
					if($CurrentWPEOption['SuggestedNotebook'] != '')
					{
						$ButtonCode .= '\',suggestNotebook:\'';
						$ButtonCode .= $CurrentWPEOption['SuggestedNotebook'];
					}
					if($CurrentWPEOption['code'] != '')
					{
						$ButtonCode .= '\',code:\'';
						$ButtonCode .= $CurrentWPEOption['code'];
					}
					if($CurrentWPEOption['SuggestedNoteTitle'] != '')
					{
						$ButtonCode .= '\' ,title:\'';
						$ButtonCode .= $CurrentWPEOption['SuggestedNoteTitle'];
					}
					if($CurrentWPEOption['SuurceURL'] != '')
					{
						$ButtonCode .= '\',url:\'';
						$ButtonCode .= $CurrentWPEOption['SourceURL'];
					}
					if($CurrentWPEOption['SuggestedTags'] != '')
					{
						$ButtonCode .= '\',suggestTags:\'';
						$ButtonCode .= $CurrentWPEOption['SuggestedTags'];
					}
					$ButtonCode .= '\'}); return false;"><img src="';
					$ButtonCode .= get_option('siteurl') . '/wp-content/plugins/wp-evernote/res/';
					$ButtonCode .= $CurrentWPEOption['Button'];
					$ButtonCode .= '" alt="Clip to Evernote" /></a>';
					$ButtonCode .= $Current_Category;
					$PostContent .= $ButtonCode;
				}
			}
			$PostContent = str_replace('%postid%', get_the_ID(), $PostContent);
			return $PostContent;
		}
		function AddOptionMenu()
		{
			$PluginDir = basename(dirname(__FILE__));
			if(function_exists(add_options_page))
			{
				add_options_page('Evernote SiteMemory', 'Evernote SiteMemory', 9, $PluginDir . '/wp-evernote-option.php');
			}
		}
		function getWPEOption()
		{
			$ResHttpURL = get_option('siteurl') . '/wp-content/plugins/wp-evernote/res/';
			$WPEOption = array(
					'enable' => 'true',
					'CtrlTag' => 'evernote',
					'SiteName' => get_option('blogname'),
					'ContentToClip' => 'post-%postid%',
					'SuggestedTags' => '',
					'Styling' => 'full',
					'SuggestedNotebook' => '',
					'code' => 'Chen3523',
					'SuggestedNoteTitle' => '',
					'SourceURL' => '',
					'Button' => 'article-clipper-vert.png');
			$CurrentWPEOption = get_option('WP_Evernote_Options');
			if(!isset($CurrentWPEOption))
			{
				foreach($CurrentWPEOption as $key => $option)
					$WPEOption[key] = $option;
			}

			update_option('WP_Evernote_Options', $WPEOption);
			return $WPEOption;
		}
		function init()
		{
			$this->getWPEOption();
		}
	}
}
if(class_exists(clsWPEvernote))
{
	global $objWPEvernote;
	$objWPEvernote = new clsWPEvernote();
}
if(isset($objWPEvernote))
{
	add_action('the_content', array(&$objWPEvernote, 'AddButton'));
	add_action('admin_menu', array(&$objWPEvernote, 'AddOptionMenu'));
	add_action('activate_' . basename(dirname(__FILE__)) . '/wp-evernote.php', array(&$objWPEvernote, 'init'));
}
?>
