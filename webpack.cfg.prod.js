const webpack = require("webpack");
const path = require("path");
//const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
	entry: {
		widget: "./web/app/main"
	},
	output:{
		path: path.resolve(__dirname, "web/js"),
		publicPath: "http://fxwatch/js/",
		filename: "[name].js"
	},
	watchOptions: {
		aggregateTimeout: 1000
	},
	//devtool: "chep-inline-module-source-map",
	plugins:[
		new webpack.NoEmitOnErrorsPlugin(),
		// new webpack.DefinePlugin({
		//
		// }),
		new webpack.ProvidePlugin({
			React: "react",
			ReactDOM: "react-dom"
		}),
		new webpack.optimize.UglifyJsPlugin({
			compress: {
				warnings: false,
				drop_console: true,
				unsafe: true
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
				test: /\.css$/,
				use: [
					'style-loader',
					{ loader: 'css-loader', options: { importLoaders: 1 } },
					//'postcss-loader'
				],
				//use: [ "css-loader", "postcss-loader"],
				exclude: [/public/]
			},
			{
				test: /\.less$/,
				use: [
					"style-loader",
					"css-loader",
					{loader: "less-loader", options: {
						path: [
							path.resolve(__dirname, "node_modules")
						]
					}
					},
					//"postcss-loader"
				],
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