<?php
if(!empty($_POST['Submit']))
{
	$newWPEOption = array();
	$newWPEOption['enable'] = $_POST['en_enable'];
	if($_POST['en_ctrl_tag'] == 'true')
	{
		$newWPEOption['CtrlTag'] = 'all';
	}
	if( $_POST['en_ctrl_tag'] == 'false')
	{
		if($_POST['en_ctrl_tag_custom'] == '')
		{
			$newWPEOption['CtrlTag'] = 'evernote';
		}
		else
		{
			$newWPEOption['CtrlTag'] = $_POST['en_ctrl_tag_custom'];
		}
	}
//	if( $_POST['en_ctrl_tag'] == 'true' && $_POST['en_ctrl_tag_custom'] != '')
//	{
//		$newWPEOption['CtrlTag'] = $_POST['en_ctrl_tag_custom'];
//	}
	$newWPEOption['SiteName'] = $_POST['en_site_name'];
	$newWPEOption['ContentToClip'] = $_POST['en_content_clip'];
	$newWPEOption['SuggestedTags'] = $_POST['en_sug_tags'];
	$newWPEOption['Styling'] = $_POST['en_styling'];
	$newWPEOption['SuggestedNotebook'] = $_POST['en_sug_nb'];
	$newWPEOption['code'] = $_POST['en_code'];
	$newWPEOption['SuggestedNoteTitle'] = $_POST['en_sug_title'];
	$newWPEOption['SourceURL'] = $_POST['en_url'];
	$newWPEOption['Button'] = $_POST['buttonImg'];

	$is_WPEOption_update_queries = array();
	$update_WPE_text = array();
	$is_WPEOption_update_queries = update_option('WP_Evernote_Options', $newWPEOption);
	$update_text = __('Evernote SiteMemory', 'wp-evernote');
	$text = '';
	if(empty($is_WPEOption_update_queries))
	{
		$text = '<font color = "red">Nothing Changed.</font>';
	}
	else
	{
		$text = '<font color = "green">Evernote Site Memory plugin settings Updated!</font>';
	}
}
?>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<div class = 'wrap'>
<?php screen_icon(); ?>
<h2><?php _e('Evernote Site Memory Option Admin','wp-evernote') ?></h2>
<br />
<?php
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
?>
<form id = "en_sitememory_option_admin" action = "<?php echo $_SERVER['REQUEST_URI']; ?>" method = "post">
<table class = "form_table">
<tr>
	<td width = "100"><strong>Evernote Site Memory</strong></td>
	<td width = "180">
		<input type = "radio" <?php if ($CurrentWPEOption['enable'] == 'true') {echo 'checked ';} ?> class = "radio" name = "en_enable" id = "enable_true" value = "true"><label for = "enable_true"><strong>Enable</strong></label>
		<input type = "radio" <?php if ($CurrentWPEOption['enable'] == 'false') {echo 'checked ';} ?>class = "radio" name = "en_enable" id = "enable_false" value = "false"><label for = "enable_false"><strong>Disable</strong></label>
	</td>
	<td></td>
</tr>
<tr>
	<td width = "180"><strong>Display Button in</strong></td>
	<td width = "180">
	<input type = "radio" <?php if ($CurrentWPEOption['CtrlTag'] != 'all') {echo 'checked ';} ?> class = "radio" name = "en_ctrl_tag" id = "en_ctrl_tag_some" value = "false">
	<label for = "en_ctrl_tag_some">Post With Control Tag</label>
	<input type = "text" value = "<?php if($CurrentWPEOption['CtrlTag'] != 'all') { echo $CurrentWPEOption['CtrlTag'];} ?>" name = "en_ctrl_tag_custom"><br />
	<input type = "radio" <?php if ($CurrentWPEOption['CtrlTag'] == 'all') {echo 'checked ';} ?> class = "radio" name = "en_ctrl_tag" id = "en_ctrl_tag_all" value = "true">
	<label for = "en_ctrl_tag_all">All Post</label>	
	</td>
	<td>When Post had the Control Tag, The Evernote SiteMemory Button will be display at the bottom of post.</td>
</tr>
<tr>
	<td width = "180"><strong>Site Name</strong></td>
	<td width = "180"><input type = "text" value = "<?php echo bloginfo('name'); ?>" name = "en_site_name"></td>
	<td></td>
</tr>
<tr>
	<td><strong>Content to clip</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['ContentToClip']; ?>" name = "en_content_clip"></td>
	<td>The ID of the HTML element that Site Memory should clip, Wordpress's default HTML element ID is "post-id", you can set this option as "post-%postid%"</td>
</tr>
<tr>
	<td><strong>Suggested Tags</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['SuggestedTags']; ?>" name = "en_sug_tags"></td>
	<td></td>
