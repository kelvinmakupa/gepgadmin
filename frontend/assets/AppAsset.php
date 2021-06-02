<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	
	/*
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.css',
    ];
    public $js = [
		'js/jquery-1.10.2.min.js',
		'js/jqueryui-1.10.3.min.js',
		'js/bootstrap.min.js',
		'js/enquire.js',
		'js/jquery.cookie.js',
		'js/jquery.nicescroll.min.js',
		'js/toggle.min.js',
		'js/placeholdr.js',
		'js/application.js'
    ];

	*/
	    public $basePath = '@webroot';
		public $baseUrl = '@web';
		public $css = [
				'css/site.css',
				];
		public $js = [
			 'js/main.js',

		    ];
		public $depends = [
				'yii\web\YiiAsset',
				'yii\bootstrap\BootstrapAsset',
				];
	
	/*
	public $sourcePath="@bower/template";

	public $css = [
       'assets/css/styles.css',
    ];
    public $js = [
		'assets/js/jquery-1.10.2.min.js',
		'assets/js/jqueryui-1.10.3.min.js',
		'assets/js/bootstrap.min.js',
		'assets/js/enquire.js',
		'assets/js/jquery.cookie.js',
		'assets/js/jquery.nicescroll.min.js',
		//'assets/demo/demo-formcomponents.js',
		/*'assets/plugins/codeprettifier/prettify.js',
		'assets/plugins/easypiechart/jquery.easypiechart.min.js',
		'assets/plugins/sparklines/jquery.sparklines.min.js',
		'assets/plugins/form-toggle/toggle.min.js',
		'assets/plugins/form-multiselect/js/jquery.multi-select.min.js',
		'assets/plugins/quicksearch/jquery.quicksearch.min.js',
		'assets/plugins/form-typeahead/typeahead.min.js',
		'assets/plugins/form-select2/select2.min.js',
		'assets/plugins/form-autosize/jquery.autosize-min.js',
		'assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js',
		'assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js',
		'assets/plugins/form-daterangepicker/daterangepicker.min.js',
		'assets/plugins/form-datepicker/js/bootstrap-datepicker.js',
		'assets/plugins/form-daterangepicker/moment.min.js',
		'assets/plugins/form-fseditor/jquery.fseditor-min.js',
		'assets/plugins/form-jasnyupload/fileinput.min.js',
		'assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js',
		'assets/demo/demo-formcomponents.js', //
		'assets/js/placeholdr.js',
		'assets/js/application.js',
		'assets/demo/demo.js',
	];

    public $depends = [
       'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
    ];
	*/
}
