const path = require('path');
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');


module.exports = (env, options) => {
    return {
        entry: {
            app: './src/index.tsx',
        },
        devtool: 'source-map',
        mode: options.mode,
        module: {
            rules: [
                {
                    test: /\.(ts|tsx)$/,
                    use: [
                        {
                            loader: 'thread-loader',
                            options: {
                                workers: require('os').cpus().length - 2,
                            },
                        },
                        {
                            loader: 'ts-loader',
                            options: {
                                configFile: path.resolve(__dirname, '../', 'tsconfig.json'),
                                transpileOnly: true,
                                happyPackMode: true,
                            }
                        }
                    ],
                    include: [
                        path.resolve(__dirname, '../src')

                    ],
                },
                {
                    test: /\.jsx?$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                            plugins: ['@babel/plugin-proposal-private-methods', '@babel/plugin-proposal-class-properties'],
                        }
                    }
                },
                {
                    test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/i,
                    loader: 'url-loader',
                    options: {
                        limit: 8192,
                    },
                },
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        // Creates `style` nodes from JS strings
                        'style-loader',
                        // Translates CSS into CommonJS
                        {
                            loader: 'css-loader',
                            options: {
                                importLoaders: 1,
                                sourceMap: true,
                                esModule: true,
                                modules: {
                                    localIdentName: '[local]',
                                },
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                postcssOptions: {
                                    config: 'postcss.config.js',
                                    path: '.',
                                },
                            },
                        },
                        // Compiles Sass to CSS
                        {
                            loader: 'sass-loader',
                            options: {
                                webpackImporter: true,
                            },
                        },
                    ],
                    include: [
                        path.resolve(__dirname, '../src'),
                    ],
                    exclude: [
                        path.resolve(__dirname, '../node_modules/'),
                    ],
                },
            ],
        },

        resolve: {
            extensions: ['.ts', '.tsx', '.js', '.jsx', '.scss', '.css'],
            alias: {
                'Components': path.resolve(__dirname, '../src/components/'),
                'Const': path.resolve(__dirname, '../src/const/'),
                'Utils': path.resolve(__dirname, '../src/utils/'),
                'Redux': path.resolve(__dirname, '../src/redux/'),
                'Network': path.resolve(__dirname, '../src/network/'),
                'Interfaces': path.resolve(__dirname, '../src/interfaces/'),
                'Static': path.resolve(__dirname, '../src/static/'),
                'Styles': path.resolve(__dirname, '../src/styles/'),
            },
        },

        plugins: [
            new CleanWebpackPlugin(),
            new HtmlWebpackPlugin({
                template: 'src/index.html',
            }),
            new webpack.DefinePlugin({
                HOST: 'http://localhost:3003',
            }),
        ],
        output: {
            filename: 'js/bundle.js',
            path: path.resolve(__dirname, '../dist'),
            publicPath: '/',
        },
    };
};
