<?php
$options = array();
$options['title'] = __('Create a new Wiki');
$options['url'] = url_for('communityWiki_create', $community);
$options['isMultipart'] = false;
op_include_form('formCommunityWiki', $form, $options);
?>
