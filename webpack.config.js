/**
 * Created by johny on 26.08.2017.
 */
const webpack = require("webpack");
const path = require("path");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const extractCss = new ExtractTextPlugin({filename: "[name].css", allChunks: true});

module.exports = {
	entry: {
		widget: "./web/app/main"
	},
	output:{
		path: path.resolve(__dirname, "web/js"),
		publicPath: "web/js",
		filename: "[name].js"
	},
	watchOptions: {
		aggregateTimeout: 1000
	},
	devtool: "chep-inline-module-source-map",
	plugins:[
		new webpack.NoEmitOnErrorsPlugin(),
		// new webpack.DefinePlugin({
		//
		// }),
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
		extensions: [".js", ".jsx", ".less", ".css"],
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
				exclude: [/node_modules/, /public/]
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
				exclude: [/node_modules/, /public/]
			},
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
				exclude: [/node_modules/, /public/]
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
				loader: "url-loader?limit=500000$mimetype=image/svg+xml"
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