</tr>
<tr>
	<td><strong>Styling</strong></td>
	<td>
		<input type = "radio" <?php if ($CurrentWPEOption['Styling'] == 'text') {echo 'checked ';} ?> class = "radio" name = "en_styling" id = "styling_text" value = "text"><label for = "styling_text">Text only</label>
		<input type = "radio" <?php if ($CurrentWPEOption['Styling'] == 'full') {echo 'checked ';} ?>class = "radio" name = "en_styling" id = "styling_full" value = "full"><label for = "styling_full">Full</label>
	</td>
	<td></td>
</tr>
<tr>
	<td><strong>Suggested notebook for clip</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['SuggestedNotebook']; ?>" name = "en_sug_nb"></td>
	<td>Suggest a destination notebook for your content. The notebook will be created if it does not exist</td>
</tr>
<tr>
	<td><strong>Suggested Note Title</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['SuggestedNoteTitle']; ?>" name = "en_sug_title"></td>
	<td>If left blank, the current page title will be used</td>
</tr>
<tr>
	<td><strong>Evernote Referal Code</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['code']; ?>" name = "en_code"></td>
	<td>You <a href = "http://www.evernote.com/about/affiliate/" target = "_black">Evernote Affiliate Program</a> referal code or API consumer key. you can leave this black.</td>
</td>
<tr>
	<td><strong>Source URL</strong></td>
	<td><input type = "text" value = "<?php echo $CurrentWPEOption['SourceURL']; ?>" name = "en_url"></td>
	<td>URL that will be associated with the clip. If left blank, the current URL will be used</td>
</tr>
</table>
<?php
	$Reshttpurl = get_option('siteurl');
	$Reshttpurl .= '/wp-content/plugins/wp-evernote/res/'; 
?>
<table>
<tr>
<td width = "250">
<ul>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper.png') echo 'checked '; ?> name="buttonImg" value="article-clipper.png" id = "btn_ac"><label for = "btn_ac"><img src="<?php echo $Reshttpurl; ?>article-clipper.png" /></label></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-fr.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-fr.png" id = "btn_ac_fr"><label for = "btn_ac_fr"><img src="<?php echo $Reshttpurl; ?>article-clipper-fr.png" /><br /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-jp.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-jp.png" id = "btn_ac_jp"><label for = "btn_ac_jp"><img src="<?php echo $Reshttpurl; ?>article-clipper-jp.png"/></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-de.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-de.png" id = "btn_ac_de"><label for = "btn_ac_de"><img src="<?php echo $Reshttpurl; ?>article-clipper-de.png" /></label>
<br />
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-es.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-es.png" id = "btn_ac_es"><label for = "btn_ac_es"><img src="<?php echo $Reshttpurl; ?>article-clipper-es.png" /><br /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-rus.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-rus.png" id = "btn_ac_rus"><label for = "btn_ac_rus"><img src="<?php echo $Reshttpurl; ?>article-clipper-rus.png" /><br /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-remember.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-remember.png" id = "btn_ac_rb"><label for = "btn_ac_rb"><img src="<?php echo $Reshttpurl; ?>article-clipper-remember.png" /></label>
</td>
<td>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'article-clipper-vert.png') echo 'checked '; ?> name="buttonImg" value="article-clipper-vert.png" id = "btn_ac_vert"><label for = "btn_ac_vert"><img style="" src="<?php echo $Reshttpurl; ?>article-clipper-vert.png" /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'site-mem-36.png') echo 'checked '; ?> name="buttonImg" value="site-mem-36.png" id = "btn_ac_36"><label for = "btn_ac_36"><img style="" src="<?php echo $Reshttpurl; ?>site-mem-36.png" /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'site-mem-32.png') echo 'checked '; ?> name="buttonImg" value="site-mem-32.png" id = "btn_ac_32"><label for = "btn_ac_32"><img style="" src="<?php echo $Reshttpurl; ?>site-mem-32.png" /><br /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'site-mem-22.png') echo 'checked '; ?> name="buttonImg" value="site-mem-22.png" id = "btn_ac_22"><label for = "btn_ac_22"><img style="" src="<?php echo $Reshttpurl; ?>site-mem-22.png" /></label>
<input type="radio" class="radio" <?php if($CurrentWPEOption['Button'] == 'site-mem-16.png') echo 'checked '; ?> name="buttonImg" value="site-mem-16.png" id = "btn_ac_16"><label for = "btn_ac_16"><img src="<?php echo $Reshttpurl; ?>site-mem-16.png" /></label>
</ul>
</td>
</table>
<input type = "submit" name = "Submit" class="button-primary" value="Save Changes">
</form>
</div>
