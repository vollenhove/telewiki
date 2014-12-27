<?php

/**
 * Skin file for wp
 *
 * @file
 * @ingroup Skins
 */
 

class Skinwp extends SkinTemplate {
	public $skinname = 'wp', $stylename = 'wp', $template = 'wpTemplate', $useHeadElement = true;

	public function setupSkinUserCss(OutputPage $out) {
		parent::setupSkinUserCss($out);
		global $wgwpFeatures;
		$wgwpFeaturesDefaults = array(
			'showActionsForAnon' => false,
			'NavWrapperType' => 'divonly',
			'showHelpUnderTools' => true,
			'showRecentChangesUnderTools' => true,
			'IeEdgeCode' => 1
		);
		foreach ($wgwpFeaturesDefaults as $fgOption => $fgOptionValue) {
			if ( !isset($wgwpFeatures[$fgOption]) ) {
				$wgwpFeatures[$fgOption] = $fgOptionValue;
			}
		}
		switch ($wgwpFeatures['IeEdgeCode']) {
			case 1:
				$out->addHeadItem('ie-meta', '<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
				break;
			case 2:
				if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
					header('X-UA-Compatible: IE=edge');
				break;
		}
		$out->addModuleStyles('skins.wp');
	}

	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;
		parent::initPage($out);

		$viewport_meta = 'width=device-width, user-scalable=yes, initial-scale=1.0';
	  $out->addMeta('viewport', $viewport_meta);
		$out->addModuleScripts('skins.wp');
	}

}

class wpTemplate extends BaseTemplate {
	public function execute() {
		global $wgUser;
		global $wgwpFeatures;
		wfSuppressWarnings();
		$this->html('headelement');
		switch ($wgwpFeatures['NavWrapperType']) {
			case '0':
				break;
			case 'divonly':
				echo "<div id='navwrapper'>";
				break;
			default:
				echo "<div id='navwrapper' class='". $wgwpFeatures['NavWrapperType']. "'>";
				break;
		}
?>
<!-- START wpTEMPLATE -->
	<?php include("header.php"); ?>
		<?php if ($wgwpFeatures['NavWrapperType'] != '0') echo "</div>"; ?>
		
		<div id="page-content">
		<div class="row">
				<div class="large-12 columns">
				<!--[if lt IE 9]>
				<div id="siteNotice" class="sitenotice panel radius"><?php echo $this->text('sitename') . ' '. wfMessage( 'wp-browsermsg' )->text(); ?></div>
				<![endif]-->

				<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="sitenotice panel radius"><?php $this->html( 'sitenotice' ); ?></div><?php } ?>
				<?php if ( $this->data['newtalk'] ) { ?><div id="usermessage" class="newtalk panel radius"><?php $this->html( 'newtalk' ); ?></div><?php } ?>
				</div>
		</div>

		<div id="mw-js-message" style="display:none;"></div>

		<div class="row">
				<div id="p-cactions" class="large-12 columns">
					<?php if ($wgUser->isLoggedIn() || $wgwpFeatures['showActionsForAnon']): ?>
						<a href="#" data-dropdown="drop1" class="button dropdown small secondary radius"><i class="fa fa-cog"><span class="show-for-medium-up">&nbsp;<?php echo wfMessage( 'actions' )->text() ?></span></i></a>
						<ul id="drop1" class="views large-12 columns f-dropdown">
							<?php foreach( $this->data['content_actions'] as $key => $item ) { echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem($key, $item)); } ?>
							<?php wfRunHooks( SkinTemplateToolboxEnd, array( &$this, true ) );  ?>
						</ul>
						<?php if ($wgUser->isLoggedIn()): ?>
							<div id="echo-notifications"></div>
						<?php endif; ?>
					<?php endif;
					$namespace = str_replace('_', ' ', $this->getSkin()->getTitle()->getNsText());
					$displaytitle = $this->data['title'];
					if (!empty($namespace)) {
						$pagetitle = $this->getSkin()->getTitle();
						$newtitle = str_replace($namespace.':', '', $pagetitle);
						$displaytitle = str_replace($pagetitle, $newtitle, $displaytitle);
					?><h4 class="namespace label"><?php print $namespace; ?></h4><?php } ?>
					<h2 class="title"><?php print $displaytitle; ?></h2>
					<?php if ( $this->data['isarticle'] ) { ?><h3 id="tagline"><?php $this->msg( 'tagline' ) ?></h3><?php } ?>
					<h5 class="subtitle"><?php $this->html('subtitle') ?></h5>
					<div class="clear_both"></div>
					<?php $this->html('bodytext') ?>
		    	<div class="group"><?php $this->html('catlinks'); ?></div>
		    	<?php $this->html('dataAfterContent'); ?>
		    </div>
		</div>

		<footer class="row">
<?php include("footer.php"); ?>
		
		<?php $this->printTrail(); ?>

		</body>
		</html>

<?php
		wfRestoreWarnings();
	}
}
?>
