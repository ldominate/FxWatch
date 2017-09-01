/**
 * Created by johny on 26.08.2017.
 */

import $ from "jquery";
import RestClient from "another-rest-client";
import dxList from "devextreme/ui/list";
import dxTabs from "devextreme/ui/tabs";
import dxDropDownBox from "devextreme/ui/drop_down_box";
import dxTreeView from "devextreme/ui/tree_view";
import dxChart from "devextreme/viz/chart";
import CustomStore from "devextreme/data/custom_store";
import  NewsSource from "./sources/NewsSource";

import "dxCommonCss";
import "dxLightCss";

import "flag-icon-css/css/flag-icon";

import "./widget.less";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

api.on('response', function(xhr) {
	//xhr.setRequestHeader('Authorization', 'Bearer xxxTOKENxxx');
	//console.log(xhr);
	const header = xhr.getResponseHeader("X-Pagination-Total-Count");
	console.log(header);
});

$("#gmi").on("click", (btn) => {
	"use strict";

	api.news.get({currency_code: "USD", sort: "-published"}).then((news) => {
		console.log(news);
	});
	// api.news.get().then((news) => {
	// 	console.log(news);
	// });
	// api.news(3).patch({release: "Dada"}).then((news) => {
	// 	console.log(news);
	// });
});

$(".navigation-box > .tabs-container").dxTabs({
	dataSource: ["Неделя", "Регион", "Поиск"],
	selectedIndex: 0,
	width: 200,
	onItemClick: function(e) {
		console.log(e);
		//selectBox.option("value", e.itemData.id);
	}
});

$("#period_tabs_left, #period_tabs_right").dxTabs({
	dataSource: {
		load: loadOption => {
			"use strict";
			const d =  $.Deferred();

			$.getJSON('/catalog/periods').done(result => {
				console.log(result);
				d.resolve(result.map(p => ({id: p.id, text: p.name})));
			});
			return d.promise();
		}
	},
	selectedIndex: 0,
	width: 200,
});

const syncTreeViewSelection = function(treeView, value){
	if (!value) {
		treeView.unselectAll();
	} else {
		treeView.selectItem(value);
	}
};

let fingroups =[];
//let fingroups = [{"id":"g1","name":"Основные валюты","fintools":[{"id":1,"fintoolgroup_id":1,"name":"EURUSD"},{"id":2,"fintoolgroup_id":1,"name":"GBPUSD"},{"id":4,"fintoolgroup_id":1,"name":"USDJPY"},{"id":7,"fintoolgroup_id":1,"name":"EURGBP"},{"id":8,"fintoolgroup_id":1,"name":"EURJPY"},{"id":11,"fintoolgroup_id":1,"name":"EURCHF"},{"id":26,"fintoolgroup_id":1,"name":"USDRUB"},{"id":27,"fintoolgroup_id":1,"name":"EURRUB"}]},{"id":"g2","name":"Вспомогательные валюты","fintools":[{"id":3,"fintoolgroup_id":2,"name":"USDCHF"},{"id":5,"fintoolgroup_id":2,"name":"AUDUSD"},{"id":6,"fintoolgroup_id":2,"name":"NZDUSD"},{"id":9,"fintoolgroup_id":2,"name":"GBPJPY"},{"id":10,"fintoolgroup_id":2,"name":"GBPCHF"},{"id":12,"fintoolgroup_id":2,"name":"USDCAD"},{"id":13,"fintoolgroup_id":2,"name":"AUDJPY"},{"id":14,"fintoolgroup_id":2,"name":"AUDNZD"},{"id":15,"fintoolgroup_id":2,"name":"AUDCAD"},{"id":16,"fintoolgroup_id":2,"name":"CHFJPY"},{"id":17,"fintoolgroup_id":2,"name":"EURAUD"},{"id":18,"fintoolgroup_id":2,"name":"EURCAD"},{"id":19,"fintoolgroup_id":2,"name":"CADJPY"},{"id":20,"fintoolgroup_id":2,"name":"EURNZD"},{"id":21,"fintoolgroup_id":2,"name":"GBPAUD"},{"id":22,"fintoolgroup_id":2,"name":"GBPCAD"},{"id":23,"fintoolgroup_id":2,"name":"NZDJPY"},{"id":24,"fintoolgroup_id":2,"name":"AUDCHF"},{"id":25,"fintoolgroup_id":2,"name":"CADCHF"}]},{"id":"g3","name":"Товары","fintools":[{"id":28,"fintoolgroup_id":3,"name":"Золото"},{"id":29,"fintoolgroup_id":3,"name":"Серебро"},{"id":30,"fintoolgroup_id":3,"name":"Нефть (Brend)"}]}];

