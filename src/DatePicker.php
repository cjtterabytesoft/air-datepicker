<?php

/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://gitlab.com/cjtterabytesoft/tadweb
 *      @author: Wilmer Arámbula <github@cjtterabyte.com>
 *   @copyright: (c) CJT TERABYTE INC
 *     @widgets: [DatePicker]
 *       @since: 1.0
 *         @yii: 3.0
 **/

namespace cjtterabytesoft\widgets;

use mrserg161\airdatepicker\DatePickerAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class AirDatePicker
 * Manual http://t1m0n.name/air-datepicker/docs/index-ru.html
 * GitHub https://github.com/t1m0n/air-datepicker.
 * @author Malovichko Sergey <mrSerg161@gmail.com>
 */
class DatePicker extends InputWidget
{
	/**
	 * template.
	 *
	 * @var string
	 */
	public $template = '{input}';

	/**
	 * options.
	 *
	 * @var array
	 */
	public $options = [
		'class' => 'form-control',
	];

	/**
	 * clientOptions.
	 *
	 * @var array
	 */
	public $clientOptions = [];

	/**
	 * clientEvents.
	 *
	 * @var array
	 */
	public $clientEvents = [];

	/**
	 * Initializes the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 *
	 * @return void
	 */
	public function init()
	{
		parent::init();

		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
		}

		if (isset($this->clientOptions['language'])) {
			$lang = $this->clientOptions['language'];
			$this->view->registerJsFile($asset->baseUrl . "/js/i18n/datepicker.$lang.js", [
				'depends' => DatePickerAsset::class,
			]);
		}
	}

	/**
	 * Run the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 *
	 * @return string
	 */
	public function run()
	{
		$asset = new DatePickerAsset();
		$asset->register($this->view);

		$id = $this->options['id'];
		$options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
		$js = "jQuery('#$id').datepicker($options)";
		preg_match_all('/\[(\d+)\]([a-z_-]+)/i', $this->attribute, $value);
		$_attr = $value[2][0] ?? $this->attribute;

		if ($value = $this->model->$_attr) {
			$this->clientEvents = array_merge($this->clientEvents, ['selectDate' => 'new Date(' . strtotime($value) * 1000 . ')']);
		}
		
		foreach ($this->clientEvents as $event => $handler) {
			$js .= ".data('datepicker').$event($handler)";
		}

		$this->view->registerJs($js . ';');

		return strtr($this->template, [
			'{input}' => $this->hasModel()
				? Html::activeTextInput($this->model, $this->attribute, $this->options)
				: Html::textInput($this->name, $this->value, $this->options),
		]);
	}
}
