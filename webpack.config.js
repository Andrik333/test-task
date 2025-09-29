const path = require('path'); // Импортируем модуль "path" для работы с путями файлов
const webpack = require('webpack');

module.exports = {
  entry: './assets/js/index.js', // Точка входа для сборки проекта

  output: {
    filename: 'script.js', // Имя выходного файла сборки
    path: path.resolve(__dirname, 'public/build'), // Путь для выходного файла сборки
  },

  module: {
    rules: [
      {
        test: /\.(scss|css)$/, // Регулярное выражение для обработки файлов с расширением .css
        use: [
          {
            loader: 'style-loader'
          },
          {
            loader: 'css-loader'
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  require('autoprefixer')
                ]
              }
            }
          },
          {
            loader: 'sass-loader'
          }
        ], // Загрузчики, используемые для обработки CSS-файлов
      },
    ],
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery'
    })
  ],

  devServer: {
    static: {
      directory: path.join(__dirname, 'dist'), // Каталог для статики
    },
    open: true, // Автоматически открывать браузер
  },

  mode: 'development', // Режим сборки
};