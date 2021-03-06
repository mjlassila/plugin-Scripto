<?php
$title = __('Scripto | Page History | ');
$title .= (1 == $this->namespaceIndex) ? __('Discussion') : _('Transcription');
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
<?php echo __('Logged in as <a href='); ?>"<?php echo html_escape(uri('scripto')); ?>"><?php echo $this->scripto->getUserName(); ?></a> 
(<a href="<?php echo html_escape(uri('scripto/logout')); ?>"><?php echo __('logout'); ?></a>) 
 | <a href="<?php echo html_escape(uri('scripto/watchlist')); ?>"><?php echo __('Your watchlist'). '</a>'; ?>
<?php else: ?>
<a href="<?php echo html_escape(uri('scripto/login')); ?>"><?php echo __('Log in to Scripto') . '</a>';?>
<?php endif; ?>
 | <a href="<?php echo html_escape(uri('scripto/recent-changes')); ?>"><?php echo __('Recent changes') .'</a>' ?> 
 | <a href="<?php echo html_escape(uri(array('controller' => 'items', 'action' => 'show', 'id' => $this->doc->getId()), 'id')); ?>"><?php echo __('View item') .'</a>'; ?>
 | <a href="<?php echo html_escape(uri(array('controller' => 'files', 'action' => 'show', 'id' => $this->doc->getPageId()), 'id')); ?>"><?php echo __('View file').'</a>';?>
 | <a href="<?php echo html_escape(uri(array('action' => 'transcribe', 'item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId()), 'scripto_action_item_file')); ?>"><?php echo __('Transcribe page') . '</a>';?>
</p>

<h2><?php if ($this->doc->getTitle()): ?><?php echo $this->doc->getTitle(); ?><?php else: ?><?php echo __('Untitled Document'); ?><?php endif; ?></h2>
<h3><?php echo $this->doc->getPageName(); ?></h3>

<!-- page history -->
<?php if (empty($this->history)): ?>
<p><?php echo __('This page has not yet been created.');?></p>
<?php else: ?>
<table>
    <thead>
    <tr>
        <th><?php echo __('Compare Changes') ?></th>
        <th><?php echo __('Changed on') ?></th>
        <th><?php echo __('Changed by') ?></th>
        <th><?php echo __('Size (bytes)') ?></th>
        <th><?php echo __('Action') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->history as $revision): ?>
    <?php
    $urlCurrent = uri(array('item-id' => $this->doc->getId(), 
                            'file-id' => $this->doc->getPageId(), 
                            'namespace-index' => $this->namespaceIndex, 
                            'old-revision-id' => $revision['revision_id'], 
                            'revision-id' => $this->info['last_revision_id']), 
                      'scripto_diff');
    $urlPrevious = uri(array('item-id' => $this->doc->getId(), 
                             'file-id' => $this->doc->getPageId(), 
                             'namespace-index' => $this->namespaceIndex, 
                             'old-revision-id' => $revision['parent_id'], 
                             'revision-id' => $revision['revision_id']), 
                       'scripto_diff');
    $urlRevert = uri(array('item-id' => $this->doc->getId(), 
                           'file-id' => $this->doc->getPageId(), 
                           'namespace-index' => $this->namespaceIndex, 
                           'revision-id' => $revision['revision_id']), 
                     'scripto_revision');
    ?>
    <tr>
        <td>(<?php if ($revision['revision_id'] != $this->info['last_revision_id']): ?><a href="<?php echo html_escape($urlCurrent); ?>"><?php echo __('current'); ?></a><?php else: ?>current<?php endif; ?> | <?php if (0 != $revision['parent_id']): ?><a href="<?php echo html_escape($urlPrevious); ?>"><?php echo __('previous') ;?></a><?php else: ?><?php echo __('previous') ;?><?php endif; ?>)</td>
        <td><a href="<?php echo html_escape($urlRevert); ?>"><?php echo date('H:i:s M d, Y', strtotime($revision['timestamp'])); ?></a></td>
        <td><?php echo $revision['user']; ?></td>
        <td><?php echo $revision['size']; ?></td>
        <td><?php echo ucfirst($revision['action']); ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</div><!-- #scripto-history -->
</div>
<?php foot(); ?>