<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categorynews`.
 */
class m170804_144427_create_categorynews_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('categorynews', [
            'id' => $this->primaryKey(),
	        'name' => $this->string(155)->notNull()->defaultValue('')
        ], 'CHARACTER SET utf8 DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->batchInsert('categorynews', ['name'],
	    [
	        ['Разрешение на строительство (м/м)'],
			['Решение РБА по процентной ставке'],
			['Индекс потребительских цен (кв/кв)'],
			['Сальдо счёта платёжного баланса (м/м)'],
			['Уровень занятости'],
			['Уровень безработицы'],
			['Валовой внутренний продукт (кв/кв)'],
			['Ипотечные кредиты'],
			['Индекс цен производителей (кв/кв)'],
			['Розничные продажи (м/м)'],
			['Базовый индекс потребительских цен от Банка Канады (м/м)'],
			['Базовый индекс потребительских цен от Банка Канады (г/г)'],
			['Индекс потребительских цен (г/г)'],
			['Индекс потребительских цен (м/м)'],
			['Изменение числа занятых'],
			['Валовый внутреннний продукт (м/м)'],
			['Начатые строительства домов (г/г)'],
			['Решение Банка Канады по процентной ставке'],
			['Розничные продажи без учёта продаж автомобилей (м/м)'],
			['Торговый баланс'],
			['Уровень безработицы (м/м)'],
			['Решение Национального банка Швейцарии по процентной ставке'],
			['Индекс цен производителей и импорта (м/м)'],
			['Индекс цен производителей и импорта (г/г)'],
			['Реальный объём розничной торговли (г/г)'],
			['Индекс деловой активности в сфере услуг'],
			['Индекс PMI Caixin в производстве'],
			['Индекс PMI Caixin в секторе услуг'],
			['Торговый баланс (в юанях) (месяц)'],
			['Экспорт, г/г в юанях (месяц)'],
			['Импорт, г/г в юанях (месяц)'],
			['Торговый баланс (месяц)'],
			['Экспорт, г/г (месяц)'],
			['Импорт, г/г (месяц)'],
			['Индекс потребительских цен г/г (месяц)'],
			['Индекс потребительских цен м/м (месяц)'],
			['Индекс цен производителей г/г (месяц)'],
			['Розничные продажи г/г (месяц)'],
			['Промышленное производство г/г (месяц)'],
			['Валовой внутренний продукт (г/г)'],
			['Валовой внутренний продукт (м/м)'],
			['Индекс делового оптимизма от IFO'],
			['Индекс настроений в деловой среде института ZEW'],
			['Индекс оценки текущих экономических условий института ZEW'],
			['Базовый индекс потребительских цен (г/г)'],
			['Базовый индекс потребительских цен (м/м)'],
			['Баланс счёта текущих операций с учётом сезонных колебаний'],
			['Новые промышленные заказы (м/м)'],
			['Промышленное производство (м/м)'],
			['Промышленное производство (г/г)'],
			['Розничные продажи (г/г)'],
			['Индекс деловой активности в секторе услуг Tankan'],
			['Прогноз деловой активности для крупных производителей Tankan'],
			['Индекс крупных производителей Tankan'],
			['Национальный индекс потребительских цен'],
			['Изменение уровня занятости'],
			['Решение РБНЗ по процентной ставке'],
			['Розничные продажи (кв/кв)'],
			['Индекс деловой активности в производственной сфере Новой Зеландии'],
			['Торговый баланс (г/г)'],
			['Торговый баланс (м/м)'],
			['Импорт'],
			['Экспорт'],
			['Индекс деловой активности в строительном секторе'],
			['Платёжный баланс'],
			['Заявки на пособия по безработице'],
			['Уровень безработицы ILO'],
			['Индикатор уровня безработицы'],
			['Индекс деловой активности в производственном секторе Markit'],
			['Производство в сфере обрабатывающей промышленности (г/г)'],
			['Производство в сфере обрабатывающей промышленности (м/м)'],
			['Индекс цен на жильё Nationwide (м/м)'],
			['Решение Банка Англии по процентной ставке'],
			['Индекс деловой активности в секторе услуг Markit'],
			['Баланс торговли товарами'],
			['Отчёт ADP по уровню занятости в частном секторе'],
			['Индекс потребительских цен без учёта продовольственных товаров и энергоносителей (г/г)'],
			['Индекс потребительских цен без учёта продовольственных товаров и энергоносителей (м/м)'],
			['Заказы на товары длительного пользования без учёта транспорта'],
			['Заказы на товары длительного пользования'],
			['Индекс деловой активности в производственном секторе ФРБ Нью-Йорка'],
			['Количество новых рабочих мест, созданных вне с/х'],
			['Средняя почасовая заработная плата (м/м)'],
			['Продажи на вторичном рынке жилья (м/м)'],
			['Решение ФРС США по процентной ставке'],
			['Годовые данные по ВВП (опережающий) (кв)'],
			['Годовые данные по ВВП (окончательный) (кв)'],
			['Годовые данные по ВВП (предварительный) (кв)'],
			['Использование производственных мощностей'],
			['Индекс деловой активности ISM в производственном секторе'],
			['Индекс деловой активности ISM в секторе услуг'],
			['Первичные заявки на пособие по безработице'],
			['Продажи новых домов'],
			['Динамика разрешений на строительство'],
			['Новые строительства домов'],
			['Незавершённые сделки по продаже жилья (м/м)'],
			['Индекс цен производителей (м/м)'],
			['Индекс цен производителей без учёта продовольственных товаров и энергоносителей (м/м)'],
			['Индекс цен производителей (г/г)'],
			['Индекс цен производителей без учёта продовольственных товаров и энергоносителей (г/г)'],
			['Изменение запасов нефти и нефтепродуктов от EIA']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('categorynews');
    }
}