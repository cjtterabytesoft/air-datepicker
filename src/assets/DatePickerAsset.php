<?php

/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://gitlab.com/cjtterabytesoft/tadweb
 *      @author: Wilmer Arámbula <github@cjtterabyte.com>
 *   @copyright: (c) CJT TERABYTE INC
 *      @assets: [DatePickerAsset]
 *       @since: 1.0
 *         @yii: 3.0
 **/

namespace cjtterabytesoft\widgets\assets;

use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
	public $sourcePath = '@bower/air-datepicker/dist';

	public $css = [
		'css/datepicker.css',
	];

	public $js = [
		'js/datepicker.js',
	];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
