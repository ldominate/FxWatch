/**
 * Created by johny on 26.08.2017.
 */
const webpack = require("webpack");
const path = require("path");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const extractCss = new ExtractTextPlugin({filename: "[name].css", allChunks: true});

const env = process.env.NODE_ENV;
const __DEV__ = env === "development";
const __PRODUCTION__ = env === "production";

const paths = {
	src: path.resolve(__dirname, 'web/app'),
	dist: path.resolve(__dirname, 'web/js')
};

module.exports = {
	entry: {
		widget: paths.src + "/main",
		finam: paths.src + "/finam"
	},
	output:{
		path: paths.dist,
		publicPath: "/js/",
		filename: "[name].js",
		chunkFilename: __PRODUCTION__ ? "[name].[chunkhash].js" : '[name].js'  //динамически загружаемые модули считаются chunk'ами
	},
	watchOptions: {
		aggregateTimeout: 1000
	},
	devtool: "chep-inline-module-source-map",
	plugins:[
		new webpack.NoEmitOnErrorsPlugin(),
		// отправляем значение NODE_ENV в качестве глобального параметра
		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify(env)
		}),
		//ускорение выполнения кода в браузере
		new webpack.optimize.ModuleConcatenationPlugin(),
		new webpack.ProvidePlugin({
			React: "react",
			ReactDOM: "react-dom"
		}),
		extractCss,
		new webpack.optimize.CommonsChunkPlugin({
			name: "vendor",
			filename: "vendor.js",
			minChunks(module) {
				const context = module.context;
				return context && context.indexOf("node_modules") >= 0;
			}
		})
	],
	resolve: {
		modules: [
			path.resolve('./'),
			path.resolve('./node_modules')
		],
		extensions: [".ts", ".tsx", ".js", ".jsx", ".less", ".css"],
		alias: {
			dxCommonCss: path.join(__dirname, "/node_modules/devextreme/dist/css/dx.common.css"),
			dxLightCss: path.join(__dirname, "/node_modules/devextreme/dist/css/dx.light.compact.css")
		}
	},
	resolveLoader: {
		modules: ["node_modules"],
		extensions: [".json", ".js"],
		moduleExtensions: ['-loader']
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				use: [
					{
						loader: "babel-loader",
						options: {
							presets: ["react", "es2015", "stage-0"]
						}
					}
				],
				exclude: [/node_modules/]
			},
			{
				test: /\.jsx$/,
				use: [
					{
						loader: "babel-loader",
						options: {
							presets: ["react", "es2015", "stage-0"]
						}
					}
				],
				exclude: [/node_modules/]
			},
			{
				test: /\.tsx?$/,
				loader: 'awesome-typescript-loader'
			}, // загрузчик для обработки файлов с расширением .ts
			{
				test: /\.css$/,
				loader: extractCss.extract({fallback: "postcss-loader", use: [{loader: "css-loader"}]}),
				exclude: [/public/]
			},
			{
				test: /\.less$/,
				loader: ExtractTextPlugin.extract({fallback: "postcss-loader", use: ["css-loader", {
					loader: "less-loader",
					options: {
						path: [
							path.resolve(__dirname, "node_modules")
						]
					}
				}]}),
				exclude: [/node_modules/, /js/]
			},
			{
				test: /\.gif$/,
				loader: "url-loader?limit=10000$mimetype=image/gif"
			},
			{
				test: /\.jpg$/,
				loader: "url-loader?limit=10000$mimetype=image/jpg"
			},
			{
				test: /\.png$/,
				loader: "url-loader?limit=10000$mimetype=image/png"
			},
			{
				test: /\.svg$/,
				use: [
					{
						loader: "url-loader",
						options: {
							limit: 1024,
							mimetype: "image/svg+xml"
						}
					}
				]
			},
			{
				test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				loader: "file?name=/fonts/[name].[ext]"
			},
			{
				test: /\.(ttf|eot)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				loader: "file?name=/fonts/[name].[ext]"
			}
		]
	}
};