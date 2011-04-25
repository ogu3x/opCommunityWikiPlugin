<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityWiki actions.
 *
 * @package    OpenPNE
 * @subpackage communityWiki
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class communityWikiActions extends opCommunityWikiPluginWikiActions
{
  /**
   * postExecute
   */
  public function postExecute()
  {
    if ($this->community instanceof Community)
    {
      sfConfig::set('sf_nav_type', 'community');
      sfConfig::set('sf_nav_id', $this->community->getId());
    }
  }
}
