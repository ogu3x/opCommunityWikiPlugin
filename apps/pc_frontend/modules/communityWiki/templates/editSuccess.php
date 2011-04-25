<?php
$options = array();
$options['title'] = __('Edit the topic');
$options['url'] = url_for('communityWiki_update', $communityWiki);
$options['isMultipart'] = true;
op_include_form('formCommunityTopic', $form, $options);
?>

<?php
op_include_parts('buttonBox', 'toDelete', array(
  'title'  => __('Delete the topic and comments'),
  'button' => __('Delete'),
  'url' => url_for('communityWiki_delete_confirm', $communityWiki),
  'method' => 'get',
));
?>
