<?php $acl = opCommunityWikiAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>
<?php $sf_response->addStylesheet('/opCommunityWikiPlugin/css/communityWiki') ?>
<?php use_helper('Date'); ?>
<tr class="communityWiki">
<th><?php echo __('Community Wikis') ?></th>
<td>
<?php if ($count = count($communityWikis)): ?>
<ul class="articleList">
<?php foreach ($communityWikis as $key => $communityWiki): ?>
<li>
<span class="date"><?php echo op_format_date($communityWiki->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s', op_truncate($communityWiki->getName(), 36)), '@communityWiki_show?id='.$communityWiki->getId()) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="moreInfo">
<ul class="moreInfo">
<?php if($count): ?>
<li><?php echo link_to(__('More'), '@communityWiki_list_community?id='.$community->getId()); ?></li>
<?php endif; ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
<li><?php echo link_to(__('Create a new Wiki'), '@communityWiki_new?id='.$community->getId()); ?></li>
<?php endif; ?>
</ul>
</div>
</tr>
<?php endif; ?>
