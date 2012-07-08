<?php
$title = __('Scripto | Revision Difference | ');
$title .= (1 == $this->namespaceIndex) ? __('Discussion') : __('Transcription');
$head = array('title' => html_escape($title));
head($head);
?>
<style type="text/css">
#scripto-diff tr {border: none !important;}
#scripto-diff td {padding: 2px !important;}
td.diff-marker {width: 10px;}
td.diff-deletedline {background-color: #FFEDED;}
td.diff-addedline {background-color: #EDFFEF;}
ins.diffchange {background-color: #BDFFC8;}
del.diffchange {background-color: #FFBDBD;}
</style>
<h1><?php echo $head['title']; ?></h1>
<div id="primary">
<?php echo flash(); ?>

<div id="scripto-diff" class="scripto">
<!-- navigation -->
<p>
<?php if ($this->scripto->isLoggedIn()): ?>
<?php echo __('Logged in as '); ?><a href="<?php echo html_escape(uri('scripto')); ?>"><?php echo $this->scripto->getUserName(); ?></a> 
(<a href="<?php echo html_escape(uri('scripto/index/logout')); ?>"><?php echo __('logout'); ?></a>) 
 | <a href="<?php echo html_escape(uri('scripto/watchlist')); ?>"><?php echo __('Your watchlist'); ?></a> 
<?php else: ?>
<a href="<?php echo html_escape(uri('scripto/index/login')); ?>"><?php echo __('Log in to Scripto'); ?></a>
<?php endif; ?>
 | <a href="<?php echo html_escape(uri('scripto/recent-changes')); ?>"><?php echo __('Recent changes'); ?></a> 
 | <a href="<?php echo html_escape(uri(array('controller' => 'items', 'action' => 'show', 'id' => $this->doc->getId()), 'id')); ?>"><?php echo __('View item'); ?></a>
 | <a href="<?php echo html_escape(uri(array('controller' => 'files', 'action' => 'show', 'id' => $this->doc->getPageId()), 'id')); ?>"><?php echo __('View file'); ?></a>
 | <a href="<?php echo html_escape(uri(array('action' => 'transcribe', 'item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId()), 'scripto_action_item_file')); ?>"><?php echo __('Transcribe page'); ?></a>
 | <a href="<?php echo html_escape(uri(array('item-id' => $this->doc->getId(), 'file-id' => $this->doc->getPageId(), 'namespace-index' => $this->namespaceIndex), 'scripto_history')); ?>"><?php echo __('View history'); ?></a>
</p> 

<h2><?php if ($this->doc->getTitle()): ?><?php echo $this->doc->getTitle(); ?><?php else: __('Untitled Document'); ?><?php endif; ?></h2>
<h3><?php echo $this->doc->getPageName(); ?></h3>

<!-- difference -->
<table>
    <thead>
    <tr>
        <th colspan="2"><?php __("Revision as of"); ?> <?php echo date('H:i:s, M d, Y', strtotime($this->oldRevision['timestamp'])); ?><br />
        <?php echo ucfirst($this->oldRevision['action']); ?> <?php echo __('by'); ?> <?php echo $this->oldRevision['user']; ?></th>
        <th colspan="2"><?php __("Revision as of"); ?> <?php echo date('H:i:s, M d, Y', strtotime($this->revision['timestamp'])); ?><br />
        <?php echo ucfirst($this->revision['action']); ?> <?php echo __('by'); ?> <?php echo $this->revision['user']; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php echo $this->diff; ?>
    </tbody>
</table>
<h2><?php echo __('Revision as of '); ?><?php echo date('H:i:s, M d, Y', strtotime($this->revision['timestamp'])); ?></h2>
<div><?php echo $this->revision['html']; ?></div>
</div><!-- #scripto-diff -->
</div>
<?php foot(); ?>