// $.getJSON('/catalog/fintoolgroups').done(result => {
// 	console.log(result);
// 	fingroups = result.map(fg => ({id: `g${fg.id}`, name: fg.name, disabled: false, fintools: fg.fintools}));
// 	//d.resolve(fingroups);
// });

const dropBox = $(".graph-parent .news-item-tabs .news-data-fintool-box").dxDropDownBox({
	value: 1,
	valueExpr: "id",
	displayExpr: "name",
	placeholder: "Select a value...",
	showClearButton: true,
	deferRendering: false,
	dropDownOptions: {
		width: 200,
		height: 300,
	},
	//dataSource: fingroups,
	//opened: true,
	dataSource: new CustomStore({
		load: loadOption => {
			"use strict";
			const d =  $.Deferred();
			$.getJSON('/catalog/fintoolgroups').done(result => {
				console.log(result);
				fingroups = result.map(fg => ({id: `g${fg.id}`, name: fg.name, expanded: false, fintools: fg.fintools}));
				d.resolve(fingroups);
			});
			return d.promise();
			// fingroups = $.getJSON('/catalog/fintoolgroups');//.map(fg => ({id: `g${fg.id}`, name: fg.name, expanded: false, fintools: fg.fintools}));
			// console.log(fingroups);
			// return fingroups;
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();
			if(/[g]\d+/.test(key)){

			}else {
				fingroups.forEach(item => {
					item.fintools.forEach(tool => {
						if(tool.id === key){
							d.resolve(tool);
							return d.promise();
						}
					});
				});
			}
			console.log(key);
			return d.promise();
		}
	}),
	contentTemplate: function(e){
		const value = e.component.option("value"),
			$treeView = $("<div>").dxTreeView({
				dataSource: e.component.option("dataSource"),
				//items: e.component.option("items"),
				//dataStructure: "plain",
				keyExpr: "id",
				parentIdExpr: "categoryId",
				selectionMode: "single",
				displayExpr: "name",
				selectByClick: true,
				itemsExpr: "fintools",
				//width: 200,
				//height: 300,
				onContentReady: function(args){
					//e.component.reset();
					syncTreeViewSelection(args.component, value);
				},
				selectNodesRecursive: false,
				onItemSelectionChanged: function(args){
					const value = args.component.getSelectedNodesKeys();

					e.component.option("value", value);
				}
			});

		const treeView = $treeView.dxTreeView("instance");

		e.component.on("valueChanged", function(args){
			syncTreeViewSelection(treeView, args.value);
		});

		return $treeView;
	}
});

// const ds = dropBox.dxDropDownBox("instance").content();
// console.log(ds);

