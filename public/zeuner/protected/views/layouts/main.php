<?php /* @var $this Controller */ ?>
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
				array('label'=>'Home', 'url'=>array('tblDomain/index_auctions')),
//				array('label'=>'About', 'url'=>array('site/page', 'view'=>'about')),
//				array('label'=>'Contact', 'url'=>array('site/contact')),
//				array('label'=>'Domains', 'url'=>array('tblDomain/index_own'), 'visible' => !(Yii::app()->user->isGuest || Yii::app()->user->checkAccess('domains'))),
				array('label'=>'Kaeufe', 'url'=>array('tblSale/index_own'), 'visible' => !(Yii::app()->user->isGuest || Yii::app()->user->checkAccess('sales'))),
				array('label'=>'Benutzer', 'url'=>array('user/index'), 'visible' => Yii::app()->user->checkAccess('customers')),
				array('label'=>'Domains', 'url'=>array('tblDomain/admin'), 'visible' => Yii::app()->user->checkAccess('domains')),
				array('label'=>'Verkäufe', 'url'=>array('tblSale/index'), 'visible' => Yii::app()->user->checkAccess('sales')),
				array('label'=>'Anfragen', 'url'=>array('tblContactData/index'), 'visible' => Yii::app()->user->checkAccess('contact_data')),
				array('label'=>'Typeins', 'url'=>array('tblTypeinBacklog/index'), 'visible' => Yii::app()->user->checkAccess('typein_stats')),
				array('label'=>'Vorlagen', 'url'=>array('tblMailTemplate/index'), 'visible' => Yii::app()->user->checkAccess('mail_templates')),
				array('label'=>'Einstellungen', 'url'=>array('smsGatewayConfiguration/update', "id" => 1), 'visible' => Yii::app()->user->checkAccess('system')),
				array('label'=>'Einloggen', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Ausloggen ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
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
		Copyright &copy; <?php echo "2016" . (("2016" == date('Y')) ? "" : "-" . date('Y')); ?> DAY Investments GmbH
	</div><!-- footer -->

	</div><!-- bottom -->

</div><!-- page -->

</body>
</html>
