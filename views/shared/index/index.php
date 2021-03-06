<?php
$head = array('title' => html_escape(__('Scripto')));
head($head);
?>
<h1><?php echo $head['title']; ?></h1>
<div id="primary">
<?php echo flash(); ?>

<div id="scripto-index" class="scripto">
<!-- navigation -->
<p>
<?php if ($this->scripto->isLoggedIn()): ?>
<?php echo __('Logged in as '); ?><?php echo $this->scripto->getUserName(); ?> 
(<a href="<?php echo html_escape(uri('scripto/logout')); ?>"><?php echo __('logout'); ?></a>) 
 | <a href="<?php echo html_escape(uri('scripto/watchlist')); ?>"><?php echo __('Your watchlist'); ?></a> 
<?php else: ?>
<a href="<?php echo html_escape(uri('scripto/login')); ?>"><?php echo __('Log in to Scripto'); ?></a> 
<?php endif; ?>
 | <a href="<?php echo html_escape(uri('scripto/recent-changes')); ?>"><?php echo __('Recent changes'); ?></a>
</p>

<!-- your contributions -->
<?php if (!$this->scripto->isLoggedIn()): ?>
<?php if ($this->homePageText): ?>
<?php echo $this->homePageText ?>
<?php else: ?>
<h2><?php echo __('Welcome to Scripto!'); ?></h2>
<p><?php echo __('By using this plugin you are helping to transcribe items 
in'); ?> <i><?php echo settings('site_title'); ?></i>. <?php echo __("All items with files can be 
transcribed. For these purposes an item is a <em>document</em>, and an item's 
files are its <em>pages</em>. To begin transcribing documents,"); ?> 
<a href="<?php echo html_escape(uri('items')); ?>"><?php echo __('browse items'); ?></a> <?php echo __('or'); ?>
<a href="<?php echo html_escape(uri('scripto/recent-changes')); ?>"><?php echo __('view recent changes'); ?></a> 
<?php echo __('to Scripto. You may '); ?><a href="<?php echo html_escape(uri('scripto/login')); ?>"><?php echo __('log in') ;?></a> <?php echo __('to 
access your account and enable certain Scripto features. Login may not be 
required by the administrator.'); ?></p>
<?php endif; ?>
<?php else: ?>
<h2><?php echo __('Your Contributions'); ?></h2>
<?php if (empty($this->documentPages)): ?>
<p><?php echo __('You have no contributions.'); ?></p>
<?php else: ?>
<table>
    <thead>
    <tr>
        <th><?php echo __('Document Page Name'); ?></th>
        <th><?php echo __('Most Recent Contribution'); ?></th>
        <th><?php echo __('Document Title'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->documentPages as $documentPage): ?>
    <?php
    // document page name
    $documentPageName = ScriptoPlugin::truncate($documentPage['document_page_name'], 60);
    $urlTranscribe = uri(array(
        'action' => 'transcribe', 
        'item-id' => $documentPage['document_id'], 
        'file-id' => $documentPage['document_page_id']
    ), 'scripto_action_item_file');
    if (1 == $documentPage['namespace_index']) {
        $urlTranscribe .= '#discussion';
    } else {
        $urlTranscribe .= '#transcription';
    }
    
    // document title
    $documentTitle = ScriptoPlugin::truncate($documentPage['document_title'], 60, __('Untitled'));
    $urlItem = uri(array(
        'controller' => 'items', 
        'action' => 'show', 
        'id' => $documentPage['document_id']
    ), 'id');
    ?>
    <tr>
        <td><a href="<?php echo html_escape($urlTranscribe); ?>"><?php if (1 == $documentPage['namespace_index']): ?><?php echo __('Talk:'); ?> <?php endif; ?><?php echo $documentPageName; ?></a></td>
        <td><?php echo gmdate('H:i:s M d, Y', strtotime($documentPage['timestamp'])); ?></td>
        <td><a href="<?php echo html_escape($urlItem); ?>"><?php echo $documentTitle; ?></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php endif; ?>
</div><!-- #scripto-index -->
</div>
<?php foot(); ?>