$("#news_list").dxList({
	dataSource: NewsSource,
	grouped: true,
	height: 356,
	groupTemplate: function(data) {
		return $(`<b>${data.key.toLocaleDateString("ru-RU", {weekday: "short", month: "short", day: "2-digit", formatMatcher: "basic"})}</b>`);

	},
	itemTemplate: function(data, index) {
		const result = $("<div>").addClass("item-news");

		$("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {hour:"numeric", minute: "2-digit"})).appendTo(result);
		$("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`).appendTo(result);
		$("<div>").html(data.categorynews).appendTo(result);
		// 	.html(Globalize.formatCurrency(data.Price, "USD", { maximumFractionDigits: 0 })).appendTo(result);
		return result;
	}
});

$("#newsdata_candle_stick_left").dxChart({
	// adaptiveLayout: {
	// 	height: 40,
	// 	keepLabels: true,
	// 	width: 60
	// },
	dataSource: new CustomStore({
		load: loadOption => {
			"use strict";
			const d =  $.Deferred();
			$.getJSON('/news/widget/news/data/5/1/2').done(result => {
				//d.resolve(result);
				// console.log(result);
				let newsdatas = result.map(nd => {
					nd.datetime = new Date(nd.datetime.replace(" ", "T"));
					return nd;
				});
				// console.log(newsdatas);
				d.resolve(newsdatas);
			});
			return d.promise();
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();

			console.log(key);
			return d.promise();
		}
	}),
	commonSeriesSettings: {
		argumentField: "datetime",
		type: "candlestick"
	},
	legend: {
		itemTextPosition: 'left',
		visible: false
	},
	series: [
		{
			name: "DELL",
			openValueField: "open",
			highValueField: "max",
			lowValueField: "min",
			closeValueField: "close",
			reduction: {
				color: "red"
			}
		}
	],
	valueAxis: {
		//tickInterval: 0.0001,
		// title: {
		// 	text: ""
		// },
		// label: {
		// 	format: {
		// 		type: "currency",
		// 		precision: 0
		// 	}
		// },
		// max: 1.141,
		// min: 1.139,
	},
	argumentAxis: {
		label: {
			format: "shortDate"
		}
	},
	"export": {
		enabled: false
	},
	tooltip: {
		enabled: true,
		location: "edge",
		customizeTooltip: function (arg) {
			return {
				text: `Open: ${arg.openValue}<br/>Close: ${arg.closeValue}<br/>High: ${arg.highValue}<br/>Low: ${arg.lowValue}`
			};
		}
	}
});
$("#newsdata_candle_stick_right").dxChart({
	// adaptiveLayout: {
	// 	height: 40,
	// 	keepLabels: true,
	// 	width: 60
	// },
	dataSource: new CustomStore({
		load: loadOption => {
			"use strict";
			const d =  $.Deferred();
			$.getJSON('/news/widget/news/data/3/1/1').done(result => {
				//d.resolve(result);
				// console.log(result);
				let newsdatas = result.map(nd => {
					nd.datetime = new Date(nd.datetime.replace(" ", "T"));
					return nd;
				});
				// console.log(newsdatas);
				d.resolve(newsdatas);
			});
			return d.promise();
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();

			console.log(key);
			return d.promise();
		}
	}),
	commonSeriesSettings: {
		argumentField: "datetime",
		type: "candlestick"
	},
	legend: {
		itemTextPosition: 'left',
		visible: false
	},
	series: [
		{
			name: "DELL",
			openValueField: "open",
			highValueField: "max",
			lowValueField: "min",
			closeValueField: "close",
			reduction: {
				color: "red"
			}
		}
	],
	valueAxis: {
		//tickInterval: 0.0001,
		// title: {
		// 	text: ""
		// },
		// label: {
		// 	format: {
		// 		type: "currency",
		// 		precision: 0
		// 	}
		// },
		// max: 1.141,
		// min: 1.139,
	},
	argumentAxis: {
		label: {
			format: d => d.toLocaleDateString("ru-RU", {month: "2-digit", day: "2-digit", year: "2-digit", formatMatcher: "basic"})
		}
	},
	"export": {
		enabled: false
	},
	tooltip: {
		enabled: true,
		location: "edge",
		customizeTooltip: function (arg) {
			return {
				text: `Open: ${arg.openValue}<br/>Close: ${arg.closeValue}<br/>High: ${arg.highValue}<br/>Low: ${arg.lowValue}`
			};
		}
	}
});