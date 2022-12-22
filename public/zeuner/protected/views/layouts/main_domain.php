<?php /* @var $this TblDomainController */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
<?php if (!Yii::app()->user->checkAccess('system')) { ?>
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
<?php } ?>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('tblDomain/index_auctions'), 'linkOptions' => array('target' => '_top')),
//				array('label'=>'About', 'url'=>array('site/page', 'view'=>'about')),
				array('label'=>'Auktion', 'url'=>array('tblDomain/status', 'id' => $this->domain_id), 'visible'=>$this->auction_tab_enabled),
				array('label'=>'Kontakt', 'url'=>array('tblDomain/contact', 'id' => $this->domain_id), 'visible'=>$this->contact_tab_enabled),
				array('label'=>'Informationen', 'url'=>array('tblDomain/page', 'view'=>'descriptive', 'id' => $this->domain_id), 'visible'=>$this->information_tab_enabled),
				array('label'=>'Einloggen', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest, 'linkOptions' => array('target' => '_top')),
				array('label'=>'Ausloggen ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions' => array('target' => '_top'))
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="bottom">

	<div id="footer-left">
		<?php echo CHtml::link('Impressum', array('site/page', 'view'=>'imprint')); ?>
	</div><!-- footer-left -->

	<div id="footer">
		Copyright &copy; <?php echo "2016" . (("2016" == date('Y')) ? "" : "-" . date('Y')); ?> by DAY Investments GmbH
	</div><!-- footer -->

	</div><!-- bottom -->

</div><!-- page -->

</body>
</html>
