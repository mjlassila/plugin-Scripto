<?php
$title = __('Scripto | Page Revision | ');
$title .= (1 == $this->namespaceIndex) ? __('Discussion') : __('Transcription');
$head = array('title' => html_escape($title));
head($head);
?>
<h1><?php echo $head['title']; ?></h1>
<div id="primary">
<?php echo flash(); ?>

<div id="scripto-history" class="scripto">
<!-- navigation -->
<p>
<?php if ($this->scripto->isLoggedIn()): ?>
<?php echo __('Logged in as '); ?><a href="<?php echo html_escape(uri('scripto')); ?>"><?php echo $this->scripto->getUserName(); ?></a> 
(<a href="<?php echo html_escape(uri('scripto/logout')); ?>"><?php echo __('logout'); ?></a>) 
 | <a href="<?php echo html_escape(uri('scripto/watchlist')); ?>"><?php echo __('Your watchlist'); ?></a> 
<?php else: ?>
<a href="<?php echo html_escape(uri('scripto/login')); ?>"><?php echo __('Log in to Scripto'); ?></a>
<?php endif; ?>
 | <a href="<?php echo html_escape(uri('scripto/recent-changes')); ?>"><?php echo __('Recent changes'); ?></a> 
 | <a href="<?php echo html_escape(uri(array('controller' => 'items', 'action' => 'show', 'id' => $this->doc->getId()), 'id')); ?>"><?php echo __('View item'); ?></a>
 | <a href="<?php echo html_escape(uri(array('controller' => 'files', 'action' => 'show', 'id' => $this->doc->getPageId()), 'id')); ?>"><?php echo __('View file'); ?></a>
 | <a href="<?php echo html_escape(uri(array('action' => 'transcribe', 'item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId()), 'scripto_action_item_file')); ?>"><?php echo __('Transcribe page'); ?></a>
 | <a href="<?php echo html_escape(uri(array('item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId(), 'namespace-index' => $this->namespaceIndex), 'scripto_history')); ?>"><?php echo __('View history'); ?></a>
</p>

<h2><?php if ($this->doc->getTitle()): ?><?php echo $this->doc->getTitle(); ?><?php else: ?><?php echo __('Untitled Document'); ?><?php endif; ?></h2>
<h3><?php echo $this->doc->getPageName(); ?></h3>

<!-- revert -->
<?php if (1 == $this->namespaceIndex && $this->doc->canEditTalkPage()): ?>
<div><?php echo $this->formTextarea('scripto-page-wikitext', $this->revision['wikitext'], array('cols' => '76', 'rows' => '16', 'disabled' => 'disabled')); ?></div>
<form method="post" action="<?php echo html_escape(uri(array('item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId(), 'namespace-index' => $this->namespaceIndex, 'revision-id' => $this->revision['revision_id']), 'scripto_revision')); ?>">
    <?php echo $this->formSubmit('scripto-page-revert', __('Revert to this revision'), array('style' => 'display:inline; float:none;')); ?>
</form>
<?php elseif ($this->doc->canEditTranscriptionPage()): ?>
<div><?php echo $this->formTextarea('scripto-page-wikitext', $this->revision['wikitext'], array('cols' => '76', 'rows' => '16', 'disabled' => 'disabled')); ?></div>
<form method="post" action="<?php echo html_escape(uri(array('item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId(), 'namespace-index' => $this->namespaceIndex, 'revision-id' => $this->revision['revision_id']), 'scripto_revision')); ?>">
    <?php echo $this->formSubmit('scripto-page-revert', __('Revert to this revision'), array('style' => 'display:inline; float:none;')); ?>
</form>
<?php endif; ?>

<!-- revision -->
<h2><?php echo __('Revision as of '); ?><?php echo date('H:i:s, M d, Y', strtotime($this->revision['timestamp'])); ?>, <?php echo ucfirst($this->revision['action']); ?> <?php echo __('by'); ?> <?php echo $this->revision['user']; ?></h2>
<div><?php echo $this->revision['html']; ?></div>

</div><!-- #scripto-history -->
</div>
<?php foot(); ?>