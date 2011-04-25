<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginTopicComponents
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 */
abstract class opCommunityWikiPluginWikiComponents extends sfComponents
{
  public function executeCommunityWikiList()
  {
    $publicFlag = Doctrine::getTable('CommunityConfig')->retrieveByNameAndCommunityId('public_flag', $this->community->getId());
    $isBelong = $this->community->isPrivilegeBelong($this->getUser()->getMemberId());
    $this->hasPermission = true;

    if ($publicFlag && !$isBelong && $publicFlag->getValue() !== 'public')
    {
      $this->hasPermission = true;
      return sfView::SUCCESS;
    }

    $this->communityWikis = Doctrine::getTable('CommunityWiki')->getWikis($this->community->getId());
  }

  public function executeWikiCommentListBox()
  {
    $this->communityWiki = Doctrine::getTable('CommunityWiki')->retrivesByMemberId($this->getUser()->getMember()->getId(), $this->gadget->getConfig('col'));
  }

  public function executeTopSearchForm()
  {
    $this->wikiSearchCaption = sfContext::getInstance()->getI18N()->__('Wiki');
  }

  public function executeConfigNotificationMail($request)
  {
    try
    {
      $this->form = new opConfigCommunityWikiNotificationMailForm($request['id']);
    }
    catch (RuntimeException $e)
    {
      // do nothing.
    }
  }
}
