<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170729_130513_create_currency_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('currency', [
            'code' => $this->string(3)->notNull(),
	        'number' => $this->integer(3)->unsigned()->notNull()->unique(),
	        'mark' => $this->string(5)->null()->defaultValue(null),
	        'name' => $this->string(40)->notNull()
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('code', 'currency', 'code');

        $this->createIndex('idx-currency-number', 'currency', 'number', true);

        $this->batchInsert('currency', ['code', 'number', 'mark', 'name'],
	        [
		        ['RUB',643,null,'Российский рубль'],
		        ['USD',840,'$','Доллар США'],
		        ['EUR',978,'€','Евро'],
		        ['JPY',392,'¥','Японская йена'],
		        ['CNY',156,'Ұ','Китайский юань женьминьби'],
		        ['GBP',826,'£','Фунт стерлингов Великобритании'],
		        ['UAH',980,'₴','Украинская гривна'],
		        ['CHF',756,null,'Швейцарский франк'],
		        ['AED',784,null,'Дирхам ОАЭ'],
		        ['AFN',971,null,'Афганский афгани'],
		        ['ALL',8  ,null,'Албанский лек'],
		        ['AMD',51 ,null,'Армянский драм'],
		        ['AOA',973,null,'Ангольская кванза'],
		        ['ARS',32 ,null,'Аргентинский песо'],
		        ['AUD',36 ,null,'Австралийский доллар'],
		        ['AZN',944,null,'Азербайджанский манат'],
		        ['BDT',50 ,null,'Бангладешская така'],
		        ['BGN',975,null,'Болгарский лев'],
		        ['BHD',48 ,null,'Бахрейнский динар'],
		        ['BIF',108,null,'Бурундийский франк'],
		        ['BND',96 ,null,'Брунейский доллар'],
		        ['BOB',68 ,null,'Боливийский боливиано'],
		        ['BRL',986,null,'Бразильский реал'],
		        ['BWP',72 ,null,'Ботсванская пула'],
		        ['BYN',933,null,'Белорусский рубль'],
		        ['CAD',124,null,'Канадский доллар'],
		        ['CDF',976,null,'Конголезский франк'],
		        ['CLP',152,null,'Чилийский песо'],
		        ['COP',170,null,'Колумбийский песо'],
		        ['CRC',188,null,'Костариканский колон'],
		        ['CUP',192,null,'Кубинский песо'],
		        ['CZK',203,null,'Чешская крона'],
		        ['DJF',262,null,'Джибутийский франк'],
		        ['DKK',208,null,'Датская крона'],
		        ['DZD',12 ,null,'Алжирский динар'],
		        ['EGP',818,null,'Египетский фунт'],
		        ['ETB',230,null,'Эфиопский быр'],
		        ['GEL',981,null,'Грузинский лари'],
		        ['GHS',936,null,'Ганский седи'],
		        ['GMD',270,null,'Гамбийский даласи'],
		        ['GNF',324,null,'Гвинейский франк'],
		        ['HKD',344,null,'Гонконгский доллар'],
		        ['HRK',191,null,'Хорватская куна'],
		        ['HUF',348,null,'Венгерский форинт'],
		        ['IDR',360,null,'Индонезийская рупия'],
		        ['ILS',376,null,'Израильский шекель'],
		        ['INR',356,null,'Индийская рупия'],
		        ['IQD',368,null,'Иракский динар'],
		        ['IRR',364,null,'Иранский риал'],
		        ['ISK',352,null,'Исландская крона'],
		        ['JOD',400,null,'Иорданский динар'],
		        ['KES',404,null,'Кенийский шиллинг'],
		        ['KGS',417,null,'Киргизский сом'],
		        ['KHR',116,null,'Камбоджийский риель'],
		        ['KPW',408,null,'Северо-корейская вона (КНДР)'],
		        ['KRW',410,null,'Южно-корейская вона (Корея)'],
		        ['KWD',414,null,'Кувейтский динар'],
		        ['KZT',398,null,'Казахский тенге'],
		        ['LAK',418,null,'Лаосский кип'],
		        ['LBP',422,null,'Ливанский фунт'],
		        ['LKR',144,null,'Шри-ланкийская рупия'],
		        ['LYD',434,null,'Ливийский динар'],
		        ['MAD',504,null,'Марокканский дирхам'],
		        ['MDL',498,null,'Молдавский лей'],
		        ['MGA',969,null,'Малагасийский ариари'],
		        ['MKD',807,null,'Македонский денар'],
		        ['MNT',496,null,'Монгольский тугрик'],
		        ['MRO',478,null,'Мавританская угия'],
		        ['MUR',480,null,'Маврикийская рупия'],
		        ['MWK',454,null,'Малавийская квача'],
		        ['MXN',484,null,'Мексиканский песо'],
		        ['MYR',458,null,'Малайзийский ринггит'],
		        ['MZN',943,null,'Мозамбикский метикал'],
		        ['NAD',516,null,'Намибийский доллар'],
		        ['NGN',566,null,'Нигерийская наира'],
		        ['NIO',558,null,'Никарагуанская кордоба'],
		        ['NOK',578,null,'Норвежская крона'],
		        ['NPR',524,null,'Непальская рупия'],
		        ['NZD',554,null,'Новозеландский доллар'],
		        ['OMR',512,null,'Оманский риал'],
		        ['PEN',604,null,'Перуанский соль'],
		        ['PHP',608,null,'Филиппинский песо'],
		        ['PKR',586,null,'Пакистанская рупия'],
		        ['PLN',985,null,'Польский злотый'],
		        ['PYG',600,null,'Парагвайский гуарани'],
		        ['QAR',634,null,'Катарский риал'],
		        ['RON',946,null,'Новый румынский лей'],
		        ['RSD',941,null,'Сербский динар'],
		        ['SAR',682,null,'Саудовский риял'],
		        ['SCR',690,null,'Сейшельская рупия'],
		        ['SDG',938,null,'Суданский фунт'],
		        ['SEK',752,null,'Шведская крона'],
		        ['SGD',702,null,'Сингапурский доллар'],
		        ['SLL',694,null,'Сьерра-леонский леоне'],
		        ['SOS',706,null,'Сомалийский шиллинг'],
		        ['SRD',968,null,'Суринамский доллар'],
		        ['SYP',760,null,'Сирийский фунт'],
		        ['SZL',748,null,'Свазилендский лилангени'],
		        ['THB',764,null,'Таиландский бат'],
		        ['TJS',972,null,'Таджикский сомони'],
		        ['TMT',795,null,'Туркменский манат'],
		        ['TND',788,null,'Тунисский динар'],
		        ['TRY',949,null,'Новая турецкая лира'],
		        ['TWD',901,null,'Тайваньский доллар'],
		        ['TZS',834,null,'Танзанийский шиллинг'],
		        ['UGX',800,null,'Угандийский шиллинг'],
		        ['UYU',858,null,'Уругвайский песо'],
		        ['UZS',860,null,'Узбекский сум'],
		        ['VEF',937,null,'Венесуэльский боливар'],
		        ['VND',704,null,'Вьетнамский донг'],
		        ['XAF',950,null,'Франк КФА (Центральная Африка)'],
		        ['XDR',960,null,'СПЗ'],
		        ['XOF',952,null,'Франк КФА (Западная Африка)'],
		        ['YER',886,null,'Йеменский риал'],
		        ['ZAR',710,null,'Южно-африканский рэнд'],
		        ['ZMK',894,null,'Замбийская квача']
	        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('currency');
    }
}
