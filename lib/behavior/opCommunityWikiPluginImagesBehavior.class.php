<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityWikiPluginImagesBehavior
 *
 * @package    opCommunityWikiPlugin
 * @subpackage behavior
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityWikiPluginImagesBehavior extends Doctrine_Template
{
  public function __construct(array $options = array())
  {
    parent::__construct($options);

    $this->_plugin = new opCommunityWikiPluginImagesRecordGenerator($this->getOptions());
  }

  public function setUp()
  {
    $this->_plugin->initialize($this->getTable());
  }
}
