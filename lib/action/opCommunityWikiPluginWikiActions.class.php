<?php
abstract class opCommunityWikiPluginWikiActions extends sfActions
{
  public function preExecute()
  {
    if ($this->getRoute() instanceof sfDoctrineRoute)
    {
      $object = $this->getRoute()->getObject();

      if ($object instanceof Community)
      {
        $this->community = $object;
        $this->acl = opCommunityWikiAclBuilder::buildCollection($this->community, array($this->getUser()->getMember()));
      }
      elseif ($object instanceof CommunityWiki)
      {
        $this->communityWiki = $object;
        $this->community = $this->communityWiki->getCommunity();
        $this->acl = opCommunityWikiAclBuilder::buildResource($this->communityWiki, array($this->getUser()->getMember()));
      }
    }
  }

  public function executeListCommunity($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'view'));

    if (!$this->size)
    {
      $this->size = 20;
    }

    $this->pager = Doctrine::getTable('CommunityWiki')->getCommunityWikiListPager(
      $this->community->getId(),
      $request->getParameter('page'),
      $this->size
    );

    return sfView::SUCCESS;
  }

  /**
   * Executes show action
   *
   * @param sfRequest $request A request object
   */
  public function executeShow($request)
  {
    //$this->form = new CommunityWikiCommentForm();
    $libPath = realpath(dirname(__FILE__)."/../vendor/Text_Wiki");
    $oldPath = get_include_path();
    set_include_path($oldPath.":".$libPath);
    require_once "Text/Wiki.php";

    $wiki = new Text_Wiki();
    $wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);

    // bodyの内容をパース後の内容に置換
    $this->communityWiki->body = $wiki->transform($this->communityWiki->getBody());

    return sfView::SUCCESS;
  }

  /**
   * Executes new action
   *
   * @param sfRequest $request A request object
   */
  public function executeNew($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add'));

    $this->form = new CommunityWikiForm();

    return sfView::SUCCESS;
  }

  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate($request)
  {

    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add'));

    $this->form = new CommunityWikiForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunity($this->community);
    $this->processForm($request, $this->form);

    $this->setTemplate('new');

    return sfView::SUCCESS;
  }
 
  /**
   * Executes edit action
   *
   * @param sfRequest $request A request object
   */
  public function executeEdit($request)
  {
    $this->form = new CommunityWikiForm($this->communityWiki);
    
    return sfView::SUCCESS;
  }
 
  /**
   * Executes update action
   *
   * @param sfRequest $request A request object
   */
  public function executeUpdate($request)
  {
    $this->form = new CommunityWikiForm($this->communityWiki);
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
    
    return sfView::SUCCESS;
  }

  /**
   * Executes deleteConfirm action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->form = new sfForm();
    
    return sfView::SUCCESS;
  }
 
  /**
   * Executes delete action
   *
   * @param sfRequest $request A request object
   */
  public function executeDelete($request)
  {
    $request->checkCSRFProtection();

    $this->communityWiki->delete();

    $this->getUser()->setFlash('notice', 'The community topic was deleted successfully.');

    $this->redirect('community/home?id='.$this->community->getId());
  }

  /**
   * Executes recentlyWikiList
   *
   * @param sfRequest $request A request object
   */

  // 最近のWiki一覧
  public function executeRecentlyWikiList($request)
  {
    if (!$this->size)
    {
      $this->size = 50;
    }

    $this->pager = Doctrine::getTable('CommunityWiki')->getRecentlyWikiListPager(
      $this->getUser()->getMemberId(),
      $request->getParameter('page', 1),
      $this->size
    );

    return sfView::SUCCESS;
  }

  /**
   * Executes search action
   *
   * @param sfRequest $request A request object
   */
  public function executeSearch($request)
  {
    $params = array(
      'keyword' => $request->getParameter('keyword'),
      'target' => $request->getParameter('target', 'in_community'),
//      'type' => $request->getParameter('type', 'wiki'),
      'id' => $request->getParameter('id'),
    );

    $this->form = new PluginCommunityWikiSearchForm();
    $this->form->bind($params);

    if ('event' === $request->getParameter('type'))
    {
      $table = Doctrine::getTable('CommunityEvent');
      $this->link_to_detail = 'communityEvent/show?id=%d';
      $this->type = 'event';
    }
//    else
    {
      $table = Doctrine::getTable('CommunityWiki');
      $this->link_to_detail = 'communityWiki/show?id=%d';
      $this->type = 'wiki';
    }

    $this->communityId = $request->getParameter('id');

    $q = $table->getSearchQuery($request->getParameter('id'), $request->getParameter('target'), $request->getParameter('keyword'));
    $this->pager = $table->getResultListPager($q, $request->getParameter('page'));

    $this->isResult = false;
    if (null !== $request->getParameter('keyword') || null !== $request->getParameter('target') || null !== $request->getParameter('type'))
    {
      $this->isResult = true;
    }

    return sfView::SUCCESS;
  }

  // 書込み決定時
  protected function processForm($request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      $communityWiki = $form->save();
      $this->redirect('@communityWiki_show?id='.$communityWiki->getId());
    }
  }

}
