<?php

/**
 * PluginCommunityWiki form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginCommunityWikiForm extends BaseCommunityWikiForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['wiki_updated_at']);

    $this->setWidget('name', new sfWidgetFormInput());
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('community_wiki_form');
  }
}
