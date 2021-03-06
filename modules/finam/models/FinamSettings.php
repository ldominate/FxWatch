<?php

namespace app\modules\finam\models;

use app\modules\catalog\models\SourceCode;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "finamsettings".
 *
 * @property integer $id
 * @property string url Ссылка на источник данных
 * @property integer $market Источник данных
 * @property integer $em Инструмент
 * @property string $sourcecode_code
 * @property integer $apply
 * @property string $from Дата начала: ДД.ММ.ГГГГ
 * @property string $to Дата окончания: ДД.ММ.ГГГГ
 * @property integer $p Периодичность: тики-(1),1 мин.-(2), 5 мин.-(3), 10 мин.-(4), 15 мин.-(5), 30 мин.-(6), 1 час-(7), 1 день-(8), 1 неделя-(9), 1 месяц-(10)
 * @property string $f Имя файла
 * @property string $e Расширение файла. Значения: .txt, .cvs
 * @property integer $dtf Формат даты: ггггммдд-1, ггммдд-2, ддммгг-3, дд/мм/гг-4, мм/дд/гг-5
 * @property integer $tmf Формат времени: ччммсс-1, ччмм-2, чч:мм:сс-3, чч:мм-4
 * @property integer $MSOR Выдавать время: 0-начало свечи, 1-окончания свечи
 * @property integer $mstimever Выдавать московское время: Да/Нет (1/0)
 * @property integer $sep Разделитель поле: запятая(,)-1, точка(.)-2, точка с запятой(;)-3, табуляция (»)-4, пробел( )-5
 * @property integer $sep2 Заздулитель разрядов: нет-1, точка(.)-2, запятая(,)-3, пробел( )-4, кавычка (')-5
 * @property integer $datf Формат записи в файл: TICKER, PER, DATE, TIME, OPEN, HIGH, LOW, CLOSE, VOL-(1), TICKER, PER, DATE, TIME, OPEN, HIGH, LOW, CLOSE-(2), TICKER, PER, DATE, TIME, CLOSE, VOL-(3), TICKER, PER, DATE, TIME, CLOSE-(4), DATE, TIME, OPEN, HIGH, LOW, CLOSE, VOL-(5), DATE, TIME, LAST, VOL, ID, OPER-(12)
 * @property integer $at Добавить заголовок в файла: Да/Нет(1/0)
 * @property integer $fsp Заполнять периоды без сделок: Да/Нет(1/0)
 *
 * @property Sourcecode $sourceCode
 */
class FinamSettings extends ActiveRecord
{
	/**
	 * Инструмент фмн. инструмент/валютная пара
	 * @var string
	 */
	public $code;

	/** @var integer */
	public $df;
	/** @var integer */
	public $mf;
	/** @var integer */
	public $yf;

	/** @var integer */
	public $dt;
	/** @var integer */
	public $mt;
	/** @var integer */
	public $yt;

	/** @var  string Имя контракта */
	public $cn;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finamsettings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['market', 'em', 'apply', 'p', 'dtf', 'tmf', 'MSOR', 'mstimever', 'sep', 'sep2', 'datf', 'at', 'fsp'], 'integer'],
            [['sourcecode_code', 'url'], 'required'],
	        [['url'], 'string', 'max' => 255],
	        [['url'], 'url', 'defaultScheme' => 'http'],
            [['sourcecode_code'], 'string', 'max' => 20],
            [['from', 'to'], 'string', 'max' => 12],
            [['f'], 'string', 'max' => 30],
            [['e'], 'string', 'max' => 10],
            [['sourcecode_code'], 'exist', 'skipOnError' => true, 'targetClass' => SourceCode::className(), 'targetAttribute' => ['sourcecode_code' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
	        'url' => 'Ссылка на источник данных',
            'market' => 'Источник данных',
            'em' => 'Инструмент',
            'sourcecode_code' => 'Связь с справочником фин. инструментов и валютных пар. Инструмент',
	        'code' => 'Инструмент фмн. инструмент/валютная пара',
            'apply' => 'apply',
	        'df' => 'День. Начало',//С лидирующим нулём
	        'mf' => 'Месяц. Начало',//Месяц--
	        'yf' => 'Год. Начало',//Год ГГГГ
            'from' => 'Интервал дат. Начало',
	        'dt' => 'День. Окончание',//С лидирующим нулём
	        'mt' => 'Месяц. Окончание',//Месяц--
	        'yt' => 'Год. Окончание',//Год ГГГГ
            'to' => 'Интервал дат. Окончание',
            'p' => 'Периодичность',
            'f' => 'Имя выходного файла',
            'e' => 'Расширение выходного файла',
            'dtf' => 'Формат даты',
            'tmf' => 'Формат времени',
            'MSOR' => 'Выдавать время. Начало/Окончание свечи',
            'mstimever' => 'Выдавать время. Московское Да/Нет',
            'sep' => 'Разделитель полей',
            'sep2' => 'Разделитель разрядов',
            'datf' => 'Формат записи в файл',
            'at' => 'Добавить заголовок в файл',
            'fsp' => 'Заполнять периоды без сделок',
        ];
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceCode()
    {
        return $this->hasOne(SourceCode::className(), ['code' => 'sourcecode_code']);
    }

    /**
     * @inheritdoc
     * @return FinamSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinamSettingsQuery(get_called_class());
    }

	/**
	 * @param $date_from string
	 * @param $date_to string
	 * @return array
	 */
	public function initAttributes($date_from, $date_to = null){
    	if(empty($date_to)) $date_to = $date_from;

    	$this->code = $this->sourceCode->code;
    	$this->cn = $this->sourceCode->code;

    	$this->from = Yii::$app->formatter->asDate($date_from, 'dd.MM.yyyy');
    	$this->df = Yii::$app->formatter->asDate($date_from, 'dd');
    	$this->mf = Yii::$app->formatter->asDate($date_from, 'MM') - 1;
    	$this->yf = Yii::$app->formatter->asDate($date_from, 'yyyy');

		$this->to = Yii::$app->formatter->asDate($date_to, 'dd.MM.yyyy');
		$this->dt = Yii::$app->formatter->asDate($date_to, 'dd');
		$this->mt = Yii::$app->formatter->asDate($date_to, 'MM') - 1;
		$this->yt = Yii::$app->formatter->asDate($date_to, 'yyyy');

		$this->f = $this->sourceCode->code.'_'.Yii::$app->formatter->asDate($date_from, 'ddMMyyyy');

		$this->url = $this->url.$this->f.$this->e;

    	return array_merge($this->attributes, [
    		'code' => $this->code,
		    'cn' => $this->cn,
		    'df' => $this->df,
		    'mf' => $this->mf,
		    'yf' => $this->yf,
		    'dt' => $this->dt,
		    'mt' => $this->mt,
		    'yt' => $this->yt,
		    'mstime' => $this->mstimever ? 'on' : ''
	    ]);
	}
}
