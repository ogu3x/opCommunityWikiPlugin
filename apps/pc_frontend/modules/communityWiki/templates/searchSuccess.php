<?php use_helper('Date') ?>
<?php
$options = array(
  'title'    => __('Search Community Wikis'),
  'url'      => url_for('communityWiki/search'),
  'button'   => __('Search'),
  'method'   => 'get'
);
if (!$communityId)
{
  unset($form['target']);
  unset($form['id']);
}

op_include_form('searchCommunityWiki', $form, $options);
?>

<?php if ($pager->getNbResults()): ?>

<?php
$list = array();
foreach ($pager->getResults() as $key => $topic)
{
  $list[$key] = array();
  $list[$key][__('Name', array(), 'community_wiki_form')] = $topic->getName();
  $list[$key][__('%community% Name')] = $topic->getCommunity()->getName();
  $list[$key][__('Body', array(), 'community_wiki_form')] = $topic->getBody();
  $list[$key][__('Date Updated', array(), 'form_community')] = format_datetime($topic->getUpdatedAt(), 'f');
}

$options = array(
  'title'          => __('Search Results'),
  'pager'          => $pager,
  'link_to_page'   => 'communityWiki/search?page=%d',
  'list'           => $list,
  'link_to_detail' => $link_to_detail,
);

op_include_parts('searchResultList', 'searchResultCommunityWiki', $options);
?>
<?php else: ?>
<?php
if ('topic' === $type)
{
  $message = __('Your search queries did not match any community topics.');
}
else if ('wiki' === $type)
{
  $message = __('Your search queries did not match any community events.');
}
op_include_box('searchCommunityWikiResult', $message, array('title' => __('Search Results')));
?>
<?php endif; ?>
