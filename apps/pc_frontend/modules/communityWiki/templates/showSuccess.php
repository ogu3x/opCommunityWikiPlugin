<?php use_stylesheet('/opCommunityWikiPlugin/css/wiki.css') ?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shCore.js');?>
<?php use_stylesheet('/opCommunityWikiPlugin/js/syntaxhighlighter/styles/shCoreDefault.css');?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shBrushJScript.js');?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shBrushPhp.js');?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shBrushXml.js');?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shBrushSql.js');?>
<?php use_javascript('/opCommunityWikiPlugin/js/syntaxhighlighter/scripts/shBrushDiff.js');?>

<script type="text/javascript">
SyntaxHighlighter.defaults['toolbar'] = false;
SyntaxHighlighter.defaults['gutter'] = false;
SyntaxHighlighter.defaults['class-name'] = 'class_community_wiki';
SyntaxHighlighter.all();
</script>

<style>
.class_community_wiki { border: 2px solid #eee; }
.class_community_wiki table{ margin: 2px !important; }
.syntaxhighlighter .gutter .line { border-right: 2px solid #ACF !important; }
</style>

<?php use_helper('Date'); ?>
<?php $acl = opCommunityWikiAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<div class="dparts wikiDetailBox">
  <div class="parts">
    <div class="partsHeading">
      <h3><?php echo '['.$community->getName().'] '.__('Wiki') ?></h3>
    </div>

    <dl>
      <dt><?php echo nl2br(op_format_date($communityWiki->getCreatedAt(), 'XDateTimeJaBr')) ?></dt>
      <dd>
        <div class="title">
          <p><?php echo $communityWiki->getName() ?></p>
        </div>

        <div class="name">
          <p><?php if ($_member = $communityWiki->getMember()) : ?><?php echo link_to($_member->getName(), 'member/profile?id='.$_member->getId()) ?><?php endif; ?></p>
        </div>

      </dd>
    </dl>

    <div class="body">
      <?php echo $sf_data->getRaw('communityWiki')->getBody() ?>
    </div>

    <?php /*if ($communityWiki->isEditable($sf_user->getMemberId())):*/ ?>
    <div class="operation">
      <form action="<?php echo url_for('communityWiki_edit', $communityWiki) ?>" method="get">
      <ul class="moreInfo button">
        <li><input class="input_submit" type="submit" value="<?php echo __('Edit') ?>" /></li>
      </ul>
      </form>
    </div>
    <?php /*endif;*/ ?>

  </div>
</div>


<?php op_include_line('linkLine', link_to('['.$community->getName().'] '.__('Community Top Page'), 'community/home?id='.$community->getId())) ?>
